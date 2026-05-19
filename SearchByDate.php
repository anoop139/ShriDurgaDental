<?php
include("Connection/Connect.php");
ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])){
    header("Location: LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];

$nonce = bin2hex(random_bytes(16));

header("Content-Security-Policy: default-src 'self'; 
script-src 'self' 'nonce-$nonce'; 
style-src 'self'; 
img-src 'self' data:; 
object-src 'none'; 
base-uri 'self';");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    
    </style>
    <title>Seach By Date</title>
<link rel="stylesheet" href="./Header2.css">
<link rel="stylesheet" href="./SearchByDate.css?v=1">
</head>
<body>
     <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>
   <ul style="background:white; height: 40px; padding-left:1010px; width:340px"  >
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientFom.php">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByNumber.php">Number</a></li><br>
    
        </ul>
        </li>
        </li>
</ul>
      <br><br>
<h1 id="inputAra">Seach by Date</h1>
<form id="dateInput" method="POST" onsubmit="return changeFomat()">
    <input type="date" name="Date0" id="date0">   
    <input type="hidden" name="Date" id="date">   
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']?>">
     <input type="submit" name="Sub"value="Click here"><br><br><br><br>
    <h1 id="err"></h1>

</form>
<div id="seeMsg" class="disp">
    <!-- <h1>hello</h1> -->
   		<?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

 $date = $_POST['Date'] ?? '';

        if (empty($date)) {
            echo "<h3>Please choose a date</h3>";
            exit();
        }
 if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
    echo "<h3>Invalid request</h3>";
    exit();
}
   $_SESSION['token'] = bin2hex(random_bytes(32));

$dateObj = DateTime::createFromFormat('d - m - Y', $date);
if (!$dateObj || $dateObj->format('d - m - Y') !== $date) {
    echo "<h3>Invalid date</h3>";
    exit();
}
if (!preg_match('/^\d{2} - \d{2} - \d{4}$/', $date)) {
    echo "Invalid date format";
    exit();
}
echo "<h1>Patient record on " . htmlspecialchars($date, ENT_QUOTES, 'UTF-8') . "</h1><br>";
   

   $patientInfo = "SELECT * FROM patient WHERE patient.date =? AND patient.admin_id = ?";
//    mysqli_prepare
	$query       = mysqli_prepare($conn, $patientInfo);
    mysqli_stmt_bind_param($query,  'si', $date, $admin_id);
	
    mysqli_stmt_execute($query);
   $result = mysqli_stmt_get_result($query);   // important

$no = mysqli_num_rows($result);
   
	//    echo"<h1>Affected ".$no."</h1><br>";
	
	
	if($no>0)
	{
		echo"<center>";
		echo" <table border='2'>
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
        $id ="select * from treatment where sno=? and admin_id=?";
        $query2 = mysqli_prepare($conn, $id);
        $idContain = $fetch['sno'];
        mysqli_stmt_bind_param($query2, 'ii', $idContain, $admin_id);
		mysqli_stmt_execute($query2);///
   $result2 = mysqli_stmt_get_result($query2);   // important
 $no2           = mysqli_num_rows($result2);   
      mysqli_stmt_close($query2);///

           		echo "<tr>
<td class='td' style='padding:7px'>".htmlspecialchars($fetch['name'], ENT_QUOTES, 'UTF-8')."</td>
<td style='text-align:center;' class='td'>".htmlspecialchars($fetch['age'], ENT_QUOTES, 'UTF-8')."</td>
<td style='text-align:center' class='td'>".htmlspecialchars($fetch['gen'],ENT_QUOTES, 'UTF-8' )."</td>
<td style='text-align:center' class='td'><a id='Number' href='TreatmentDetail.php?id=".urlencode($fetch['sno'])."'>$no2</a></td>
<td style='text-align:center; padding:7px' class='td'><a id='Number' href='InsertTreatment.php?id=".urlencode($fetch['sno'])."&tp=True'>Click here to add treatment</a></td>
<td class='td' style='padding:7px'>".htmlspecialchars($fetch['phoNo'],ENT_QUOTES, 'UTF-8')."</td>
<td class='td' style='padding:7px'><a href='Edit.php?id=".htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8')."&admin_id=$admin_id'>Edit</a></td>
</tr>";
	  }
       echo"</table><br>";
       echo"</center><br>";
	}
	else
	{
		echo"<h1 >No recod found</h1>";
	}
mysqli_stmt_close($query);
}

	
?>
</div>
<script nonce="<?php echo $nonce; ?>">
    let dateVal;
    let error = document.getElementById("err")
   
    function changeFomat() {
        dateVal = document.getElementById("date0").value
        dateVal2 = document.getElementById("date")
       let x;
       let v = "0"
        if (!dateVal) {
           error.innerHTML="Please choose a date";
            return false
            
        }
        else{ 
      
      x = dateVal.split("-").reverse().join(" - ")
    // let date = x.slice(//0,7)   
    // error.innerHTML=dateVal
      dateVal2.value=x;
   }
   return true
 }
    window.oninput = ()=>{
        error.innerHTML="";
    }
    //  x = x.replace(v, "")
      //  dateVal2.value=x
</script>
</div>
</body>
</html> 