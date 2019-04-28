<html>
<head>
<title>Tablet View</title>
  <link rel="stylesheet" href="../css/tablet.css">
<link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Font+Name">


</head>
<?php
  
Include "../config.php";
Include "../functions.php";

$sql		= "SELECT * FROM config WHERE id='1' LIMIT 1";
$query		= mysql_query($sql);
$config		= mysql_fetch_assoc($query);


///Tablet view enabled?
if($config['tablet_view'] != "1") {
	echo "<br /><br /><br /><font color =\"white\" size=\"4\"> <center>Tablet view disabled, go to menu -> configuration -> general.  And enable tablet view. </center> </font>";
exit;
}



/// Internal Accepts
if($config['ip_check'] == "1") { 

///IP Check  / Allow / DisAllow
$accept 			= 0;
$ip 				= $_SERVER["REMOTE_ADDR"]; 
$ip_array 			= explode(".", $_SERVER['REMOTE_ADDR']);

$ip_config_array	= explode(".",$config['ip_range']);


if($ip_array[0] == $ip_config_array[0]) { 
$accept = 1;
}

$sql			= "SELECT * FROM iplist";
$query			= mysql_query($sql);
while($check 	= mysql_fetch_assoc($query)) {
	
if($check['ip'] == $ip) {
	$accept = 1;
}
	
}

if($accept == "0") {
	echo "<br /> <br /><center><font size='4' color='white'>No Access from this IP address :).</font></center>";
	exit;
}


}




///
If(isset($_GET['a'])) {

$a	= addslashes($_GET['a']);
	
if($a == "new_temp")  {
$new_temp = addslashes($_GET['temp']);
mysql_query("UPDATE config SET set_temp='$new_temp' WHERE id='1'");
}

$pin 	= addslashes($_GET['pin']);

// turn pin on
if($a == "on") {
WritePin($pin,0);
}

//turn pin off
if($a == "off") {
WritePin($pin,1);
}

if($a == "autoheater")	 {
	$state = $_GET['state'];
mysql_query("UPDATE config SET heater_control='$state' WHERE id='1'");
}

if($a == "cleaning")	 {
	$state = $_GET['state'];
mysql_query("UPDATE config SET cleaning_mode ='$state' WHERE id='1'");
}

if($a == "frost")	 {
	$state = $_GET['state'];
mysql_query("UPDATE config SET frost_protection ='$state' WHERE id='1'");
}
	
}

//View area
echo "<table width=\"100%\"> ";
echo " <tr>";
echo "  <td width=\"50%\" valign=\"top\"> ";
//start colum 1

$sql			= "SELECT * FROM config WHERE id='1'";	
$query			= mysql_query($sql);
$config			= mysql_fetch_assoc($query);

$mid_column = $config['mid_column'];

$sql2			= "SELECT * FROM sensors WHERE address='$mid_column' LIMIT 1";	
$query2			= mysql_query($sql2);
$sensor			= mysql_fetch_assoc($query2);

$current_temp = $sensor['temperature'];



$min_temp = $config['set_temp'] - 0.5;
$max_temp = $config['set_temp'] + 0.5;

$min_temp2 = $config['set_temp'] - 1;
$max_temp2 = $config['set_temp'] + 1;


echo "<table width=\"100%\">";
echo "<tr>";
echo "  <td width=\"33%\"> <a href=\"index.php?a=new_temp&temp=".$min_temp2."\"> <img src=\"../images/minus.png\" width=\"80\" height=\"80\"> </a>  </td> ";

echo "  <td width=\"33%\"> <div class=\"temp-circle\"> <div class=\"inner-circle\"> <div class=\"other-circle\">   <br/><br/><br/> $current_temp&#176; <br/><br/>";
echo "  <font size=\"3\"> <a href=\"index.php?a=new_temp&temp=".$min_temp."\"> - </a> ".$config['set_temp']." <a href=\"index.php?a=new_temp&temp=".$max_temp."\"> + </a> </font> <br/>";

echo "";

echo "  <font size=\"2\">";
if(ReadPin($config['heater_relay']) == 0) {
echo " <img src=\"../images/flame.png\" width=\"20\" height=\"20\"> ";
}
echo " WATER </font>   </div> </div> </div>   </td>";

