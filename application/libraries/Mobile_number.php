<?php
include('mobile_number/vendor/autoload.php');

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\PhoneNumber\PhoneNumberParseException;

class Mobile_number {
	public function set_format($number){
		$number      = str_replace('+','',$number);
		$number      = str_replace(' ','',$number);
		$number      = str_replace('_','',$number);
		$number      = str_replace('-','',$number);
		$number = '+'.$number;
		return $number;
	}
	public function is_valid_number($number){
		$number = $this->set_format($number);
		try {
			$number = PhoneNumber::parse($number);
			if ($number->isValidNumber()){
				return true;
			} else {
				return false;
			}
		} catch (PhoneNumberParseException $e) {
			return false;
		}
	}
	public function region_code($number){
		$number = $this->set_format($number);
		try {
			$number = PhoneNumber::parse($number);
			return $number->getRegionCode();
		} catch (PhoneNumberParseException $e) {
			echo $e->getMessage();
		}
	}
	public function country_code($number){
		$number = $this->set_format($number);
		try {
			$number = PhoneNumber::parse($number);
			return $number->getCountryCode();
		} catch (PhoneNumberParseException $e) {
			echo $e->getMessage();
		}
	}
	public function national_number($number){
		$number = $this->set_format($number);
		try {
			$number = PhoneNumber::parse($number);
			return $number->format(PhoneNumberFormat::NATIONAL);
		} catch (PhoneNumberParseException $e) {
			echo $e->getMessage();
		}
	}
	public function international_number($number){
		$number = $this->set_format($number);
		try {
			$number = PhoneNumber::parse($number);
			return $number->format(PhoneNumberFormat::INTERNATIONAL);
		} catch (PhoneNumberParseException $e) {
			echo $e->getMessage();
		}
	}
	public function system_number($number){
		$number = $this->set_format($number);
		try {
			$number = PhoneNumber::parse($number);
			return $number->format(PhoneNumberFormat::E164);
		} catch (PhoneNumberParseException $e) {
			echo $e->getMessage();
		}
	}
}

