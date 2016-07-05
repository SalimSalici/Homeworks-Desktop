<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Classe;

class HomeController extends Controller {

	public function index($request, $response) {

		if ($this->auth->check()) {

			$userId = $this->auth->user()->id;

			$userClasses = Classe::where("id_creator", $userId)
				->get()->sortBy("name")->toArray();

			$this->view->getEnvironment()
				->addGlobal("userClasses", $userClasses);
		}

		return $this->view->render($response, "home.html.twig");
	}

}