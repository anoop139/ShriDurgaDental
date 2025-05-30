<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Treatment record</title>
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

    #deleteInfo{
		position:absolute;
		top:10px;
		left: 500px;
	}
	#del{
		position: absolute;
		top:-50px;
		left: 700px;
		transition: transform 3s;
	}

	#del{
		background-color:white;
		font-size:2em;
		font-weight:bold
	}
	#deleteInfo{
		transition: transform 3s
	}
	/* #deleteInfo:hover {
    transform: translateY(-50px)
} */
	</style>
    <link rel="stylesheet" href="Header.css?v=6">
</head>
<body>
<div id="header0" style="background-color:lightblue">

<div id="header">

        <ul>
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="PatientFom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="SearchByName.php">Search by Name</a></li>
        </ul>
	
</ul><br><br><br><br><br>
</div>
</div>
<div id="res1" style="padding-top:0px;">
 <?php
 

 ?>
 
 <?php 
 $fid= $_GET['id'];
 $tid= $_GET['tid'];
 if (isset($_GET['Delete'])) {

	echo"<h1 id='del'>Deleted succesfully</h1>";

	}
	// else {
	
	// 	echo"<span id='del'>Deletion failed</span>";

	//  }
 
?>
<script>

</script>
<?php
if (isset($fid)) {
 $showName ="select *from patient where sno=$fid";
 $NameQuery   =  mysqli_query($conn, $showName);
 $PatienName  =  mysqli_fetch_assoc($NameQuery);
 $display ="select *from treatment where sno=$fid"; 
 $query   =  mysqli_query($conn, $display);
 $no   =  mysqli_num_rows($query);
 $display2 ="select SUM(amount) as amt from treatment  where sno=$fid";
 $query1   =  mysqli_query($conn, $display2);
  
 $fect0    = mysqli_fetch_assoc($query1);
 if($no>0) 
 {
echo"<h1>Treatment for "."$PatienName[name]"."</h1>";
 }
}
?>
 </script>
 <?php
if (isset($_GET['treatInserted'])) {
	// $deleted =$_GET['delete'];
	echo"<h1 id='del'> Treament  inserted successfully </h1>";///
}
if (isset($_GET['delete'])) {
	$deleted =$_GET['delete'];
	echo"<h1 id='del'> Treament  deleted successfully </h1>";///
}
?>
<?php
 if($no>0) 
 {
// echo"<h1>Treatment for ".$no."  </h1>";
// echo"<h1>You are here</h1>";
echo"<center>
<table border='1' id='myTable' cellpadding='4px' style='text-align:center'>
   <tr>
   <th>Treatment</th>
   <th>Amount</th>
   <th>Delete</th>
   </tr>";
while( $fect= mysqli_fetch_assoc($query))
{
	echo"<tr>
   <td>$fect[treatment]</td>
   <td>$fect[amount]</td>
  <td><a href='Edit\TreatmentDel.php?id=$PatienName[sno]&tid=$fect[tid]'>Delete</a></td>
    </tr>";

}
echo"<th>Total</th>
   <th> $fect0[amt]</th>
      </table>
      </center>";
}

else if($no==0){

	echo"<h1 id='no'> No treatment for "."$PatienName[name]"." recoded</h1>";
}
?>
<script>
		let x = document.getElementById("del")
	onload=()=>{
		x.style.transform="translateY(100px)"

	}
	setTimeout(() => {
		x.style.transform="translateY(-50px)"
	}, 5000);
</script>
 
 <form action="./InsertTreatment.php" id="addTreatment">
	<input type="hidden" name="id" value=<?php echo"$fid"?> />
	<input type="hidden" name="tp" value=<?php echo"True"?> />
	<input type="submit" value="Click here to add more treatment">
 </form>
</div>
<!-- <div id="Back"><button class="Col">Back</button></div>
 <form action="./InsertTreatment.php" id="addTreatment" method="GET">
	<input type="hidden" name="id" value=<?php echo"$fid"?> />
	<input type="hidden" name="n"  id="con" value=<?php echo$treatCon;?>>
	<input type="submit" value="Click here to add more treatment"> -->
 </form>
</div>
<script>

//	alert("row counts  "+con)
	let deleted =  document.getElementById("del")
	let deleted4 =  document.getElementById("tratmetInfo").value 
     setTimeout(() => {
		deleted.style.transform="translateY(-80px)";
	 }, 5000);

window.onload=pop;
 </script>

<a id="Back"><button class="Col">Back</button></a>
<div id="Next"><button class="Col">Next</button></div>
</body> 
