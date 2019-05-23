<?php
$debug = '1';


/****
if ($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']){
  echo "No Remote Access Allowed";
  exit; //just for good measure
}
***/
/*** Cron each minute ***/

set_include_path('/var/www/html');
require 'config.php';
require 'functions.php';

$sql = "SELECT * FROM config WHERE id='1'";
$query = mysqli_query($m_connect, $sql);
$config	= mysqli_fetch_assoc($query);
$now = gmdate(time());
$heater_sensor_id = sensor_id_address($config['heater_sensor']);
$heater_relay_pin = $config['heater_relay'];
$pump_relay_pin = $config['pump_relay'];


/**** sensor value write 
To add new sensors, copy the two lines and replace the new API in the URL. Create a unique folder with the Sensor ID (in main espurna status screen). Sensor folder should be placed
in /var/www/html/sensors/[sensor ID]/ with a blank file called 'sonoff_th' inside. You can get the Sensor ID from espurna status screen to the right of the Temperature reading.
Place that sensor ID in the two lines. ****/

/**** In-Tub Temperature Sensor ****/
echo file_put_contents("/var/www/html/sensors/28FFA8E780140283/sonoff_th","Current Tub Temperature \n");
exec('curl -s http://192.168.22.61/api/temperature/1?apikey=356F97ED779751B5 >> /var/www/html/sensors/28FFA8E780140283/sonoff_th');

/**** Incoming Water Temperature Sensor ****/
echo file_put_contents("/var/www/html/sensors/28FF1D83241703E3/sonoff_th","Incoming Tub Temperature \n");
exec('curl -s http://192.168.22.61/api/temperature/2?apikey=356F97ED779751B5 >> /var/www/html/sensors/28FF1D83241703E3/sonoff_th');

/**** Ambient outdoor air temperature sensor ****/
echo file_put_contents("/var/www/html/sensors/28FF70876E1801EF/sonoff_th","Outdoor Temperature \n");
exec('curl -s http://192.168.22.61/api/temperature/0?apikey=356F97ED779751B5 >> /var/www/html/sensors/28FF70876E1801EF/sonoff_th');

if($debug == '1') { echo 'Temp Write works. <br />'; }

  /***** Check which one pin is on to record for used KWH and set relay state *****/
  $sql = "SELECT * FROM relays WHERE id !='0'";
  $query = mysqli_query($m_connect, $sql);
  while($relay	= mysqli_fetch_assoc($query)) {
    if(ReadPin($relay['pin']) == 0)  {
      mysqli_query($m_connect, "UPDATE relays SET minutes_power = minutes_power + 1 WHERE id = ".$relay['id']." LIMIT 1");
    }
    if($debug == '1') { echo 'KWH recorder works. <br />'; }
  }

/**** OverHeat Protection *****/
if($config['overheat_control'] == "1") {

if(GetTemp(sensor_id_address($config['overheat_sensor'])) > $config['overheat_temp'])  {
        WritePin($config['pump_relay'],0);
}

}

/**** Save Temperature for each sensor in database ****/
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysqli_query($m_connect, $sql);
while($sensor	= mysqli_fetch_assoc($query)) {

$temp			= GetTemp($sensor['address']);

mysqli_query($m_connect, "UPDATE sensors SET temperature= $temp WHERE id=".$sensor['id']." LIMIT 1");

if($debug == '1') { echo 'Update temperature works. <br />'; }
}
/*********/

/***  Cleaning Mode , Turn All Off From Here ****/
if($config['cleaning_mode'] == "1")  {
	exit;
}
/*********** Below won't work when cleaning mode is on ************/




/*** AUTOMATIC TEMPERATURE CONTROL *****/
$sql			= "SELECT * FROM temp_control WHERE id !='0'";
$query			= mysqli_query($m_connect, $sql);
while($temp		= mysqli_fetch_assoc($query)) {

$eval = "
if(GetTemp(sensor_id_address(".$temp['sensor_id'].")) ". $temp['mark'] . $temp['value'].")  {
        WritePin(".$temp['switch'].",".$temp['state'].");
}
";

eval($eval);

if($debug == '1') { echo 'Automatic temperature control works. <br />'; }
}

