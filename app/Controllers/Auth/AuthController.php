<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends Controller {

	public function getSignIn($request, $response) {
		return $this->view->render($response, "auth/signin.html.twig");
	}

	public function postSignIn($request, $response) {

		$validation = $this->validator->validate($request, [
			"email" => v::notEmpty()->email(),
			"password" => v::notEmpty()
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor("auth.signin"));		
		}

		$auth = $this->auth->attempt(
			$request->getParam("email"),
			$request->getParam("password")
		);

		if (!$auth) {
			// TODO: Flash message
			return $response->withRedirect($this->router->pathFor("auth.signin"));
		}

		return $response->withRedirect($this->router->pathFor("home"));

	}

	public function getSignOut($request, $response) {

		$this->auth->logout();
		return $response->withRedirect($this->router->pathFor("home"));
		
	}

	public function getSignUp($request, $response) {
		return $this->view->render($response, "auth/signup.html.twig");
	}

	public function postSignUp($request, $response) {

		$validation = $this->validator->validate($request, [
			"email" => v::notEmpty()->email()->emailAvailable(),
			"name" => v::notEmpty()->alpha(),
			"surname" => v::notEmpty()->alpha(),
			"password" => v::notEmpty()
		]);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor("auth.signup"));			
		}

		$email = $request->getParam("email");
		$name = $request->getParam("name");
		$surname = $request->getParam("surname");
		$password = $request->getParam("password");

		$user = User::create([
			"email" => $email,
			"name" => $name,
			"surname" => $surname,
			"password" => password_hash($password, PASSWORD_DEFAULT)
		]);

		$auth = $this->auth->attempt(
			$user->email,
			$password
		);

		return $response->withRedirect($this->router->pathFor("home"));

	}

}