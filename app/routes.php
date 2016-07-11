<?php

use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;

$app->get("/", "HomeController:index")->setName("home");

$app->get("/user/{tag}", "UserProfileController:profile")->setName("user.profile");

$app->group("/class", function() {

	$this->group("", function() {

		$this->post("/day/add", "HomeworkController:addDay")->setName("class.addDay");

		$this->post("/subject/add", "SubjectController:addSubject")->setName("subject.addSubject");

		$this->post("/subject/remove", "SubjectController:removeSubject")->setName("subject.removeSubject");

		$this->get("/create", "ClassController:getCreateClass")->setName("class.create");

		$this->post("/create", "ClassController:postCreateClass");

	})->add(new AuthMiddleware($this->getContainer()));

	$this->get("/page/{tag}", "ClassController:getClassPage")->setName("class.page");

});

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

})->add(new AuthMiddleware($container));

// Ajax
$app->group("", function() {

	$this->post("/homework/remove/ajax", "HomeworkController:removeHomeworkAjax")
		->setName("homework.removeHomework.ajax");

	$this->post("/homework/complete/ajax", "HomeworkController:completeHomeworkAjax")
		->setName("homework.completeHomework.ajax");

	$this->post("/homework/uncomplete/ajax", "HomeworkController:uncompleteHomeworkAjax")
		->setName("homework.uncompleteHomework.ajax");

});