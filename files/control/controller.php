<?php



if(isset($_GET['a'])) { 

$a = addslashes($_GET['a']);

if($a == "new_temp")  {
$new_temp = addslashes($_GET['temp']);
mysql_query("UPDATE config SET set_temp='$new_temp' WHERE id='1'");
}

if(isset($_GET['pin'])) {
$pin 	= addslashes($_GET['pin']);
}

// turn pin on
if($a == "on") {
WritePin($pin,0);
}

//turn pin off
if($a == "off") {
WritePin($pin,1);
}


if($a == "edit") {

if(isset($_POST['submit'])) {

$left		= addslashes($_POST['left']);
$mid		= addslashes($_POST['mid']);
$right		= addslashes($_POST['right']);

mysql_query("UPDATE config SET left_column='$left', mid_column='$mid', right_column='$right' WHERE id='1' LIMIT 1");


Alert("Layout changed.");
return;
}





$sql		= "SELECT * FROM config WHERE id !='0'";
$query		= mysql_query($sql);
$config		= mysql_fetch_assoc($query);


echo "<table width=\"60%\">";
echo "<form method=\"post\" action=\"\">";

echo "<tr>";
echo "	<td width=\"40%\">Left Column: </td>";
echo "  <td width=\60%\"> <p>";
echo "     <select name=\"left\">";
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($config['left_column'] == $relay['pin']) { echo "selected";  } echo "> ".$relay['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\">Mid Column (Hottub Temp.) </td>";
echo "  <td width=\60%\"> <p>";
echo "     <select name=\"mid\">";
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysql_query($sql);
while($sensor	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['address']."\" "; if($config['mid_column'] == $sensor['address']) { echo "selected";  } echo "> ".$sensor['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\">Right Column: </td>";
echo "  <td width=\60%\"> <p>";
echo "     <select name=\"right\">";
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($config['right_column'] == $relay['pin']) { echo "selected";  } echo "> ".$relay['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Edit\">  </td>";
echo "</tr>";

echo "</form>";
echo "</table>";

return;
}




} 





$sql			= "SELECT * FROM config WHERE id='1'";	
$query			= mysql_query($sql);
$config			= mysql_fetch_assoc($query);

$current_temp = GetTemp($config['mid_column']);



$min_temp = $config['set_temp'] - 0.1;
$max_temp = $config['set_temp'] + 0.1;


echo "<table width=\"60%\" align=\"center\">";
echo "<tr>";
echo "  <td width=\"33%\"> <div class=\"pomp-circle\"> <br/><br/> ".PinToName($config['left_column'])." <br/><br/>  <font size=\"9\">".to_state(ReadPin($config['left_column']))."</font></div>  </td> ";

echo "  <td width=\"33%\"> <div class=\"temp-circle\"> <div class=\"inner-circle\"> <div class=\"other-circle\">   <br/><br/><br/> $current_temp&#176; <br/><br/>";
echo "  <font size=\"3\"> <a href=\"index.php?p=control&a=new_temp&temp=".$min_temp."\"> - </a> ".$config['set_temp']." <a href=\"index.php?p=control&a=new_temp&temp=".$max_temp."\"> + </a> </font> <br/>";

echo "";

echo "  <font size=\"2\">";
if(ReadPin($config['heater_relay']) == 0) {
echo " <img src=\"./images/flame.png\" width=\"20\" height=\"20\"> ";
}
echo " WATER </font>   </div> </div> </div>   </td>";

echo "	<td width=\"33%\"> <div class=\"pomp-circle\"> <br/><br /> ".PinToName($config['right_column'])." <br/><br/>  <font size=\"9\">".to_state(ReadPin($config['right_column']))."</font></div>  </td>";
echo "</tr>";
echo "</table>";


echo " <a href=\"index.php?p=control&a=edit\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"> </a>   ";



/// Relay control
echo "<br /><br />"; 
echo "<h1> Manual Relay Control </h1> </br>"; 
echo "<table width=\"50%\"> ";
echo "<tr>";
echo "  <td width=\"30%\"> <p> Name: </p> </td>";
//echo "  <td width=\"30%\"> Current State: </td>";
echo "  <td width=\"30%\"> Power: </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


$sql				= "SELECT * FROM relays WHERE id !='0' ORDER BY pin ASC"; 
$query				= mysql_query($sql);
while($relay		= mysql_fetch_assoc($query)) { 

$on 	= "<a href=\"index.php?a=on&pin=".$relay['pin'] ."\"> <img src=\"images/poweron.png\" width=\"20\" height=\"20\"> </a>   ";
$off  	= "<a href=\"index.php?&a=off&pin=".$relay['pin'] ."\"> <img src=\"images/poweroff.png\" width=\"20\" height=\"20\"> </a>   ";

echo "<tr>";
echo "  <td width=\"30%\"> ".$relay['name']." </td>";
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
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

}

echo "</table>";

echo ' <img src="images/poweron.png" width="20" height="20"> = OFF <br />';
echo ' <img src="images/poweroff.png" width="20" height="20"> = ON <br />';


echo "<br/><p align=\"right\">  <a href=\"./manual.html#controller\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";

?>