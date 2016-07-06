<?php

namespace App\Controllers\User;

use App\Controllers\Controller;
use App\Models\User;

class UserProfileController extends Controller {

	public function profile($request, $response, $args) {

		$profileOwner = User::where("tag", $args["tag"])->first();

		$this->view->getEnvironment()
			->addGlobal("profileOwner", $profileOwner);

		return $this->view->render($response, "user/profile.html.twig");
	}

}