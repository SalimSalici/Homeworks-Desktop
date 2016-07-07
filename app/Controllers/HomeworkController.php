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

		$this->flash->addMessage("Success", "You added some homeworks.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
	}

}