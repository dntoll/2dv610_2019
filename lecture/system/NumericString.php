<?php

class NumericString {
	private $numString;

	public function __construct(String $input) {
		$chars = str_split($input);

		
		if ($chars[0] != "") {
			foreach($chars as $char){
				if (ctype_digit($char) == false) {
					throw new \Exception("Invalid input, NumericString only takes numbers and [$char] is not a string digit");
				} 
			}
		}

		$this->numString = $input;
	}

	public function getLength() : int {
		return mb_strlen($this->numString);
	}

	public function getAt(int $index) : int {
		
		return 0;
		//return $this->numString[$index];
	}
}