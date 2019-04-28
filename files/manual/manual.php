<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Luxury Inflatable SPA</title>
  <link rel="stylesheet" href="/css/logged.css">
<link href="https://fonts.googleapis.com/css?family=Arima+Madurai|Bungee+Inline|Bungee+Outline|Bungee+Shade|Rakkas|Rasa|Shrikhand|Yatra+One|Space+Mono" rel="stylesheet">
</head>
<body>
  <style>
 html {  
  background: url("/images/bg2.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
  <section class="about">
    <p class="about-links">
      <a href="/index.php" target="_parent">Main Page</a>
	  <a href="/tablet" target="_parent">Mobile page</a>
	  <?php 
	  if($this_user['rank'] >= "2") {
	  ?>
      <a href="/index.php?p=SCHEDULE.main" target="_parent">Scheduling</a>
      <a href="/index.php?p=CONF.main" target="_parent">settings</a>
	  <?php
	  } 
	  ?>
	  <a href="/index.php?p=info.main" target="_parent">Info</a>
      <a href="/index.php?p=logout" target="_parent">Logout</a>

	  </p>
   </section>



  <section class="container">
    <div class="login">
      <h1>Oasis Luxury Home SPA</h1>
      
	  <!--- include from here --->
	  
<?php
	Include("../include.php");
	include("manual.htm");
?>
	  
	  <!-- End includes --->
	  
    </div>
  </section>


</body>
</html>
