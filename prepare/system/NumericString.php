<?php


class NumericString {

	protected $numberString;

	public function __construct(String $input) {
		$chars = str_split($input);
		foreach($chars as $char){
			if (ctype_digit($char) == false) {
				throw new \Exception("Invalid input, NumericString only takes numbers and [$char] is not a string digit");
			} 
		}

		$this->numberString = $input;
	}


	public function getLength() : int {
		return strlen($this->numberString);
	}


	public function getAt(int $index) : int {
		return $this->numberString[$index];
	}
}