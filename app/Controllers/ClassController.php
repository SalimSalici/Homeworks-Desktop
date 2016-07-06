<?php

namespace App\Controllers;

use App\Models\Accessibility;
use App\Models\Classe;
use App\Models\UserClass;
use Respect\Validation\Validator as v;

class ClassController extends Controller {

	public function getClassPage($request, $response, $args) {

		$tag = $args["tag"];

		$classe = Classe::where("tag", $tag)->first();

		$info_userClass = [
			"hasJoined" => false,
			"isAdmin" => false
		];

		if ($this->auth->check()) {

			$where_class_user = [
				"id_user" => $this->auth->user()->id,
				"id_class" => $classe->id
			];

			$userClass = UserClass::where($where_class_user)->first();

			if ($userClass !== null) {
				$info_userClass["hasJoined"] = true;
				$info_userClass["isAdmin"] = $userClass->admin == 1 ? true : false;
			}

		}

		$this->view->getEnvironment()
			->addGlobal("info_userClass", $info_userClass);

		$this->view->getEnvironment()
			->addGlobal("class", $classe);

		return $this->view->render($response, "class/class.html.twig");
	}

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

		$tag = substr(preg_replace('/[0-9_\/]+/','',base64_encode(sha1(uniqid()))),0,11);

		while (Classe::where("tag", $tag)->first() != null)
			$tag = substr(preg_replace('/[0-9_\/]+/','',base64_encode(sha1(uniqid()))),0,11);

		$columns = [
			"name" => $request->getParam("name"),
			"id_creator" => $userId,
			"id_accessibility" => $request->getParam("accessibility"),
			"tag" => $tag
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