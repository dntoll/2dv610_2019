<?php

require_once("index.php");
require_once("system/ArrayUtils.php");

$sut = new ArrayUtils();
$input = array(1, 5, 6, 6);
$actual = $sut->max($input);

$expected = 6;

if ($actual !== $expected) {
	echo "There is an error in ArrayUtils.max ";	
} else {
	echo "The ArrayUtils.max works as specified for the provided input";	
}

$input = array(4, 3, 2, 1);
$actual = $sut->max($input);

$expected = 4;

if ($actual !== $expected) {
	echo "There is an error in ArrayUtils.max ";	
} else {
	echo "The ArrayUtils.max works as specified for the provided input";	
}

$input = array();

try {
	$actual = $sut->max($input);
	echo "There is an error in ArrayUtils.max ";
} catch (\Exception $e) {
	echo "The ArrayUtils.max works as specified for the provided input";
}

