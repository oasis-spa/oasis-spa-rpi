<?php

if(isset($_POST['login_username'])) {
$login_username		= mysql_real_escape_string($_POST['login_username']);
$login_password   	= mysql_real_escape_string(md5($_POST['login_password']));


$log_sql			= "SELECT id,username,password,ip FROM users WHERE username='$login_username' AND password='$login_password' LIMIT 1";
$log_mysql			= mysql_query($log_sql) or die("Something went wrong, try it again later.");
$log_user			= mysql_fetch_assoc($log_mysql);

if(mysql_num_rows($log_mysql) != "0") {
	
$_SESSION['username'] = $login_username;   /// sessie username setten
$_SESSION['password'] = $login_password;   /// sessie password zetten
$_SESSION['ip']   	  = $ip; // sessie ip zetten.


/** Login gegevens even opslaan in database **/
mysql_query("INSERT INTO login (id,userid,ip,time) VALUES('','".$log_user['id']."','$ip','".time()."')");
/** Ip adres opslaan / koppelen aan de user **/
mysql_query("UPDATE users SET ip='$ip' WHERE id='".$log_user['id']."' LIMIT 1");

/** Login is goed , en nu gaan we doorverwijzen **/
echo " <META http-equiv=\"refresh\" content=\"1; URL=./index.php\"> ";
//AddLog("".$log_user['username']." has logged in.");

}
else {
	echo "Bad Login !.";
	echo " <META http-equiv=\"refresh\" content=\"1; URL=./index.php\"> ";

	/** Opslaan in de database **/
	$pww = addslashes($_POST['login_password']);
	AddLog("".$login_username." tried to login, but failed. From Ip: ".$ip."");
	return;
}


return;
}

?>




<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
  <title>Hot Damn! Tub</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <style>
 html {  
  background: url("images/loginbglarge.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
  <section class="container">
    <div class="login">
      <h1>Login to Luxury</h1>
	  <h2><center>Be sure to take a shower!</center></h2><p></p>
      <form method="post" action="">
        <p><input type="text" name="login_username" value="" placeholder="Username"></p>
        <p><input type="password" name="login_password" value="" placeholder="Password"></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>

    <div class="login-help">
      <p>Forgot your password? <a href="index.html">Click here to reset it</a>.</p>
    </div>
  </section>

  <!--
  <section class="about">
    <p class="about-links">
      <a href="" target="_parent">Contact</a>
      <a href="" target="_parent">About</a>
    </p>
    <p class="about-author">
      &copy; 2014&ndash;2015 <br>
   </section>
   
   -->
</body>
</html>




