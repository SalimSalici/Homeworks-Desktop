<?php

namespace App\Middlewares;

use Slim\Csrf\Guard;

class CsrfMiddleware extends Middleware {

	protected $whitelist = [];

	public function __construct($container, array $whitelist) {
		parent::__construct($container);
		$this->whitelist = $whitelist;
	}

	public function __invoke($request, $response, $next) {

		$guard = new Guard;

		$route = $request->getAttribute('route')->getName();

		// If current route name is not in whitelist, invoce Guard - slim/csrf
		if (!in_array($route, $this->whitelist))
			return $guard($request, $response, $next);

		$response = $next($request, $response);
		return $response;

	}

	public function setWhitelist(array $whitelist) {
		$this->whitelist = $whitelist;
		return $this;
	}

}