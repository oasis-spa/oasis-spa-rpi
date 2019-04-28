<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Papermashup.com | iPhone - jQuery - Switch</title>
<link href="../style.css" rel="stylesheet" type="text/css" />
  <script src="jquery.js" type="text/javascript"></script>
  <script src="jquery.iphone-switch.js" type="text/javascript"></script>

<style>



body{
font-family:Verdana, Geneva, sans-serif;
font-size:14px;}

.left{
float:left;
width:120px;}

#ajax{
float:left;
width:300px;
padding-top:5px;
font-weight:700;
}

.clear{clear:both;}

</style>

</head>

<body>

<div id="container">
 <div class="left" id="1"></div>
   <div class="clear">&nbsp;</div>
</div>
<div id="container"> 
 <div class="left" id="2"></div>

  <div id="ajax"></div> 
  <div class="clear"></div>
  
  


  <script type="text/javascript">  
    $('#1').iphoneSwitch("on", 
     function() {
       $('#ajax').load('on.html');
      },
      function() {
       $('#ajax').load('off.html');
      },
      {
        switch_on_container_path: 'iphone_switch_container_off.png'
      });
  </script>
  
    <script type="text/javascript">  
    $('#2').iphoneSwitch("on", 
     function() {
       $('#ajax').load('on.html');
      },
      function() {
       $('#ajax').load('off.html');
      },
      {
        switch_on_container_path: 'iphone_switch_container_off.png'
      });
  </script>
  
  

  
</div>




</body>
</html>