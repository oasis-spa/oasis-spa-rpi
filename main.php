<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Web App Controller</title>
  <link rel="stylesheet" href="css/logged.css">
</head>
<body>

  <section class="about">
    <p class="about-links">
      <a href="./index.php" target="_parent">Home</a>
	  <?php 
	  if($this_user['rank'] >= "2") {
	  ?>
      <a href="./index.php?p=SCHEDULE.main" target="_parent">Time Schedule</a>
      <a href="./index.php?p=CONF.main" target="_parent">Configuration</a>
      <a href="./index.php?p=LOGS.main" target="_parent">Logs</a>
	  <?php
	  } 
	  ?>
      <a href="./index.php?p=logout" target="_parent">Logout</a>

	  </p>
   </section>



  <section class="container">
    <div class="login">
      <h1>Web App Hottub Controller</h1>
      
	  <!--- include from here --->
	  
<?php
	Include("include.php");
?>
	  
	  <!-- End includes --->
	  
    </div>
  </section>


</body>
</html>
