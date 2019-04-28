<?php
  
Include "submenu.php";

echo "<br/>";


if(isset($_GET['a'])) {
	
$a = addslashes($_GET['a']);

if(isset($_GET['id'])) {
$id 	= addslashes($_GET['id']);
}

if($a == "del") {
mysql_query("DELETE FROM sensors WHERE id='$id' LIMIT 1");
alert("Sensor deleted.");
}


if($a == "edit") {

$sql				= "SELECT * FROM sensors WHERE id ='$id'"; 
$query				= mysql_query($sql);
$sensor				= mysql_fetch_assoc($query);

if(isset($_POST['submit'])) {

$name  			= addslashes($_POST['name']);
$type  			= addslashes($_POST['type']);
$address		= addslashes($_POST['address']); 
$calibration	= addslashes($_POST['calibration']);
$visible		= addslashes($_POST['visible']);

if($address != $sensor['address']) { 
$result =mysql_query("SELECT * FROM sensors WHERE address = '$address'");
if(mysql_num_rows($result) > 0) {
        Alert("Address already in use."); 
return;
}
}




mysql_query("UPDATE sensors SET name='$name', type='$type', address='$address', calibration_value='$calibration', visible='$visible' WHERE id='$id' LIMIT 1");
alert("Sensor changed.");
return;
}


echo "<table width=\"60%\"> ";
echo "<form method=\"post\" action=\"\">";
echo "<tr>";
echo "  <td width=\"50%\">Name: </td>";
echo "  <td width=\"40%\">  <input type=\"text\" name=\"name\" value=\"".$sensor['name']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"50%\">Type: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"type\">";
echo "       <option value=\"IoT\" "; if($config['type'] == "IoT") { echo "selected";  } echo ">IoT</option>"; 
echo "       <option value=\"GPIO\" "; if($config['type'] == "GPIO") { echo "selected";  } echo ">GPIO</option>"; 
echo "    </select></td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"50%\">Address: </td>";
echo "  <td width=\"40%\">  <input type=\"text\" name=\"address\" value=\"".$sensor['address']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"50%\">+/- Value: </td>";
echo "  <td width=\"40%\">  <input type=\"text\" name=\"calibration\" value=\"".$sensor['calibration_value']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"50%\">Display: </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"visible\">";
echo "       <option value=\"no\" "; if($config['visible'] == "no") { echo "selected";  } echo ">No</option>"; 
echo "       <option value=\"yes\" "; if($config['visible'] == "yes") { echo "selected";  } echo ">Yes</option>"; 
echo "    </select></td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Edit\">  </td>";
echo "</tr>";


echo "</form>";
echo "</table>";
return;
}


if($a == "new") {

if(isset($_POST['submit'])) {

$name  				= addslashes($_POST['name']);
$type				= addslashes($_POST['type']);
$address			= addslashes($_POST['address']); 
$calibration		= addslashes($_POST['calibration']);
$visible			= addslashes($_POST['visible']);

if(empty($name)) {
alert("Name could not be empty.");
return;
}

if(empty($address)) {
alert("Address could not be empty.");
return;
}

$result =mysql_query("SELECT * FROM sensors WHERE address = '$address'");
if(mysql_num_rows($result) > 0) {
        Alert("Address already in use."); 
return;
}

mysql_query("INSERT INTO sensors (id,name,type,address,calibration_value,visible) VALUES('','$name','$type','$address','$calibration','$visible')");
alert("Sensor Added.");
return;
}

echo "<table width=\"50%\"> ";
echo "<form method=\"post\" action=\"\">";
echo "<tr>";
echo "  <td width=\"40%\">Name </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"name\" value=\"\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


echo "<tr>";
echo "  <td width=\"40%\">Address </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"address\" value=\"".$_GET['sensor']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"50%\">Type </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"type\">";
echo "       <option value=\"IoT\" "; if($config['type'] == "IoT") { echo "selected";  } echo ">IoT</option>"; 
echo "       <option value=\"GPIO\" "; if($config['type'] == "GPIO") { echo "selected";  } echo ">GPIO</option>"; 
echo "    </select></td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


echo "<tr>";
echo "  <td width=\"40%\">+/- Value </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"calibration\" value=\"\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"50%\">Display </td>";
echo "  <td width=\"40%\"> <p>";
echo "     <select name=\"visible\">";
echo "       <option value=\"no\" "; if($config['visible'] == "no") { echo "selected";  } echo ">No</option>"; 
echo "       <option value=\"yes\" "; if($config['visible'] == "yes") { echo "selected";  } echo ">Yes</option>"; 
echo "    </select></td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Add Sensor\">  </td>";
echo "</tr>";


echo "</form>";
echo "</table>";

return;
}



if($a == "search_iot") {

//echo "search sensor <br/>";
echo "<table width=\"60%\"> ";
echo "<tr>";
echo "	<td width=\"60%\"> Address: </td>";
echo "	<td width=\"40%\"> Sensor: </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

if ($handle = opendir('/var/log/sensors/')) {
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        $data[] =$entry ;
    }

    closedir($handle);
}

foreach ($data as $sensor) {
	if ($sensor != '.' && $sensor != '..' && $sensor != 'w1_bus_master1') {
			echo "<tr>";
			echo "	<td width=\"60%\"> $sensor </td>";
			echo "	<td width=\"40%\">";
				if(FindAddress($sensor) == "0") {
					echo "<a href=\"index.php?p=CONF.sensors&a=new&sensor=".$sensor."\">New Sensor</a>";
				} else {
					echo " ".sensor_address_name($sensor)."";
				}
			echo "	</td>";
			echo "</tr>";
	}
}
echo "</table>";
return;
}

