<?php
// Let op tijdelijk logout file , login file gewoon includen ivm verwijderen van login in de db. etc.

session_destroy();

echo "<br /><center>Thanks for you're visit. </center><br />";


echo " <META http-equiv=\"refresh\" content=\"2; URL=./index.php\"> ";

exit;
?>