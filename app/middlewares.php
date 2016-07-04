<?php

$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));

$app->add(new \App\Middlewares\OldInputMiddleware($container));

$app->add(new \App\Middlewares\CsrfViewMiddleware($container));

$app->add(new \App\Middlewares\UserAuthMiddleware($container));

$app->add(new \App\Middlewares\FlashMiddleware($container));

$app->add($container->csrf);