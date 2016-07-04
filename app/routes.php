<?php

$app->get("/", "HomeController:index")->setName("home");

$app->get("/signup", "AuthController:getSignUp")->setName("auth.signup");
$app->post("/signup", "AuthController:postSignUp");

$app->get("/signin", "AuthController:getSignIn")->setName("auth.signin");
$app->post("/signin", "AuthController:postSignIn");

$app->get("/signout", "AuthController:getSignOut")->setName("auth.signout");

$app->get("/password/change", "PasswordController:getChangePassword")
	->setName("auth.password.change");
	
$app->post("/password/change", "PasswordController:postChangePassword");