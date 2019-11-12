<?php

namespace test;

require_once("system/SocialSecurityNumber.php");




class SocialSecurityNumberTest extends \TDD\TestClass {

	private $stringMock;

	public function setUp() {
		$this->stringMock = \PHPMock::Mock("\NumericString");
		$this->luhnMock = \PHPMock::Mock("\Luhn");
	}

	public function getSystemUnderTestInstance() {
		//Not really used here...
		return Null;
	}

	public function tearDown() {
		
	}

	public function constructorShouldThrowExceptionOnShortNumbers() {
		
		$this->stringMock->whenCalled("getLength")->thenReturn(9);


		\TDD\Assert::expectException(new \Exception());

		new \SocialSecurityNumber($this->stringMock, $this->luhnMock);
	}

	public function constructorShouldNOTThrowExceptionOn10characters() {
		$this->stringMock->whenCalled("getLength")->thenReturn(10);
		$this->luhnMock->whenCalled("isLuhn")->thenReturn(true);
		new \SocialSecurityNumber($this->stringMock, $this->luhnMock);
	}

	public function getYearShouldReturnFirstTwoCharactersAsNumber() {
		$this->stringMock->whenCalled("getLength")->thenReturn(10);
		$this->luhnMock->whenCalled("isLuhn")->thenReturn(true);
		$this->stringMock->whenCalled("getAt", 0)->thenReturn(1);
		$this->stringMock->whenCalled("getAt", 1)->thenReturn(2);

		$sut = new \SocialSecurityNumber($this->stringMock, $this->luhnMock);

		$actual = $sut->getYear();

		\TDD\Assert::assertEquals($actual, 12);
	}

	public function shouldThrowExceptionOnLuhnFalse() {
		$this->stringMock->whenCalled("getLength")->thenReturn(10);
		$this->luhnMock->whenCalled("isLuhn")->thenReturn(false);

		\TDD\Assert::expectException(new \Exception());
		$sut = new \SocialSecurityNumber($this->stringMock, $this->luhnMock);
	}

	public function shouldNotThrowExceptionOnLuhnTrue() {
		$this->stringMock->whenCalled("getLength")->thenReturn(10);
		$this->luhnMock->whenCalled("isLuhn")->thenReturn(true);

		$sut = new \SocialSecurityNumber($this->stringMock, $this->luhnMock);
	}

	public function shouldCallIsLuhn() {
		$this->stringMock->whenCalled("getLength")->thenReturn(10);
		$this->luhnMock->whenCalled("isLuhn")->thenReturn(true);

		$sut = new \SocialSecurityNumber($this->stringMock, $this->luhnMock);

		$this->luhnMock->assertMethodWasCalled("isLuhn");
	}

	
}