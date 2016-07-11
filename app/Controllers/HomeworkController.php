<?php

namespace App\Controllers;

use App\Models\Homework;
use App\Models\Classe;
use App\Models\Completed;

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

		$jsonObj = [
			"status" => 201,
			"message" => "You removed some homeworks."
		];

		$jsonObj = json_encode($jsonObj);

		$response = $response->withStatus(201);

		return $response->write($jsonObj);

	}

	public function completeHomeworkAjax($request, $response) {

		$response = $response->withHeader('Content-type', 'application/json');

		$tag = $_POST["classTag"];

		$class = Classe::where("tag", $tag)->first();
		$user = $this->auth->user();

		$isMember = $class->hasMember($this->auth->user());

		if (!$isMember) {
			$this->flash->addMessage("error", "You are not a member of this class.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
		}

		$homeworkId = $_POST["homeworkId"];

		Completed::create([
			"id_user" => $user->id,
			"id_homework" => $homeworkId
		]);

		$jsonObj = [
			"status" => 201,
			"message" => "You completed some homeworks."
		];

		$jsonObj = json_encode($jsonObj);

		$response = $response->withStatus(201);

		return $response->write($jsonObj);

	}

	public function uncompleteHomeworkAjax($request, $response) {

		$response = $response->withHeader('Content-type', 'application/json');

		$tag = $_POST["classTag"];

		$class = Classe::where("tag", $tag)->first();
		$user = $this->auth->user();

		$isMember = $class->hasMember($this->auth->user());

		if (!$isMember) {
			$this->flash->addMessage("error", "You are not a member of this class.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
		}

		$homeworkId = $_POST["homeworkId"];

		Completed::where([
			"id_user" => $user->id,
			"id_homework" => $homeworkId
		])->delete();

		$jsonObj = [
			"status" => 201,
			"message" => "You uncompleted some homeworks."
		];

		$jsonObj = json_encode($jsonObj);

		$response = $response->withStatus(201);

		return $response->write($jsonObj);

	}

}

/* TRASH

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

*/