<?php 
  function alert($text) { 
    echo " <script language=\"javascript\" type=\"text/javascript\"> ";
    echo " alert('$text')"; 
	  echo " </script>";  
	  return; 										 
  } 
  function AddLog($log, $time) { 				  
    global $m_connect; 
    mysqli_query($m_connect,"INSERT INTO logs (id,log,time) VALUES('','$log',now())");						 
  }	
  function Succes($title,$msg) { 
    echo "<table width=\"400\" align=\"center\" border=\"0\" cellpadding=\"0\" cellpadding=\"0\">";
    echo " <form method=\"post\" name=\"ok\" action=\"index.php\">"; 
    echo " <tr>"; 
    echo " <td background=\"images/content-table-headbg.jpg\" width=\"100%\"><center>".$msg."</center></td> "; 
    echo " <tr>"; 
	echo " <tr>"; 
    echo " <td width=\"100%\"><center> <img src=\"./images/done.gif\"> </center></td> "; 
    echo " <tr>"; 
    echo " <tr>";
    echo " <td width=\"100%\"><center>".$msg."</center></td> "; 
    echo " <tr>"; 
    echo " <tr>"; 
    echo " <td width=\"100%\"><center> <input type=\"submit\" name=\"ok\" value=\"Ok\"> </center></td> "; 
    echo " <tr>"; 
    echo " </form>"; 
    echo " </table>"; 
  } 
  /** This is for GPIO , changed 0 to ON / 1 to OFF
otherwise the relays will be on when device disabled ***/ 
  function to_state($state) {
    assert($state == 0 || $state == 1);
    return ["On", "Off"][$state];
  } 
    
  function to_state_menu($state) {
    assert($state == 0 || $state == 1);
    return ["Off", "On"][$state];
  } 
  
  function yes_no($value) {
    assert($value == 0 || $value == 1);
    return ["No", "Yes"][$value];
  } 
  
  function to_function($rank) {
    $rank_names = ["None", "User", "Administrator"];
    return $rank_names[$rank];
  }
   
  function WritePin($pin, $state) { 
    $output = shell_exec("gpio mode {$pin} out"); 
    $output .= shell_exec("gpio write {$pin} {$state}"); 
    return trim($output); 
  }

  function ReadPin($pin)
  {
    $output = shell_exec("gpio read {$pin}");
    return trim($output);
  }

  function PinToName($pin)
  {
  	global $m_connect;
    $sql		= "SELECT * FROM relays WHERE pin='$pin' LIMIT 1";
    $query	= mysqli_query($m_connect, $sql);
    $pins		= mysqli_fetch_assoc($query);
    return $pins['name'];
  }

  function RelayToPin($id)
  {
  	global $m_connect;
    $sql		= "SELECT * FROM relays WHERE id='$id' LIMIT 1";
    $query	= mysqli_query($m_connect, $sql);
    $pins		= mysqli_fetch_assoc($query);
    return $pins['pin'];
  }

  function sensor_name($id)
  {
  	global $m_connect;
    $sql	  = "SELECT * FROM sensors WHERE id='$id' LIMIT 1";
    $query	= mysqli_query($m_connect, $sql);
    $sensor = mysqli_fetch_assoc($query);
    return $sensor['name'];
  }

  function sensor_address_name($address)
  {
  	global $m_connect;
    $sql	  = "SELECT * FROM sensors WHERE address='$address' LIMIT 1";
    $query	= mysqli_query($m_connect, $sql);
    $sensor = mysqli_fetch_assoc($query);
    return $sensor['name'];
  }

  function sensor_id_address($id)
  {
		global $m_connect;
    $sql	  = "SELECT * FROM sensors WHERE id='$id' LIMIT 1";
    $query	= mysqli_query($m_connect, $sql);
    $sensor = mysqli_fetch_assoc($query);
    return $sensor['address'];
  }

  function FindAddress($address)
  {
		global $m_connect;
    $sql	  = "SELECT * FROM sensors WHERE address='$address' LIMIT 1";
    $query	= mysqli_query($m_connect, $sql);
    $sensor	= mysqli_fetch_assoc($query);
    if(mysqli_num_rows($query) == "1") {
    	$name	= 1;
    } else {
    	$name	= 0;
    }
    return $name;
  }

  // This function is also in the cron files.
  function GetTemp($address)
  {
		global $m_connect;
  	$sql		  = "SELECT * FROM sensors WHERE address='$address' LIMIT 1";
  	$query		= mysqli_query($m_connect, $sql);
  	$sensor		= mysqli_fetch_assoc($query);
	
    //File to read
    $file = '/var/log/sensors/'.$address.'/sonoff_th';
    if (file_exists($file)) {
      //Read the file line by line
      $lines = file($file);
      //Get the temp from second line
      $temp = ($lines[1]);
    } else {
      $temp = "9999";
    }
    return $temp + $sensor['calibration_value'];
  }
?>