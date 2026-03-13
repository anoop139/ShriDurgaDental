<?php
include("Connection/Connect.php");
error_reporting(0);
$name = $_GET['n'];
session_start();
if(!isset($_SESSION['user'])){
    header("Location: LogIn.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information page</title>
    <link rel="stylesheet" href="Header2.css?v=1">
    <style>
      ul ul li{
        background:lightblue;
      }
      table tr th, td{
        padding: 5px;
      }
      #trefo{
        position: absolute;
        top: -28px;
      }
       #trefo{
        background-color:white;
      } 
      #trefo{
        transition: transform, 3s
      }
       #export{
        position: absolute;
        top: 150px;
        left: 1200px;
      
      }
      #export input{
        border: 2px solid black;
      }
      #export input{
       padding: 10px;
       background:blue;
       color:white;
       font-size:20px;
      }
    </style>
</head>
<body id="body">
<?php


?>
       <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>

    <!-- <div id///="ul" style="background-color: white; height: 40px;"> -->
       <ul id="ul" style="padding-left:1000px; background-color:lightblue; height: 40px; width: 255px; ">
        <li><a href="./DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientFom.html">Add Patient</a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByDate.php">Date</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByNumber.php">number</a></li>
        </ul>
        </li>
      </ul>
<div id="dis">     
<form action="" id="dateForm" method="POST">
  
<input type="hidden" name="toDate" id="date" value="he"/>
<!-- <input type="hidden" name="ss" id="h" value="he"/> -->
<input type="hidden" name="fid1" id="fid1" value="<?php echo htmlspecialchars($_GET['fid'] ?? ''); ?>"/>
</form>
  <?php
  
  // 
  if (isset($_GET['fid'])) {
    
    $treamentInsert = $_GET['fid'];
    if ($treamentInsert=="true") {
          echo"<h1 id='trefo'>Treatment Inseted </h1>";

    }
  }///
  ?>
<script>
  let date = new Date()
  let month =date.getMonth()+1
     let today = date.getDate()+" - "+month+" - "+date.getFullYear()
  if (!window.localStorage.getItem("fomSubmited")) {
    window.localStorage.setItem("fomSubmited", "true");
    document.getElementById("date").value=today
    document.getElementById("dateForm").submit()
    
  }
  else{
    onbeforeunload=()=>{
   window.localStorage.clear()
    }
  }
  onload = ()=>{
      document.getElementById("trefo").style.transform="translateY(50px)"
  }
    setTimeout(() => {
      document.getElementById("trefo").style.transform="translateY(-100px)"
    }, 5000);


</script>

 <?php

  $todayDate = $_POST['toDate'];
$admin_id = $_SESSION['admin_id'];
$display ="Select * from patient where date=? and admin_id=?";
$query   = mysqli_prepare($conn, $display);
mysqli_stmt_bind_param($query, "si", $todayDate, $admin_id);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$no = mysqli_num_rows($result);
 if($no>0 && !isset($_GET['name']))
{
  //  echo"<h1>Today is ".$ /////no."</h1>";
	echo"<table border='2'>
  <th>Name</th>
  <th>Age</th>
  <th>Gender</th>
  <th>Phone Number</th>
  <th>No. of treatment</th>
  <th>Treatment details</th>
  <th>Edit</th>";
   while( $show    = mysqli_fetch_assoc($result))
   {
    $storeDate = $show['date'];

    // if ($todayDate>$storeDate)
     {
    # code...
        // echo"<h2>the date are /$todayDate</h2>";
    
 ///  $display3 ="select * from treatment where sno=$show[sno]";
  //  $query5  = mysqli_query($conn, $display3);
  //  $Con  = mysqli_num_rows($query5);
 $display3 ="select * from treatment where sno =?";
  $query5 = mysqli_prepare($conn,$display3);
  mysqli_stmt_bind_param($query5, 'i', $show['sno']);
  mysqli_stmt_execute($query5);
 $result5 = mysqli_stmt_get_result($query5);
  $Con  = mysqli_num_rows($result5);
    echo"<tr>
	<td>".htmlspecialchars($show['name'])."</td>
<td>".htmlspecialchars($show['age'])."</td>
<td>".htmlspecialchars($show['gen'])."</td>
<td>".htmlspecialchars($show['phoNo'])."</td>
	<td style='text-align:center;'><a href='TreatmentDetail.php?id=$show[sno]' class='ank' title='Click here to view treatment details'>$Con</a></td>
	<td style='text-align:center;'><a href='InsertTreatment.php?id=$show[sno]&patientRecord=true' class='ank' title='Click here to add treatment details'>Add treatment details</a></td>
	<td style='text-align:center;'><a href='Edit.php?id=$show[sno]' class='ank'>Edit</a></td>
	</tr>"; 	
   }
   }
  }
 else if ($no==0) {
   echo"<h1 style='padding-left:100px;' id='del11'>No Patient record for today</h1>";
 }


 ?> </table>
<form action="./Export.php"  name="export" method="POST" id="export">
<input type="submit" name="export7" value="Export">
</form>

  <script>
  </script> 
</div>
<div>
<div id="button">
 <!-- <button class="btn">Back</button>
 <button id="next" class="btn">Next</button>
  -->
</div>
</div>
</body>
</html>