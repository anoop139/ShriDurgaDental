<?php
include("Connection/Connect.php");

// Error & session security
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // only if HTTPS
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
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; style-src 'self'; img-src 'self' data: https://encrypted-tbn0.gstatic.com;");
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
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        die("CSRF validation failed");
    }
}
// if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
//     $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//     header("Location: $redirect");
//     exit();
// }
// Get today’s date
$todayDate = date("d - m - Y");

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
<link rel="stylesheet" href="Header2.css?v=17">
    
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

        $display3 = "SELECT * FROM treatment WHERE sno=?";
        $query5 = mysqli_prepare($conn, $display3);
        mysqli_stmt_bind_param($query5, 'i', $show['sno']);
        mysqli_stmt_execute($query5);
        $result5 = mysqli_stmt_get_result($query5);
        $Con = mysqli_num_rows($result5);

        echo "<tr>
            <td>".htmlspecialchars($show['name'])."</td>
            <td>".htmlspecialchars($show['age'])."</td>
            <td>".htmlspecialchars($show['gen'])."</td>
            <td>".htmlspecialchars($show['phoNo'])."</td>
            <td style='text-align:center;'>
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