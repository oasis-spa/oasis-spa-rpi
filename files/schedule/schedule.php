<?php
$a = 0;



if(isset($_GET['a'])) {

$a = addslashes($_GET['a']);
	
$id = 0;

if(isset($_GET['id'])) {
$id = addslashes($_GET['id']);
}

if($a == "new") {

if(isset($_POST['submit'])) {

$device			= addslashes($_POST['device']);
$state			= addslashes($_POST['state']);
$time			= addslashes($_POST['time']);
$active			= addslashes($_POST['active']);
$remarks		= addslashes($_POST['remarks']);

if(empty($device) || empty($time)) {
alert("Not all the fields where filled.");
return;
}

$tags = explode(':',$time);

$error1 = 0;
$error2 =0;

foreach($tags as $key) {

if($tags[0] > "23" || $tags[0] < "0") {
//echo 'Hours cannot be higher then 23. <br />';
$error1 = '1';
}

if($tags[1] > "59" || $tags[1] < "0") {
//echo 'Minutes cannot be higher then 59. <br />';
$error2 = '1';
}

}



if($error1 == '1') {
alert("Input time error. Hours must be between 0-23");
return;
}

if($error2 == '1') {
alert("Input time error. Minutes must be between 0-59");
return;
}

mysqli_query($m_connect,"INSERT INTO schedule (id,pin,state,time,active,remarks) VALUES('','$device','$state','$time','$active','$remarks')")or die(mysql_error());


alert("Time schedule added");

return;
}



echo "<table width=\"80%\">";
echo "<form method=\"post\" action=\"\">";

echo "<tr>";
echo "	<td width=\"40%\"> Device: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"device\">";

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
echo '       <option value= '.$relay['pin'].'>  '.$relay['name'].' </option>'; 
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo "<tr>";
echo "	<td width=\"40%\"> State: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"state\">";
echo "       <option value=\"0\"> On </option>"; 
echo "       <option value=\"1\"> Off </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo "<tr>";
echo "	<td width=\"40%\"> Time: </td>";
echo "	<td width=\"60%\"> <input type=\"text\" name=\"time\" value=\"HOUR:MINUTE\" maxlength=\"5\"> </td>";
echo "</tr>";

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';;

echo "<tr>";
echo "	<td width=\"40%\"> Active: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"active\">";
echo "       <option value=\"0\"> Off </option>"; 
echo "       <option value=\"1\"> On </option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo '<tr>';
echo '	<td width="40%"> Remarks: </td>';
echo '	<td width="60%"> <input type="text" name="remarks"> </td>';
echo '</tr>';

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo '<tr>';
echo '	<td colspan="2" width="100%"> <input type="submit" name="submit" value="Add Schedule">  </td>';
echo '</tr>';



echo "</form>";
echo "</table>";

return;
}


if($a == "del") {
mysqli_query($m_connect,"DELETE FROM schedule WHERE id='$id' LIMIT 1");
alert("Time Schedule Deleted.");
return;
}




if($a == "edit") {

$sql		= "SELECT * FROM schedule WHERE id='$id' LIMIT 1";
$query		= mysqli_query($m_connect,$sql);
$schedule	= mysqli_fetch_assoc($query);

if(isset($_POST['submit'])) {
	
$error1 = 0;
$error2 = 0;

$device			= addslashes($_POST['device']);
$state			= addslashes($_POST['state']);
$time			= addslashes($_POST['time']);
//$overrule		= addslashes($_POST['overrule']);
$active			= addslashes($_POST['active']);
$remarks		= addslashes($_POST['remarks']);


if(empty($device) || empty($time)) {
alert("Not all the fields where filled.");
return;
}

$tags = explode(':',$time);

foreach($tags as $key) {

if($tags[0] > "23" || $tags[0] < "0") {
//echo 'Hours cannot be higher then 23. <br />';
$error1 = '1';
}

if($tags[1] > "59" || $tags[1] < "0") {
//echo 'Minutes cannot be higher then 59. <br />';
$error2 = '1';
}

}

if($error1 == '1') {
alert("Input time error. Hours must be between 0-23");
return;
}

if($error2 == '1') {
alert("Input time error. Minutes must be between 0-59");
return;
}


mysqli_query($m_connect,"UPDATE schedule SET pin='$device', state='$state', time='$time', active='$active', remarks='$remarks' WHERE id='$id' LIMIT 1");

alert("Time schedule changed.");

return;
}



echo '<table width="80%">';
echo '<form method="post" action="">';

echo '<tr>';
echo '	<td width="40%"> Device: </td>';
echo '  <td width="60%"> <p>';
echo '     <select name="device">';

$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
echo '       <option value="'.$relay['pin'].'" '; if($schedule['pin'] == $relay['pin']) { echo 'selected'; } echo '>  '.$relay['name'].' </option>'; 
}
echo '    </select>';
echo ' </p> </td>';
echo '</tr>';

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo '<tr>';
echo "	<td width=\"40%\"> State: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"state\">";
echo '       <option value="0" '; if($schedule['state'] == "0") { echo 'selected'; } echo '>  On </option>'; 
echo '       <option value="1" '; if($schedule['state'] == "1") { echo 'selected'; } echo '>  Off </option>';  
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo '<tr>';
echo '	<td width="40%"> Time: </td>';
echo '	<td width="60%"> <input type="text" name="time" value="'.substr($schedule['time'],0,5).'" maxlength="5"> </td>';
echo '</tr>';

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo '<tr>';
echo '	<td width="40%"> Active: </td>';
echo '  <td width="60%"> <p>';
echo '     <select name="active">';
echo '       <option value="0" '; if($schedule['active'] == "0") { echo 'selected'; } echo '>  Off </option>';
echo '       <option value="1" '; if($schedule['active'] == "1") { echo 'selected'; } echo '>  On </option>';
echo '    </select>';
echo ' </p> </td>';
echo '</tr>';

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo '<tr>';
echo '	<td width="40%"> Remarks: </td>';
echo '	<td width="60%"> <input type="text" name="remarks" value="'.$schedule['remarks'].'"> </td>';
echo '</tr>';

echo '<tr>';
echo '	<td colspan="2" width="100%"> &nbsp; </td>';
echo '</tr>';

echo '<tr>';
echo '	<td colspan="2" width="100%"> <input type="submit" name="submit" value="Edit Schedule">  </td>';
echo '</tr>';

echo '</form>';
echo '</table>';

return;
}



}

