<?php

namespace App\Controllers;

use App\Models\Accessibility;
use App\Models\Classe;
use App\Models\UserClass;
use Respect\Validation\Validator as v;

class ClassController extends Controller {

	public function getCreateClass($request, $response) {

		$accessabilities = Accessibility::all()->sortBy("id")->toArray();

		$this->view->getEnvironment()
			->addGlobal("accessabilities", $accessabilities);

		return $this->view->render($response, "class/create.html.twig");
	}

	public function postCreateClass($request, $response) {

		$accessibility = $request->getParam("accessibility");

		$rules = [
			"name" => v::notEmpty()
		];

		if ($accessibility == 2)
			$rules["password"] = v::notEmpty();

		$validation = $this->validator->validate($request, $rules);

		if ($validation->failed()) {
			return $response->withRedirect($this->router->pathFor("class.create"));		
		}

		$userId = $this->auth->user()->id;

		$columns = [
			"name" => $request->getParam("name"),
			"id_creator" => $this->auth->user()->id,
			"id_accessibility" => $request->getParam("accessibility")
		];

		if ($accessibility == 2)
			$columns["password"] = $request->getParam("password"); // TODO: hash password

		$class = Classe::create($columns);

		$userClass = UserClass::create([
			"id_user" => $userId,
			"id_class" => $class->id,
			"admin" => 1
		]);

		$this->flash->addMessage("success", "Your class has been created.");

		return $response->withRedirect($this->router->pathFor("home"));
	}

}