if($a == "search_gpio") {

//echo "search sensor <br/>";
echo "<table width=\"60%\"> ";
echo "<tr>";
echo "	<td width=\"60%\"> Address: </td>";
echo "	<td width=\"40%\"> Sensor: </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

if ($handle = opendir('/sys/bus/w1/devices/')) {
    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
        $data[] =$entry ;
    }

    closedir($handle);
}

foreach ($data as $sensor) {
	if ($sensor != '.' && $sensor != '..' && $sensor != 'w1_bus_master1') {
			echo "<tr>";
			echo "	<td width=\"60%\"> $sensor </td>";
			echo "	<td width=\"40%\">";
				if(FindAddress($sensor) == "0") {
					echo "<a href=\"index.php?p=CONF.sensors&a=new&sensor=".$sensor."\">New Sensor</a>";
				} else {
					echo " ".sensor_address_name($sensor)."";
				}
			echo "	</td>";
			echo "</tr>";
	}
}
echo "</table>";
return;
}

} // end isset $_GET ['a']



//View area

echo "<table width=\"100%\"> ";
echo "<tr>";
echo "  <td width=\"5%\"> Name  </td>";
echo "  <td width=\"10%\"> Type  </td>";
echo "  <td width=\"30%\"> Sensor ID  </td>";
echo "  <td width=\"10%\"> +/- Value  </td>";
echo "  <td width=\"10%\"> Current </td>";
echo "  <td width=\"15%\"> Display </td>";
echo "  <td width=\"30%\"> DB </td>";

echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


$sql				= "SELECT * FROM sensors WHERE id !='0' ORDER BY id ASC"; 
$query				= mysql_query($sql);
while($sensor		= mysql_fetch_assoc($query)) { 

$edit 	= "<a href=\"index.php?p=CONF.sensors&a=edit&id=".$sensor['id']."\"> <img src=\"images/edit.png\" width=\"15\" height=\"15\"></a>   ";
$del  	= "<a href=\"index.php?p=CONF.sensors&a=del&id=".$sensor['id']."\"> <img src=\"images/delete.png\" width=\"15\" height=\"15\"></a>   ";

//$temp	= GetTemp($sensor['address']) + $sensor['calibration_value'];

echo "<tr>";
echo "  <td width=\"20%\"> ".$sensor['name']." </td>";
echo "  <td width=\"10%\"> ".$sensor['type']." </td>";
echo "  <td width=\"30%\"> ".$sensor['address']." </td>";
echo "  <td width=\"10%\"> ".$sensor['calibration_value']." </td>";
echo "  <td width=\"10%\"> ".GetTemp($sensor['address'])." </td>";
echo "  <td width=\"10%\"> ".$sensor['visible']." </td>";
//echo "  <td width=\"20%\"> $temp </td>";
echo "  <td width=\"30%\"> $edit  $del </td>";
echo "</tr>";

}

echo "</table>";

echo "<br/><a href=\"index.php?p=CONF.sensors&a=new\"><img src=\"images/add.png\" width=\"30\" height=\"30\"></a>&nbsp;";
echo "<a href=\"index.php?p=CONF.sensors&a=search_iot\"><img src=\"images/iot_box.png\" alt=\"Add ESPurna sensor\" width=\"30\"></a>&nbsp;";
echo "<a href=\"index.php?p=CONF.sensors&a=search_gpio\"><img src=\"images/search.png\" width=\"30\"></a>&nbsp;";

echo "<br/><p align=\"right\">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";


?>
