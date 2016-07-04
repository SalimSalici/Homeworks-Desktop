<?php

use Respect\Validation\Validator as v;

// Setting up Eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container["settings"]["db"]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container["db"] = function($container) use ($capsule) {
	return $capsule;
};

// Setting up Twig
$container["view"] = function($container) {

	$view = new \Slim\Views\Twig('../resources/views', [
        'cache' => false // 'path/to/cache' TODO: Re-enable cache
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;

};

// Setting up Validator
$container["validator"] = function($container) {
	return new \App\Validation\Validator;
};

v::with("App\\Validation\\Rules\\");

// Setting up CSRF
$container["csrf"] = function($container) {
    return new \Slim\Csrf\Guard;
};

// Setting up Auth
$container["auth"] = function($container) {
    return new \App\Auth\Auth;
};

// Setting up Controllers
$container["HomeController"] = function($container) {
	return new \App\Controllers\HomeController($container);
};

$container["AuthController"] = function($container) {
	return new \App\Controllers\Auth\AuthController($container);
};