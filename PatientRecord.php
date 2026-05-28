<?php
include("Connection/Connect.php");

// Error & session security secure 8.5/10
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('session.cookie_httponly', 1);
//ini_set('session.cookie_secure', 0); // only if HTTPS
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
// header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
// CSRF token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// Nonce for CSP
$nonce = bin2hex(random_bytes(16));

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; style-src 'self'; img-src 'self' data:; object-src 'none'; base-uri 'self';");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

// Session timeout (15 minutes)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    session_unset();
    session_destroy();
    header("Location: LogIn.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// User authentication check
if (!isset($_SESSION['user'])) {
    header("Location: LogIn.php");
    exit();
}

// CSRF check for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        die("CSRF validation failed");
    }
}

// Get today’s date
$todayDate = date("Y-m-d");

// Admin authentication
if (!isset($_SESSION['admin_id'])) {
    die("Unauthorized access");
}
$admin_id = $_SESSION['admin_id'];

// Fetch patients for today
$display = "SELECT * FROM patient WHERE date=? AND admin_id=?";
$query = mysqli_prepare($conn, $display);
if (!$query) die("Query prepare failed");

mysqli_stmt_bind_param($query, "si", $todayDate, $admin_id);
if (!mysqli_stmt_execute($query)) die("Query execution failed");

$result = mysqli_stmt_get_result($query);
$no = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Information Page</title>
<link rel="stylesheet" href="Header2.css?v=20">
    <style>  
     #body{
            background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQV5tegbIR32oDRVB_qdMazaa-KJwDX04xfiA&s");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
			
        }
    </style>
</head>
<body id="body">

<h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>
 <!-- <div id///="ul" style="background-color: white; height: 40px;"> -->
       <ul id="ul">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="./PatientFom.php">Add Patient </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        
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
<!-- 
<script>
  onload = () => { document.getElementById("trefo").style.transform = "translateY(50px)"; }
  setTimeout(() => { document.getElementById("trefo").style.transform = "translateY(-100px)"; }, 5000);
</script> -->

<?php
if($no > 0 && !isset($_GET['name'])) {
    echo "<table border='2'>
        <th>Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Phone Number</th>
        <th>No. of treatment</th>
        <th>Treatment details</th>
        <th>Edit</th>";

    while($show = mysqli_fetch_assoc($result)) {
        $id = (int)$show['sno'];

        $display3 = "SELECT COUNT(*) AS total FROM treatment WHERE sno=? AND admin_id=?";
        $query5 = mysqli_prepare($conn, $display3);
        if (!$query5) {
            die("Query failed");
        }
        mysqli_stmt_bind_param($query5, 'ii', $show['sno'], $admin_id);
        mysqli_stmt_execute($query5);
        mysqli_stmt_bind_result($query5, $Con);
        mysqli_stmt_fetch($query5);
        mysqli_stmt_close($query5);

        echo "<tr>
            <td>".htmlspecialchars($show['name'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($show['age'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($show['gen'], ENT_QUOTES, 'UTF-8')."</td>
            <td>".htmlspecialchars($show['phoNo'], ENT_QUOTES, 'UTF-8')."</td>
            <td align='center'>
                <a href='TreatmentDetail.php?id=".urlencode($id)."' class='ank' title='View treatment details'>$Con</a>
            </td>
            <td style='text-align:center;'>
                <a href='InsertTreatment.php?id=".urlencode($id)."&patientRecord=true' class='ank' title='Add treatment details'>Add treatment details</a>
            </td>
            <td style='text-align:center;'>
                <a href='Edit.php?id=".urlencode($id)."' class='ank'>Edit</a>
            </td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<h1 style='padding-left:100px;' id='del11'>No Patient record for today</h1>";
}
?>

<form action="./Export.php" name="export" method="POST" id="export">
  <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
  <input type="submit" name="export7" value="Export">
</form>

</div>
</body>
</html>