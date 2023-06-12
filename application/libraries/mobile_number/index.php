<?php
include('vendor/autoload.php');

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\PhoneNumber\PhoneNumberParseException;

//$number = PhoneNumber::parse('+333');
try {
    $number = PhoneNumber::parse('+923009401968');
	echo $number->getRegionCode().'<br>'; // GB
	echo $number->getCountryCode().'<br>'; // 44
	echo $number->getNationalNumber().'<br>'; // 7123456789
	echo $number->getNumberType().'<br>'; // 7123456789
	echo $number->isValidNumber().'<br>'; // 7123456789
	
	echo $number->format(PhoneNumberFormat::E164).'<br>'; // +41446681800
	echo $number->format(PhoneNumberFormat::INTERNATIONAL).'<br>'; // +41 44 668 18 00
	echo $number->format(PhoneNumberFormat::NATIONAL).'<br>'; // 044 668 18 00
	echo $number->format(PhoneNumberFormat::RFC3966).'<br>'; // tel:+41-44-668-18-00
}
catch (PhoneNumberParseException $e) {
	echo $e->getMessage();
}
