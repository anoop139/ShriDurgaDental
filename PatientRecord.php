<?php
include("Connection/Connect.php");
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // only if using HTTPS
ini_set('session.use_strict_mode', 1);
$name = htmlspecialchars($_GET['n'] ?? '');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => true,      // only if HTTPS
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
$nonce = bin2hex(random_bytes(16));
// header("Content-Security-Policy: default-src 'self'; img-src 'self' https://encrypted-tbn0.gstatic.com data:; script-src 'self' 'nonce-$nonce'; style-src 'self';");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    session_unset();
    session_destroy();
    header("Location: LogIn.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();
if (empty($_SESSION['token'])) {

$_SESSION['token'] = bin2hex(random_bytes(32));
}
if(!isset($_SESSION['user'])){
    header("Location: LogIn.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die("CSRF validation failed");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information page</title>
    <link rel="stylesheet" href="Header2.css?v=1">
    <style>
      ul ul li{
        background:lightblue;
      }
      table tr th, td{
        padding: 5px;
      }
      #trefo{
        position: absolute;
        top: -28px;
      }
       #trefo{
        background-color:white;
      } 
      #trefo{
        transition: transform, 3s
      }
       #export{
        position: absolute;
        top: 150px;
        left: 1200px;
      
      }
      #export input{
        border: 2px solid black;
      }
      #export input{
       padding: 10px;
       background:blue;
       color:white;
       font-size:20px;
      }
    </style>
</head>
<body id="body">
<?php


?>
       <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>

    <!-- <div id///="ul" style="background-color: white; height: 40px;"> -->
       <ul id="ul" style="padding-left:1000px; background-color:lightblue; height: 40px; width: 255px; ">
        <li><a href="./DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientFom.php">Add Patient</a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">number</a></li>
        </ul>
        </li>
      </ul>
<div id="dis">     
<form action="" id="dateForm" method="POST">
  
<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
<input type="hidden" name="fid1" id="fid1" value="<?php echo htmlspecialchars($_GET['fid'] ?? ''); ?>"/>
</form>
  
<script>
  let date = new Date()
  let month =date.getMonth()+1
     let today = date.getDate()+" - "+month+" - "+date.getFullYear()
  // if (!window.localStorage.getItem("fomSubmited")) {
  //   window.localStorage.setItem("fomSubmited", "true");
  //   // document.getElementById("date").value=toda/y
  
  onload = ()=>{
      document.getElementById("trefo").style.transform="translateY(50px)"
  }
    setTimeout(() => {
      document.getElementById("trefo").style.transform="translateY(-100px)"
    }, 5000);


</script>

 <?php

  $todayDate = date("d - m - Y");
  
  if (!isset($_SESSION['admin_id'])) {
    die("Unauthorized access");
}
$admin_id = $_SESSION['admin_id'];
$display ="Select * from patient where date=? and admin_id=?";
$query   = mysqli_prepare($conn, $display);
if (!$query) {
    die("Query prepare failed");
}
mysqli_stmt_bind_param($query, "si", $todayDate, $admin_id);
if (!mysqli_stmt_execute($query)) {
    die("Query execution failed");
}
$result = mysqli_stmt_get_result($query);
$no = mysqli_num_rows($result);
 if($no>0 && !isset($_GET['name']))
{
	echo"<table border='2'>
  <th>Name</th>
  <th>Age</th>
  <th>Gender</th>
  <th>Phone Number</th>
  <th>No. of treatment</th>
  <th>Treatment details</th>
  <th>Edit</th>";
   while( $show    = mysqli_fetch_assoc($result))
   {
    $storeDate = $show['date'];

    // if ($todayDate>$storeDate)
     { 
$id = (int)$show['sno'];
 $display3 ="select * from treatment where sno =?";
  $query5 = mysqli_prepare($conn,$display3);
  if (!$query5) {
    die("Query5 prepare failed");
}
  mysqli_stmt_bind_param($query5, 'i', $show['sno']);
  
  if (!mysqli_stmt_execute($query5)) {
    die("Query5 execution failed");
}
 $result5 = mysqli_stmt_get_result($query5);
  $Con  = mysqli_num_rows($result5);
    echo"<tr>
	<td>".htmlspecialchars($show['name'])."</td>
<td>".htmlspecialchars($show['age'])."</td>
<td>".htmlspecialchars($show['gen'])."</td>
<td>".htmlspecialchars($show['phoNo'])."</td>
	<td style='text-align:center;'><a href='TreatmentDetail.php?id=".htmlspecialchars($id)."'"." class='ank' title='Click here to view treatment details'>$Con</a></td>
	<td style='text-align:center;'><a href='InsertTreatment.php?id=".htmlspecialchars($id)."&patientRecord=true' class='ank' title='Click here to add treatment details'>Add treatment details</a></td>
	<td style='text-align:center;'><a href='Edit.php?id=".htmlspecialchars($id)."'"."class='ank'>Edit</a></td>
	</tr>"; 	
   }
   }
  }
 else if ($no==0) {
  //  echo"<h1>Today //is ".$toDate."</h1>";

 echo"<h1 style='padding-left:100px;' id='del11'>No Patient record for today</h1>";
 }

 ?> </table>
<form action="./Export.php"  name="export" method="POST" id="export">
  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
<input type="submit" name="export7" value="Export">
</form>

  <script>
  </script> 
</div>
<div>
<div id="button">
 <!-- <button class="btn">Back</button>
 <button id="next" class="btn">Next</button>
  -->
</div>
</div>
</body>
</html>