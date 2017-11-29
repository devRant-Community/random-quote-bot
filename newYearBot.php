<?php

require "DevRant.php";

class newYearBot {
	private $devRant;

	private $newYearMsg = "Happy new year everyone!";

	function __construct($username, $password) {
		// Some configuration for the getQuote function
		if(ini_get("allow_url_fopen") != 1)
			ini_set("allow_url_fopen", 1);
		ignore_user_abort(true);

		// New DevRant object
		$this->devRant = new DevRant();

		// Login
		$this->devRant->login($username, $password);
	}

	function run() {
		/* Main function */

		// Post quote
		$this->devRant->postRant($this->newYearMsg);
	}
}