<?php

namespace App\Middlewares;

use Slim\Csrf\Guard;

class AjaxCsrfMiddleware {

	protected $prefix;

	public function __construct($prefix = 'ajaxCsrf') {
		$this->prefix = $prefix;
	}

	public function __invoke($request, $response, $next) {

		$cookie = isset($request->getCookieParams()["X-Csrf-Token"]) ?
			$request->getCookieParams()["X-Csrf-Token"] : null;

		if (in_array($request->getMethod(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {

			if ($cookie === null || $_SESSION[$this->prefix] !== $cookie) {
				return $response->withStatus(400)->withHeader('Content-type', 'application/json')->write($this->getJsonError());
			} else
				return $next($request, $response);

        }

		if ($cookie === null) {
			$token = sha1(uniqid());
			setcookie("X-Csrf-Token", $token, 0, "/");
			$_SESSION[$this->prefix] = $token;
		}

		$response = $next($request, $response);
		return $response;

	}

	protected function getJsonError() {
		$json = [
			"status" => 400,
			"message" => "Failed csrf check."
		];
		return json_encode($json);
	}

}