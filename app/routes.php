<?php

use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

$app->get("/", "HomeController:index")->setName("home");



$app->group("", function() {

	$this->get("/signup", "AuthController:getSignUp")->setName("auth.signup");
	$this->post("/signup", "AuthController:postSignUp");

	$this->get("/signin", "AuthController:getSignIn")->setName("auth.signin");
	$this->post("/signin", "AuthController:postSignIn");
	
})->add(new GuestMiddleware($container));

$app->group("", function() {

	$this->get("/signout", "AuthController:getSignOut")->setName("auth.signout");

	$this->get("/password/change", "PasswordController:getChangePassword")
		->setName("auth.password.change");

	$this->post("/password/change", "PasswordController:postChangePassword");

	$this->get("/class/create", "ClassController:getCreateClass")->setName("class.create");

	$this->post("/class/create", "ClassController:postCreateClass");

})->add(new AuthMiddleware($container));