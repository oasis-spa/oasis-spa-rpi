 <?php
 
/*
 http://stackoverflow.com/questions/12719008/use-shell-exec-to-restart-server
*/
 
Include "submenu.php";
echo "<br/> ";

if(isset($_POST['restart']))  {

system("sudo /usr/bin/reboot");

alert("Server is going down for restart.");
} 

if(isset($_POST['shutdown']))  {
system("sudo /sbin/reboot");
alert("Server is going down. Recycle power to turn it on.");
} 


$current = date('H:i:s', $tijd);

echo 'System Time: '.$current.' <br />';
 
//GET SERVER LOADS
$loadresult = @exec('uptime');
preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/",$loadresult,$avgs);

//GET SERVER UPTIME
$uptime = explode(' up ', $loadresult);
$uptime = explode(',', $uptime[1]);
$uptime = $uptime[0].', '.$uptime[1];
$data .= "Server Load Averages $avgs[1], $avgs[2], $avgs[3]\n <br/>";
$data .= "Server Uptime $uptime";
echo $data;




exec("cat /sys/class/thermal/thermal_zone0/temp",$cputemp);
$cputemp = $cputemp[0] / 1000;
echo '<br />';
echo 'Server CPU temperature: ';
echo $cputemp;
echo '&deg;C </br>';

echo '<br /><br />';
echo '<form method="post" action="">';
echo '<p class="submit"><input type="submit" name="restart" value="Restart Server"></p>';
echo '<p class="submit"><input type="submit" name="shutdown" value="Shutdown Server"></p>';
echo '</form>';


echo '<br /> <p> <a href="index.php?p=about">About</a> </p>';
echo '<br /> <p> <a href="./index.php?p=LOGS.main" target="_parent">Logs</a> </p>';
echo '<br /><p align="right">  <a href=\"https://github.com/the-butterfry/Oasis-Spa/wiki\" target=\"_blank\"> <img src="./images/questionmark.png"> </a> </p>';

?>





  
  
