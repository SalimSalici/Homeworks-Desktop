<?php

$settings = [

	"settings" => [

		"displayErrorDetails" => true,
		"db" => [
			"driver" => "mysql",
			"host" => $ini_array["host"],
			"database" => $ini_array["database"],
			"username" => $ini_array["username"],
			"password" => $ini_array["password"],
			"charset" => $ini_array["charset"],
			"collation" => $ini_array["collation"],
			"prefix" => "",
		]

	]
	
];

return $settings;