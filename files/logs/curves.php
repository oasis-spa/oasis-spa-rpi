<?php

include "submenu.php";


///echo 'http://www.highcharts.com/demo/?example=line-basic&theme=gray';
echo "<br />";
//echo 'http://highcharttable.org/#demo';

?>


<link href="./chart/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script src="./chart/jquery.min.js"></script>
<script type="text/javascript" src="./chart/highcharts.js"></script>
<script type="text/javascript" src="./chart/jquery.highchartsmaker.js"></script>
<style type="text/css"></style>

<body>

<div id="chart"></div>






<table id="data">
<thead>
<tr>
<th>Date</th>
<?

$sql				= "SELECT * FROM sensors WHERE id !='0'"; 
$query				= mysql_query($sql);
while($data 		= mysqli_fetch_assoc($query)) { 
echo '<th> '.($data['name']).' </th>';	
  $counter++; // or $counter = $counter + 1;
}

for ($i = 1; $i <= $counter; $i++) {
    echo $i;
}

?>
</tr>
</thead>
<tbody>
<tr>
<td>08:00</td>
<td>20.7</td>
<td>15.2</td>
<td>12.1</td>
<td>2.0</td>
</tr>
<tr>
<td>09:00</td>
<td>23.4</td>
<td>17.8</td>
<td>14.3</td>
<td>2.8</td>
</tr>
<tr>
<td>10:00</td>
<td>25.1</td>
<td>19.2</td>
<td>16</td>
<td>2.7</td>
</tr>
<tr>
<td>11:00</td>
<td>29.2</td>
<td>21.2</td>
<td>16</td>
<td>5.7</td>
</tr>



</tr>
</tbody>
</table>
<br />
<script type="text/javascript">
$(function() {
$('#chart').highchartsMaker($('#data'), {
	"title": "Temperature Overview",
	"yAxis":{"min":0}, 
	"date_interval":86400000
	});
});
</script>


</body>



