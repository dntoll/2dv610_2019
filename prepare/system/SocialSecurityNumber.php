<?php

require_once("system/NumericString.php");
require_once("system/Luhn.php");

class SocialSecurityNumber {

	const LENGTH = 10;
	private $numString;

	public function __construct(NumericString $str, Luhn $alg) {

		if ($str->getLength() != self::LENGTH) {
			throw new \Exception("SocialSecurityNumber has ten characters");
		}

		if ($alg->isLuhn($str) == false) {
			throw new \Exception("SocialSecurityNumber must follow Luhn");	
		}

		$this->numString = $str;
	}

	public function getYear() : int {

		$tens = $this->numString->getAt(0);
		$onces = $this->numString->getAt(1);
		return $tens * 10 + $onces;
	}

	public function bornGirl() : bool {

		$secondLast = $this->numString->getAt(self::LENGTH-2);

		if ($secondLast % 2 == true) // odd
			return false;
		return true;
	}


}