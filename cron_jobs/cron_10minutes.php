<?php

if ($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']){
  $this->output->set_status_header(400, 'No Remote Access Allowed');
  exit; //just for good measure
}


/*** Cron each 10 minutes ***/


set_include_path('/var/www/html');
require 'config.php';
require 'functions.php';

$sql		= "SELECT * FROM config WHERE id='1'";
$query		= mysqli_query($m_connect,$sql);
$conf		= mysqli_fetch_assoc($query);



/*** Save temperature in database ***/
$sql		= "SELECT * FROM config WHERE id!='0'";
$query		= mysqli_query($m_connect,$sql);
$config		= mysqli_fetch_assoc($query);

if($config['save_temp'] == "1") {

$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($sensor	= mysqli_fetch_assoc($query)) {

$temp	= GetTemp($sensor['address']);


if($temp != "9999") {
mysqli_query($m_connect,"INSERT INTO temp_logger (id,address,date_time,value) VALUES('','".$sensor['address']."',now(),'$temp')");
}



}

}



?>