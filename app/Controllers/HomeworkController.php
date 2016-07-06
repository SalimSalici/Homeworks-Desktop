<?php

namespace App\Controllers;

use App\Models\Classe;

class HomeworkController extends Controller {

	public function addDay($request, $response) {

		var_dump($_POST);

		die();

		return $this->view->render($response, "home.html.twig");
	}

}