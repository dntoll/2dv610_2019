<?php


require_once("system/SocialSecurityNumber.php");

class SocialSecurityNumberTests extends \TDD\TestClass {

	public function getYearShouldReturnTheFirstTwoNumbers() {
		$stringMock = \PHPMock::Mock("\NumericString");
		$stringMock->whenCalled("getAt", 0)->thenReturn(0);
		$stringMock->whenCalled("getAt", 1)->thenReturn(1);

		$sut = new SocialSecurityNumber($stringMock);

		$actual = $sut->getYear();
		$expected = 1;
		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function getYearShouldReturnTheFirstTwoNumbers2() {
		$stringMock = \PHPMock::Mock("\NumericString");
		$stringMock->whenCalled("getAt", 0)->thenReturn(9);
		$stringMock->whenCalled("getAt", 1)->thenReturn(8);

		$sut = new SocialSecurityNumber($stringMock);

		$actual = $sut->getYear();
		$expected = 98;
		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function constructorShouldCallgetLength() {
		$stringMock = \PHPMock::Mock("\NumericString");
		$sut = new SocialSecurityNumber($stringMock);

		$stringMock->assertMethodWasCalled("getLength");
	}
}