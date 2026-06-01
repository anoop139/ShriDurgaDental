<?php
//92
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'));
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();
if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_time'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_time'] = time();
}
$max_time = 600; // 10 minutes

if (
    !isset($_SESSION['csrf_time']) ||
    time() - $_SESSION['csrf_time'] > $max_time
) {
    unset($_SESSION['csrf_token'], $_SESSION['csrf_time']);
    die("Session expired. Refresh page.");
}
include("Connection/Connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
if (!isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];
if (!isset($_GET['id'])) {
    die("Invalid request");
}

$fid = (int) $_GET['id'];
if ($fid <= 0) {
    die("Invalid patient ID");
}
header("Content-Security-Policy:
default-src 'self';
script-src 'self';
style-src 'self';
base-uri 'self';
img-src 'self' data: https://encrypted-tbn0.gstatic.com;
object-src 'none';
frame-ancestors 'none';
form-action 'self';
");

header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: strict-origin-when-cross-origin");
$pr = '';
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Treatment Details</title>
    <style>
	 #ul{ 
      background-color:lightblue; 
     }
	 	ul li ul li{
		background:lightblue;
	}

   	
     body{
        background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBztpBXjR7M2C_AkcfV_0IWiQ48qGrmTgPLw&s");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
     }
     form{
         position: absolute;
         top:93px;
         left:800px;
     }
     .treat{
      border:2px solid black;
     }
     .errorMessage{
      background-color:white;
     }
      #errorMessage1{
      color:red
     }
     .errorMessage{
      height: auto;
      font-weight:bold;
      font-size:20px;
     }
     #div1{
      position: absolute;
      top:70px;
     }
     #errorMessage{
      position: relative;
      top:0px;
     }
     #del{
		position: absolute;
		top:-10px;
		left: 550px;
	}
  #navFom{
    position: absolute;
    top: 450px;
   left: 1210px;
   
  }
  #navFom input{
    padding: 20px;
    background:lightblue;
    
  }
    </style>
	<link rel="stylesheet" href="Header.css?v=8">
</head>
<body>
<div id="header0" >
<?php


  // echo"<h1>Testing with new code</h1>";
$patientName0 ="select name from patient where sno =? and admin_id=?";
$smb         = mysqli_prepare($conn,$patientName0);
if ($smb) {

  mysqli_stmt_bind_param($smb, "ii", $fid, $admin_id);
      mysqli_stmt_execute($smb);
   mysqli_stmt_bind_result($smb, $patientName);

  
if (mysqli_stmt_fetch($smb)) {
    // value exists
} else {
    $patientName = '';
}
$n = $patientName;


if (!$patientName) {
    die("Invalid patient");
    exit;
}
 mysqli_stmt_close($smb);   // 🔥 CLOSE IT

     if (!empty($patientName)) {
echo "<h1 id='del'>Treatment for ".htmlspecialchars($patientName)."</h1>";
     }     
}	


?> 
   <ul style="padding-left:955px; height: 40px;" id="ul">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List</a></li>&nbsp;
        <li><a href="Shri/PatientFom.php">Add Patient</a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">Number</a></li><br>
        </ul>
        </li>
</ul>
  <div id="div1">
    <h1>Enter Treatmemt </h1>
    <h1> Enter due date </h1>
    <h1>Enter Advance Amount if any </h1>
    <h1>Enter online Amount </h1>
    <h1>Enter cash Amount </h1>
  </div>
  <form action="" onsubmit="return Submit()" method="POST">
    <textarea name="treat" id="treat1" class="treat"></textarea><br>
    <div class="errorMessage" id="errorMessage1"></div> <br>
   &nbsp; <input type="date" name="dueDate1" id="dueDate">
   &nbsp; <input type="text" name="dueDate" id="dueDateInput" hidden>
    
    <br><br>
    <input type="text" name="advanceAmount" id="Advance" class="treat" required ><br><br><br>
    <input type="number" name="onlineAmount" id="onlinePayment" class="treat" ><br><br><br>
    <input type="number" name="amt" id="receivedAmount" class="treat" ><br><br>
  
 
    <input type="hidden" name="pname" value="<?php echo htmlspecialchars($n);?>"/>
    <input type="hidden" name="pr" value="<?php echo htmlspecialchars($pr);?>">
    <input type="hidden" name="tp" value="<?php echo htmlspecialchars($_GET['tp']?? '');?>"/>
     <input type="hidden" name="sbm" value="<?php echo htmlspecialchars($_GET['sbm']?? '');?>"/>
     <input type="text" name="date" id="date2"  hidden>
  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <input type="submit" name="sub" id="sub" class="treat" ><br>
	<?php


 
