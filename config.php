<?php

/**
Config File
Mysql connect etc.

Created at 24-12-2014 at 11:17
*/

/// Error Reporting
//  http://nl2.php.net/manual/en/errorfunc.configuration.php


ini_set("display_errors","On");   /// don't show mysql errors
ini_set('error_reporting',E_ALL);
ini_set("variables_order","EGPCS");

require __DIR__ . '/vendor/autoload.php';
require __DIR__.'/models/model.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$mqtt = new Bluerhinos\phpMQTT(getenv("MQTT_HOST"), getenv("MQTT_TCP_PORT"), "oasis-phpapp".rand());

/** Mysql_ Server Data**/
$mysql_server		= getenv("DB_HOST");  /// mysql server bijna altijd localhost
$mysql_user			= getenv("MYSQL_USER");  /// De mysql username
$mysql_pass			= getenv("MYSQL_PASSWORD");  /// mysql password
$mysql_db			  = getenv("MYSQL_DATABASE"); /// Welke database ?

$mysqli = new mysqli($mysql_server, $mysql_user, $mysql_pass, $mysql_db);

/* Dont change anything here */

$m_connect = mysqli_connect($mysql_server,$mysql_user,$mysql_pass,$mysql_db) or die("Could not connect to the database.");

$_SESSION['m_connect'] = $m_connect;

#print_r($m_connect);

#mysqli_select_db($m_connect,$mysql_db,$m_connect) or die("Could not find the database.");

if (mysqli_connect_errno())

  {

  echo "Failed to connect to MySQL: " . mysqli_connect_error();

  }



$tijd		= time();

$ip			= $_SERVER['REMOTE_ADDR'];



foreach ($_GET as $key => $get) {

	$getx = strtolower($get);

	if (strstr($getx, 'delete')) {

		$get = str_replace('DELETE', '', $get);

		$get = str_replace('delete', '', $get);

		$get = str_replace('DROP', '', $get);

		$get = str_replace('drop', '', $get);

		$get = str_replace('UPDATE', '', $get);

		$get = str_replace('update', '', $get);

	}

	$get = str_replace(';', '', $get);



	$_GET[$key] = $get;

}



foreach ($_POST as $key => $get) {

    $getx = strtolower($get);

    if (strstr($getx, 'delete')) {

		$get = str_replace('DELETE', '', $get);

		$get = str_replace('delete', '', $get);

		$get = str_replace('DROP', '', $get);

		$get = str_replace('drop', '', $get);

		$get = str_replace('UPDATE', '', $get);

		$get = str_replace('update', '', $get);

        }

        $get = str_replace(';', '', $get);



        $_POST[$key] = $get;

}



?>
