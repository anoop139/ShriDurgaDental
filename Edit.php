<?php
include("Connection/Connect.php");

ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Edit Page</title>
	<style>
        ul ul li a{
            background-color: lightblue;
        }
	#header0{
		background-color:black

	}
    	table th, td{
		padding: 5px;
	}
    #updateMessage{
    position: absolute;
    top: -80px;
    color: green;
    background-color: white;
    transition: transform 3s;
}
   
	</style>
    <link rel="stylesheet" href="Header2.css?v=1">
    <link rel="stylesheet" href="StlyEdit.css?v=11">
	
</head>
<body id="editBody">
  <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>
      <ul style="background:lightblue; height: 40px; width:340px; padding-left:1000px">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="PatientForm.php">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">Number</a></li>
    
        </ul>
        </li>
        </li>
</ul>


<div id="EidtSection">
<?php
if (!isset($_GET['id']) || (int)$_GET['id'] <= 0) {
    die("Invalid or missing patient ID");
}

$id = (int) $_GET['id'];
$admin_id = $_SESSION['admin_id'];
// echo"id id $id<br>";
$query = "SELECT * FROM patient WHERE sno=? AND admin_id=?";
$prepare = mysqli_prepare($conn,$query);

if ($prepare) {
    
mysqli_stmt_bind_param($prepare, 'ii', $id, $admin_id);
mysqli_stmt_execute($prepare);
$result = mysqli_stmt_get_result($prepare);   // ✅ correct
$fetch = mysqli_fetch_assoc($result);  
 if (!$fetch) {
    die("No patient record found for this ID.");
}
   
 if(isset($_GET['id']))    // ✅ correct
 {
    	echo"<h1 id='updateMessage'>Age updated successfully</h1>";
 }
 if(isset($_GET['id']))    // ✅ correct
 {
    	echo"<h1 id='updateMessage'>Name updated successfully</h1>";
 }
  if(isset($_GET['id']))    // ✅ correct
 {
    	echo"<h1 id='updateMessage'>Phone Number updated successfully</h1>";
 }
   if(isset($_GET['id']))    // ✅ correct
 {
    	echo"<h1 id='updateMessage'>Gender updated successfully</h1>";
 }
    mysqli_stmt_close($prepare);
}
// $query1 = mysqli_query($conn, $query);
// $show   = mysqli_fetch_assoc($query1);


?>

<script>
   

</script>
<table border='2' cellpadding="4">
<tr style='padding:2px'>
<th>Name</th>
<th>Edit name</th>
<th>Age</th>
<th>Edit age</th>
<th>Gender</th>
<th>Edit Gender</th>
<th>Phone Number</th>
<th> Edit Phone Number</th>
<th>Delete</th>
</tr>
<tr>
<td><?php echo htmlspecialchars($fetch['name'], ENT_QUOTES, 'UTF-8'); ?></td>
<td><a href="Edit/Name.html?id=<?php echo htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8'); ?>">Edit name</a></td>
<td style="text-align:center;"><?php echo htmlspecialchars($fetch['age'], ENT_QUOTES, 'UTF-8'); ;?></td>
<td style="text-align:center;"><a href="Edit/Age.html?id=<?php echo htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8');?>">Edit age</a></td>
<td style="text-align:center;"><?php echo htmlspecialchars($fetch['gen'], ENT_QUOTES, 'UTF-8');?></td>
<td style="text-align:center;"><a href="Edit/Gender.html?id=<?php echo htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8');?>">Edit gender</a></td>
<td><?php echo htmlspecialchars($fetch['phoNo'], ENT_QUOTES, 'UTF-8');?></td>
<td><a href="Edit/Phone.html?id=<?php echo htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8');?>">Edit phone number</a></td>
<td>
<form method="POST" action="Edit/DeletePatientRecord.php" style="display:inline;">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <button type="submit">Delete</button>
</form>
</td>
</tr>
</table>
<script>
window.onload = () => {
    let mess = document.getElementById("updateMessage");

    if (!mess) return;

    mess.style.transform = "translateY(80px)";

    setTimeout(() => {
        mess.style.transform = "translateY(-80px)";
    }, 5000);
};

</script>
</div>

    
</body>
</html>