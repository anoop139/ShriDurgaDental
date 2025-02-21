<?php
include("Connection/Connect.php");
error_reporting(0);
$name = $_GET['n'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information page</title>
	<style>
	#header0{
		background-color:black

	}
	</style>
    <link rel="stylesheet" href="Header.css?v=6">
</head>
<body id="body">
<input type="text" name="name" value="<?php echo$name;?>" hidden />
<?php
$name1 = $name;
if(isset($name1))
{
	
	echo"<script>
	alert('The treatment for $name1 has been inserted successfully')
	</script>";
}



?>
<div id="header0" style="background-color:lightblue">

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

 <?php
 
   $display ="select * from patient";
   $display2 ="select * from treatment";
   $query   =  mysqli_query($conn, $display);
   $query2   =  mysqli_query($conn, $display2);  
  $no    = mysqli_num_rows($query);
  $no2    = mysqli_num_rows($query2);
  //$show1   = mysqli_fetch_assoc($query);
if($no>0)
{
	echo"<table border='2' cellpadding='4'>
  <th>Name</th>
  <th>Age</th>
  <th>Gender</th>
  <th>Phone Number</th>
  <th>No. of treatment</th>
  <th>Treatment details</th>
  <th>Edit</th>";
   while( $show    = mysqli_fetch_assoc($query))
   {
   $display3 ="select * from treatment where tid=$show[sno]";
   $query5  = mysqli_query($conn, $display3);
   $Con  = mysqli_num_rows($query5);
 
    echo"<tr>
	<td>$show[name]</td>
	<td style='text-align:center'>$show[age]</td>
	<td style='text-align:center'>$show[gen]</td>
	<td>$show[phoNo]</td>
	<td style='text-align:center;'><a href='Info.php?v=$show[sno]&n=$show[name]' class='ank' title='Click here to view treatment details'>$Con</a></td>
	<td style='text-align:center;'><a href='T1.php?v=$show[sno]&n=$show[name]' class='ank' title='Click here to add treatment details'>Add treatment details</a></td>
	<td style='text-align:center;'><a href='Edit.php?name=$show[sno]' class='ank'>Edit</a></td>
	</tr>"; 	
   }	

   }
 

  else{
	  	echo"<h1 style='text-align:center'> No patient recoded yet</h1>";
   }
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