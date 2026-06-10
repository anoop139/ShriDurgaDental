<?php
include("Connection/Connect.php");

$isLocalhost = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1', '::1'], true);

if (!$isLocalhost && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect);
    exit();
}

if (!$isLocalhost) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
}

ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => !$isLocalhost,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])){
    header("Location: LogIn.php");
    exit();
}

if (!isset($_SESSION['token_time'])) {
    session_regenerate_id(true);
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token_time'] = time();
} elseif (time() - $_SESSION['token_time'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token_time'] = time();
}
$admin_id = $_SESSION['admin_id'];

$nonce = bin2hex(random_bytes(16));
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; style-src 'self'; img-src 'self' data:; object-src 'none'; base-uri 'self';");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seach By Date</title>
<link rel="stylesheet" href="./Header2.css">
<link rel="stylesheet" href="./SearchByDate.css?v=2">
<link rel="stylesheet" href="./Export.css?v=2">
</head>
<body>
     <h1  id="deleted"></h1>
   <ul id="ul">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="PatientFom.php">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByNumber.php">Number</a></li><br>
    
        </ul>
        </li>
        </li>
</ul>
      <br><br>
<h1 id="inputAra">Seach by Date</h1>
<form id="dateInput" method="POST">
    <input type="date" name="date" id="date0" required>   
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']?>">
    <input type="submit" value="Click here"><br><br><br><br>
    <h1 id="err"></h1>
</form>
<div id="seeMsg" class="disp">
    <!-- <h1>hello</h1> -->
   		<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $date = trim($_POST['date'] ?? '');

        if (empty($date)) {
            echo "<h3>Please choose a date</h3>";
            exit();
        }
        if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
            echo "<h3>Invalid request</h3>";
            exit();
        }

        $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
            echo "<h3>Invalid date</h3>";
            exit();
        }

        $formattedDate = $dateObj->format('d - m - Y');
        echo "<h1>Patient record on " . htmlspecialchars($formattedDate, ENT_QUOTES, 'UTF-8') . "</h1><br>";
           
        $patientInfo = "SELECT patient.sno, patient.name, patient.age, patient.gen, patient.phoNo,
COUNT(treatment.tid) AS total_treatment
FROM patient
LEFT JOIN treatment
ON patient.sno = treatment.sno
AND patient.admin_id = treatment.admin_id
WHERE DATE(patient.date) = ?
AND patient.admin_id = ?
GROUP BY patient.sno, patient.name, patient.age, patient.gen, patient.phoNo";

        $query = mysqli_prepare($conn, $patientInfo);
        if (!$query) {
            error_log(mysqli_error($conn));
            exit("Something went wrong");
        }

        mysqli_stmt_bind_param($query, 'si', $date, $admin_id);

        if (!mysqli_stmt_execute($query)) {
            error_log(mysqli_stmt_error($query));
            exit("Something went wrong");
        }

        $result = mysqli_stmt_get_result($query);
        $no = mysqli_num_rows($result);
	//    echo"<h1>Affected ".$total."</h1><br>";
	
	
	if($no>0)
	{
		echo"<center>";
	   echo "<table border='2' class='contain1'>
	 <tr cellpadding;4px>
	 <th style='padding:3px;'>Name</th>
	 <th style='padding:5px;'>Age</th>
	 <th style='padding:5px;'>Gender</th>
	 <th style='padding:5px;'>No. of treatment</th>
	 <th style='padding:5px;'>Treatment details</th>
	 <th style='padding:5px;'>Phone Number</th>
	 <th style='padding:5px;'>Edit</th>
	 </tr>";
      while($fetch =mysqli_fetch_assoc($result))
	  { 

           		echo "<tr>
<td class='td' >".htmlspecialchars($fetch['name'], ENT_QUOTES, 'UTF-8')."</td>
<td class='td'>".htmlspecialchars($fetch['age'], ENT_QUOTES, 'UTF-8')."</td>
<td class='td'>".htmlspecialchars($fetch['gen'],ENT_QUOTES, 'UTF-8' )."</td>
<td class='td' align='center'><a id='Number' href='TreatmentDetail.php?id=".urlencode($fetch['sno'])."'>".htmlspecialchars($fetch['total_treatment'], ENT_QUOTES, 'UTF-8')."</a></td>
<td align='center'><a id='Number' href='InsertTreatment.php?id=".urlencode($fetch['sno'])."&tp=True'>Click here to add treatment</a></td>
<td class='td'>".htmlspecialchars($fetch['phoNo'],ENT_QUOTES, 'UTF-8')."</td>
<td class='td''><a href='Edit.php?id=".urlencode($fetch['sno'])."'>Edit</a></td>
</tr>";
	  }
       echo"</table><br>";
       echo"</center><br>";
	}
	else
	{
		echo"<h1 >No record found</h1>";
	}
mysqli_stmt_close($query);
}

	
?>
</div>
<script nonce="<?php echo $nonce; ?>">
</script>

</body>
</html> 