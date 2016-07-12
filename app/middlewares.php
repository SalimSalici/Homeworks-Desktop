<?php

$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));

$app->add(new \App\Middlewares\OldInputMiddleware($container));

$app->add(new \App\Middlewares\CsrfViewMiddleware($container));

$app->add(new \App\Middlewares\UserAuthMiddleware($container));

$app->add(new \App\Middlewares\FlashMiddleware($container));

$ajaxCsrfWhitelist = [
	"homework.removeHomework",
	"subject.addSubject",
	"subject.removeSubject",
	"class.create",
	"class.addDay",
	"class.join",
	"auth.signup",
	"auth.signup",
	"auth.signin",
	"auth.signout",
	"auth.signout",
	"auth.password.change"
];
$app->add(new \App\Middlewares\AjaxCsrfMiddleware($container, $ajaxCsrfWhitelist));

// Adding csrf middleware
$csrfWhitelist = [
	"homework.removeHomework.ajax",
	"homework.completeHomework.ajax",
	"homework.uncompleteHomework.ajax"
];
$app->add(new \App\Middlewares\CsrfMiddleware($container, $csrfWhitelist));

// $app->add($container->csrf);