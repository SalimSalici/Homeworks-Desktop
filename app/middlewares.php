<?php

$app->add(new \App\Middlewares\ValidationErrorsMiddleware($container));

$app->add(new \App\Middlewares\OldInputMiddleware($container));
