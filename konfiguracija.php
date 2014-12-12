<?php
$mysql_host = "localhost";
$mysql_database = "book";
$mysql_user = "keche";
$mysql_password = "keche";

$putanjaApp="/pojects/pmk/";

$app="book_";

$naslovapp="Posudi mi knjigu";

$googleAnalyticsCode="UA-55785218-1";

$veza = new PDO("mysql:dbname=" . $mysql_database . ";host=" . $mysql_host . "", $mysql_user, $mysql_password);
$veza->exec("SET CHARACTER SET utf8");
$veza->exec("SET NAMES utf8");

$veza1 = new PDO("mysql:dbname=" . $mysql_database . 
		";host=" . $mysql_host . 
		"", 
			$mysql_user, $mysql_password);
$veza1->exec("SET CHARACTER SET utf8");
$veza1->exec("SET NAMES utf8");

 
session_start();