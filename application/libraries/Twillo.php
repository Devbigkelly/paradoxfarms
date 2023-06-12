<?php
include('twillo/vendor/autoload.php');

class Twillo {
	
	private $CI;

	function __construct() {
       $this->CI =& get_instance();
       $this->CI->load->database();
	}
	function send_message($to, $body){
		
		$twillo_phone_number = $this->CI->db->query("SELECT * FROM options WHERE option_name = 'twillo_phone_number'")->row('option_value');
		$twillo_sid = $this->CI->db->query("SELECT * FROM options WHERE option_name = 'twillo_sid'")->row('option_value');
		$twillo_token = $this->CI->db->query("SELECT * FROM options WHERE option_name = 'twillo_token'")->row('option_value');
		
		$curl = curl_init();
		
		$client = new Twilio\Rest\Client($twillo_sid, $twillo_token);
		
		
		try {
			$message = $client->messages->create(
			  $to, // Text this number
			  [
				'from' => $twillo_phone_number, // From a valid Twilio number
				'body' => $body
			  ]);
			  return true;
		} catch (exception $e) {
			return false;
			//echo $e->getMessage();
		}
	}
}

