<?php

namespace test;

require_once("system/Luhn.php");


class LuhnTest extends \TDD\TestClass {

	public function setUp() {
		$this->sut = new \Luhn();
		$this->stringMock = \PHPMock::Mock("\NumericString");	
		$this->stringMock->whenCalled("getLength")->thenReturn(2);
	}

	public function isLuhnShouldReturnTrueForCorrectShort() {
		$this->stringMock->whenCalled("getAt", 0)->thenReturn(8); //18 2*1 + 1*8 = 10 == 10
		$this->stringMock->whenCalled("getAt", 1)->thenReturn(1);
		
		\TDD\Assert::assertTrue($this->sut->isLuhn( $this->stringMock ));
	}
	public function isLuhnShouldReturnFalseForWrongShort() {
		$this->stringMock->whenCalled("getAt", 0)->thenReturn(7); //17 -> 2*1 + 7 = 9 != 10
		$this->stringMock->whenCalled("getAt", 1)->thenReturn(1);

		\TDD\Assert::assertFalse($this->sut->isLuhn( $this->stringMock ));
	}

	

	
}