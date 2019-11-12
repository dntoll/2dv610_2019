<?php


//ArrayUtilsTest.php
namespace test;



class Exceptions extends \TDD\TestClass {
	public function getSystemUnderTestInstance() {
		return new \ArrayUtils();
	}

	public function shouldThrowExceptionOnEmptyArray(\ArrayUtils $sut) {
		\TDD\Assert::expectException(new \Exception());
		$actual = $sut->max(array());
	}

	public function shouldThrowExceptionOnNonNumericInput(\ArrayUtils $sut) {
		\TDD\Assert::expectException(new \Exception());
		$actual = $sut->max(array("a"));
	}


}





