<?php

// ini_set('display_errors', 1); 
// ini_set('log_errors', 1); 
// ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
// error_reporting(E_ALL);

class json
{
	private $txt;

	public function __construct($txt) {
		$this->txt = $txt;
	}

	public function response()
	{
		// Initialize the result array
		//print_r($this->txt);
		$encoded_json = json_encode($this->txt);
		
		//Return JSON response.
		return $encoded_json;
	}
}
?>
