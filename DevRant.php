<?php

class DevRant {
	private $token_id;
	private $token_key;
	private $user_id;

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
		curl_close($curl);

		$this->token_id = $response["auth_token"]["id"];
		$this->token_key = $response["auth_token"]["key"];
		$this->user_id = $response["auth_token"]["user_id"];

		return $response;
	}

	function postRant($msg) {
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
		$url = 'https://devrant.com/api/devrant/rants';

		// Curl options
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		// Execute curl and get response
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}
}
