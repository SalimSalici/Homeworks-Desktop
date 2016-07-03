<?php

session_start();

require_once("../vendor/autoload.php");

$ini_array = parse_ini_file("../app/config.ini");

$settings = require("settings.php");

$app = new \Slim\App($settings);

$container = $app->getContainer();

require_once("../app/dependencies.php");

require_once("../app/middlewares.php");

require_once("../app/routes.php");