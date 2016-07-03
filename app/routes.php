<?php

$app->get("/", "HomeController:index")->setName("home");

$app->get("/signup", "AuthController:getSignUp")->setName("auth.signup");
$app->post("/signup", "AuthController:postSignUp");