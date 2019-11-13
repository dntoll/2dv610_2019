<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("system/NumericString.php");
require_once("system/SocialSecurityNumber.php");


$num = new NumericString("0101017697");

echo $num->getLength();

echo " At pos 9 there is a " . $num->getAt(9);

$ssn = new SocialSecurityNumber($num);

echo "0101017697 is born year " . $ssn->getYear();