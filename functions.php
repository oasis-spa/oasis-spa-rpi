<?php

function alert($text) {
echo " <script language=\"javascript\" type=\"text/javascript\">  ";
echo " alert('$text')";
echo " </script>";

return;
}



function AddLog($log, $time)
{
mysql_query("INSERT INTO logs (id,log,time) VALUES('','$log',now())");

}

function Succes($title,$msg)
{
echo "<table width=\"400\" align=\"center\" border=\"0\" cellpadding=\"0\" cellpadding=\"0\">";
echo " <form method=\"post\" name=\"ok\" action=\"index.php\">";
echo " <tr>";
echo "  <td background=\"images/content-table-headbg.jpg\" width=\"100%\"><center>".$msg."</center></td> ";
echo " <tr>";
echo " <tr>";
echo "  <td width=\"100%\"><center> <img src=\"./images/done.gif\"> </center></td> ";
echo " <tr>";
echo " <tr>";
echo "  <td width=\"100%\"><center>".$msg."</center></td> ";
echo " <tr>";
echo " <tr>";
echo "  <td width=\"100%\"><center> <input type=\"submit\" name=\"ok\" value=\"Ok\"> </center></td> ";
echo " <tr>";
echo " </form>";
echo " </table>";
}

/** This is for GPIO , changed 0 to ON / 1 to OFF otherwise the relays will be on when device disabled ***/
function to_state($id)
{
	switch($id)
        {
                case 0  : return "On"; break;
                case 1  : return "Off"; break;
        }
}

function to_state_menu($id)
{
	switch($id)
        {
                case 0  : return "Off"; break;
                case 1  : return "On"; break;
        }
}

function yes_no($id)
{
	switch($id)
        {
                case 0  : return "No"; break;
                case 1  : return "Yes"; break;
        }
}


function to_function($rank)
{
	switch($rank)
        {
                case 0  : return "None"; break;
                case 1  : return "User"; break;
				case 2  : return "Administrator"; break;
        }
}

function WritePin($pin,$state)
{
$output = shell_exec('gpio mode '.$pin.' out');
$output = shell_exec('gpio write '.$pin.' '.$state);
return $output;
}



function ReadPin($pin)
{
$output = shell_exec('gpio read '.$pin.'');
return $output;
}



function PinToName($pin) 
{
$sql		= "SELECT * FROM relays WHERE pin='$pin' LIMIT 1";
$query		= mysql_query($sql);
$pins		= mysql_fetch_assoc($query);

return $pins['name'];
}

function RelayToPin($id) 
{
$sql		= "SELECT * FROM relays WHERE id='$id' LIMIT 1";
$query		= mysql_query($sql);
$pins		= mysql_fetch_assoc($query);

return $pins['pin'];
}


function sensor_name($id)
{
$sql	= "SELECT * FROM sensors WHERE id='$id' LIMIT 1";
$query	= mysql_query($sql);
$sensor = mysql_fetch_assoc($query);

return $sensor['name'];
}

function sensor_address_name($address)
{
$sql	= "SELECT * FROM sensors WHERE address='$address' LIMIT 1";
$query	= mysql_query($sql);
$sensor = mysql_fetch_assoc($query);

return $sensor['name'];
}

function sensor_id_address($id)
{
$sql	= "SELECT * FROM sensors WHERE id='$id' LIMIT 1";
$query	= mysql_query($sql);
$sensor = mysql_fetch_assoc($query);

return $sensor['address'];
}

function FindAddress($address)
{
$sql	= "SELECT * FROM sensors WHERE address='$address' LIMIT 1";
$query	= mysql_query($sql);
$sensor	= mysql_fetch_assoc($query);

if(mysql_num_rows($query) == "1")     {
		$name	= 1;
} else {
		$name	= 0;
}

return $name;
}


// This function is also in the cron files.
function GetTemp($address) 
{
	$sql		= "SELECT * FROM sensors WHERE address='$address' LIMIT 1";
	$query		= mysql_query($sql);
	$sensor		= mysql_fetch_assoc($query);
	
//File to read

$file = '/var/log/sensors/'.$address.'/sonoff_th';

if (file_exists($file)) {
							 
//Read the file line by line
$lines = file($file);
 
//Get the temp from second line 
$temp = ($lines[1]);
 
} 

return $temp + $sensor['calibration_value'];

$file = '/sys/bus/w1/devices/'.$address.'/w1_slave';

if (file_exists($file)) {
							 
//Read the file line by line
$lines = file($file);
 
//Get the temp from second line 
$temp = explode('=', $lines[1]);
//$temp = ($lines[1]);
 
//Setup some nice formatting (i.e. 21,3)
$temp = number_format($temp[1] / 1000, 1, '.', '');
$temp = $temp;

/// Dont change 9999 because cronjob 10 minutes
} else {
    $temp = "9999";
}

return $temp + $sensor['calibration_value'];
}


?>