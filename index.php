<?php

error_reporting (1);

include("config.php");
include("functions.php");
session_start();

/**
index.php File

@ Realityhost.nl

Created at 7-1-2009  (dd/mm/yyyy) at 11:00
**/



/** Als er geen sessie is ga je naar de login pagina **/
if(empty($_SESSION['username']) OR empty($_SESSION['password'])) {
include("login.php"); /// login file includen
return;
}
/** Eind **/

$username = $_SESSION['username'];
$password = $_SESSION['password'];



/** Diverse logins checks op echtheid etc. **/
if(!empty($_SESSION['username']) OR !empty($_SESSION['password'])) {

$check_sql		= "SELECT * FROM users WHERE username='".$_SESSION['username']."' AND password='".$_SESSION['password']."' LIMIT 1";
$check_query	= mysqli_query($m_connect,$check_sql) or die("Error, please close this session and try again.");
$this_user		= mysqli_fetch_assoc($check_query);


/** Login Check op echtheid **/
if(mysqli_num_rows($check_query) != "1") {
	session_destroy();
/** Sesie is verwijderd en je gaat weer terug naar de login. **/
echo " <META http-equiv=\"refresh\" content=\"1; URL=./index.php\"> ";
return;
}

/** Einde login check **/

/*** Kijken of de users zijn ip wel gelijkt blijft , ivm sesie hijacking **/
/**
if($ip != $_SESSION['ip'] OR $ip != $this_user['ip']) {
session_destroy();

echo " <META http-equiv=\"refresh\" content=\"1; URL=./index.php\"> ";

return;
}
/** Einde ip check **/


include("./main.php");

return;
}



?>






