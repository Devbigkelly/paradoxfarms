<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use infobip\api\client\SendSingleTextualSms;
use infobip\api\configuration\BasicAuthConfiguration;
use infobip\api\model\sms\mt\send\textual\SMSTextualRequest;

$username = 'idamjad';
$password = 'y2Lbc20cv@2890';

$from = '+923009401968';
$to = '+923009401968';
$message = 'This is an example message.';

// Initializing SendSingleTextualSms client with appropriate configuration
$client = new SendSingleTextualSms(new BasicAuthConfiguration($username, $password));

// Creating request body
$requestBody = new SMSTextualRequest();
$requestBody->setFrom($from);
$requestBody->setTo([$to]);
$requestBody->setText($message);

// Executing request
try {
    $response = $client->execute($requestBody);
    $sentMessageInfo = $response->getMessages()[0];
    echo "Message ID: " . $sentMessageInfo->getMessageId() . "\n";
    echo "Receiver: " . $sentMessageInfo->getTo() . "\n";
    echo "Message status: " . $sentMessageInfo->getStatus()->getName();
} catch (Exception $exception) {
    echo "HTTP status code: " . $exception->getCode() . "\n";
    echo "Error message: " . $exception->getMessage();
}