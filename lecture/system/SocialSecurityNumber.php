<?php


class SocialSecurityNumber {

	private $numString;

	public function __construct(NumericString $input) {

		if ($input->getLength() != 10) {
			throw new \Exception();
		}

		$this->numString = $input;
	}

	public function getYear() : int {
		return $this->numString->getAt(0) * 10 + $this->numString->getAt(1);
	}
}