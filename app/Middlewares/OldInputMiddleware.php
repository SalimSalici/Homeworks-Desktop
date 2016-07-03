<?php

namespace App\Middlewares;

class OldInputMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {

		if (isset($_SESSION["oldInput"])) {
			$this->container
				 ->view
				 ->getEnvironment()
				 ->addGlobal("oldInput", $_SESSION["oldInput"]);
		}

		$_SESSION["oldInput"] = $request->getParams();

		$response = $next($request, $response);
		return $response;

	}

}