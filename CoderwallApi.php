<?php
class Coderwall_Api {
	public $username;
	public $name;
	public $location;
	public $endorsements;
	public $accounts;
	public $badges;
	public $success;

	/**
	 * Constructs a new instance of the coderwall api
	 * @param  string $username The username to get information about
	 * @return bool           True indicates success, false indicates faliure.
	 */
	function coderwall_api ($username) {
		// Call the API
		$response = self::webRequest("http://coderwall.com/{$username}.json");
		// Decode the JSON response
		$json = json_decode($response, true);

		if($json["username"] != $username) {
			$this->success = 0;
			return false;
		}
		
		// Save the values in the class variables
		$this->username = $json["username"];
		$this->name = $json["name"];
		$this->location = $json["location"];
		$this->endorsements = $json["endorsements"];
		$this->accounts = $json["accounts"];
		$this->badges = $json["badges"];
		$this->success = 1;
		
		return true;
	}

	/**
	 * Decides how to call the API
	 * @param  string $url The URL to call
	 * @return string      The response
	 */
	function webRequest ($url) {
		// Is curl installed?
		if (function_exists('curl_init')){
			// Yes, use CURL
			return self::_webRequestCurl($url);
		} else {
			// No, use alternative method
			return self::_webRequestAlternative($url);
		}
	}

	/**
	 * Calls the API with CURL
	 * @param  string $url The URL to call
	 * @return string      The response
	 */
	private function _webRequestCurl ($url) {
		// Create handle
		$ch = curl_init();

		// Set url
		curl_setopt($ch, CURLOPT_URL, $url);

		// Return instead of printing
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Timeout in seconds
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);

		// Download and save output
		$output = curl_exec($ch);

		// Clean up
		curl_close($ch);
		// Return result
		return $output;
	}

	/**
	 * Calls the API with file_get_contents
	 * @param  string $url The URL to call
	 * @return string      The response
	 */
	private function _webRequestAlternative ($url) {
		return @file_get_contents($url);
	} 
}
?>