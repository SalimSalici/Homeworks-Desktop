<?php

namespace App\Middlewares;

class CsrfViewMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {

		$nameKey = $this->container->csrf->getTokenNameKey();
	    $valueKey = $this->container->csrf->getTokenValueKey();
	    $name = $request->getAttribute($nameKey);
	    $value = $request->getAttribute($valueKey);

	    $csrfInputs = "<input type='hidden' name='$nameKey' value='$name'>";
	    $csrfInputs .= "<input type='hidden' name='$valueKey' value='$value'>";

		$this->container
			 ->view
			 ->getEnvironment()
			 ->addGlobal("csrfInputs", $csrfInputs);

		$response = $next($request, $response);
		return $response;

	}

}