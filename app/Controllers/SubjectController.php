<?php

namespace App\Controllers;

use App\Models\Subject;
use App\Models\Classe;
use Illuminate\Database\QueryException;

class SubjectController extends Controller {

	public function addSubject($request, $response) {

		$tag = $_POST["classTag"];
		$class = Classe::where("tag", $tag)->first();

		$isAdmin = $class->hasAdmin($this->auth->user());

		if (!$isAdmin) {
			$this->flash->addMessage("error", "You cannot add subjects in this class.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
		}

		$subjects = $_POST["subjects"];

		$subjects = explode(",", $subjects);

		$rows = [];

		foreach ($subjects as $key => $subject) {
			$rows[] = [
				"name" => trim($subject),
				"id_class" => $class->id
			];
		}

		try {
			Subject::insert($rows);
			$this->flash->addMessage("success", "You just added some subjects.");
		} catch(QueryException $e) {
			if ($e->errorInfo[0] == 23000)
				$this->flash
					->addMessage("error", "Cannot add already present subjects.");
		}
		
		return $response
			->withRedirect($this->router
				->pathFor("class.page", ["tag" => $tag]));	
	}

	public function removeSubject($request, $response) {

		$tag = $_POST["classTag"];
		$subjectIds = $_POST["subjects"];
		$class = Classe::where("tag", $tag)->first();

		$isAdmin = $class->hasAdmin($this->auth->user());

		if (!$isAdmin) {
			$this->flash->addMessage("error", "You cannot add subjects in this class.");
			return $response
				->withRedirect($this->router
					->pathFor("class.page", ["tag" => $tag]));	
		}

		Subject::destroy($subjectIds);

		$this->flash->addMessage("success", "You just deleted some subjects.");
		return $response
			->withRedirect($this->router
				->pathFor("class.page", ["tag" => $tag]));
	}

}