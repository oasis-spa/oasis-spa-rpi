<?php
/** Because the php function shell_exec wouldn't work in a standard cronjob. I made a cronjob with WGET to get it work. **/
$debug = '0';



if ($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']){
  echo "No Remote Access Allowed";
  exit; //just for good measure
}


/*** Cron each minute ***/

set_include_path('/var/www/html');
require 'config.php';
require 'functions.php';



mysqli_query($m_connect,"TRUNCATE TABLE login");

?>