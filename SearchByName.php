<?php
include("Connection/Connect.php");
ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure',
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 1 : 0
);
ini_set('session.cookie_samesite', 'Strict');
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
session_start();

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search by name</title>
    <link rel="stylesheet" href="Header2.css">
	<link rel="stylesheet" href="SearchByName.css?v=3">
</head>
<body id="body">
       <ul id="ul1">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="PatientFom.php">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">Number</a></li>
    
        </ul>
        </li>
        </li>
</ul>
   <!-- </di> -->
<div id="res1">
<h1>Search by Name :</h1>
<form id="input" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
<input type="text" id="input1" name="name" class="Col">&nbsp;
<input type="submit" name="Sub" class="Col" value="Click here" ><br>
</form><br><br>
<div id="resultDiv">
	
		<?php
	if(isset($_POST['Sub']))

{    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
   die("Invalid CSRF token");
   exit();
}
	$name = trim($_POST['name']);
     if ($name === "" || strlen($name) > 50) {
    echo "<h1>Invalid input</h1>";
    exit();
   }
	$admin_id = $_SESSION['admin_id'];
	$pateintName =  $name . "%";
   $patientInfo = " SELECT sno, date, name, age, gen, phoNo FROM patient WHERE name LIKE ? and admin_id =?";
$prepare = mysqli_prepare($conn, $patientInfo);

if (!$prepare) {
    error_log(mysqli_error($conn));
    exit("Something went wrong");
}

mysqli_stmt_bind_param($prepare, 'si', $pateintName, $admin_id);
if (!mysqli_stmt_execute($prepare)) {
    error_log(mysqli_stmt_error($prepare));
    exit("Something went wrong");
}

	$query       = mysqli_stmt_get_result($prepare);
	$no           = mysqli_num_rows($query);
	 
	
	
	if($no>0)
	{
		
		echo" <table border='2' id='table'>
	 <tr>
	 <th style='padding:3px;'>Date</th>
	 <th style='padding:3px;'>Name</th>
	 <th style='padding:5px;'>Age</th>
	 <th style='padding:5px;'>Gender</th>
	 <th style='padding:5px;'>No. of treatment</th>
	 <th style='padding:5px;'>Treatment details</th>
	 <th style='padding:5px;'>Phone Number</th>
	 <th style='padding:5px;'>Edit</th>
	 </tr>";
	 ?>
	 <?php
      while($fetch =mysqli_fetch_assoc($query))
	  { 
        $id ="SELECT COUNT(*) as total FROM treatment WHERE sno=? AND admin_id=?";
		$prepare2       = mysqli_prepare($conn, $id);
		       if (!$prepare2) {
           die("Query failed");
          }
		mysqli_stmt_bind_param($prepare2, 'ii',  $fetch['sno'], $admin_id);
		if (!mysqli_stmt_execute($prepare2)) {
    error_log(mysqli_stmt_error($prepare2));
    exit("Something went wrong");
}
		$res  = mysqli_stmt_get_result($prepare2);
		$count = mysqli_fetch_assoc($res);
  $no2 = $count['total']; //mysqli_num_rows($res);

		 ///  echo"hi $fetch[sno]";
           		echo"<tr>
		  <td id='date' class='td'>".htmlspecialchars(date('d-m-Y', strtotime($fetch['date'])))."</td>
		  <td class='td'>".htmlspecialchars($fetch['name'], ENT_QUOTES, 'UTF-8')."</td>
	 <td align='center' class='td'>".htmlspecialchars($fetch['age'], ENT_QUOTES, 'UTF-8')."</td>
	 <td  class='td'>".htmlspecialchars($fetch['gen'], ENT_QUOTES, 'UTF-8')."</td>
          <td align='center'>
<a href='TreatmentDetail.php?id=".urlencode($fetch['sno'])."' class='ank' title='View treatment details'>$no2</a>
            </td>
	 <td  class='td'><a id='Number' href='InsertTreatment.php?id=".htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8')."&pr=true'>Click here to add treatment</a></td>
	 <td class='td'>".htmlspecialchars($fetch['phoNo'], ENT_QUOTES, 'UTF-8')."</td>
	 <td class='td'><a href='Edit.php?id=".htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8')."'>Edit</a></td>
	 </tr>";		  
	  }
       echo"</table>";
	}
	else
	{
		echo"<h1 style='margin-left:0px'>No recod found</h1>";
	}

}


?>
</div>

<!-- <input type="submit" name="Sub" class="Col" value="Click here" ><br> -->
<h1 id="errInfo"></h1><br><br>
<!-- </form> -->

<form action="" id="hidden" method="POST">

   <input type="text" id="input2" name="name4" class="Col" hidden>&nbsp;

</form>
<form id="pateintInfo">
	
<?php
// echo"<h1>hee</h1>";
// if (isset($_GET['id'])) {

// 	# code...
// 	$sno =$_GET['id'];
// }
//if (isset($_GET['inserted'])) {
//    $x = $_GET['inserted'];
//	echo"<h1 id='TreatInserted'>Treatment inserted successfully</h1>";
//}
// echo"<h1>name is  ".$nisset($_GET["id"])ame1."</h1>";

?>

</form>
</div>
</div>

<script src="./FomValidation.js?v=12"></script>

</body>
</html>