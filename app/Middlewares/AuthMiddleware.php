<?php

namespace App\Middlewares;

class AuthMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {

		if (!$this->container->auth->check()) {
			$this->container->flash
				->addMessage("error", "You need to be signed in to access that page.");

			return $response
				->withRedirect($this->container->router->pathFor("auth.signin"));
		}

		$response = $next($request, $response);
		return $response;

	}

}
