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
<div id="res1">
 <?php 
 $fid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
 $tid = isset($_GET['tid']) ? (int)$_GET['tid'] : 0;

?>
<?php
if ($fid > 0){
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
 $treatment ="select *from treatment where sno=? and admin_id=?";
   $treatQuery   =  mysqli_prepare($conn, $treatment);
  if (!$treatQuery) {
    
        die("Query failed");
     
    }
mysqli_stmt_bind_param($treatQuery, 'ii',$fid, $admin_id);
if (!mysqli_stmt_execute($treatQuery)) {
         die("Execution failed");
         }
  $treatmentRes = mysqli_stmt_get_result($treatQuery);
//  $PatienName  =  mysqli_fetch_assoc($result);
//  $query   =  mysqli_query($conn, $display);
 $noOfTreat   =  mysqli_num_rows($treatmentRes);
if (!$PatienName) {
    die("Patient not found");
}
 if($noOfTreat>0) 
 {
echo"<h1>Treatment for ". htmlspecialchars($PatienName['name'], ENT_QUOTES, 'UTF-8')."</h1>";
echo"<br>";
 }
}
?>
 <?php
 $pending = 0;


 if($noOfTreat>0) 
 {
// echo"<h1>Treatment for ".$no."  </h1>";
// echo"<h1>You are here</h1>";
   $fect0['amt'] = 0;
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
{ $tid = (int)$fect['tid'];
$sno = (int)$PatienName['sno'];

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
   <td>".htmlspecialchars($fect['date'])."</td>
   <td>".htmlspecialchars($fect['dueDate'])."</td>
   <td >".htmlspecialchars($fect['treatment'])."</td>
   <td align='center'>".htmlspecialchars($fect['advance'])."</td>
   <td align='center'>".htmlspecialchars($fect['online'])."</td>
   <td align='center'>".htmlspecialchars($pending)."</td>
   <td align='center'>".htmlspecialchars($fect['amount'])."</td>
  <td><a href='EditTreatment\EditTreatment.php?tid=$tid'>Edit</a></td>
  <td><a href='EditTreatment\TreatmentDelete.php?id=$sno&treatId=$tid'>Delete</a></td>
    </tr>";

}
echo"<th></th>
   <th></th>
   <th></th><br>
   <th></th>
   <th>Total</th>
   <th></th>
   <th> $fect0[amt]</th>
         </table>
      </center>";
}

else if($noOfTreat==0){

	echo"<h1 id='no'> No treatment for ".htmlspecialchars($PatienName['name'], ENT_QUOTES, 'UTF-8')." recoded</h1>";
}  

?>
 <form action="./InsertTreatment.php" id="addTreatment">
	<input type="hidden" name="id" value=<?php echo"$fid"?> /> 
    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
	<input type="hidden" name="tp" value=<?php echo"True"?> />
	<input type="submit" value="Click here to add more treatment"><br>
 </form>
 <form action="EditTreatment\TreatmentDelete.php?"  method="POST" id="delF">
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
</body>
</html> 