/** View Area ***/

echo "<table width=\"80%\">";
echo "<tr>";
echo "  <td width=\"10%\"><span class=\"bg\"> Device </span></td>";
echo "  <td width=\"10%\"><span class=\"bg\"> Time </span></td>";
echo "  <td width=\"5%\"><span class=\"bg\"> On/Off </span></td>";
echo "  <td width=\"10%\"><span class=\"bg\"> State </span></td>";
echo "	<td width=\"5%\"><span class=\"bg\"> DB </span></td>";
echo "</tr>";

$sql		= "SELECT * FROM schedule WHERE id !='0' ORDER BY pin DESC";
$query		= mysqli_query($m_connect,$sql);
while($schedule = mysqli_fetch_array($query)) {

$del = "<a href=\"index.php?p=SCHEDULE.main&a=del&id=".$schedule['id']."\"> <img src=\"images/delete.png\" width=\"20\" height=\"20\"></a>";
$edit = "<a href=\"index.php?p=SCHEDULE.main&a=edit&id=".$schedule['id']."\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"></a>";
  
echo "<tr>";
echo "  <td width=\"20%\"> ".PinToName($schedule['pin'])." </td>";
echo "  <td width=\"10%\"> ".$schedule['time']." </td>";
echo "  <td width=\"5%\"> ".to_state($schedule['state'])." </td>";
echo "  <td width=\"10%\">";
if($schedule['active'] == "1") {
echo "Enabled";   
} else {
echo "Disabled";
}
echo "</td>";
echo "	<td width=\"5%\"> $edit $del </td>";
echo "</tr>";



}

echo "</table>"; 

echo "<br/> <a href=\"index.php?p=SCHEDULE.main&a=new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"> </a> ";


echo "<br/><p align=\"right\">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";


?>