if(isset($_POST['sub']))
{  
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    die("CSRF attack detected");
}
$dueDate = $_POST['dueDate1'] ?? '';
// echo"<h1>date $dueDate</h1>";//
if (!empty($dueDate) && $dueDate !== "None") {

    $due = DateTime::createFromFormat('Y-m-d', $dueDate);
if (!$due || $due->format('Y-m-d') !== $dueDate) {
    die("Invalid date");
}


     $today = new DateTime('today');
    if (!$due) {
        die("Invalid date");
    }

    if ($due < $today) {
        die("Invalid date");
    }
}

$date = date('Y-m-d');

$treat = strtolower(trim($_POST['treat']));
if (!preg_match('/^[a-zA-Z0-9\s.,\-()\/#&]+$/', $treat)) {
    die("Invalid treatment");
}
if (strlen($treat) > 255) {
    die("Input too long");
}
$fid1 = $fid;
$adv_raw =trim($_POST['advanceAmount'] ?? '');
$advance = ($adv_raw === '') ? 0 : (
    ctype_digit($adv_raw) ? intval($adv_raw) : die("Invalid")
);
$online_raw =trim($_POST['onlineAmount'] ?? '');
$online = ($online_raw === '') ? 0 : (
    ctype_digit($online_raw) ? intval($online_raw) : die("Invalid")
);
$amt_raw = trim($_POST['amt'] ?? '');
$amt =  ($amt_raw === '') ? 0 : (
    ctype_digit($amt_raw ) ? intval($amt_raw) : die("Invalid")
);
if ($advance > 1000000 || $online > 1000000 || $amt > 1000000) {
    die("Amount too large");
}
if ($advance > 0 && $amt == 0) {
    $amt = $advance;
}
$pr =  $_POST['pr'] ?? '';
$tp = $_POST['tp'] ?? '';
$sbm = $_POST['sbm'] ?? '';

if (strlen($pr) > 50) {
    die("Invalid input");
}

if (strlen($tp) > 50 || strlen($sbm) > 50) {
    die("Invalid input");
}
if (!preg_match('/^[a-zA-Z0-9_\-]*$/', $tp) || !preg_match('/^[a-zA-Z0-9_\-]*$/', $sbm)) {
    die("Invalid input");
}
if (empty($treat)) {
    die("Invalid treatment");
}
if ($fid1 <= 0) {
    die("Invalid patient");
}$check = "SELECT sno FROM patient WHERE sno = ? AND admin_id = ?";
$stmt = mysqli_prepare($conn, $check);

mysqli_stmt_bind_param($stmt, "ii", $fid, $admin_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 0) {
    die("Unauthorized access");
}

mysqli_stmt_close($stmt);
  	$treatmentName = "Select treatment from treatment where treatment = ? and admin_id= ? and sno= ? and date =?";
  $query1        = mysqli_prepare($conn, $treatmentName);
mysqli_stmt_bind_param($query1, 'siis', $treat, $admin_id, $fid1,$date);
   mysqli_stmt_execute($query1);
 mysqli_stmt_store_result($query1);   // important

$treatCont41 = mysqli_stmt_num_rows($query1);
   mysqli_stmt_close($query1);
$treatQuery=0;
// $rowCount = 0;
	
