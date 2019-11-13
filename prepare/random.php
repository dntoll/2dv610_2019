<?php

require_once("index.php");
require_once("system/ArrayUtils.php");

$sut = new ArrayUtils();


const NUM_RUNS = 1000;

for ($i = 0; $i < NUM_RUNS; $i++) {

	$input = array();
	$numInputs = rand(0, 1000);
	$expected = PHP_INT_MIN;

	for($in = 0; $in < $numInputs; $in++) {
		$r = rand(PHP_INT_MIN, PHP_INT_MAX);
		$input[] = $r;

		//
		if ($r > $expected) {
			$expected = $r;
		}
	}

	$actual = $sut->max($input);

	

	if ($actual !== $expected) {
		echo "There is an error in ArrayUtils.max ";	
	} else {
		//echo "The ArrayUtils.max works as specified for the provided input";	
	}

}