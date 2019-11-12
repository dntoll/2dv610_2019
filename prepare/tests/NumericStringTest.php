<?php

namespace test;

require_once("system/NumericString.php");


class NumericStringTest extends \TDD\TestClass {

	public function constructorShouldThrowExceptionOnCharacter() {
		\TDD\Assert::expectException(new \Exception());
		$sut = new \NumericString("a");
	}

	public function constructorShouldThrowExceptionOnTwoCharacters() {
		\TDD\Assert::expectException(new \Exception());
		$sut = new \NumericString("ab");
	}

	public function constructorShouldThrowExceptionOnPlus() {
		\TDD\Assert::expectException(new \Exception());
		$sut = new \NumericString("+");
	}

	public function constructorShouldNotThrowExceptionOnValidStrings() {
		$sut = new \NumericString("0");
	}

	public function getLengthReturnsLengthOfString() {
		$sut = new \NumericString("0");
		$actual = $sut->getLength();
		$expected = 1;
		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function getLengthReturnsLengthOfString2() {
		$sut = new \NumericString("00");
		\TDD\Assert::assertEquals($sut->getLength(), 2);
	}

	public function getAt() {
		$sut = new \NumericString("01");
		\TDD\Assert::assertEquals($sut->getAt(0), 0);
		\TDD\Assert::assertEquals($sut->getAt(1), 1);
	}

	public function isPlusANumber() {
		\TDD\Assert::assertTrue('+' >= 0 && '+' <= 9);
		\TDD\Assert::assertFalse(ctype_digit('+'), "plus is a int?");
		\TDD\Assert::assertTrue(ctype_digit('0'), "0 is an int?");
	}

	
}