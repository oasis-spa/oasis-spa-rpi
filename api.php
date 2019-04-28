<?php


include("./config.php");
include("./functions.php");


$size 		= '13';
$text 		= '000000';
$background = 'FFFFFF';

if(isset($_GET['size'])) { $size = $_GET['size']; }
if(isset($_GET['text'])) { $text = $_GET['text']; }
if(isset($_GET['background'])) { $background = $_GET['background']; }



?>
<html>
<head>
<title>API</title>
<style>
body {
  font: <?php echo $size; ?>px 'Lucida Grande', Tahoma, Verdana, sans-serif;
  color: #<?php echo $text; ?>;
  background: #<?php echo $background; ?>;
}
</style>
</head>
<?php


///***** Check for API key *****///
$sql	 = "SELECT * FROM config WHERE id !='0' LIMIT 1";
$query	 = mysqli_query($m_connect,$sql);
$data	 = mysqli_fetch_assoc($query);

if($config['api'] = '0') {
exit;
}

$key		= $_GET['key'];


if($key != $data['token']) {
echo 'invalid key.';
return;
}



$action		= addslashes($_GET['action']);

//http://192.168.1.77/api.php?key=Gdw34^%FHYDe&action=read_temp&sensor=28-0000040d5895

if(isset($action)) {


if($action == "read_temp") {

$sensor		= addslashes($_GET['sensor']);
$temp		= GetTemp($sensor);

echo "".$temp." &deg;C";

return;
}




if($action == "read_relay") {

$relay		= addslashes($_GET['relay']);

if(ReadPin($relay) == '0') {
echo 'On';
} else {
echo 'Off';
}
//echo ReadPin($relay);
return;
}



if($action == "read_all_sensors") {

echo '<table width="20%">';

$sql		= "SELECT * FROM sensors WHERE id!='0'";
$query		= mysqli_query($m_connect,$sql);
while($all	= mysqli_fetch_assoc($query)) {
echo '<tr>';
//echo '  <td width="33%"> '.$all['address'].' </td> ';
echo '  <td width="80%"> '.$all['name'].' </td> ';
echo '  <td width="20%"> '.GetTemp($all['address']).' </td> ';
echo '</tr>';
}
echo '</table>';

return;
}



if($action == "read_all_relays") {

echo '<table width="20%">';

$sql		= "SELECT * FROM relays WHERE id!='0'";
$query		= mysqli_query($m_connect, $sql);
while($all	= mysqli_fetch_assoc($query)) {
echo '<tr>';
echo '  <td width="33%"> '.$all['pin'].' </td> ';
echo '  <td width="80%"> '.$all['name'].' </td> ';
echo '  <td width="20%"> '.to_state_menu($all['state']).' </td> ';
echo '</tr>';
}
echo '</table>';


return;
}


if($action == "get_pool_temp") {

$sql		= "SELECT * FROM config WHERE id='1' LIMIT 1";
$query		= mysqli_query($m_connect,$sql);
$data		= mysqli_fetch_assoc($query);

echo $data['set_temp'];

return;
}



if($action == "set_pool_temp") {

if(isset($_GET['temp'])) {
$temp		= $_GET['temp'];
mysqli_query($m_connect,"UPDATE config SET set_temp='$temp' WHERE id='1' LIMIT 1");
echo 'Temperature Set';
}


return;
}


if($action == "write_relay") {

$relay		= addslashes($_GET['relay']);
$state		= addslashes($_GET['state']);

WritePin($relay,$state);

echo 'Done';

return;
}



} ////end of if(isset

?>

</font>
</body>
</html>
