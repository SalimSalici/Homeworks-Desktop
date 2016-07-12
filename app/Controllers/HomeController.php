<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserClass;

class HomeController extends Controller {

	public function index($request, $response) {

		if ($this->auth->check()) {

			$user = $this->auth->user();

			$userClasses = $user->classes->sortBy("name")->toArray();

			$this->view->getEnvironment()
				->addGlobal("userClasses", $userClasses);
		}

		return $this->view->render($response, "home.html.twig");
	}

}