//  echo"<h1 style='background:white;'>test $treatCont41 </h1>";////
if (!empty($dueDate) && $dueDate !== "None"){
 ///echo"<h1 style='background:white;'> and  $fid1 </h1>";////
  if ($dueDate!=$date && $treatCont41===0) {

    $insert = "INSERT INTO treatment 
(dueDate, date, treatment, advance, online, amount, sno, admin_id) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $smt= mysqli_prepare($conn, $insert);
 if ($smt) {
  # code...
  mysqli_stmt_bind_param($smt, "sssiiiii",
    $dueDate,
    $date,
    $treat,
    $advance,
    $online,
    $amt,
    $fid1,
    $admin_id
);
      mysqli_stmt_execute($smt);
    $treatQuery = mysqli_stmt_affected_rows($smt);
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$_SESSION['csrf_time'] = time();
 }
if ($smt) {
    mysqli_stmt_close($smt);
}
   if($treatQuery>0)
    {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_time'] = time();
       $id_safe = urlencode($fid1);
$count_safe = urlencode($treatQuery);
   echo "<h3 style='position:absolute; top:0px; background:white; color:green;' id='treatExisted'>
Treatment inserted successfully<br>
<a href='TreatmentDetail.php?id=" . htmlspecialchars($id_safe, ENT_QUOTES, 'UTF-8') . "&treatInserted=" . htmlspecialchars($count_safe, ENT_QUOTES, 'UTF-8') . "'>
Click here to view</a> treatment
</h3>";
 }
    // ✅ Correct place to refresh token



  }
      else if($treatCont41>0){
 
      $id_safe = urlencode($fid1);
$count_safe = urlencode($treatQuery);
        echo"<h3 style='position:absolute; top:0px; background:white; color:red;' id='treatExisted'>Treatment existed<br>
 <a href='TreatmentDetail.php?id=".htmlspecialchars($id_safe, ENT_QUOTES, 'UTF-8')."&treatInserted=".htmlspecialchars($count_safe,  ENT_QUOTES, 'UTF-8')."'>Click here to view  </a>treatment 
        </h3>";
 }
      } 
    
   else{
 if ($treatCont41==0) {
  # code...
  //  echo"<h1/ style='background:white;'>else part new $date</h1>";/////

  	$insert ="insert into treatment(date, treatment, advance, online, amount, sno, admin_id) values(?, ?, ?, ?, ?, ?, ?)";
	$smt1 =  mysqli_prepare($conn, $insert);
   if ($smt1) {
    # code...
      mysqli_stmt_bind_param($smt1, "ssiiiii",
    $date,
    $treat,
    $advance,
    $online,
    $amt,
    $fid1,
    $admin_id
    
);

  mysqli_stmt_execute($smt1);
  $rowCount = mysqli_stmt_affected_rows($smt1);
$id_safe = htmlspecialchars($fid1);
   $row_safe = htmlspecialchars($rowCount);
        mysqli_stmt_close($smt1);
        echo"<h3 style='position:absolute; top:0px; background:white; color:green;' id='treatExisted'>Treatment inserted successfully<br> <a href='TreatmentDetail.php?id=$id_safe&treatInserted=$row_safe'>Click here to view </a>treatment  </h3>";

   }
 
if (!$smt1) {
    echo "Prepare failed: ".mysqli_error($conn);
}
          // echo"<span class='errorMessage'/>Treatment /nserted".$rowCount."</span><br>";

}
else {
    $id_safe = htmlspecialchars($fid1, ENT_QUOTES, 'UTF-8');
    $row_safe = 0;
        echo"<h3 style='position:absolute; top:0px; background:white; color:red;' id='treatExisted'>Treatment existed<br>
 <a href='TreatmentDetail.php?id=$id_safe&treatInserted=$row_safe'>Click here to view  </a>treatment 
        </h3>";

 }
//    

}


}

    

?>
<script src="./Treatment.js?v=2"></script>  
  </form>

</body>
</html>