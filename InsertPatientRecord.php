<?php  // 👉 8/10 secure
include("Connection/Connect.php");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Invalid request");
}
if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
    exit("Invalid request");
}
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Page</title>
   <link rel="stylesheet" href="InsertPatient.css">
</head>
<body>
    <div id="output">
 <?php

 
 $date =date('Y-m-d');
$name = trim($_POST['name'] ?? '');
$age = trim($_POST['age'] ?? '');
$gender = trim($_POST['Gender'] ?? '');
$phone = trim($_POST['pho'] ?? '');

//echo"<h1 style='color:green'>date is: $date</h1>";
if (
    empty($date) ||
    empty($name) ||
    empty($age) ||
    empty($gender) ||
    empty($phone)
) {
    echo "<h1 style='color:red'>All fields are required</h1>";
    exit();
}
if (!in_array($gender, ['Male', 'Female', 'Other'], true)) {
    exit("Invalid gender");
}
if (!is_numeric($age) || $age <= 0 || $age > 120) {
    echo "Invalid age";
    exit();
}
if (!preg_match("/^[A-Za-z .'-]{1,100}$/", $name)) {
    exit("Invalid name");
}
 if (!preg_match('/^[0-9]{10}$/', $phone)) {
    echo "Invalid phone number";
    exit();
}
$fetch = "SELECT sno, name, phoNo 
FROM patient 
WHERE phoNo=? AND admin_id=?";
$prepared = mysqli_prepare($conn, $fetch);
if (!$prepared) {
    error_log(mysqli_error($conn));
    exit("Something went wrong");
}

    # code...
    mysqli_stmt_bind_param($prepared, "si",$phone, $admin_id);
    mysqli_stmt_execute($prepared);
   mysqli_stmt_store_result($prepared);
// echo"<h1>hello</h1>"
$num   = mysqli_stmt_num_rows($prepared);

    mysqli_stmt_bind_result($prepared, $sno, $patientName, $phoNo);
    mysqli_stmt_fetch($prepared);
mysqli_stmt_close($prepared);
    
if ($num>0)
 {
    $sno = urlencode($sno);
    echo"<h1 class='errMsg'>".htmlspecialchars($patientName, ENT_QUOTES, 'UTF-8')."'s record exists, to add treatment
    <a href='./InsertTreatment.php?id=$sno'>Click here </a> 
    </h1>";    // ✅ ADD THIS
    $_SESSION['token'] = bin2hex(random_bytes(32));
    echo"<h1>OR</h1>";
       echo"<h1  class='errMsg'>to view treatment details
    <a href='./TreatmentDetail.php?id=$sno&tp=True' >Click here  </a> 
    </h1>";  // ✅ regenerate token BEFORE exit




    exit();
}

 
$insert ="insert into patient(date, name, age, gen, phoNo, admin_id) values(?, ?, ?, ?, ?, ?)";
$insertPrepare =mysqli_prepare($conn, $insert);
if (!$insertPrepare) {
    error_log(mysqli_error($conn));
    exit("Something went wrong");
}
mysqli_stmt_bind_param($insertPrepare, "ssissi", $date,
$name, $age, $gender, $phone, $admin_id);
mysqli_stmt_execute($insertPrepare);
// mysqli_stmt_store_result($insertPrepare);
$rows  = mysqli_stmt_affected_rows($insertPrepare);
mysqli_stmt_close($insertPrepare);

// $insertQuery = mysqli_query($conn, $insert);

if ($rows>0) {
//     # code...
    echo"<h1 id='success'>Record inserted successfully </h1>";
     
    // ✅ ADD THIS (VERY IMPORTANT)
    $_SESSION['token'] = bin2hex(random_bytes(32));
}


   
?>

</div>
<div id="blank">
  </div>
  <form action="./PatientFom.php" id="back">
    <input type="submit" value="Back" class="btn">
</form>

  <form action="./PatientRecord.php" id="next">
    <input type="submit" value="Next" class="btn">
  </form>
</html>