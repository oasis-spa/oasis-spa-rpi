<?php
  
Include "submenu.php";

echo "<br/>";


$sql 			= "SELECT * FROM config WHERE id='1' LIMIT 1";
$query			= mysqli_query($m_connect,$sql);
$data			= mysqli_fetch_assoc($query);


   

if(isset($_GET['a'])) {
	
$a = addslashes($_GET['a']);

if($a == "edit") {

if(isset($_POST['submit'])) {
$raspberry_type		= addslashes($_POST['raspberry_type']);
$api				= addslashes($_POST['api']);
$token				= addslashes($_POST['token']);

$tablet				= addslashes($_POST['tablet']);
$ip_check			= addslashes($_POST['ip_check']);
$ip_range			= addslashes($_POST['ip_range']);

mysqli_query($m_connect,"UPDATE config SET raspberry_type='$raspberry_type', api='$api', token='$token', tablet_view='$tablet', ip_check='$ip_check', ip_range='$ip_range' WHERE id='1' LIMIT 1");

alert("Changes saved.");

return;
}

echo "<table width=\"100%\"> ";
echo "<form method=\"post\" action=\"\"> ";

echo "<tr>";
echo "  <td width=\"20%\"> Raspberry Model: </td>";
echo "  <td width=\"80%\"> <p>";
echo "     <select name=\"raspberry_type\">";
echo "       <option value=\"Model A\" "; if($data['raspberry_type'] == "Model A") { echo "selected";  } echo ">Model A</option>"; 
echo "       <option value=\"Model B\" "; if($data['raspberry_type'] == "Model B") { echo "selected";  } echo ">Model B</option>"; 
echo "       <option value=\"Model B+\" "; if($data['raspberry_type'] == "Model B+") { echo "selected";  } echo ">Model B+</option>"; 
echo "       <option value=\"Model 2b\" "; if($data['raspberry_type'] == "Model 2b") { echo "selected";  } echo ">Model 2B</option>";
echo "       <option value=\"Model 3\" "; if($data['raspberry_type'] == "Model 3") { echo "selected";  } echo ">Model 3</option>";
echo "       <option value=\"Model 3b\" "; if($data['raspberry_type'] == "Model 3b") { echo "selected";  } echo ">Model 3B</option>";
echo "       <option value=\"Model 3b+\" "; if($data['raspberry_type'] == "Model 3b+") { echo "selected";  } echo ">Model 3B+</option>";
echo "       <option value=\"Zero\" "; if($data['raspberry_type'] == "Zero") { echo "selected";  } echo ">Zero</option>"; 
echo "    </select>";
echo " </p> </td>";
echo "</tr>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp;  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> API enabled: </td>";
echo "  <td width=\"80%\"> <p>";
echo "     <select name=\"api\">";
echo "       <option value=\"0\" "; if($data['api'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($data['api'] == "1") { echo "selected";  } echo ">On</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp;  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Token: </td>";
echo "  <td width=\"80%\"> <p><input type=\"text\" name=\"token\" value=\"".$data['token']."\"></p> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp;  </td>";
echo "</tr>";
echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp;  </td>";
echo "</tr>";



echo "<tr>";
echo "  <td width=\"20%\"> Tablet View: </td>";
echo "  <td width=\"80%\"> <p>";
echo "     <select name=\"tablet\">";
echo "       <option value=\"0\" "; if($data['tablet_view'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($data['tablet_view'] == "1") { echo "selected";  } echo ">On</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp;  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Ip Check: </td>";
echo "  <td width=\"80%\"> <p>";
echo "     <select name=\"ip_check\">";
echo "       <option value=\"0\" "; if($data['ip_check'] == "0") { echo "selected";  } echo ">Off</option>"; 
echo "       <option value=\"1\" "; if($data['ip_check'] == "1") { echo "selected";  } echo ">On</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp;  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Ip Address: </td>";
echo "  <td width=\"80%\"> <p>";
echo "     <select name=\"ip_range\">";
echo "       <option value=\"10.x.x.x\" "; if($data['ip_range'] == "10.x.x.x") { echo "selected";  } echo ">10.x.x.x</option>"; 
echo "       <option value=\"172.x.x.x\" "; if($data['ip_range'] == "172.x.x.x") { echo "selected";  } echo ">172.x.x.x</option>";
echo "       <option value=\"192.168.x.x\" "; if($data['ip_range'] == "192.168.x.x") { echo "selected";  } echo ">192.168.x.x</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp;  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> <br/> <input type=\"submit\" name=\"submit\" value=\"Edit\">  </td>";
echo "</tr>";


echo "</form>";
echo "</table>";


return;
}

}   




echo "<table width=\"100%\"> ";

echo "<tr>";
echo "  <td width=\"20%\"> Raspberry Model: </td>";
echo "  <td width=\"80%\"> ".$data['raspberry_type']." </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Token: </td>";
echo "  <td width=\"80%\"> ".$data['token']." </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> API enabled: </td>";
echo "  <td width=\"80%\">";
if($data['api'] == "1") {
echo "Enabled";
} else {
echo "Disabled";
}
echo " </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> &nbsp; </td>";
echo "</tr>";


/*
echo "<tr>";
echo "  <td width=\"20%\"> Push Notification: </td>";
echo "  <td width=\"80%\">";
if($data['push'] == "1") {
echo "Enabled";
} else {
echo "Disabled";
}
echo " </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Pushover API Token/Key: </td>";
echo "  <td width=\"80%\"> ".$data['push_token']."  &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Pushover User Key: </td>";
echo "  <td width=\"80%\"> ".$data['push_key']." </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>"; 
echo "  <td width=\"100%\" colspan=\"2\">Learn more about push notifications. To create a new project click <a href='https://pushover.net/apps/build' target='_blank'>here</a> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> &nbsp; </td>";
echo "</tr>";

*/

echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> <h1> Tablet Interface</h1> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Tablet View: </td>";
echo "  <td width=\"80%\"> ".to_state_menu($data['tablet_view'])." </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> IP Check: </td>";
echo "  <td width=\"80%\"> ".to_state_menu($data['ip_check'])." </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> IP Range to accept: </td>";
echo "  <td width=\"80%\"> ".$data['ip_range']." .*  &nbsp;&nbsp; (Internal Only) </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Manage IP: </td>";
echo "  <td width=\"80%\"> <a href=\"index.php?p=CONF.iplist\" >Ip List</a> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"100%\" colspan=\"2\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"20%\"> Tablet Page: </td>";
echo "  <td width=\"80%\"> <a href=\"http://".$_SERVER['SERVER_ADDR']."/tablet\" target=\"_blank\"> http://".$_SERVER['SERVER_ADDR']."/tablet </a> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\">  <br/><a href=\"index.php?p=CONF.main&a=edit\">  <img src=\"./images/edit.png\" width=\"32\" height=\"32\"></a> </td>";
echo "</tr>";

echo "</table>";

echo "<br/><p align=\"right\">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";
 
?>
