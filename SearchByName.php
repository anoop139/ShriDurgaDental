<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search by name</title>
	<style>
	body{
		background-image:url("Images/SearchbyNames.jpeg");
		background-repeat:no-repeat;
		background-size:cover;
	}
	#res1{
		background-color:white;
	}
	ul li a{
		color:white;
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
		top:140px
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
	#res1
	{
/* //		background-color:lightblue */
	}
	#Number
	{
		text-docoration:none;
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
    <link rel="stylesheet" href="Header.css?v=9">
</head>
<body>
<div id="header0" style="background-color:black">

<div id="header">

       <ul>
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="PatientFom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="SearchByName.php">Search by Name</a></li>
        </ul>
	
</ul><br><br><br><br><br>
</div>
</div>
<div id="res1">
<h1>Search by Name :</h1>
<form id="input"onsubmit="return checkInput()" method="POST">
<input type="text" id="input1" name="name" class="Col">&nbsp;
<input type="submit" name="Sub" class="Col" value="Click here" ><br>
</form>
<div id="resultDiv">
		<?php
	if(isset($_POST['Sub']))

{    
	$name =  $_POST['name'];

// 
   $patientInfo = "SELECT * FROM patient WHERE name LIKE '$name%'";

	$query       = mysqli_query($conn, $patientInfo);
	$no           = mysqli_num_rows($query);
	 
	
	
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
      while($fetch =mysqli_fetch_assoc($query))
	  { 
        $id ="select * from treatment where sno=$fetch[sno]";
		$query2       = mysqli_query($conn, $id);
	    $no2           = mysqli_num_rows($query2);   
		 ///  echo"hi $fetch[sno]";
           		echo"<tr>
		  <td class='td'>$fetch[date]</td>
		  <td class='td'>$fetch[name]</td>
	 <td style='text-align:center;' class='td'>$fetch[age]</td>
	 <td style='text-align:center' class='td'>$fetch[gen]</td>
	 <td style='text-align:center' class='td'><a id='Number' href='TreatmentDetail.php?id=$fetch[sno]'>$no2</a></td>
	 <td style='text-align:center' class='td'><a id='Number' href='InsertTreatment.php?id=$fetch[sno]&sbm=True'>Click here to add treatment</a></td>
	 <td class='td'>$fetch[phoNo]</td>
	 <td class='td'><a href='Edit.php?id=$fetch[sno]'>Edit</a></td>
	 </tr>";		  
	  }
       echo"</table>";
	}
	else
	{
		echo"<h1 style='padding-left:350px;'>No recod found</h1>";
	}

}
else if(isset($_GET["pid"]))
{
	$name1 =  $_GET['name4'];
	$pid = $_GET["pid"];

// 
   $patientInfo = "SELECT * FROM patient WHERE sno =$pid";

	$query       = mysqli_query($conn, $patientInfo);
	$no           = mysqli_num_rows($query);
	 
	
	
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
      while($fetch =mysqli_fetch_assoc($query))
	  { 
        $id ="select * from treatment where sno=$fetch[sno]";
		$query2       = mysqli_query($conn, $id);
	    $no2           = mysqli_num_rows($query2);   
		 ///  echo"hi $fetch[sno]";
           		echo"<tr>
		  <td class='td'>$fetch[date]</td>
		  <td class='td'>$fetch[name]</td>
	 <td style='text-align:center;' class='td'>$fetch[age]</td>
	 <td style='text-align:center' class='td'>$fetch[gen]</td>
	 <td style='text-align:center' class='td'><a id='Number' href='TreatmentDetail.php?id=$fetch[sno]'>$no2</a></td>
	 <td style='text-align:center' class='td'><a id='Number' href='InsertTreatment.php?id=$fetch[sno]&sbm=True'>Click here to add treatment</a></td>
	 <td class='td'>$fetch[phoNo]</td>
	 <td class='td'><a href='Edit.php?id=$fetch[sno]'>Edit</a></td>
	 </tr>";		  
	  }
       echo"</table>";
	}
	else
	{
		echo"<h1 style='padding-left:350px;'>No recod found</h1>";
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
<script src="./FomValidation.js?v=5"></script>
<div id="Back"><button class="Col">Back</button></div>
<div id="Next"><button class="Col">Next</button></div>
</body>
</html>