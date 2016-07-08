<?php

$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));

$app->add(new \App\Middlewares\OldInputMiddleware($container));

$app->add(new \App\Middlewares\CsrfViewMiddleware($container));

$app->add(new \App\Middlewares\UserAuthMiddleware($container));

$app->add(new \App\Middlewares\FlashMiddleware($container));

$app->add(new \App\Middlewares\AjaxCsrfMiddleware());

// Adding csrf middleware
$csrfWhitelist = ["homework.removeHomework.ajax"];
$app->add(new \App\Middlewares\CsrfMiddleware($container, $csrfWhitelist));

// $app->add($container->csrf);