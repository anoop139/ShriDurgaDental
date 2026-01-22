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
	ul li ul li{
		background:lightblue;
	}
	#res1{
		background-color:white;
		padding: 40px;
	}
	#res1{
		border:2px solid black;
	    
	}
	#res1{
		height: auto;
	}
	#res1{
		
		margin-top:50px;
		text-align:center;
	}
	#res1{
		
		padding-top:0px;
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
/* 		
		padding-left:30px;
		padding-right:30px; */
		
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
		top:-150px;
		left: 700px;
		transition: transform 3s;
	}
	table th, td{
		padding: 5px;
	}

	#del{
		background-color:white;
		font-size:2em;
		font-weight:bold
	}
	#deleteInfo{
		transition: transform 3s
	}
	#delF {
      position: relative;
	  top: 40px;
	  left: 35px;
    }
	#delF input {
      padding: 20px;
	  /* text-align:right; */
    }

	</style>
    <!-- <link rel="stylesheet" href="Header.css">/ -->
	    <link rel="stylesheet" href="Header2.css">
</head>
<body>
        <ul style="background-color:lightblue; height: 40px; padding-left:1050px;">
        <li style="text-align:right"><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li style="text-align:right"><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="PatientFom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul style="">
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByDate.php">Date</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByNumber.php">Number</a></li><br>
        </ul>
        </li>
      </ul><br>
</div>
<div id="res1" style="padding-top:0px;">
 <?php
 

 ?>
 
 <?php 
 $fid= $_GET['id'];
 $tid= $_GET['tid'];
 if (isset($_GET['treatInserted'])) {
	// $deleted =$_GET['delete'];
	echo"<h1 id='del'> Treament  inserted successfully </h1>";///
}
if (isset($_GET['Delete'])) {
	// $deleted =$_GET['delete'];
	echo"<h1 id='del'> Treament  deleted successfully </h1>";///
}
if (isset($_GET['DeleteAll'])) {
	
	echo"<h1 id='del'> All treaments  deleted successfully </h1>";///
}
?>
<?php
if (isset($fid)) {
 $showName ="select *from patient where sno=$fid";
 $NameQuery   =  mysqli_query($conn, $showName);
 $PatienName  =  mysqli_fetch_assoc($NameQuery);
 $display ="select *from treatment where sno=$fid"; 
 $query   =  mysqli_query($conn, $display);
 $no   =  mysqli_num_rows($query);
 $display2 ="select SUM(amount) as amt from treatment where sno=$fid";
 $query1   =  mysqli_query($conn, $display2);
  
 $fect0    = mysqli_fetch_assoc($query1);
 if($no>0) 
 {
echo"<h1>Treatment for "."$PatienName[name]"."</h1>";
echo"<br>";
 }
}
?>
 </script>
 <?php
 $pending = 0;
 if($no>0) 
 {
// echo"<h1>Treatment for ".$no."  </h1>";
// echo"<h1>You are here</h1>";

echo"<center>
<table border='1' id='myTable' cellpadding='10px' style='text-align:center;'>
   <tr>
   <th>Date</th>
   <th>Due Date</th>
   <th>Treatment</th>
   <th>Advance Amount</th>
   <th>Online Amount</th>
   <th>Pending Amount</th>
   <th>Amount</th>
   <th>Edit</th>
   <th>Delete</th>
   </tr>";
while( $fect= mysqli_fetch_assoc($query))
{
	if ($fect['amount']>$fect['advance'] && $fect['advance']!=0) {
	  $pending = $fect['amount']-($fect['advance'] + $fect['online']);
	//   echo"<></>";pending = amount - (advance + online)

	}///
	else if ($fect['amount']==$fect['advance']) {
	  $pending = 0;//$fect['amount']-$fect['advance'];
	}///
	else if ($fect['advance']==0) {
	  $pending = 0;
	//   echo"<h1>yes bro</h1>";
	}///
	// $pending =$fect['amount']-$fect['advance'];
	if ($fect['online']!=0) {
	   $fect0['amt']+=$fect['online'];
	}
	echo"<tr>
   <td>$fect[date]</td>
   <td>$fect[dueDate]</td>
   <td style='padding-right: 50px;'>$fect[treatment]</td>
   <td style='padding: 10px;'>$fect[advance]</td>
   <td style='padding: 10px;'>$fect[online]</td>
   <td>$pending</td>  
    <td >$fect[amount]</td>

  <td><a href='EditTreatment\EditTreatment.php?tid=$fect[tid]'>Edit</a></td>
  <td><a href='Edit\TreatmentDelete.php?id=$PatienName[sno]&treatId=$fect[tid]'>Delete</a></td>
    </tr>";

}
echo"<th></th>
   <th></th>
   <th></th><br>
   <th></th>
   <th>Total</th>
   <th style='margin-left:450px'></th>
   <th style='margin-left:450px'> $fect0[amt]</th>
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
		x.style.transform="translateY(200px)"

	}
	setTimeout(() => {
		x.style.transform="translateY(-50px)"
	}, 5000);
</script>
 
 <form action="./InsertTreatment.php" id="addTreatment">
	<input type="hidden" name="id" value=<?php echo"$fid"?> />
	<input type="hidden" name="tp" value=<?php echo"True"?> />
	<input type="submit" value="Click here to add more treatment"><br>
 </form>
 <form action="Edit\TreatmentDelete.php?"  method="GET" id="delF">
	<input type="hidden" name="fid" value=<?php echo"$PatienName[sno]"?> />

<div style="text-align:right;"> <input type="Submit" name="DeleteAll" value="Delete All" id="deleteAll"> </div>
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

<!-- <a id="Back"><button class="Col">Back</button></a>/ -->
<!-- <div id="Next"><button class="Col">Next</button></div>h -->
</body> 
