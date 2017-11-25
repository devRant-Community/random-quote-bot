<?php

class Bot {
	private $token_id;
	private $token_key;
	private $user_id;

	private $store = "quoteids.json";
	private $quoteids = [];

	private $quotesFile = "quotes.json";
	private $quotes = [];

	function __construct($username, $password) {
		// Some configuration for the getQuote function
		if(ini_get("allow_url_fopen") != 1)
			ini_set("allow_url_fopen", 1);
		ignore_user_abort(true);

		// Get already posted quotes
		$json = file_get_contents($this->store);
		$this->quoteids = json_decode($json, true);

		// Get all quotes
		$this->quotes = json_decode(file_get_contents($this->quotesFile), true);

		// Login
		$this->login($username, $password);
	}

	function run() {
		/* Main function */

		// Get quote
		$quote = $this->getQuotes();

		// Post quote
		$this->post($quote);
	}

	function post($msg) {
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

		$url = 'https://www.devrant.com/api/devrant/rants';

		// Curl options
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		// Execute curl and get response
		$response = curl_exec($curl);
		return $response;
	}

	function getQuotes() {
		// Get the next quote
		$quoteNum = $this->nextQuote();
		$quotedata = $this->quotes[$quoteNum];

		// Save quote ID
		array_push($this->quoteids, $quoteNum);
		$this->saveRespostIDs();

		// Clean quote
		$quotedata["quote"] = str_replace(['“', '”', '"'], "'", $quotedata["quote"]);

		// Format the quote
		$quotemsg = "\"{$quotedata["quote"]}\" - {$quotedata["author"]}";

		// Return the data
		return $quotemsg;
	}

	function login($username, $password) {
		// The data to send
		$postdata = [
			"app" => 3,
			"plat" => 3,
			"username" => $username,
			"password" => $password
		];

		// Make data useable for request
		$postdata = http_build_query($postdata);

		$url = 'https://devrant.com/api/users/auth-token';

		// Curl options
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		// Execute curl and get response
		$response = json_decode(curl_exec($curl), true);

		$this->token_id = $response["auth_token"]["id"];
		$this->token_key = $response["auth_token"]["key"];
		$this->user_id = $response["auth_token"]["user_id"];
	}

	function nextQuote() {
		return count($this->quoteids);
	}

	function saveRespostIDs() {
		// Encode to JSON
		$json = json_encode($this->quoteids);

		// Save to file
		file_put_contents($this->store, $json);
	}
}

?>
