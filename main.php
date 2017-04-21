<?php

class Bot {
	function __construct(){
		// Some configuration for the getQuote function
		if(ini_get("allow_url_fopen") != 1)
			ini_set("allow_url_fopen", 1);
	}

	function post($msg){
		// WIP - maybe I'll have to use a library...
	}

	function getQuote(){
		// Get the JSON from an API
		$json = file_get_contents('http://quotes.stormconsultancy.co.uk/random.json');

		// Decode it to an array
		$array = json_decode($json, true);

		// Return it
		return $array;
	}
}

?>