/*** TIME SCHEDULE ****/
$current = date('H:i:00', $tijd);

$sql			= "SELECT * FROM schedule WHERE active='1'";
$query			= mysqli_query($m_connect, $sql);
while($schedule	= mysqli_fetch_assoc($query)) {

if($schedule['time'] == $current) {
		WritePin($schedule['pin'],$schedule['state']);
}

if($debug == '1') { echo 'Time schedule works. <br />'; }
}


/** This part is to controlling Automatic device Control **/
/** For example:  When heater goes on , then pump most go on as well **/

$sql			= "SELECT * FROM device_control WHERE id !='0'";
$query			= mysqli_query($m_connect, $sql);
while($device	= mysqli_fetch_assoc($query)) {

$eval = "
if(ReadPin(".$device['relay_pin'].") == ". $device['relay_state'].")  {
        WritePin(".$device['other_relay_pin'].",".$device['other_relay_state'].");
}
";

eval($eval);
if($debug == '1') { echo 'Automatic device control works. <br />'; }
}


/********* Frost Protection ********/

$sql		= "SELECT * FROM config WHERE id !='0' LIMIT 1";
$query		= mysqli_query($m_connect, $sql);
$config		= mysqli_fetch_assoc($query);

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
$sql = "SELECT * FROM relays WHERE id !='0'";
$query = mysqli_query($m_connect, $sql);

while($relay	= mysqli_fetch_assoc($query)) {
  if($config['heater_control'] == '1') {
    $temp_deviation = intval($config['set_temp_dev']);
    $desired_temp = intval($config['set_temp']);
    $current_tub_temp = intval(GetTemp($heater_sensor_id));

    // only apply to the heater relay
    if($relay['pin'] == $heater_relay_pin) {
      // if the heater relay is off...
      if(ReadPin($relay['pin']) == 1)  {
        // if the current heater temp plus deviation is less than the desired temp 
        // then turn the heater and pump on
        if ($current_tub_temp + $temp_deviation < $desired_temp) {
          WritePin($heater_relay_pin, 0);
          WritePin($pump_relay_pin, 0);
        }
      } else {
        // if the heater is on and current heater temp is greater or equal to the desired temp
        // then turn the heater and pump off
        if ($current_tub_temp >= $desired_temp) {
          WritePin($heater_relay_pin, 1);
          WritePin($pump_relay_pin, 1);
        }
      }
    }
  }
}

if($debug == '1') { echo 'Heater Control works. <br />'; }

/**** Heater Reset, to turn off the heater after 18 minutes ****/ 

$sql = "SELECT * FROM relays WHERE id !='0'";
$query = mysqli_query($m_connect, $sql);

while($relay	= mysqli_fetch_assoc($query)) {
  if(ReadPin($relay['pin']) == 0)  {
    // if the heater relay is on...
    if(ReadPin($relay['pin']) == 0 && $relay['pin'] == $heater_relay_pin) {
    	$heater_time_on = strtotime($relay['time_on']);
    	if ($heater_time_on == null) {
        // set the heater time on value to now
        mysqli_query($m_connect, "UPDATE relays SET time_on = FROM_UNIXTIME({$now}) WHERE id = {$relay['id']} LIMIT 1");
      } else {
        $delta_mins = ($now - $heater_time_on) / 60;
        echo "The heater has been on for {$delta_mins} minutes.<br/>";
        if ($delta_mins > 18 ) {
          echo "Turning off the heater.<br/>";
          WritePin($heater_relay_pin, 1);
          mysqli_query($m_connect, "UPDATE relays SET time_on = null WHERE id = {$relay['id']} LIMIT 1");
        }
      }
    }
  } 
}
if($debug == '1') { echo 'Heater reset works. <br />'; }
?>
