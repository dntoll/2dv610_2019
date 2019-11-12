<?php

class Luhn {
	public function isLuhn(NumericString $s) {

		//$controllNumber = $s->getAt($s->getLength()-1);
		$multiplyByTwo = false;

		$sum = 0;
		for ($i = $s->getLength()-1; $i >= 0; $i--) {

			$number = $s->getAt($i);
			if ($multiplyByTwo) {
				$number *= 2;
				if ($number >= 10) {
					$sum += 1 + ($number - 10);
				} else {
					$sum += $number;
				}
			} else {
				$sum += $number;
			}

		
			$multiplyByTwo = !$multiplyByTwo;
		}

		return $sum % 10 == 0;
	}
}