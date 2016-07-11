<?php

namespace App\Middlewares;

class Middleware {

	protected $container;

	protected $whitelist = [];

	public function __construct($container, array $whitelist = []) {
		$this->container = $container;
		$this->whitelist = $whitelist;
	}

	public function setWhitelist(array $whitelist) {
		$this->whitelist = $whitelist;
		return $this;
	}

}