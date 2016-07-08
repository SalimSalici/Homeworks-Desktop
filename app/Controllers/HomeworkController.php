<?php

namespace App\Controllers;

use App\Models\Homework;
use App\Models\Classe;

class HomeworkController extends Controller {

	public function addDay($request, $response) {

		$tag = $_POST["classTag"];

		$class = Classe::where("tag", $tag)->first();

		$isAdmin = $class->hasAdmin($this->auth->user());

		if (!$isAdmin) {
			$this->flash->addMessage("error", "You cannot add homeworks in this class.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
		}

		$classId = $class->id;
		$consignDate = $_POST["consignDate"];
		$subjectId = $_POST["subjectId"];
		$subjectHomework = $_POST["subjectHomework"];

		$rows = [];

		foreach ($subjectId as $key => $subId) {
			
			$rows[] = [
				"id_class" => $classId,
				"consignDate" => $consignDate,
				"id_subject" => $subId,
				"description" => $subjectHomework[$key],
				"consignDate" => $consignDate
			];

		}

		Homework::insert($rows);

		$this->flash->addMessage("success", "You added some homeworks.");
		return $response
			->withRedirect($this->router
				->pathFor("class.page", ["tag" => $tag]));	
	}

	public function removeHomework($request, $response) {

		$tag = $_POST["classTag"];

		$class = Classe::where("tag", $tag)->first();

		$isAdmin = $class->hasAdmin($this->auth->user());

		if (!$isAdmin) {
			$this->flash->addMessage("error", "You cannot remove homeworks in this class.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
		}

		$homeworkId = $_POST["homeworkId"];
		Homework::destroy([$homeworkId]);
		
		$this->flash->addMessage("success", "You removed some homeworks.");
		return $response
			->withRedirect($this->router
				->pathFor("class.page", ["tag" => $tag]));	

	}

	public function removeHomeworkAjax($request, $response) {

		$response = $response->withHeader('Content-type', 'application/json');

		$tag = $_POST["classTag"];

		$class = Classe::where("tag", $tag)->first();

		$isAdmin = $class->hasAdmin($this->auth->user());

		if (!$isAdmin) {
			$this->flash->addMessage("error", "You cannot remove homeworks in this class.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
		}

		$homeworkId = $_POST["homeworkId"];
		Homework::destroy([$homeworkId]);

		$nameKey = $this->container->csrf->getTokenNameKey();
	    $valueKey = $this->container->csrf->getTokenValueKey();
	    $name = $request->getAttribute($nameKey);
	    $value = $request->getAttribute($valueKey);

		$jsonObj = [
			"status" => 201,
			"message" => "You removed some homeworks."
		];

		$jsonObj = json_encode($jsonObj);

		$response = $response->withStatus(201);

		return $response->write($jsonObj);

	}

}