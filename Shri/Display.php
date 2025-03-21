<?php
include("Connection/Connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<style>
	#header0{
		background-color:black
	}
	</style>
    <link rel="stylesheet" href="Header.css?v=4">
</head>
<body id="body">
<div id="header0" style="background-color:lightblue;">
	  <div id="header">
        <ul>
        <li><a href="HomePage.html">Home </a></li>&nbsp;
        <li><a href="Fom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by Name</a></li>
        </ul>
</ul><br><br><br><br><br>
</div>
</div>
<div id="dis">
 <table border="2" cellpadding="4">
  <th>Date</th>
  <th>Name</th>
  <th>Age</th>
  <th>Gender</th>
  <th>Phone Number</th>
  <th>No. of treatment</th>
  <th>Treatment details</th>
  <th>Edit</th>
 <?php
   $display ="select * from patient";
   $display2 ="select * from treatment";
   $query   =  mysqli_query($conn, $display);
   $query2   =  mysqli_query($conn, $display2);
   // $amt   =  $_GET['amt'];
   // echo"".$amt;
  
  $no    = mysqli_num_rows($query);
  $no2    = mysqli_num_rows($query2);
    while( $show    = mysqli_fetch_assoc($query))
    echo"<tr>
	<td>$show[date]</td>
	<td>$show[name]</td>
	<td style='text-align:center'>$show[age]</td>
	<td style='text-align:center'>$show[gen]</td>
	<td>$show[phoNo]</td>
	<td style='text-align:center;'><a href='' class='ank' title='Click here to view treatment details'>$no2</a></td>
	<td style='text-align:center;'><a href='Treatment.php?v=$show[sno]' class='ank' title='Click here to add treatment details'>Add treatment details</a></td>
	<td style='text-align:center;'><a href='' class='ank' title='Click here to add treatment details'>Edit</a></td>
	</tr>"; 		
   
 
 
 ?>
 </table>
</div>
<div>
<div id="button">
 <button class="btn">Back</button>
 <button id="next" class="btn">Next</button>
</div>
</div>
</body>
</html>