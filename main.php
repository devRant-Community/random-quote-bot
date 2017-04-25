<?php

class Bot {
	private $token_id = 0;
	private $token_key = "";
	private $user_id = 0;

	function __construct($token_id, $token_key, $user_id){
		// Some configuration for the getQuote function
		if(ini_get("allow_url_fopen") != 1)
			ini_set("allow_url_fopen", 1);

		$this->token_id = $token_id;
		$this->token_key = $token_key;
		$this->user_id = $user_id;
	}

	function post($msg){
		// The data to send
		$postdata = [
			"app" => 3,
			"rant" => $msg,
			"tags" => "Random Quote",
			"token_id" => $this->token_id,
			"token_key" => $this->token_key,
			"user_id" => $this->user_id
		];

		// Make data useable for request
		$postdata = http_build_query($postdata);

		$url = 'https://www.devrant.io/api/devrant/rants';

		// Curl options
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Execute curl and get response
		$response = curl_exec($ch);
		return $response;
	}

	function getQuote(){
		// Get the JSON from an API
		$json = file_get_contents('http://quotes.stormconsultancy.co.uk/random.json');

		// Decode it to an array
		$quotedata = json_decode($json, true);

		// Clean quote
		$quotedata["quote"] = str_replace(['“', '”', '"'], "'", $quotedata["quote"]);

		// Format the quote
		$quote = "\"{$quotedata["quote"]}\" - {$quotedata["author"]}";

		// Return it
		return $quote;
	}
}

?>
