<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search By Name</title>
	<style>
	body{
		/* background-image:url("Images/SearchbyNames.jpeg");
		background-repeat:no-repeat;
		background-size:cover; */
	}
	#res1{
		background-color:white;
	}
	ul li a{
		color:white;
	}
	#res1{
		border:2px solid black;
		height:400px;
	}
	
	#res1{
		
		margin-top:50px;
		padding-left:50px;
	}
	#res1{
		
		padding-top:0px;
		//text-align:center;
	}
		
	#input{
	    position:absolute;
		left:800px;
		top:140px
	}
	.Col{
		border:2px solid black;
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
	#pateintInfo{
		padding-left:500px;
	}
	#res1
	{
//		background-color:lightblue
	}
	#Number
	{
		text-docoration:none;
	}
	 

	</style>
    <link rel="stylesheet" href="Header.css?v=9">
</head>
<body>
<div id="header0" style="background-color:black">

<div id="header">

        <ul>
        <li><a href="HomePage.html">Home </a></li>&nbsp;
        <li><a href="Fom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="http://localhost:8081/Shri/display.php">Patient List</a></li>
        </ul>
	
</ul><br><br><br><br><br>
</div>
</div>
<div id="res1">
<h1>Search by Name :</h1>
<form id="input">
<input type="text" id="input1" name="name" class="Col">&nbsp;

<div id="pateintInfo">
<?php
$name = $_GET['name'];
if(isset($_GET['Sub']))
{
    $patientInfo ="select *from patient where name like'$name%'";
	$query       = mysqli_query($conn, $patientInfo);
	$no           = mysqli_num_rows($query);
	 
	
	
	if($no>0)
	{
		echo" <table border='2'>
	 <tr>
	 <th style='padding:3px;'>Name</th>
	 <th style='padding:5px;'>Age</th>
	 <th style='padding:5px;'>Gender</th>
	 <th style='padding:5px;'>No. of treatment</th>
	 <th style='padding:5px;'>Phone Number</th>
	 <th style='padding:5px;'>Edit</th>
	 </tr>";
      while($fetch =mysqli_fetch_assoc($query))
	  { 
        $id = "select tid from treatment where tid=$fetch[sno]";
		$query2       = mysqli_query($conn, $id);
	    $no2           = mysqli_num_rows($query2);   
		 ///  echo"hi $fetch[sno]";
           		echo"<tr>
	 <td>$fetch[name]</td>
	 <td style='text-align:center'>$fetch[age]</td>
	 <td style='text-align:center'>$fetch[gen]</td>
	 <td style='text-align:center'><a id='Number' href='Info.php?v=$fetch[sno]&n=$fetch[name]'>$no2</a></td>
	 <td>$fetch[phoNo]</td>
	 <td><a href='Edit.php?id=$fetch[sno]&name=$fetch[name];'>Edit</a></td>
	 </tr>";		  
	  }
       echo"</table>";
	}
	else
	{
		echo"<h1 style='padding-left:200px;'>No recod found</h1>";
	}
}
?>
<input type="submit" name="Sub" class="Col" value="Click here" onsubmit="return checkInput()"><br><br><br>
</form>

</div>
</div>
</div>
</div>
<script src="./Script.js?v=4"></script>
<div id="Back"><button class="Col">Back</button></div>
<div id="Next"><button class="Col">Next</button></div>
</body>
