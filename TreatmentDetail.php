<?php  //88–92% secure
include("Connection/Connect.php");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_set_cookie_params([
    'httponly' => true,
    'secure' => true,
    'samesite' => 'Strict'
]);
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])){
    header("Location: LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];

if (isset($_POST['p'])) {

    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        die("CSRF attack detected");
    }
// /if (empty($_SESSION['token'])) {
    // $_SESSION['token'] = bin2hex(random_bytes(32));
// }
    // your main logic here
}
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; object-src 'none';");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Treatment record</title>
	<style>
   
	</style>
    <!-- <link rel="stylesheet" href="Header.css">/ -->
	    <link rel="stylesheet" href="Header2.css">
		<link rel="stylesheet" href="TreatmenDetail.css?v=1">
		<link rel="stylesheet" href="Export.css?v=1">
</head>
<body>
         <ul  id="ul">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List</a></li>&nbsp;
        <li><a href="PatientFom.php">Add Patient</a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">Number</a></li><br>
        </ul>
        </li>
</ul><br>
</div>
<div id="res1" style="padding-top:0px;">
 <?php
 

 ?>
 
 <?php 
$fid = (int)$_GET['id'];
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
 $showName ="select *from patient where sno=? and admin_id=?";
 $NameQuery   =  mysqli_prepare($conn, $showName);
  if (!$NameQuery) {
    
        die("Query failed");
     
    }
mysqli_stmt_bind_param($NameQuery, 'ii',$fid, $admin_id);

if (!mysqli_stmt_execute($NameQuery)) {
         die("Execution failed");
         }
  $result = mysqli_stmt_get_result($NameQuery);
 $PatienName  =  mysqli_fetch_assoc($result);
 $treatment ="select *from treatment where sno=?";
   $treatQuery   =  mysqli_prepare($conn, $treatment);
  if (!$treatQuery) {
    
        die("Query failed");
     
    }
mysqli_stmt_bind_param($treatQuery, 'i',$fid);
if (!mysqli_stmt_execute($treatQuery)) {
         die("Execution failed");
         }
  $treatmentRes = mysqli_stmt_get_result($treatQuery);
//  $PatienName  =  mysqli_fetch_assoc($result);
//  $query   =  mysqli_query($conn, $display);
 $noOfTreat   =  mysqli_num_rows($treatmentRes);
//  $display2 ="select SUM(amount) as amt from treatment where sno=$fid";
//  $query1   =  mysqli_query($conn, $display2);
  
//  $fect0    = mysqli_fetch_assoc($query1);
 if($noOfTreat>0) 
 {
echo"<h1>Treatment for "."$PatienName[name] </h1>";
echo"<br>";
 }
}
?>
 </script>
 <?php
 $pending = 0;
 if($noOfTreat>0) 
 {
// echo"<h1>Treatment for ".$no."  </h1>";
// echo"<h1>You are here</h1>";

echo"<center>
<table border='2' id='myTable' cellpadding='10px' class='treatTable'>
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
while( $fect= mysqli_fetch_assoc($treatmentRes))
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
   <td >$fect[treatment]</td>
   <td align='center'>$fect[advance]</td>
   <td align='center'>$fect[online]</td>
   <td align='center'>$pending</td>  
    <td align='center' >$fect[amount]</td>

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

<div id="submitBtn"> <input type="Submit" name="DeleteAll" value="Delete All" id="deleteAll"> </div>
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
