<?php

namespace test;

require_once("system/SocialSecurityNumber.php");




class SocialSecurityNumberTest extends \TDD\TestClass {

	private $okNumStringMock;

	public function setUp() {
		$this->okNumStringMock = \PHPMock::Mock("\NumericString");
		$this->okNumStringMock->whenCalled("getLength")->thenReturn(10);

		$this->okLuhnMock = \PHPMock::Mock("\Luhn");
		$this->okLuhnMock->whenCalled("isLuhn")->thenReturn(true);
		//$this->okLuhnMock->whenCalled("isLuhn",1)->thenReturn(true);

		$this->okSUT = new \SocialSecurityNumber($this->okNumStringMock, $this->okLuhnMock);
	}

	public function constructorShouldThrowExceptionOnShortNumbers() {
		$toShortStringMock = \PHPMock::Mock("\NumericString");
		$toShortStringMock->whenCalled("getLength")->thenReturn(9);

		\TDD\Assert::expectException(new \Exception());

		new \SocialSecurityNumber($toShortStringMock, $this->okLuhnMock);
	}

	public function shouldThrowExceptionOnLuhnFalse() {
		$notLuhnMock = \PHPMock::Mock("\Luhn");
		$notLuhnMock->whenCalled("isLuhn")->thenReturn(false);

		\TDD\Assert::expectException(new \Exception());
		$sut = new \SocialSecurityNumber($this->okNumStringMock, $notLuhnMock);
	}

	public function getYearShouldReturnFirstTwoCharactersAsNumber() {
		$this->okNumStringMock->whenCalled("getAt", 0)->thenReturn(1);
		$this->okNumStringMock->whenCalled("getAt", 1)->thenReturn(2);

		$sut = new \SocialSecurityNumber($this->okNumStringMock, $this->okLuhnMock);

		$actual = $sut->getYear();

		\TDD\Assert::assertEquals($actual, 12);
	}

	

	public function shouldCallIsLuhn() {
		$this->okLuhnMock->assertMethodWasCalled("isLuhn");
	}

	
}