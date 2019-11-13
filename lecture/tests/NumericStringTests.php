<?php


require_once("system/NumericString.php");

class NumericStringTests extends \TDD\TestClass {


	

	public function getLengthShouldReturnZeroForEmptyStrings() {
		$sut = new NumericString("");

		$expected = 0;
		$actual = $sut->getLength();

		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function getLengthShouldReturnOneForOneDigit() {
		$sut = new NumericString("0");

		$expected = 1;
		$actual = $sut->getLength();

		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function getAtShouldReturnNumberAtPosZero() {
		$sut = new NumericString("9");

		$expected = 9;
		$actual = $sut->getAt(0);

		\TDD\Assert::assertEquals($actual, $expected);
	}	

	public function getAtShouldReturnNumberAtPosOne() {
		$sut = new NumericString("98");

		$expected = 8;
		$actual = $sut->getAt(1);

		\TDD\Assert::assertEquals($actual, $expected);
	}	

	public function constructorShouldThrowExceptionOnNonNumericStrings() {
		\TDD\Assert::expectException(new \Exception());

		$sut = new NumericString("a");
	}

}