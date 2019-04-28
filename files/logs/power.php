<?php

include "submenu.php";

echo 'Calculated Power Usage. <br /><br />';

if(isset($_GET['a'])) {
	
$a		= addslashes($_GET['a']);	
	
if($a == "reset") {
mysql_query("UPDATE relays SET minutes_power='0'");
mysql_query("UPDATE config SET used_power_date = NOW() WHERE id !='0'");
Alert("Used KWH reset.");	
}
	
	
}

echo '<table width="70%"> ';
echo '<tr>';
echo '		<td width="40%"> Device: </td> ';
echo '		<td width="30%"> Power Usage (Watt): </td> ';
echo '		<td width="30%"> Used Kw: </td> ';
echo '</tr>';

echo '<tr>';
echo '		<td width="100%" colspan="3"> &nbsp; </td>';
echo '</tr>';


$sql			= "SELECT * FROM relays WHERE id !='0'"; 
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
	$total = $relay['power'] * $relay['minutes_power'] / 60000;
	$kwh += $total;
echo '<tr>';
echo '		<td width="40%"> '. PinToName($relay['pin']).' </td> ';
echo '		<td width="30%"> '.$relay['power'].' </td> ';
echo '		<td width="30%"> '.round($total,2).' </td> ';
echo '</tr>';
}
echo '</table>';

echo '<br/>';
echo 'Total used KWH: '.round($kwh,2).' <br /><br />';

$sql	= "SELECT * FROM config WHERE id='1' LIMIT 1";
$query	= mysql_query($sql);
$config	= mysql_fetch_assoc($query);	


$datetime1 	= date_create('now');
$datetime2 	= date_create($config['used_power_date']);
$interval 	= date_diff($datetime2, $datetime1);
$total_days = $interval->format('%a');

echo 'Total Days Expired: '.$total_days.' <br />';
$power_day = $kwh / $total_days;
echo 'Calculated power usage per Day: '.round($power_day,2).' Kw<br />';
$power_year = $power_day * 365;
echo 'Calculated power usage per Year: '.round($power_year,2).' Kw<br />';


echo '<br /> <br /><a href="index.php?p=LOGS.power&a=reset">Reset all used Kw</a>';



?>