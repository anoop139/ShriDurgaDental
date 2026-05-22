<?php
include("Connection/Connect.php");
include("Connection/Init.php");
if(!isset($_SESSION['user'])){
    header("Location: LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search by number</title>
	<style>
	ul li:hover ul li{
	
     background-color: black;
	} 
	body{
		/* background-image:url("Images/SearchbyNames.jpeg"); */
		background-repeat:no-repeat;
		background-size:cover;
	}
	#res1{
		background-color:white;
	}
	ul li a{
		color:white;
	}
	
	ul li a{
		padding: 0px;
	}
	#res1{
		border:2px solid black;
		height:400px;
	}
	
	#res1{
		
		margin-top:50px;
		padding-left:50px;
	}
	#res1{
		
		padding-top:0px;
		//text-align:center;
	}
		
	#input{
	    position:absolute;
		left:740px;
		top:120px
	}
	.Col{
		border:2px solid black;
	}

	#Next button{
		position:relative;
		top:-20px;
		

	}
	#Next Button{
		float:right;
		color:green;
	}
	#Back{
		padding-top:10px;
		
	}	
	#Back button{
		
		padding-left:30px;
		padding-right:30px;
		
	}
	
	#Next button{
		padding-left:30px;
		padding-right:30px;
		
	}
	#pateintInfo{
		padding-left:308px;
	}
	
#Number
{
    text-decoration: none;
}
	#TreatInserted
	 {
		position: absolute;
		top:-50px;
	 }
	#TreatInserted
	 {
		background-color:white
	 }
     #TreatInserted
	 {
		transition:transform 3s 
	}
	/* #TreatInserted:hover
	 {
		transform:translateY(-50px) 
	} */
	  #resultDiv
	 {
		padding-left:330px ;
	} 
	 #errInfo
	 {
		text-align:center;
	} 
	.td{
		padding: 5px;
	}
	</style>
    <link rel="stylesheet" href="Header2.css">
</head>
<body>
        <ul style="background:black; height: 40px; width:340px; padding-left:1000px">
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
<h1>Search by Number :</h1>
<form id="input"onsubmit="return checkNumberInput()" method="POST">
<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
<input type="text" id="input1" name="number" class="Col">&nbsp;
<input type="submit" name="Sub" class="Col" value="Click here" ><br>
</form><br><br>
<div id="resultDiv">
		<?php
	 if ($_SERVER['REQUEST_METHOD'] == 'POST')

{   
if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
    exit("Invalid request");
}
	
$number = trim($_POST['number']);


if (!preg_match("/^[0-9]{10,15}$/", $number)) {
    exit("Invalid number");
}
  $patientInfo = "SELECT * FROM patient WHERE phoNo=? AND admin_id=?";
   $prepared    = mysqli_prepare($conn, $patientInfo);
   mysqli_stmt_bind_param($prepared, "si", $number, $admin_id);
   mysqli_stmt_execute($prepared);
$result       = mysqli_stmt_get_result($prepared);
	$no           = mysqli_num_rows($result);
	//  echo"<h1>No. ".$no."</h1>";
	mysqli_stmt_close($prepared);
	
	if($no>0)
	{
		
		echo" <table border='2'>
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
      while($fetch =mysqli_fetch_assoc($result))
	  {
		
	  $id ="SELECT COUNT(*) as total FROM treatment WHERE sno=?";
		$prepared2      = mysqli_prepare($conn, $id);
		mysqli_stmt_bind_param($prepared2, 'i', $fetch['sno']);
		mysqli_stmt_execute($prepared2);
		$numberOfTreat = mysqli_stmt_get_result($prepared2);
		$count = mysqli_fetch_assoc($numberOfTreat);
  $no2 = $count['total']?? 0; //mysqli_num_rows($res); 
	mysqli_stmt_close($prepared2);
           		echo"<tr>
		  	  <td class='td'>".htmlspecialchars($fetch['date'], ENT_QUOTES, 'UTF-8')."</td>
		  <td class='td'>".htmlspecialchars($fetch['name'], ENT_QUOTES, 'UTF-8')."</td>
	 <td style='text-align:center;' class='td'>".htmlspecialchars($fetch['age'], ENT_QUOTES, 'UTF-8')."</td>
	 <td style='text-align:center' class='td'>".htmlspecialchars($fetch['gen'], ENT_QUOTES, 'UTF-8')."</td>
	 <td style='text-align:center' class='td'><a id='Number' href='TreatmentDetail.php?id=".htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8')."'>$no2</a></td>
	 <td style='text-align:center' class='td'><a id='Number' href='InsertTreatment.php?id=".htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8')."&sbm=True'>Click here to add treatment</a></td>
