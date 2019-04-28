<?php



if(isset($_GET['a'])) {

$a = addslashes($_GET['a']);

if($a == "new_temp")  {
$new_temp = addslashes($_GET['temp']);
mysqli_query($m_connect,"UPDATE config SET set_temp='$new_temp' WHERE id='1'");
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

mysqli_query($m_connect,"UPDATE config SET left_column='$left', mid_column='$mid', right_column='$right' WHERE id='1' LIMIT 1");


Alert("Layout changed.");
return;
}



$sql		= "SELECT * FROM config WHERE id !='0'";
$query		= mysqli_query($m_connect,$sql);
$config		= mysqli_fetch_assoc($query);


echo "<table width=\"60%\">";
echo "<form method=\"post\" action=\"\">";

echo "<tr>";
echo "	<td width=\"40%\">Left Column: </td>";
echo "  <td width=\60%\"> <p>";
echo "     <select name=\"left\">";
$sql			= "SELECT * FROM relays WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
echo "       <option value=\"".$relay['pin']."\" "; if($config['left_column'] == $relay['pin']) { echo "selected";  } echo "> ".$relay['name']." </option>";
}
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "	<td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "	<td width=\"40%\">Mid Column (Tub Temp.) </td>";
echo "  <td width=\60%\"> <p>";
echo "     <select name=\"mid\">";
$sql			= "SELECT * FROM sensors WHERE id !='0'";
$query			= mysqli_query($m_connect,$sql);
while($sensor	= mysqli_fetch_assoc($query)) {
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
$query			= mysqli_query($m_connect,$sql);
while($relay	= mysqli_fetch_assoc($query)) {
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
$query			= mysqli_query($m_connect,$sql);
$config			= mysqli_fetch_assoc($query);

$current_temp = GetTemp($config['mid_column']);

$min_temp = $config['set_temp'] - 1;
$max_temp = $config['set_temp'] + 1;

echo " <a href=\"./index.php?p=webcam.main\" target=\"_parent\"> <img class=\"editdivt\" src=\"./images/webcam.svg\" height=\"30\">  </a> ";


echo "<table class=\"circletb\" width=\"60%\">";
echo "<tr>";
echo "  <td width=\"33%\"> <div class=\"pomp-circle\"> <br/><br/> ".PinToName($config['left_column'])." <br/><br/>  <font size=\"9\">".to_state(ReadPin($config['left_column']))."</font></div>  </td> ";

echo "  <td width=\"33%\"> <div class=\"temp-circle\"> <div class=\"inner-circle\"> <div class=\"other-circle\">  ";

echo " <font class=\"current\" size=\"2\">Current Temp</font><br/><br/><br/><span class=\"probe\">$current_temp&#176;</span><br/>";
echo "<span class=\"plusminus\"> ".$config['set_temp']." </span><br />";
echo "  <a class=\"minus\" href=\"index.php?p=control&a=new_temp&temp=".$min_temp."\"> <img class=\"minus\" src=\"./images/minus.png\" height=\"25\"> </a> <a class=\"minus\" href=\"index.php?p=control&a=new_temp&temp=".$max_temp."\"> <img class=\"minus\" src=\"./images/plus.png\" height=\"25\"> </a> <br/>";
echo "  <span class=\"plus\">";
echo " Set Temp</span> </div></div></div>   </td>";
echo "	<td width=\"33%\"> <div class=\"pomp-circle\"> <br/><br /> ".PinToName($config['right_column'])." <br/><br/>  <font size=\"9\">".to_state(ReadPin($config['right_column']))."</font></div>  </td>";
echo "</tr>";
echo "</table>";

echo " <div class=\"editdiv\" > ";
echo " <span class=\"editdivr\" > <a href=\"index.php?p=control&a=edit\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"></a>  ";
echo " <a href=\"tablet\" > <img class=\"editdivl\" src=\"images/tablet_icon.png\" width=\"20\"> </a>  ";
echo " </div> ";


/// Relay control
echo "<br /><br />";
echo "<h1> Oasis Spa Control </h1><br/>";
echo "<table align=\"right\" width=\"50%\"> ";
/****
echo "<tr>";
echo "  <td width=\"100%\" <span class=\"tfont\" >INSTRUCTIONS </span></td>";
echo "</tr>";
echo "<tr>";
echo "  <td colspan=\"1\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";
echo "  <td align=\"center\" colspan=\"2\"> Welcome to Luxury <br /></td>";
echo "</tr>";
echo "</tr>";
echo " <td class=\"instructionsbg\"  colspan=\"1\"> Your Luxury is important to us. To operate this luxurious SPA, please follow these simple instructions. <br /><br />To heat the SPA, click the '+' button in the temp circle above to the desired temperature. It will take about an hour to heat from 29° to 40° (104°). When done luxuriating, set the temp down with the '-' button to 29° ";
echo " </td>";
echo "</tr>";
echo "  <td align=\"center\"> OTHER TEMPERATURES <br /></td>";
echo "</tr>";
****/
$sql				= "SELECT * FROM sensors WHERE visible='yes' ORDER BY id ASC";
$query				= mysqli_query($m_connect,$sql);
while($sensor		= mysqli_fetch_assoc($query)) {
echo "<tr class=\"temps\" align=\"left\">";
echo "  <td> ".$sensor['name']." </td>";
echo "  <td> ".$sensor['temperature']." &#8457; </td>";
echo "</tr>";
}
echo "</table>";
echo "<table width=\"50%\"> ";
// echo "<tr>";
// echo "  <td width=\"30%\"><span class=\"tfont\" >  Function</span></td>";
// echo "  <td width=\"30%\"><span class=\"tfont\"> State</span></p> </td>";
// echo "</tr>";

// echo "<tr>";
// echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
// echo "</tr>";


$sql				= "SELECT * FROM relays WHERE visible='yes' ORDER BY pin ASC";
$query				= mysqli_query($m_connect,$sql);
while($relay		= mysqli_fetch_assoc($query)) {

$on 	= "<a href=\"index.php?a=on&pin=".$relay['pin'] ."\"> <img class=\"tdbutton\" src=\"images/poweron.png\" width=\"45\" height=\"45\"> </a>   ";
$off  	= "<a href=\"index.php?&a=off&pin=".$relay['pin'] ."\"> <img class=\"tdbutton\" src=\"images/poweroff.png\" width=\"45\" height=\"45\"> </a>   ";

echo "<tr>";
echo "  <td width=\"30%\"><span class=\"fpfont\" > ".$relay['name']." </span></td>";
echo "  <td width=\"30%\">";

if(ReadPin($relay['pin']) == 1) {
mysqli_query($m_connect, "UPDATE relays SET state = '0' WHERE id = ".$relay['id']." LIMIT 1");
echo $on;
} else {
mysqli_query($m_connect, "UPDATE relays SET state = '1' WHERE id = ".$relay['id']." LIMIT 1");
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
echo ' <img src="images/poweroff.png" width="20" height="20"> = ON ';



// echo "<p align=\"right\">  <a href=\"https://app.weathercloud.net/d4800709094\" target=\"_blank\"> <img src=\"https://app.weathercloud.net/device/sticker/4800709094\" ></a> </p>";
// echo "<p align=\"right\">  <a href=\"http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=KWASEATT1944\" target=\"_blank\"> <img src=\"http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250&weatherstationcount=KWASEATT1944\" width=\"250\" height=\"150\" border=\"0\" alt=\"Weather Underground PWS KWASEATT1944\"></a> </p>";
echo "<p align=\"right\">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";

?>
