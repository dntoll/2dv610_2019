<?php

namespace test;

require_once("system/SocialSecurityNumber.php");




class IntegrationTests extends \TDD\TestClass {

	public function setUp() {
		$this->correctSSN = new \NumericString("0101010049");
		$this->wrongSSN = new \NumericString("0101010040");
	}

	//Integration Tests
	public function bornGirlShouldReturnSexOfBoy() {
		$dependency = new \NumericString("0101017697"); //a man from http://www.personnummer.nu/
		
		$sut = new \SocialSecurityNumber($dependency, new \Luhn());

		\TDD\Assert::assertFalse($sut->bornGirl());
	}

	public function bornGirlShouldReturnSexOfGirl() {
		$dependency = new \NumericString("0101010049"); //a female from http://www.personnummer.nu/
		
		$sut = new \SocialSecurityNumber($dependency, new \Luhn());

		\TDD\Assert::assertTrue($sut->bornGirl());
	}

	public function isLuhnShouldReturnTrueForCorrectSSN() {
		$sut = new \Luhn();

		\TDD\Assert::assertTrue($sut->isLuhn( $this->correctSSN ));
	}

	public function isLuhnShouldReturnFalseorWrongSSN() {
		$sut = new \Luhn();

		\TDD\Assert::assertFalse($sut->isLuhn( $this->wrongSSN ));
	}
	
}