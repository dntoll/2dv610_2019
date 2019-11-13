<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("TDD/TDD.php");
require_once("TDD/PHPMock.php");
require_once("tests/NumericStringTests.php");
require_once("tests/SocialSecurityNumberTests.php");



use TDD\TestSuite;
$testSuite = new TestSuite();
$testSuite->addTest(new NumericStringTests());
$testSuite->addTest(new SocialSecurityNumberTests());

$testSuite->runTests();
$testSuite->showResults();