<?php
  
Include "submenu.php";

echo "<br/>";


if(isset($_GET['a'])) {
	

$a = addslashes($_GET['a']);

if(isset($_GET['id'])) {
$id 	= addslashes($_GET['id']);
}

if($a == "del") {
mysql_query("DELETE FROM relays WHERE id='$id' LIMIT 1");
alert("Relay deleted.");
}


if($a == "edit") {

$sql				= "SELECT * FROM relays WHERE id ='$id'"; 
$query				= mysql_query($sql);
$relay				= mysql_fetch_assoc($query);

if(isset($_POST['submit'])) {

$name  	= addslashes($_POST['name']);
$power	= addslashes($_POST['power']);
$pin	= addslashes($_POST['pin']); 

if($pin != $relay['pin']) { 
$result =mysql_query("SELECT * FROM relays WHERE pin = '$pin'");
if(mysql_num_rows($result) > 0) {
        Alert("Pin already in use."); 
return;
}
}


mysql_query("UPDATE relays SET name='$name', pin='$pin', power='$power' WHERE id='$id' LIMIT 1");
alert("Relay changed.");
return;
}


echo "<table width=\"50%\"> ";
echo "<form method=\"post\" action=\"\">";
echo "<tr>";
echo "  <td width=\"40%\">Name: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"name\" value=\"".$relay['name']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Power (Watt): </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"power\" value=\"".$relay['power']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Pin No.: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"pin\" value=\"".$relay['pin']."\">  </td>";
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

$name  	= addslashes($_POST['name']);
$pin	= addslashes($_POST['pin']); 

if(empty($pin)) {
alert("Pin cannot be empty.");
return;
}

$result =mysql_query("SELECT * FROM relays WHERE pin = '$pin'");
if(mysql_num_rows($result) > 0) {
        Alert("Pin already in use."); 
return;
}

mysql_query("INSERT INTO relays (id,name,pin) VALUES('','$name','$pin')");
alert("Relay Added.");
return;
}

echo "<table width=\"50%\"> ";
echo "<form method=\"post\" action=\"\">";
echo "<tr>";
echo "  <td width=\"40%\">Name: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"name\" value=\"\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


echo "<tr>";
echo "  <td width=\"40%\">Pin No.: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"pin\" value=\"\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Add Relay\">  </td>";
echo "</tr>";


echo "</form>";
echo "</table>";

return;
}


}



echo "<table width=\"50%\"> ";
echo "<tr>";
echo "  <td width=\"20%\"> Name:  </td>";
echo "  <td width=\"20%\"> Power (Watt):  </td>";
echo "  <td width=\"20%\"> Pin No.:  </td>";
echo "  <td width=\"10%\"> DB: </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


$sql				= "SELECT * FROM relays WHERE id !='0' ORDER BY pin ASC"; 
$query				= mysql_query($sql);
while($relay		= mysql_fetch_assoc($query)) { 

$edit 	= "<a href=\"index.php?p=CONF.relays&a=edit&id=".$relay['id'] ."\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"> </a>   ";
$del  	= "<a href=\"index.php?p=CONF.relays&a=del&id=".$relay['id'] ."\"> <img src=\"images/delete.png\" width=\"20\" height=\"20\"> </a>   ";

echo "<tr>";
echo "  <td width=\"20%\"> ".$relay['name']." </td>";
echo "  <td width=\"20%\"> ".$relay['power']." </td>";
echo "  <td width=\"20%\"> ".$relay['pin']." </td>";
echo "  <td width=\"10%\"> $edit  $del </td>";
echo "</tr>";

}

echo "</table>";

echo "<br/><a href=\"index.php?p=CONF.relays&a=new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"> </a> ";
echo "<br/><a href=\"./images/GPIO.png\" target=\"_blank\">GPIO pin layout</a>"; 
echo "<br/><p align=\"right\">  <a href=\"./manual.html#controller_relays\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";

?>