<?php
// Let op tijdelijk logout file , login file gewoon includen ivm verwijderen van login in de db. etc.

session_destroy();

echo "<br /><center>Be sure to turn off Automatic Control please! </center><br />";
echo "<center><img src=\"images/off-logout.gif\" width=\"15%\" height=\"15%\"></center>";

echo " <META http-equiv=\"refresh\" content=\"5; URL=./index.php\"> ";

exit;
?>