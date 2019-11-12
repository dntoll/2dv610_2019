<?php

require_once("index.php");
require_once("system/ArrayUtils.php");

$sut = new ArrayUtils();
$input = array_keys($_GET); 
//extract the keys from the URL for example http://localhost:8081/manual.php?1&2&5&3
$actual = $sut->max($input);


echo "Test method by adding numbers to the url like: manual.php?1&2&5&3 <br/>";
echo "The highest input is :" . $actual;

