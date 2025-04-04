<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<style>
     body{
  background-image:url("https://media.istockphoto.com/id/1349328691/photo/young-happy-woman-during-dental-procedure-at-dentists-office.jpg?s=612x612&w=0&k=20&c=H0WBvMhyspSX10Xq65AFhF4DoMLzg8wOpqjjupwTWDE=");
  background-repeat:no-repeat;
  background-size:cover;

		 
	 }
	
	#res1{
		background-color:white;
	}
	#res1{
		border:2px solid black;
		height:400px;
	}
	
	#res1{
		
		margin-top:50px;
		text-align:center;
	}
	#res1{
		
		padding-top:100px;
		//text-align:center;
	}
	#Next button{
		position:relative;
		top:-20px;
		
	}
	#Next Button{
		float:right;
		color:green;
	}
	#Back{
		padding-top:10px;
		
	}	
	#Back button{
		
		padding-left:30px;
		padding-right:30px;
		
	}
	
	#Next button{
		padding-left:30px;
		padding-right:30px;
		
	}

	</style>
    <link rel="stylesheet" href="Header.css?v=6">
</head>
<body>
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
<div id="res1" style="padding-top:0px;">
 <?php
 $name= $_GET['n'];
 $fid= $_GET['v'];
 $display ="select * from treatment where tid = $fid ";
 $display2 ="select SUM(amount) as amt from treatment  where tid = $fid";
 $query   =  mysqli_query($conn, $display);
 $no   =  mysqli_num_rows($query);
 $query1   =  mysqli_query($conn, $display2);
 $fect0    = mysqli_fetch_assoc($query1);
 if($no>0)
 {
	 
echo"<h1>Treatment for ".$name."</h1>";
echo$no."</h1>";
echo"<center>
<table border='1' cellpadding='4px' style='text-align:center'>
   <tr>
   <th>Treatment</th>
   <th>Amount</th>
   <tr>";
while( $fect    = mysqli_fetch_assoc($query))
{
	echo"<tr>
   <td>$fect[treatment]</td>
   <td>$fect[amount]</td>
   <tr>";
}
echo"<th>Total</th>
   <th> $fect0[amt]</th>
      </table>
      </center>";
}
else{
	echo"<h1> No treatment for ".$name." recoded</h1>";
}
 ?>
 

</div>
<div id="Back"><button class="Col">Back</button></div>
<div id="Next"><button class="Col">Next</button></div>
</body>
