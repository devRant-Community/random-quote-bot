<?php

class Bot {
	private $token_id = 0;
	private $token_key = "";
	private $user_id = 0;

	private $store = "quoteids.json";
	private $quoteids = [];

	function __construct($token_id, $token_key, $user_id) {
		// Some configuration for the getQuote function
		if(ini_get("allow_url_fopen") != 1)
			ini_set("allow_url_fopen", 1);
		ignore_user_abort(true);

		// Get already posted quotes
		$json = file_get_contents($this->store);
		$this->quoteids = json_decode($json, true);

		// Set vars
		$this->token_id = $token_id;
		$this->token_key = $token_key;
		$this->user_id = $user_id;
	}

	function run() {
		/* Main function */

		// Get quote
		$quote = $this->getQuote();

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

	function getQuotes() {
		// Get the JSON from an API
		$json = file_get_contents('http://quotes.stormconsultancy.co.uk/quotes.json');

		// Decode it to an array
		$allquotes = json_decode($json, true);

		// If all available quotes are sent once, start again
		if(count($allquotes) == count($this->quoteids)){
			$this->quoteids = [];
		}

		// Get a random quote
		do {
			$quotedata = $allquotes[rand(0, count($allquotes))];
		} while($this->checkRepost($quotedata["id"]));

		// Save quote ID
		array_push($this->quoteids, $quotedata["id"]);
		$this->saveRespostIDs();

		// Clean quote
		$quotedata["quote"] = str_replace(['“', '”', '"'], "'", $quotedata["quote"]);

		// Format the quote
		$quotemsg = "\"{$quotedata["quote"]}\" - {$quotedata["author"]}";

		// Return the data
		return $quotemsg;
	}

	function checkRepost($quoteid) {
		// Check if quote ID already exists
		if(in_array($quoteid, $this->quoteids))
			return true;
		return false;
	}

	function saveRespostIDs() {
		// Encode to JSON
		$json = json_encode($this->quoteids);

		// Save to file
		file_put_contents($this->store, $json);
	}
}

?>
