<?php
  
Include "submenu.php";
echo "<br/>";

$sql	= "SELECT * FROM config WHERE id='1' LIMIT 1";
$query	= mysqli_query($m_connect,$sql);
$config	= mysqli_fetch_assoc($query);

if(isset($_GET['a'])) {
	
$a = addslashes($_GET['a']);

if(isset($_GET['id'])) {
$id 	= addslashes($_GET['id']);
}

if($a == "del") {
mysqli_query($m_connect,"DELETE FROM temp_control WHERE id='$id' LIMIT 1");
alert("Temperature Control deleted.");
return;
}

if($a == "device_del") {
mysqli_query($m_connect,"DELETE FROM device_control WHERE id='$id' LIMIT 1");
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
alert("Please fill in all fields.");
return;
}

mysqli_query($m_connect,"INSERT INTO temp_control (id,sensor_id,mark,value,switch,state,remarks) VALUES('','$sensor_id','$mark','$temperature','$relay','$state','$remarks')");

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
$query		= mysqli_query($m_connect,$sql);
while($sensor	= mysqli_fetch_assoc($query)) {
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
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
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
$query		= mysqli_query($m_connect,$sql);
$data		= mysqli_fetch_assoc($query);

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

//mysqli_query($m_connect,"INSERT INTO temp_control (id,sensor_id,mark,value,switch,state,remarks) VALUES('','$sensor_id','$mark','$temperature','$relay','$state','$remarks')");

mysqli_query($m_connect,"UPDATE temp_control SET sensor_id='$sensor_id', mark='$mark', value='$temperature', switch='$relay', state='$state', remarks='$remarks' WHERE id='$id' LIMIT 1");
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
$query			= mysqli_query($m_connect,$sql);
while($sensor	= mysqli_fetch_assoc($query)) {
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
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
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

mysqli_query($m_connect,"UPDATE config SET frost_protection='$frost_protection', frost_temp='$frost_temp', frost_sensor='$frost_sensor', cleaning_mode='$cleaning_mode', heater_control='$heater_control', heater_sensor='$heater_sensor', overheat_control='$overheat_control', overheat_sensor='$overheat_sensor', overheat_temp='$overheat_temp', pump_control='$pump_control', set_temp='$set_temp', set_temp_dev='$set_temp_dev', save_temp='$save_temp', heater_relay='$heater_relay', pump_relay='$pump_relay' WHERE id='1'");
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
echo "  <td width=\"60%\"> Frost Protection: (F&deg;)</td>";
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
$query			= mysqli_query($m_connect,$sql);
while($sensor	= mysqli_fetch_assoc($query)) {
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
$query			= mysqli_query($m_connect,$sql);
while($sensor	= mysqli_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['id']."\" "; if($config['heater_sensor'] == $sensor['id']) { echo "selected";  } echo "> ".$sensor['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Set Water Temperature: (F&deg;) </td>";
echo "	<td width=\"40%\"> <input type=\"text\" name=\"set_temp\" value=\"".$config['set_temp']."\"> </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Deviation: (F&deg;) </td>";
echo "	<td width=\"40%\"> <input type=\"text\" name=\"set_temp_dev\" value=\"".$config['set_temp_dev']."\"> </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Pump Control: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"pump_control\">";
echo "       <option value=\"0\" "; if($config['pump_control'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($config['pump_control'] == "1") { echo "selected";  } echo ">On</option>"; 
echo "    </select>";
echo " </p>This will turn pump on / off automatically with Auto Heater Control.</td>";			 
echo "</tr>";
echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";


echo "<tr>";
echo "  <td width=\"60%\"> Over Heat Control: </td>";
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
echo "  <td width=\"60%\"> Over Heat Control Sensor: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"overheat_sensor\">";
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($sensor	= mysqli_fetch_assoc($query)) {
echo "       <option value=\"".$sensor['id']."\" "; if($config['overheat_sensor'] == $sensor['id']) { echo "selected";  } echo "> ".$sensor['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Over Heat Temperature: (F&deg;) </td>";
echo "	<td width=\"40%\"> <input type=\"text\" name=\"overheat_temp\" value=\"".$config['overheat_temp']."\"> </td>";		 
echo "</tr>";

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
echo "  <td width=\"60%\"> Heater: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"heater_relay\">";
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($config['heater_relay'] == $relay['pin']) { echo "selected";  } echo "> ".$relay['name']." (".$relay['pin'].") </option>"; 
}
echo "    </select>";
echo " </p> </td>";	 
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Pump: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"pump_relay\">";
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
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
$query		= mysqli_query($m_connect,$sql);
$data		= mysqli_fetch_assoc($query);

if(isset($_POST['submit'])) {

$device					= addslashes($_POST['device']);
$device_state			= addslashes($_POST['device_state']);
$other_device			= addslashes($_POST['other_device']);
$other_device_state		= addslashes($_POST['other_device_state']);
$remarks				= addslashes($_POST['remarks']);

mysqli_query($m_connect,"UPDATE device_control SET relay_pin='$device', relay_state='$device_state', other_relay_pin='$other_device', other_relay_state='$other_device_state', remarks='$remarks' WHERE id='$id' LIMIT 1");

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
$query			= mysqli_query($m_connect,$sql);
while($device	= mysqli_fetch_assoc($query)) {
echo "       <option value=\"".$device['pin']."\" "; if($device['pin'] == $data['relay_pin']) { echo "selected";  } echo "> ".$device['name']." </option>"; 
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
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($relay['pin'] == $data['other_relay_pin']) { echo "selected";  } echo ">  ".$relay['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Action </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"other_device_state\">";
echo "       <option value=\"0\" "; if($data['other_device_state'] = "0") { echo "selected";  } echo "> On </option>"; 
echo "       <option value=\"1\" "; if($data['other_device_state'] = "1") { echo "selected";  } echo "> Off </option>"; 
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

mysqli_query($m_connect,"INSERT INTO device_control (id,relay_pin,relay_state,other_relay_pin,other_relay_state,remarks) VALUES('','$device','$device_state','$other_device','$other_device_state','$remarks')");

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
$query			= mysqli_query($m_connect,$sql);
while($device	= mysqli_fetch_assoc($query)) {
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
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\">  ".$relay['name']." </option>"; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\"> Action </td>";
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

	
echo "<a href=\"index.php?p=CONF.controller&a=edit_general\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"></a><br/> ";
echo "<table width=\"50%\">";
echo "<tr>";
echo "  <td width=\"60%\"> Frost Protection:  </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['frost_protection'])." </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Trigger Temp: </td>";
echo "	<td width=\"40%\"> ".$config['frost_temp']." F&deg; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Frost Sensor: </td>";
echo "	<td width=\"40%\"> ".sensor_name($config['frost_sensor'])."  </td>";		 
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
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
echo "  <td width=\"60%\"> Set Water Temperature: </td>";
echo "	<td width=\"40%\"> ".$config['set_temp']." F&deg; </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Deviation: </td>";
echo "	<td width=\"40%\"> ".$config['set_temp_dev']." F&deg; </td>";		 
echo "</tr>";
echo "<tr>";
echo "  <td width=\"60%\"> Pump Control: </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['pump_control'])." <br/></td>";			 
echo " </tr>";
echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Over Heat Control: </td>";
echo "	<td width=\"40%\"> ".to_state_menu($config['overheat_control'])." </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Over Heat Control Sensor: </td>";
echo "	<td width=\"40%\"> ".sensor_name($config['overheat_sensor'])."  </td>";		 
echo "</tr>";

echo "<tr>";
echo "  <td width=\"60%\"> Over Heat Temperature: </td>";
echo "	<td width=\"40%\"> ".$config['overheat_temp']." F&deg; </td>";		 
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

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

echo "<br/> <br />";
echo "<h1>Automatic Actions</h1>";


echo "<table width=\"100%\">";
echo "<h2><tr>";
echo "  <td width=\"15%\"><span class=\"bg\">  When Sensor</span> </td>";
echo "  <td width=\"5%\"><span class=\"bg\" >Is </span></td>";
echo "  <td width=\"15%\"><span class=\"bg\" > Temp. </span></td>";
echo "  <td width=\"20%\"><span class=\"bg\" > Device </span></td>";
echo "	<td width=\"10%\"><span class=\"bg\" > Action </span></td>";
//echo "	<td width=\"5%\"><span class=\"bg\" > &nbsp;</span> </td>";		 
echo "	<td width=\"25%\"><span class=\"bg\" > Remarks </span></td>";
echo "	<td width=\"5%\"><span class=\"bg\" > DB  </span></td>";
echo "</tr></h2>";

$sql		= "SELECT * FROM temp_control WHERE id !='0'";
$query		= mysqli_query($m_connect,$sql);
while($temp = mysqli_fetch_array($query)) {

$edit = "<a href=\"index.php?p=CONF.controller&a=edit&id=".$temp['id']."\"> <img src=\"images/edit.png\" width=\"15\" height=\"15\"></a>";
$del = "<a href=\"index.php?p=CONF.controller&a=del&id=".$temp['id']."\"> <img src=\"images/delete.png\" width=\"15\" height=\"15\"></a>";

echo "<tr>";
echo "  <td width=\"20%\"> ".sensor_name($temp['sensor_id'])." </td>";
echo "  <td width=\"5%\"> ".$temp['mark']." </td>";
echo "  <td width=\"15%\"> ".$temp['value']." F&deg; </td>";
echo "  <td width=\"20%\"> ".PinToName($temp['switch'])."  </td>";
echo "	<td width=\"5%\"> ".to_state($temp['state'])." </td>";		 
//echo "	<td width=\"5%\"> &nbsp;";
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

echo "<br/> <a href=\"index.php?p=CONF.controller&a=new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"></a> ";

/** Device Control **/

echo "<br/> <br />";
echo "<h1>Automatic Device Control</h1>";


echo "<table width=\"100%\">";
echo "<tr>";
echo "  <td width=\"15%\"><span class=\"bg\"> Device </span></td>";
echo "  <td width=\"5%\"><span class=\"bg\"> = </span></td>";
echo "  <td width=\"10%\"><span class=\"bg\"> State </span></td>";
echo "  <td width=\"10%\"><span class=\"bg\"> Device </span></td>";
echo "	<td width=\"5%\"><span class=\"bg\"> Action </span></td>";		 
//echo "	<td width=\"1%\"><span class=\"bg\"> &nbsp; </span></td>";
echo "	<td width=\"40%\"><span class=\"bg\"> Remarks </span></td>";
echo "	<td width=\"5%\"><span class=\"bg\"> DB </span></td>";
echo "</tr>";

$sql		= "SELECT * FROM device_control WHERE id !='0'";
$query		= mysqli_query($m_connect,$sql);
while($dev = mysqli_fetch_array($query)) {

$edit = "<a href=\"index.php?p=CONF.controller&a=device_edit&id=".$dev['id']."\"> <img src=\"images/edit.png\" width=\"15\" height=\"15\"></a>";
$del = "<a href=\"index.php?p=CONF.controller&a=device_del&id=".$dev['id']."\"> <img src=\"images/delete.png\" width=\"15\" height=\"15\"></a>";

echo "<tr>";
echo "  <td width=\"15%\"> ".PinToName($dev['relay_pin'])." </td>";
echo "  <td width=\"5%\"> = </td>";
echo "  <td width=\"10%\"> ".to_state($dev['relay_state'])."  </td>";
echo "  <td width=\"10%\"> ".PinToName($dev['other_relay_pin'])."  </td>";
echo "	<td width=\"5%\"> ".to_state($dev['other_relay_state'])." </td>";	
//echo "	<td width=\"5%\"> &nbsp";
/*
if($dev['push'] == "1") {
	echo "<img src=\"images/pushover.png\" height=\"20\" width=\"20\" title=\"Push Notification On\"> ";
}
*/
echo "  </td>"; 
echo "	<td width=\"30%\"> ".$dev['remarks']." </td>";
echo "	<td width=\"5%\"> $edit  $del </td>";	
echo "</tr>";

}
echo "</table>";

echo "<br/> <a href=\"index.php?p=CONF.controller&a=device_new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"></a> ";



echo "<br/><p align=\"right\">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";



?>