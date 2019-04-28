<?php
  
Include "submenu.php";

echo "<br/>";


if(isset($_GET['a'])) {
	
$a = addslashes($_GET['a']);

if(isset($_GET['id'])) {
$id 	= addslashes($_GET['id']);
}

if($a == "del") {
    if($id == "1") {
    alert("This user cannot be deleted.");
    return;
    }
mysqli_query($m_connect,"DELETE FROM users WHERE id='$id' LIMIT 1");
alert("User deleted.");
}


if($a == "new") {


if(isset($_POST['submit'])) {

$username  	= addslashes($_POST['username']);
$password	= md5($_POST['password']);
$email		= addslashes($_POST['email']);
$rank		= addslashes($_POST['rank']);

if(empty($username)) {
alert("Username could not be empty.");
return;
}

mysqli_query($m_connect,"INSERT INTO users (id,username,password,email,rank) VALUES('','$username','$password','$email','$rank')");
alert("User Added.");
return;
}

echo "<table width=\"60%\"> ";
echo "<form method=\"post\" action=\"\">";
echo "<tr>";
echo "  <td width=\"40%\">Username: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"username\" value=\"\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Password: </td>";
echo "  <td width=\"60%\">  <input type=\"password\" name=\"password\" value=\"\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Email: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"email\" value=\"\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Rank: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"rank\">";
echo "       <option value=\"0\">None</option>"; 
echo "       <option value=\"1\">User</option>";
echo "       <option value=\"2\">Administrator</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Add User\">  </td>";
echo "</tr>";


echo "</form>";
echo "</table>";
return;
}


if($a == "edit") {

$sql				= "SELECT * FROM users WHERE id ='$id'"; 
$query				= mysqli_query($m_connect,$sql);
$user				= mysqli_fetch_assoc($query);

if(isset($_POST['submit'])) {

$username  	= addslashes($_POST['username']);
$password	= addslashes($_POST['password']);
$email		= addslashes($_POST['email']);
$rank		= addslashes($_POST['rank']);

if(empty($username)) {
alert("Username could not be empty.");
return;
}

if($user['id'] == "1" && $rank !="2") {
alert("Administrator rank cannot be changed.");
return;
}

if(!empty($password)) {
$pass 	= md5($password);
mysqli_query($m_connect,"UPDATE users SET password='$pass' WHERE id='$id' LIMIT 1");
}

mysqli_query($m_connect,"UPDATE users SET username='$username', email='$email', rank='$rank' WHERE id='$id' LIMIT 1");

alert("User Changed.");
return;
}

echo "<table width=\"60%\"> ";
echo "<form method=\"post\" action=\"\">";
echo "<tr>";
echo "  <td width=\"40%\">Username: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"username\" value=\"".$user['username']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Password: </td>";
echo "  <td width=\"60%\">  <input type=\"password\" name=\"password\" value=\"\">  (don't change it? leave it blank)</td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Email: </td>";
echo "  <td width=\"60%\">  <input type=\"text\" name=\"email\" value=\"".$user['email']."\">  </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"2\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";

echo "<tr>";
echo "  <td width=\"40%\">Rank: </td>";
echo "  <td width=\"60%\"> <p>";
echo "     <select name=\"rank\">";
echo "       <option value=\"0\" "; if($user['rank'] == "0") { echo "selected";  } echo ">None</option>"; 
echo "       <option value=\"1\" "; if($user['rank'] == "1") { echo "selected";  } echo ">User</option>";
echo "       <option value=\"2\" "; if($user['rank'] == "2") { echo "selected";  } echo ">Administrator</option>";
echo "    </select>";
echo " </p> </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> <input type=\"submit\" name=\"submit\" value=\"Edit User\">  </td>";
echo "</tr>";


echo "</form>";
echo "</table>";
return;
}



}





echo "<table width=\"90%\"> ";
echo "<tr>";
echo "  <td width=\"20%\"> Username:  </td>";
echo "  <td width=\"40%\"> Email:  </td>";
echo "  <td width=\"20%\"> Function:  </td>";
echo "  <td width=\"20%\"> DB: </td>";
echo "</tr>";

echo "<tr>";
echo "  <td colspan=\"4\" width=\"100%\"> &nbsp; </td>";
echo "</tr>";


$sql				= "SELECT * FROM users WHERE id !='0' ORDER BY id ASC"; 
$query				= mysqli_query($m_connect,$sql);
while($user 		= mysqli_fetch_assoc($query)) { 

$edit 	= "<a href=\"index.php?p=CONF.users&a=edit&id=".$user['id'] ."\"> <img src=\"images/edit.png\" width=\"20\" height=\"20\"></a>   ";
$del  	= "<a href=\"index.php?p=CONF.users&a=del&id=".$user['id'] ."\"> <img src=\"images/delete.png\" width=\"20\" height=\"20\"></a>   ";

echo "<tr>";
echo "  <td width=\"20%\"> ".$user['username']." </td>";
echo "  <td width=\"40%\"> ".$user['email']." </td>";
echo "  <td width=\"20%\"> ".to_function("".$user['rank']."")." </td>";
echo "  <td width=\"20%\"> $edit  $del </td>";
echo "</tr>";

}

echo "</table>";

echo "<br/><a href=\"index.php?p=CONF.users&a=new\"> <img src=\"images/add.png\" width=\"20\" height=\"20\"> </a> ";

echo "<br/><p align=\"right\">  <a href=\"./manual.html#controller_users\" target=\"_blank\"> <img src=\"./images/questionmark.png\"> </a> </p> ";


?>