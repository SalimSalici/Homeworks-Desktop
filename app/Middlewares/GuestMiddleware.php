<?php

namespace App\Middlewares;

class GuestMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {

		if ($this->container->auth->check()) {
			$this->container->flash
				->addMessage("error", "You need to be signed out to access that page.");

			return $response
				->withRedirect($this->container->router->pathFor("home"));
		}

		$response = $next($request, $response);
		return $response;

	}

}
