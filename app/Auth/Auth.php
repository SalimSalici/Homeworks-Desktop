<?php

namespace App\Auth;

use \App\Models\User;

class Auth {

	public function attempt($email, $password) {

		$user = User::where("email", $email)->first();

		if (!$user) return false;

	}

}