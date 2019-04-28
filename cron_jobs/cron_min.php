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

$sql		= "SELECT * FROM config WHERE id='1'";
$query		= mysql_query($sql);
$conf		= mysql_fetch_assoc($query);

/***** sensor value write*****/

/****
To add new sensors, copy the two lines and replace the new API in the URL. Create a unique folder with the Sensor ID (in main espurna status screen). Sensor folder should be placed
in /var/log/sensors/[sensor ID]/ with a blank file called 'sonoff_th' inside. You can get the Sensor ID from espurna status screen to the right of the Temperature reading. 
Place that sensor ID in the two lines. ****/

/**** In-Tub Temperature Sensor ****/	
echo file_put_contents("/var/log/sensors/28FFB1A88317041A/sonoff_th","Current Tub Temperature \n");
exec('curl -s http://192.168.10.63/api/temperature?apikey=9E2CA07C2C799F9C >> /var/log/sensors/28FFB1A88317041A/sonoff_th'); 

/**** Incoming Water Temperature Sensor ****/
echo file_put_contents("/var/log/sensors/28FF55FA83170400/sonoff_th","Incoming Tub Temperature \n");
exec('curl -s http://192.168.10.62/api/temperature?apikey=5DA9DCA3BD9DD86C >> /var/log/sensors/28FF55FA83170400/sonoff_th');

/**** Ambient outdoor air temperature sensor ****/
echo file_put_contents("/var/log/sensors/28FF36EBA21704D7/sonoff_th","Outdoor Temperature \n");
exec('curl -s http://192.168.10.66/api/temperature?apikey=61B8D62DC8DE6D2E >> /var/log/sensors/28FF36EBA21704D7/sonoff_th');



/***** Check which one pin is on to record for used KWH *****/

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
	
if(ReadPin($relay['pin']) == 0)  {
mysql_query("UPDATE relays SET minutes_power = minutes_power + 1 WHERE id = ".$relay['id']." LIMIT 1");       
}

if($debug == '1') { echo 'KWH recorder works. <br />'; }
}	

/********/

/**** OVerHeat Protection *****/
if($conf['overheat_control'] == "1") {

if(GetTemp(sensor_id_address($conf['overheat_sensor'])) > $conf['overheat_temp'])  {
        WritePin($conf['pump_relay'],0);
}

}
/*******/

/**** Save Temperature for each sensor in database ****/
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysql_query($sql);
while($sensor	= mysql_fetch_assoc($query)) {

$temp			= GetTemp($sensor['address']);

mysql_query("UPDATE sensors SET temperature= $temp WHERE id=".$sensor['id']." LIMIT 1");

if($debug == '1') { echo 'Update temperature works. <br />'; }	
}
/*********/

/***  Cleaning Mode , Turn All Off From Here ****/
if($conf['cleaning_mode'] == "1")  {
	exit;
}
/*********** Below won't work when cleaning mode is on ************/






/*** This part is to execute AUTOMATIC TEMPERATURE CONTROL *****/
$sql			= "SELECT * FROM temp_control WHERE id !='0'";
$query			= mysql_query($sql);
while($temp		= mysql_fetch_assoc($query)) {

$eval = "
if(GetTemp(sensor_id_address(".$temp['sensor_id'].")) ". $temp['mark'] . $temp['value'].")  {
        WritePin(".$temp['switch'].",".$temp['state'].");
}
";

eval($eval);

if($debug == '1') { echo 'Automatic temperature control works. <br />'; }
}





/*** This part is to execute TIME SCHEDULE ****/
$current = date('H:i:00', $tijd);

$sql			= "SELECT * FROM schedule WHERE active='1'";
$query			= mysql_query($sql);
while($schedule	= mysql_fetch_assoc($query)) {

if($schedule['time'] == $current) {
		WritePin($schedule['pin'],$schedule['state']);
}

if($debug == '1') { echo 'Time schedule works. <br />'; }
}





/** This part is to controlling Automatic device Control **/
/** For example:  When heater goes on , then pump most go on as well **/

$sql			= "SELECT * FROM device_control WHERE id !='0'";
$query			= mysql_query($sql);
while($device	= mysql_fetch_assoc($query)) {

$eval = "
if(ReadPin(".$device['relay_pin'].") == ". $device['relay_state'].")  {
        WritePin(".$device['other_relay_pin'].",".$device['other_relay_state'].");
}
";

eval($eval);
if($debug == '1') { echo 'Automatic device control works. <br />'; }
}
/********/





/********* Frost Protection ********/

$sql		= "SELECT * FROM config WHERE id !='0' LIMIT 1";
$query		= mysql_query($sql);
$config		= mysql_fetch_assoc($query);

if($config['frost_protection'] == "1" && $config['heater_control'] == '0') {

if(GetTemp(sensor_id_address($config['frost_sensor']))  <  $config['frost_temp'])  {
        WritePin($config['heater_relay'],0);
		WritePin($config['pump_relay'],0);
}

$new_temp = $config['frost_temp'] + 1;

if(GetTemp(sensor_id_address($config['frost_sensor'])) >= $new_temp) {
        WritePin($config['heater_relay'],1);
		WritePin($config['pump_relay'],1);
}
	
if($debug == '1') { echo 'Frost protection works. <br />'; }
}



/**** Heater Control , to get tub nice and warm ****/
if($config['heater_control'] == '1') {

$eval2 = "
if(GetTemp(sensor_id_address(".$config['heater_sensor'].")) + ".$config['set_temp_dev']."  <  ".$config['set_temp'].")  {
        WritePin(".$config['heater_relay'].",0);		
		WritePin(".$config['pump_relay'].",0);
}
";

$eval3 = "
if(GetTemp(sensor_id_address(".$config['heater_sensor']."))  >=  ".$config['set_temp'].")  {
        WritePin(".$config['heater_relay'].",1);
			if(".$config['pump_relay']." == '0') { 
				WritePin(".$config['pump_relay'].",1);
			}
}
";

eval($eval2);
eval($eval3);

if($debug == '1') { echo 'Heater Control works. <br />'; }
} 

/************/
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
	
if(ReadPin($relay['pin']) == 0)  {
mysql_query("UPDATE relays SET time_on = time_on + 1 WHERE id = ".$relay['id']." LIMIT 1");       
}

if($debug == '1') { echo 'Tankless reset works. <br />'; }
}	



?>
