<?php

require_once __DIR__ . '/infobip/vendor/autoload.php';

use infobip\api\client\SendSingleTextualSms;
use infobip\api\configuration\BasicAuthConfiguration;
use infobip\api\model\sms\mt\send\textual\SMSTextualRequest;

class Infobip{
	function __construct() {
       $this->CI =& get_instance();
       $this->CI->load->database();
	}
	function send_message($to, $body){
		$infobip_phone_number = $this->CI->db->query("SELECT * FROM options WHERE option_name = 'infobip_phone_number'")->row('option_value');
		$infobip_username = $this->CI->db->query("SELECT * FROM options WHERE option_name = 'infobip_username'")->row('option_value');
		$infobip_password = $this->CI->db->query("SELECT * FROM options WHERE option_name = 'infobip_password'")->row('option_value');
	
		// Initializing SendSingleTextualSms client with appropriate configuration
		$client = new SendSingleTextualSms(new BasicAuthConfiguration($infobip_username, $infobip_password));

		// Creating request body
		$requestBody = new SMSTextualRequest();
		$requestBody->setFrom($infobip_phone_number);
		$requestBody->setTo([$to]);
		$requestBody->setText($body);
		
		try {
			$response = $client->execute($requestBody);
			/*$sentMessageInfo = $response->getMessages()[0];
			echo "Message ID: " . $sentMessageInfo->getMessageId() . "\n";
			echo "Receiver: " . $sentMessageInfo->getTo() . "\n";
			echo "Message status: " . $sentMessageInfo->getStatus()->getName();*/
			return true;
		} catch (Exception $exception) {
			/*echo "HTTP status code: " . $exception->getCode() . "\n";
			echo "Error message: " . $exception->getMessage();*/
			return false;
		}
	}
}

