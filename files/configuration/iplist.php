<?php

Include "submenu.php";
echo "<br />";


if(isset($_GET['a'])) { 

$a		= mysqli_real_escape_string($m_connect, $_GET['a']);
$id		= mysqli_real_escape_string($m_connect, $_GET['id']);

if($a == "del") {
mysqli_query($m_connect,"DELETE FROM iplist WHERE id='$id' LIMIT 1");
alert("IP address deleted.");	
}


if($a == "new") { 

if(isset($_POST['submit'])) {
	$ipadd = mysqli_real_escape_string($m_connect, $_POST['ipaddress']);
	mysqli_query($m_connect,"INSERT INTO iplist (id,ip) VALUES('','$ipadd')");
Alert("Ip Address added.");
}


echo "<table width=\"50%\"> ";
echo "<form method=\"post\"> ";

echo "<tr>";
echo "  <td width=\"40%\"> Ip Address:  </td>";
echo "  <td width=\"60%\"> <input type=\"text\" name=\"ipaddress\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Add\">  </td>";
echo "</tr>";

echo "</form>";
echo "</table>";

return;
} 





} 


echo "<table width=\"40%\"> ";
echo "<tr>";
echo "  <td width=\"80%\"> Ip Address:  </td>";
echo "  <td width=\"20%\"> DB: </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


$sql				= "SELECT * FROM iplist WHERE id !='0'"; 
$query				= mysqli_query($m_connect,$sql);
while($iplist		= mysqli_fetch_assoc($query)) { 

$del  	= "<a href=\"index.php?p=CONF.iplist&a=del&id=".$iplist['id'] ."\"> <img src=\"images/delete.png\" width=\"20\" height=\"20\"></a>   ";

echo "<tr>";
echo "  <td width=\"80%\"> ".$iplist['ip']." </td>";
echo "  <td width=\"20%\"> $del </td>";
echo "</tr>";

}

echo "</table>";

echo "<br/><a href=\"index.php?p=CONF.iplist&a=new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"> </a> ";
echo "<br/><p align=\"right\">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";


?>