<td class='td'>".htmlspecialchars($fetch['phoNo'], ENT_QUOTES, 'UTF-8')."</td>
	 <td class='td'><a href='Edit.php?id=".htmlspecialchars($fetch['sno'], ENT_QUOTES, 'UTF-8')."'>Edit</a></td>
	 </tr>";		  
	  }
       echo"</table>";
	}
	else
	{
		echo"<h1 style='padding-left:350px;'>No recod found</h1>";
	}

}
// else if(isset($_GET["pid"]))
// {
// 	$name1 =  $_GET['name4'];
// 	$pid = $_GET["pid"];

// // 
//    $patientInfo = "SELECT * FROM patient WHERE sno =$pid";

// 	$query       = mysqli_query($conn, $patientInfo);
// 	$no           = mysqli_num_rows($query);
	 
	
	
// 	if($no>0)
// 	{
		
// 		echo" <table border='2'>
// 	 <tr>
// 	 <th style='padding:3px;'>Date</th>
// 	 <th style='padding:3px;'>Name</th>
// 	 <th style='padding:5px;'>Age</th>
// 	 <th style='padding:5px;'>Gender</th>
// 	 <th style='padding:5px;'>No. of treatment</th>
// 	 <th style='padding:5px;'>Treatment details</th>
// 	 <th style='padding:5px;'>Phone Number</th>
// 	 <th style='padding:5px;'>Edit</th>
// 	 </tr>";
//       while($fetch =mysqli_fetch_assoc($query))
// 	  { 
//         $id ="select * from treatment where sno=$fetch[sno]";
// 		$query2       = mysqli_query($conn, $id);
// 	    $no2           = mysqli_num_rows($query2);   
// 		 ///  echo"hi $fetch[sno]";
//            		echo"<tr>
// 		  <td class='td'>$fetch[date]</td>
// 		  <td class='td'>$fetch[name]</td>
// 	 <td style='text-align:center;' class='td'>$fetch[age]</td>
// 	 <td style='text-align:center' class='td'>$fetch[gen]</td>
// 	 <td style='text-align:center' class='td'><a id='Number' href='TreatmentDetail.php?id=$fetch[sno]'>$no2</a></td>
// 	 <td style='text-align:center' class='td'><a id='Number' href='InsertTreatment.php?id=$fetch[sno]&sbm=True'>Click here to add treatment</a></td>
// 	 <td class='td'>$fetch[phoNo]</td>
// 	 <td class='td'><a href='Edit.php?id=$fetch[sno]'>Edit</a></td>
// 	 </tr>";		  
// 	  }
//        echo"</table>";
// 	}
// 	else
// 	{
// 		echo"<h1 style='padding-left:350px;'>No recod found</h1>";
// 	}
// 	}


?>
</div>
<!-- <input type="submit" name="Sub" class="Col" value="Click here" ><br> -->
<h1 id="errInfo"></h1><br><br>
<!-- </form> -->

<form action="" id="hidden" method="POST">

   <input type="text" id="input2" name="name4" class="Col" hidden>&nbsp;

</form>
	</script>
<form id="pateintInfo">
	
<?php
// echo"<h1>hee</h1>";
// if (isset($_GET['id'])) {

// 	# code...
// 	$sno =$_GET['id'];
// }
if (isset($_GET['inserted'])) {
    $x = $_GET['inserted'];
	echo"<h1 id='TreatInserted'>Treatment inserted successfully</h1>";
}
// echo"<h1>name is  ".$nisset($_GET["id"])ame1."</h1>";

?>
<script>
    let name = document.getElementById("TreatInserted")   
    window.onload=()=>{
      name.style.transform="translateY(100px)"
	// alert(1)
   
       setTimeout(() => {
      name.style.transform="translateY(-85px)"
     }, 5000);  
	
};   

</script>
</form>
</div>
</div>
</div>
<script src="./FomValidation.js?v=8"></script>
<div id="Back"><button class="Col">Back</button></div>
<div id="Next"><button class="Col">Next</button></div>
</body>
</html>