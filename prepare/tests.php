<?php


require_once("index.php");
require_once("TDD/TDD.php");
require_once("TDD/PHPMock.php");
require_once("system/ArrayUtils.php");
require_once("tests/ArrayUtilsTest.php");
require_once("tests/Exceptions.php");
require_once("tests/NumericStringTest.php");
require_once("tests/SocialSecurityNumberTest.php");
require_once("tests/LuhnTest.php");
require_once("tests/IntegrationTests.php");




//tests.php
use TDD\TestSuite;
$testSuite = new TestSuite();
$testSuite->addTest(new MockTests());
$testSuite->addTest(new test\ArrayUtilsTest());
$testSuite->addTest(new test\Exceptions());
$testSuite->addTest(new test\NumericStringTest());
$testSuite->addTest(new test\LuhnTest());
$testSuite->addTest(new test\SocialSecurityNumberTest());

$testSuite->runTests();
$testSuite->showResults();


$integrations = new TestSuite();
$integrations->addTest(new test\IntegrationTests());

$integrations->runTests();
$integrations->showResults();