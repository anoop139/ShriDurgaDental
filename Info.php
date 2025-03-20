<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Treatment record</title>
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
	#del{
		position: absolute;
		top:0px;
		left: 500px;
		transition: transform 3s;
	}
	#del:hover{
	   transform:translateY(-50px);
	}
	#del{
		background-color:white;
		font-weight:bold;
		font-size:32px;
	}
  #addTreatment{
	margin-top:10px
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
 

 ?>
 
 <?php
 $name= $_GET['n'];
 $fid= $_GET['v'];
 $sno= $_GET['t'];

//  echo"<h1>hi ".$name3."</h1>";
if (!isset($_GET['name3'])) {
	 $name3 = $_GET['name3'];
	
//    echo"<h2>Wel</h2>";
 $display ="select * from treatment where tid =$fid "; 
 $query   =  mysqli_query($conn, $display);
 $no   =  mysqli_num_rows($query);
//  $pid  =  mysqli_fetch_assoc($query);
 $display2 ="select SUM(amount) as amt from treatment  where tid = $fid";
 $query1   =  mysqli_query($conn, $display2);
 $fect0    = mysqli_fetch_assoc($query1);
 if($no>0) 
 {
	 
echo"<h1>Treatment for ".$name."</h1>";
// echo"<h1>the ".$fect0['tid']."</h1>";
echo"<center>
<table border='1' cellpadding='4px' style='text-align:center'>
   <tr>
   <th>Treatment</th>
   <th>Amount</th>
   <th>Delete</th>
   </tr>";
while( $fect    = mysqli_fetch_assoc($query))
{
	echo"<tr>
   <td>$fect[treatment]</td>
   <td>$fect[amount]</td>
      <th><a href='Edit/TreatmentDel.php?t=$fect[sno]&name3=$name&fid2=$fect[tid]'>Delete</a></th>
   <tr>";
}
echo"<th>Total</th>
   <th> $fect0[amt]</th>
   
      </table>
      </center>";
}

else if($no==0){
	echo"<h1 id='no'> No treatment for ".$name." recoded</h1>";
}
}
else if (isset($_GET['name3'])) {
	# code...
    	$primary =$_GET['primary'];
    	$pm = $_GET['name4'];
    //    echo"<h1>treatment of  ".$_GET['name4']."</h1>";//
        $deletedTreatment ="delete from treatment where sno=$primary";
		$deletedQuery     = mysqli_query($conn, $deletedTreatment);
		if ($deletedQuery) {
			# code...
			echo"<h1 id='del'>Treatment for ".$pm." deleted successfully</h1>";
		}
        else{
			echo"<h1 id='del'>Deletion failed</h1>";
		}
    	$name3 = $_GET['name3'];
		$fid2 = $_GET['fid2'];
		$name4 = $_GET['name4'];
		// echo"<h1>".$name3."</h1>";
		// echo"<h1>the ".$fid2."</h1>";
		$display ="select * from treatment where tid =$name3";
		 $display2 ="select SUM(amount) as amt from treatment  where tid =$name3";
		$query   =  mysqli_query($conn, $display);
		$no   =  mysqli_num_rows($query);
		$query1   =  mysqli_query($conn, $display2);
		$fect0    = mysqli_fetch_assoc($query1);
	   
		if($no>0) 
		{
			
	   echo"<h1>Treatment for ".$name4."</h1>";
	   // echo"<h1>the ".$fect0['tid']."</h1>";
	   echo"<center>
	   <table border='1' cellpadding='4px' style='text-align:center'>
		  <tr>
		  <th>Treatment</th>
		  <th>Amount</th>
		  <th>Delete</th>
		  </tr>";
	   while( $fect    = mysqli_fetch_assoc($query))
	   {
		   echo"<tr>
		  <td>$fect[treatment]</td>
		  <td>$fect[amount]</td>
			 <th><a href='Edit/TreatmentDel.php?t=$fect[sno]&name3=$name;'>Delete</a></th>
		  <tr>";
	   }
	   echo"<th>Total</th>
		  <th> $fect0[amt]</th>
		  
			 </table>
			 </center>";
	   }
	   
	   else if($no==0){
		   echo"<h1 id='no'> No treatment for ".$name." recoded</h1>";
	   }
}

 ?>
 <form action="./T1.php" id="addTreatment">
	<input type="hidden" name="v" value=<?php echo"$fid"?> />
	<input type="submit" value="Click here to add more treatment">
 </form>
</div>
<script>
	// alert("Testing")
	let deleted =  document.getElementById("del")
     setTimeout(() => {
		deleted.style.transform="translateY(-80px)";
	 }, 5000);
 </script>

<a id="Back"><button class="Col">Back</button></a>
<div id="Next"><button class="Col">Next</button></div>
</body>