echo "	<td width=\"33%\">  <a href=\"index.php?a=new_temp&temp=".$max_temp2."\"> <img src=\"../images/plus.png\" width=\"80\" height=\"80\"> </a>  </td>";
echo "</tr>";
echo "</table>";


/// Relay control

echo "<table width=\"100%\"> ";

echo "<tr>";
echo " <td width=\"100%\" colspan=\"2\"> <p>MANUAL RELAY CONTROL </p> <br />  </td>";
echo " </tr>";


echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


$sql				= "SELECT * FROM relays WHERE id !='0' ORDER BY pin ASC"; 
$query				= mysql_query($sql);
while($relay		= mysql_fetch_assoc($query)) { 

$on 	= "<a href=\"index.php?a=on&pin=".$relay['pin'] ."\"> <img src=\"../images/check_off.png\" height=\"24\"> </a>   ";
$off  	= "<a href=\"index.php?a=off&pin=".$relay['pin'] ."\"> <img src=\"../images/check_on.png\" height=\"24\"> </a>   ";

echo "<tr>";
echo "  <td width=\"30%\"> <p>".$relay['name']."</p> </td>";
echo "  <td width=\"30%\">";

if(ReadPin($relay['pin']) == 1) { 
echo $on;
} else {
echo $off;
}
echo "  </td>";
//echo "  <td width=\"30%\"> $on $off </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; <br /><br /></td>";
echo "</tr>";

}

echo "</table>";

//end colom 1
echo "</td>";



echo "  <td width=\"50%\" VALIGN=\"top\" >";
//start

echo "<table width=\"100%\"> ";
echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> <p>ALL TEMPERATURES </p> <br /></td>";
echo "</tr>";

$sql				= "SELECT * FROM sensors WHERE id !='0' ORDER BY id ASC"; 
$query				= mysql_query($sql);
while($sensor		= mysql_fetch_assoc($query)) { 
echo "<tr>";
echo "  <td width=\"50%\"> <p>".$sensor['name']." </p></td>";
echo "  <td width=\"40%\"> <p>".$sensor['temperature']." &#x2103; </p></td>";
echo "</tr>";
}
echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> &nbsp; <br /></td>";
echo "</tr>";
echo "</table>";
//end

echo "<table width=\"100%\" align=\"left\"> ";
echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"><br /> <p>CONTROL</p> <br /></td>";
echo "</tr>";
echo "<tr>";
echo "  <td width=\"50%\"> <p>Automatic Heater Control</p> </td>";
echo "  <td width=\"40%\">";
if($config['heater_control'] == 1) {
	echo  "<p> <a href=\"index.php?a=autoheater&state=0\"> <img src=\"../images/check_on.png\" height=\"24\"> </a> </p>";
} else {
	echo  "<p> <a href=\"index.php?a=autoheater&state=1\"> <img src=\"../images/check_off.png\" height=\"24\"> </a> </p>";
}
echo "  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; <br /><br /></td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"50%\"> <p>Frost Protection </p></td>";
echo "  <td width=\"40%\">";
if($config['frost_protection'] == 1) {
	echo  "<p> <a href=\"index.php?a=frost&state=0\"> <img src=\"../images/check_on.png\" height=\"24\"> </a> </p>";
} else {
	echo  "<p> <a href=\"index.php?a=frost&state=1\"> <img src=\"../images/check_off.png\" height=\"24\"> </a> </p>";
}
echo "  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; <br /><br /></td>";
echo "</tr>";


echo "<tr>";
echo "  <td width=\"50%\"> <p>Cleaning Mode </p></td>";
echo "  <td width=\"40%\">";
if($config['cleaning_mode'] == 1) {
	echo  "<p> <a href=\"index.php?a=cleaning&state=0\"> <img src=\"../images/check_on.png\" height=\"24\"> </a> </p>";
} else {
	echo  "<p> <a href=\"index.php?a=cleaning&state=1\"> <img src=\"../images/check_off.png\" height=\"24\"> </a> </p>";
}
echo "  </td>";
echo "</tr>";


echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> &nbsp; <br /></td>";
echo "</tr>";
echo "</table>";




echo "  </td>";
echo " </tr>";
echo "</table>";








?>