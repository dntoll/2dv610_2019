<?php

namespace depInjection;

require_once("TDD/TDD.php");
require_once("index.php");

class NumericArray {
	private $numbers = array();

	public function set(array $input) {
		foreach($input as $key => $num) {
			if (is_numeric($num)) {
				$this->numbers[$key] = $num;
			} else {
				throw new \Exception("Not a number");
			}
		}
	}

	public function get() : array {
		return $this->numbers;
	}

	public function isEmpty() {
		return true;
	}
}


class ArrayUtils {

	public function max(NumericArray $inputs) {
		if ($inputs->isEmpty()) {
			throw new \Exception("Cannot find max on empty array");
		}

		$max = PHP_INT_MIN;
		foreach ($inputs->get() as $number) {
			if ($max < $number) 
			{
				$max = $number;
			}
		}
		return $max;
	}
}




class NumericArrayTests extends \TDD\TestClass {
	public function getSystemUnderTestInstance() {
		return new NumericArray();
	}


	public function shouldThrowExceptionOnNonNumericInput(NumericArray $sut) {
		\TDD\Assert::expectException(new \Exception());
		$actual = $sut->set(array("a"));
	}

	public function shouldShowEmptyForEmptyArrays(NumericArray $sut) {
		$actual = $sut->set(array());
		
		\TDD\Assert::assertTrue($sut->isEmpty());
	}
}

class ArrayUtilsTest extends \TDD\TestClass {
	public function getSystemUnderTestInstance() {
		return new ArrayUtils();
	}

	public function shouldReturnLastIfHighest(ArrayUtils $sut) {
		$actual = $sut->max(new NumericArrayStub(array(1,2)));
		$expected = 2;

		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function shouldReturnFirstIfHighest(ArrayUtils $sut) {
		$actual = $sut->max(new NumericArrayStub(array(2,1)));
		$expected = 2;

		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function shouldThrowExceptionOnEmptyArray(ArrayUtils $sut) {
		\TDD\Assert::expectException(new \Exception());

		
		$actual = $sut->max(new NumericArrayEmptyStub());
	}
}

class NumericArrayStub extends NumericArray {

	public function __construct(array $input) {
		$this->a = $input;
	}

	public function get() : array{
		return $this->a;
	}

	public function isEmpty() {
		return false;
	}
}

class NumericArrayEmptyStub extends NumericArray {
	public function isEmpty() {
		return true;
	}
}

class NumericArrayNotEmptyStub extends NumericArray {
	public function isEmpty() {
		return false;
	}
}








//tests.php
use TDD\TestSuite;
$testSuite = new TestSuite();
$testSuite->addTest(new NumericArrayTests());
$testSuite->addTest(new ArrayUtilsTest());
$testSuite->runTests();
$testSuite->showResults();