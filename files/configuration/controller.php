<?php
  
Include "submenu.php";
echo "<br/>";

$sql	= "SELECT * FROM config WHERE id='1' LIMIT 1";
$query	= mysql_query($sql);
$config	= mysql_fetch_assoc($query);	


if(isset($_GET['a'])) {
	
$a = addslashes($_GET['a']);

if(isset($_GET['id'])) {
$id 	= addslashes($_GET['id']);
}

if($a == "del") {
mysql_query("DELETE FROM temp_control WHERE id='$id' LIMIT 1");
alert("Temperature Control deleted.");
return;
}

if($a == "device_del") {
mysql_query("DELETE FROM device_control WHERE id='$id' LIMIT 1");
alert("Device Control deleted.");
return;
}


if($a == "new") {

if(isset($_POST['submit'])) {

$sensor_id		= addslashes($_POST['sensor_id']);
$mark			= addslashes($_POST['mark']);
$temperature	= addslashes($_POST['temperature']);
$relay			= addslashes($_POST['relay']);
$state			= addslashes($_POST['state']);
$remarks		= addslashes($_POST['remarks']);

if(empty($sensor_id) || empty($mark) || empty($temperature) || empty($relay)) { 
alert("Not all the fields where filled.");
return;
}

mysql_query("INSERT INTO temp_control (id,sensor_id,mark,value,switch,state,remarks) VALUES('','$sensor_id','$mark','$temperature','$relay','$state','$remarks')");

alert("Temperature Control Added.");

return;
}

echo "<table width=\"60%\">";
echo "<form method=\"post\" action=\"\">";

echo "<tr>";
echo "	<td width=\"40%\"> Sensor:</td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"sensor_id\">";

$sql		= "SELECT * FROM sensors WHERE id !='0'";
$query		= mysql_query($sql);
while($sensor	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['id']."\">".$sensor['name']."</option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Higher / Lower </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"mark\">";
echo "       <option value=\">\"> > Higher</option>"; 
echo "       <option value=\"<\"> < Lower</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Temperature: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"temperature\"> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Device to switch:</td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"relay\">";

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\">".$relay['name']."</option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Switch: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"state\">";
echo "       <option value=\"1\"> Off</option>"; 
echo "       <option value=\"0\"> On</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Remarks: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"remarks\"> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Add\"> </td>";
echo "</tr>";


echo "</form>";
echo "</table>";


return;
}



if($a == "edit") {

$id			= addslashes($_GET['id']);

$sql		= "SELECT * FROM temp_control WHERE id ='$id' LIMIT 1";
$query		= mysql_query($sql);
$data		= mysql_fetch_assoc($query);

if(isset($_POST['submit'])) {

$sensor_id		= addslashes($_POST['sensor_id']);
$mark			= addslashes($_POST['mark']);
$temperature	= addslashes($_POST['temperature']);
$relay			= addslashes($_POST['relay']);
$state			= addslashes($_POST['state']);
/*
$push			= addslashes($_POST['push']);
$push_text		= addslashes($_POST['push_text']);
*/
$remarks		= addslashes($_POST['remarks']);

//if(empty($sensor_id) || empty($mark) || empty($temperature) || empty($relay) || empty($state)) { 
if(empty($sensor_id) || empty($mark) || empty($temperature) || empty($relay) ) { 
alert("Not all the fields where filled.");
return;
}

//mysql_query("INSERT INTO temp_control (id,sensor_id,mark,value,switch,state,remarks) VALUES('','$sensor_id','$mark','$temperature','$relay','$state','$remarks')");

mysql_query("UPDATE temp_control SET sensor_id='$sensor_id', mark='$mark', value='$temperature', switch='$relay', state='$state', remarks='$remarks' WHERE id='$id' LIMIT 1");
/// mysql update
alert("Temperature Control Changed.");
return;
}




echo "<table width=\"60%\">";
echo "<form method=\"post\" action=\"\">";

echo "<tr>";
echo "	<td width=\"40%\"> Sensor:</td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"sensor_id\">";

$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysql_query($sql);
while($sensor	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['id']."\" "; if($sensor['id'] == $data['sensor_id']) { echo "selected";  } echo "> ".$sensor['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Higher / Lower </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"mark\">";
echo "       <option value=\">\" "; if($data['mark'] == ">") { echo "selected";  } echo "> > Higher </option>"; 
echo "       <option value=\"<\" "; if($data['mark'] == "<") { echo "selected";  } echo "> < Lower </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Temperature: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"temperature\" value=\"".$data['value']."\"> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Device to switch:</td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"relay\">";

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($relay['pin'] == $data['switch']) { echo "selected";  } echo ">  ".$relay['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Switch: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"state\">";
echo "       <option value=\"0\" "; if($data['state'] == "0") { echo "selected";  } echo "> On </option>"; 
echo "       <option value=\"1\" "; if($data['state'] == "1") { echo "selected";  } echo "> Off </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


/*
echo "<tr>";
echo "	<td width=\"40%\"> Push Notification: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"push\">";
echo "       <option value=\"0\" "; if($data['push'] == "0") { echo "selected";  } echo "> Off </option>"; 
echo "       <option value=\"1\" "; if($data['push'] == "1") { echo "selected";  } echo "> On </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Push Text: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"push_text\" value=\"".$data['push_text']."\"> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";
*/

echo "<tr>";
echo "	<td width=\"40%\"> Remarks: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"remarks\" value=\"".$data['remarks']."\"> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Edit\"> </td>";
echo "</tr>";


echo "</form>";
echo "</table>";


return;
}






if($a == "edit_general") {


if(isset($_POST['submit'])) {

$frost_protection	= addslashes($_POST['frost_protection']);
$frost_temp			= addslashes($_POST['frost_temp']);
$frost_sensor		= addslashes($_POST['frost_sensor']);
$cleaning_mode		= addslashes($_POST['cleaning_mode']);
$heater_control		= addslashes($_POST['heater_control']);
$heater_sensor		= addslashes($_POST['heater_sensor']);
$overheat_control	= addslashes($_POST['overheat_control']);
$overheat_sensor	= addslashes($_POST['overheat_sensor']);
$overheat_temp		= addslashes($_POST['overheat_temp']);
$pump_control		= addslashes($_POST['pump_control']);
$set_temp			= addslashes($_POST['set_temp']);
$set_temp_dev		= addslashes($_POST['set_temp_dev']);
$save_temp			= addslashes($_POST['save_temp']);
$heater_relay		= addslashes($_POST['heater_relay']);
$pump_relay			= addslashes($_POST['pump_relay']);

mysql_query("UPDATE config SET frost_protection='$frost_protection', frost_temp='$frost_temp', frost_sensor='$frost_sensor', cleaning_mode='$cleaning_mode', heater_control='$heater_control', heater_sensor='$heater_sensor', overheat_control='$overheat_control', overheat_sensor='$overheat_sensor', overheat_temp='$overheat_temp', pump_control='$pump_control', set_temp='$set_temp', set_temp_dev='$set_temp_dev', save_temp='$save_temp', heater_relay='$heater_relay', pump_relay='$pump_relay' WHERE id='1'");
alert("Settings updated.");
return;
}



echo "<table width=\"70%\">";
echo "<form method=\"post\" action=\"\"> ";
echo "<tr>";
echo "  <td width=\"60%\"> Frost Protection:  </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"frost_protection\">";
echo "       <option value=\"0\" "; if($config['frost_protection'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($config['frost_protection'] == "1") { echo "selected";  } echo ">On</option>"; 
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Frost Protection: (C&deg;)</td>";
echo "	<td width=\"40%\"> <input type=\"text\" name=\"frost_temp\" value=\"".$config['frost_temp']."\">  </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Frost Sensor: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"frost_sensor\">";
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysql_query($sql);
while($sensor	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['id']."\" "; if($config['frost_sensor'] == $sensor['id']) { echo "selected";  } echo "> ".$sensor['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Cleaning Mode:  </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"cleaning_mode\">";
echo "       <option value=\"0\" "; if($config['cleaning_mode'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($config['cleaning_mode'] == "1") { echo "selected";  } echo ">On</option>"; 
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Heater Control: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"heater_control\">";
echo "       <option value=\"0\" "; if($config['heater_control'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($config['heater_control'] == "1") { echo "selected";  } echo ">On</option>"; 
echo "    </select>";
echo " </p> </td>";			 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Heater Control Sensor: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"heater_sensor\">";
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysql_query($sql);
while($sensor	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['id']."\" "; if($config['heater_sensor'] == $sensor['id']) { echo "selected";  } echo "> ".$sensor['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Set Pool Temperature: (C&deg;) </td>";
echo "	<td width=\"40%\"> <input type=\"text\" name=\"set_temp\" value=\"".$config['set_temp']."\"> </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Pool Temperature Deviation: (C&deg;) </td>";
echo "	<td width=\"40%\"> <input type=\"text\" name=\"set_temp_dev\" value=\"".$config['set_temp_dev']."\"> </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";
echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";


echo "<tr>";
echo "  <td width=\"60%\"> OverHeat Control: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"overheat_control\">";
echo "       <option value=\"0\" "; if($config['overheat_control'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($config['overheat_control'] == "1") { echo "selected";  } echo ">On</option>"; 
echo "    </select>";
echo " </p> </td>";			 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> OverHeat Control Sensor: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"overheat_sensor\">";
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysql_query($sql);
while($sensor	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['id']."\" "; if($config['overheat_sensor'] == $sensor['id']) { echo "selected";  } echo "> ".$sensor['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> OverHeat Temperature: (C&deg;) </td>";
echo "	<td width=\"40%\"> <input type=\"text\" name=\"overheat_temp\" value=\"".$config['overheat_temp']."\"> </td>";		 
echo "</tr>";


/*
echo "<tr>";
echo "  <td width=\"60%\"> Pump Control: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"pump_control\">";
echo "       <option value=\"0\" "; if($config['pump_control'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($config['pump_control'] == "1") { echo "selected";  } echo ">On</option>"; 
echo "    </select>";
echo " </p>This will turn you're pump on / off while temperature controlling.</td>";			 
echo "</tr>";
*/
echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Record Temperature:  </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"save_temp\">";
echo "       <option value=\"0\" "; if($config['save_temp'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($config['save_temp'] == "1") { echo "selected";  } echo ">On</option>"; 
echo "    </select>";
echo " </p> </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Relay Heater: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"heater_relay\">";
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($config['heater_relay'] == $relay['pin']) { echo "selected";  } echo "> ".$relay['name']." (".$relay['pin'].") </option>"; 
}
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Relay Pump: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"pump_relay\">";
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($config['pump_relay'] == $relay['pin']) { echo "selected";  } echo "> ".$relay['name']." (".$relay['pin'].") </option>"; 
}
echo "    </select>";
echo " </p> </td>";			 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Edit\">  </td>";		 
echo "</tr>";

echo "</form>";
echo "</table>";


return;
}


if($a == "device_edit") {

$id			= addslashes($_GET['id']);

$sql		= "SELECT * FROM device_control WHERE id ='$id'";
$query		= mysql_query($sql);
$data		= mysql_fetch_assoc($query);

if(isset($_POST['submit'])) {

$device					= addslashes($_POST['device']);
$device_state			= addslashes($_POST['device_state']);
$other_device			= addslashes($_POST['other_device']);
$other_device_state		= addslashes($_POST['other_device_state']);
$remarks				= addslashes($_POST['remarks']);

mysql_query("UPDATE device_control SET relay_pin='$device', relay_state='$device_state', other_relay_pin='$other_device', other_relay_state='$other_device_state', remarks='$remarks' WHERE id='$id' LIMIT 1");

alert("Device Control Changed.");

return;
}




echo "<table width=\"60%\">";
echo "<form method=\"post\" action=\"\">";

echo "<tr>";
echo "	<td width=\"40%\"> Device: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"device\">";

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($device	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$device['pin']."\" "; if($device['pin'] == $data['relay_pin']) { echo "selected";  } echo "> ".$device['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\">Device  State: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"device_state\">";
echo "       <option value=\"0\" "; if($data['relay_state'] == "0") { echo "selected";  } echo "> On </option>"; 
echo "       <option value=\"1\" "; if($data['relay_state'] == "1") { echo "selected";  } echo "> Off </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";


echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Device to switch:</td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"other_device\">";

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($relay['pin'] == $data['other_relay_pin']) { echo "selected";  } echo ">  ".$relay['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Go: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"other_device_state\">";
echo "       <option value=\"0\" "; if($data['other_device_state'] == "0") { echo "selected";  } echo "> On </option>"; 
echo "       <option value=\"1\" "; if($data['other_device_state'] == "1") { echo "selected";  } echo "> Off </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Remarks: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"remarks\" value=\"".$data['remarks']."\"> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Edit\"> </td>";
echo "</tr>";


echo "</form>";
echo "</table>";


return;
}


if($a == "device_new") {


if(isset($_POST['submit'])) {

$device					= addslashes($_POST['device']);
$device_state			= addslashes($_POST['device_state']);
$other_device			= addslashes($_POST['other_device']);
$other_device_state		= addslashes($_POST['other_device_state']);
$remarks				= addslashes($_POST['remarks']);

mysql_query("INSERT INTO device_control (id,relay_pin,relay_state,other_relay_pin,other_relay_state,remarks) VALUES('','$device','$device_state','$other_device','$other_device_state','$remarks')");

alert("Device Control Added.");

return;
}




echo "<table width=\"60%\">";
echo "<form method=\"post\" action=\"\">";

echo "<tr>";
echo "	<td width=\"40%\"> Device: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"device\">";

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($device	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$device['pin']."\"> ".$device['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\">Device State: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"device_state\">";
echo "       <option value=\"0\"> On </option>"; 
echo "       <option value=\"1\"> Off </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";


echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Device to switch:</td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"other_device\">";

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysql_query($sql);
while($relay	= mysql_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\">  ".$relay['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Go: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"other_device_state\">";
echo "       <option value=\"0\"> On </option>"; 
echo "       <option value=\"1\"> Off </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Remarks: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"remarks\" value=\"".$data['remarks']."\"> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Edit\"> </td>";
echo "</tr>";


echo "</form>";
echo "</table>";

return;
}





} /// end of $_GET ['a'];





//View Aera

	

echo "<table width=\"50%\">";

echo "<tr>";
echo "  <td width=\"60%\"> Frost Protection:  </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['frost_protection'])." </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Frost Protection: </td>";
echo "	<td width=\"40%\"> ".$config['frost_temp']." C&deg; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Frost Sensor: </td>";
echo "	<td width=\"40%\"> ".sensor_name($config['frost_sensor'])."  </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Cleaning Mode:  </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['cleaning_mode'])." </td>";		 
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Heater Control: </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['heater_control'])." </td>";			 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Heater Control Sensor: </td>";
echo "	<td width=\"40%\"> ".sensor_name($config['heater_sensor'])."  </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Set Pool Temperature: </td>";
echo "	<td width=\"40%\"> ".$config['set_temp']." C&deg; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Pool Temperature Deviation: </td>";
echo "	<td width=\"40%\"> ".$config['set_temp_dev']." C&deg; </td>";		 
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> OverHeat Control: </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['overheat_control'])." </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> OverHeat Control Sensor: </td>";
echo "	<td width=\"40%\"> ".sensor_name($config['overheat_sensor'])."  </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> OverHeat Temperature: </td>";
echo "	<td width=\"40%\"> ".$config['overheat_temp']." C&deg; </td>";		 
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";
/*
echo "<tr>";
echo "  <td width=\"60%\"> Pump Control: </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['pump_control'])." </td>";			 
echo "</tr>";
*/
echo "<tr>";
echo "  <td width=\"60%\"> Record Temperature:  </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['save_temp'])." </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Relay Heater: </td>";
echo "	<td width=\"40%\"> ".$config['heater_relay']." - (".PinToName($config['heater_relay']).")  </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Relay Pump: </td>";
echo "	<td width=\"40%\"> ".$config['pump_relay']." - (".PinToName($config['pump_relay']).") </td>";		 
echo "</tr>";


echo "</table>";
echo "<br/><a href=\"index.php?p=CONF.controller&a=edit_general\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"> </a> ";


echo "<br/> <br />";
echo "<h1>Automatic Temperature Control</h1>";


echo "<table width=\"100%\">";
echo "<tr>";
echo "  <td width=\"20%\"> Sensor: </td>";
echo "  <td width=\"5%\"> < / > </td>";
echo "  <td width=\"15%\"> Temp.: </td>";
echo "  <td width=\"20%\"> Device: </td>";
echo "	<td width=\"5%\"> Go: </td>";
echo "	<td width=\"5%\"> &nbsp; </td>";		 
echo "	<td width=\"25%\"> Remarks: </td>";
echo "	<td width=\"5%\"> DB: </td>";
echo "</tr>";

$sql		= "SELECT * FROM temp_control WHERE id !='0'";
$query		= mysql_query($sql);
while($temp = mysql_fetch_array($query)) {

$edit = "<a href=\"index.php?p=CONF.controller&a=edit&id=".$temp['id']."\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"> </a>";
$del = "<a href=\"index.php?p=CONF.controller&a=del&id=".$temp['id']."\"> <img src=\"images/delete.png\" width=\"20\" height=\"20\"> </a>";

echo "<tr>";
echo "  <td width=\"20%\"> ".sensor_name($temp['sensor_id'])." </td>";
echo "  <td width=\"5%\"> ".$temp['mark']." </td>";
echo "  <td width=\"15%\"> ".$temp['value']." C&deg; </td>";
echo "  <td width=\"20%\"> ".PinToName($temp['switch'])."  </td>";
echo "	<td width=\"5%\"> ".to_state($temp['state'])." </td>";		 
echo "	<td width=\"5%\"> &nbsp;";
/*
if($temp['push'] == "1") {
	echo "<img src=\"images/pushover.png\" height=\"20\" width=\"20\" title=\"Push Notification On\"> ";
}
*/
echo "  </td>";
echo "	<td width=\"25%\"> ".$temp['remarks']." </td>";
echo "	<td width=\"5%\"> $edit  $del </td>";	
echo "</tr>";

}
echo "</table>";

echo "<br/> <a href=\"index.php?p=CONF.controller&a=new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"> </a> ";

/** Device Control **/

echo "<br/> <br />";
echo "<h1>Automatic Device Control</h1>";


echo "<table width=\"100%\">";
echo "<tr>";
echo "  <td width=\"20%\"> Device: </td>";
echo "  <td width=\"5%\"> = </td>";
echo "  <td width=\"15%\"> State: </td>";
echo "  <td width=\"20%\"> Other Device: </td>";
echo "	<td width=\"5%\"> Go: </td>";		 
echo "	<td width=\"5%\"> &nbsp; </td>";
echo "	<td width=\"25%\"> Remarks: </td>";
echo "	<td width=\"5%\"> DB: </td>";
echo "</tr>";

$sql		= "SELECT * FROM device_control WHERE id !='0'";
$query		= mysql_query($sql);
while($dev = mysql_fetch_array($query)) {

$edit = "<a href=\"index.php?p=CONF.controller&a=device_edit&id=".$dev['id']."\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"> </a>";
$del = "<a href=\"index.php?p=CONF.controller&a=device_del&id=".$dev['id']."\"> <img src=\"images/delete.png\" width=\"20\" height=\"20\"> </a>";

echo "<tr>";
echo "  <td width=\"20%\"> ".PinToName($dev['relay_pin'])." </td>";
echo "  <td width=\"5%\"> = </td>";
echo "  <td width=\"15%\"> ".to_state($dev['relay_state'])."  </td>";
echo "  <td width=\"20%\"> ".PinToName($dev['other_relay_pin'])."  </td>";
echo "	<td width=\"5%\"> ".to_state($dev['other_relay_state'])." </td>";	
echo "	<td width=\"5%\"> &nbsp";
/*
if($dev['push'] == "1") {
	echo "<img src=\"images/pushover.png\" height=\"20\" width=\"20\" title=\"Push Notification On\"> ";
}
*/
echo "  </td>"; 
echo "	<td width=\"25%\"> ".$dev['remarks']." </td>";
echo "	<td width=\"5%\"> $edit  $del </td>";	
echo "</tr>";

}
echo "</table>";

echo "<br/> <a href=\"index.php?p=CONF.controller&a=device_new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"> </a> ";



echo "<br/><p align=\"right\">  <a href=\"./manual.html#controller_settings\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";



?>