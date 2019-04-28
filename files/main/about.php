<?php

$sql 			= "SELECT * FROM config WHERE id ='1' LIMIT 1";
$query			= mysql_query($sql);
$data			= mysql_fetch_assoc($query);


echo "<strong>OASIS LUXURY SPA</strong><br />";
echo "Server version: ".$data['version']."  <br />"; 

echo "<br /> <br/>";
echo "For further information or new software releases<br /> <a href=\"https://github.com/the-butterfry/Oasis-Spa\" target=\"_blank\">https://github.com/the-butterfry/Oasis-Spa</a>";
echo "<br /> <br/>";
echo "Oasis Luxury Spa edition by Cory Verellen";
echo "<br />";
echo "Modified to be used with MQTT controlled <a href=\"https://www.itead.cc/sonoff-wifi-wireless-switch.html\" target=\"_blank\">Sonoff</a> switches and 
<a href=\"https://github.com/xoseperez/espurna\" target=\"_blank\">Espurna firmware</a>";
echo "<br /> <br/>";
echo "Oasis Spa based on original code by <a href=\"http://www.instructables.com/id/Hottub-Pool-Controller-Web-Interface\" target=\"_blank\">Rick Feenstra</a> ";
echo "<br /> <br/>";

echo "<br/><p align=\"right\">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";


?>