<?php
include "submenu.php";
/*** $a = addslashes($_GET['a']);
if(isset($a)) {
if($a == "clearall") {
mysqli_query($m_connect,'TRUNCATE TABLE logs;');
alert("All logs cleared.");
}
} **/
echo "<table width=\"60%\"> ";
echo "<tr>";
echo "		<td width=\"70%\"> System Log: </td>";
echo "		<td width=\"30%\"> Time: </td>";
echo "</tr>";
echo "<tr>";
echo "		<td colspan=\"2\" width=\"100%\"> <p align=\"right\"> <a href=\"index.php?p=LOGS.system&a=clearall\"> <img src=\"./images/clearall.png\">  </a>  </p> </td>";
echo "</tr>";
$sql			= "SELECT * FROM logs WHERE id !='0' ORDER BY time DESC";
$query			= mysqli_query($m_connect,$sql);
while($logs		= mysqli_fetch_assoc($query)) {
echo "<tr>";
echo "		<td width=\"70%\"> ".$logs['log']." </td>";
echo "		<td width=\"30%\"> ".$logs['time']." </td>";
echo "</tr>";
}
echo "</table>";
?>
