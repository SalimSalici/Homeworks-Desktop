<?php

namespace App\Middlewares;

use Slim\Csrf\Guard;

/**
 * https://en.wikipedia.org/wiki/Cross-site_request_forgery#Cookie-to-Header_Token
 */

class AjaxCsrfMiddleware extends Middleware {

	protected $prefix;

	public function __construct($container, $whitelist, $prefix = "ajaxCsrf") {
		parent::__construct($container, $whitelist);
		$this->prefix = $prefix;
	}

	public function __invoke($request, $response, $next) {

		$cookie = $request->getHeader('X-Csrf-Token');
		if (isset($cookie[0]) && $cookie[0] !== "")
			$cookie = $cookie[0];
		else
			$cookie = null;

		if ($cookie === null) {
			$token = sha1(uniqid());
			setcookie("X-Csrf-Token", $token, 0, "/");
			$_SESSION[$this->prefix] = $token;
		}

		// If current route name is not in whitelist
		$route = $request->getAttribute('route')->getName();
		if (in_array($route, $this->whitelist))
			return $next($request, $response);

		if (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {

			if ($cookie === null || $_SESSION[$this->prefix] !== $cookie) {
				return $response->withStatus(400)->withHeader('Content-type', 'application/json')->write($this->getJsonError());
			} else
				return $next($request, $response);

        }

		$response = $next($request, $response);
		return $response;

	}

	protected function getJsonError() {
		$json = [
			"status" => 400,
			"message" => "Failed ajaxCsrf check."
		];
		return json_encode($json);
	}

}