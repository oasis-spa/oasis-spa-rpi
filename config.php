<?php

/**
Config File
Mysql connect etc.

Created at 24-12-2014 at 11:17
*/

/// Error Reporting
//  http://nl2.php.net/manual/en/errorfunc.configuration.php

//ini_set("display_errors","0");   /// don't show mysql errors
//ini_set('error_reporting',E_ALL);


/** Mysql_ Server Data**/
$mysql_server		= "localhost";  /// mysql server bijna altijd localhost
$mysql_user			= "root";  /// De mysql username
$mysql_pass			= "welcometoluxury";  /// mysql password
$mysql_db			= "controller"; /// Welke database ?




/* Dont change anything here */
$m_connect = mysql_connect($mysql_server,$mysql_user,$mysql_pass) or die("Could not connect to the database.");
mysql_select_db($mysql_db,$m_connect) or die("Could not find the database.");


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
