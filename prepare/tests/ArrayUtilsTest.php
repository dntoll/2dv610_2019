<?php

namespace test;






class ArrayUtilsTest extends \TDD\TestClass {
	public function getSystemUnderTestInstance() {
		return new \ArrayUtils();
	}

	public function shouldReturnLastIfHighest(\ArrayUtils $sut) {
		$actual = $sut->max(array(1, 2));
		$expected = 2;

		\TDD\Assert::assertEquals($actual, $expected);
	}

	public function shouldReturnFirstIfHighest(\ArrayUtils $sut) {
		$actual = $sut->max(array(2, 1));
		$expected = 2;

		\TDD\Assert::assertEquals($actual, $expected);
	}


}





