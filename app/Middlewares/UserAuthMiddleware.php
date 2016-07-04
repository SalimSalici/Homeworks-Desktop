<?php

namespace App\Middlewares;

class UserAuthMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {

		$this->container
			->view
			->getEnvironment()
			->addGlobal("auth", [
				"check" => $this->container->auth->check(),	
				"user" => $this->container->auth->user()	
			]);

		$response = $next($request, $response);
		return $response;

	}

}