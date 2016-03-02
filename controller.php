<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function to_epoch($t) {
	$date = new DateTime($t);
	return $date->getTimestamp();
}

$intent = $_GET["intent"];
$entities = $_GET["entities"];

switch($intent) {
	case "places_visited":
//	case "blah":
//	case ...
		include "$intent.php";
		break;
	default:
		die("Intent not understood.");
}