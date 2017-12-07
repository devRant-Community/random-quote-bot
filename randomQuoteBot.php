<?php

require "DevRant.php";

class RandomQuoteBot {
	private $store = "quoteids.json";
	private $quoteids = [];

	private $quotesFile = "quotes.json";
	private $quotes = [];

	private $devRant;

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

		// New DevRant object
		$this->devRant = new DevRant();

		// Login
		$this->devRant->login($username, $password);
	}

	function run() {
		/* Main function */

		// Get quote
		$quote = $this->getQuotes();

		// Post quote
		$this->devRant->postRant($quote, "Random Quote");
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
