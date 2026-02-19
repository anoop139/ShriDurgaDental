<?php
include("Connection/Connect.php");
error_reporting(0);
$name = $_GET['n'];
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
<input type="hidden" name="fid1" id="fid1" value="<?php echo$_GET['fid']; ?>"/>
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

     $display ="SELECT * FROM patient where date = '$todayDate'";
   $query   =  mysqli_query($conn, $display);
   $dateQuery   =  mysqli_query($conn, $display);
  $no    = mysqli_num_rows($query);
 if($no>0 && !isset($_GET['name']))
{
  //  echo"<h1>Today is ".$todayDate."</h1>";
	echo"<table border='2'>
  <th>Name</th>
  <th>Age</th>
  <th>Gender</th>
  <th>Phone Number</th>
  <th>No. of treatment</th>
  <th>Treatment details</th>
  <th>Edit</th>";
   while( $show    = mysqli_fetch_assoc($query))
   {
    $storeDate = "$show[date]";

    // if ($todayDate>$storeDate)
     {
    # code...
        // echo"<h2>the date are /$todayDate</h2>";
    
    $display3 ="select * from treatment where sno=$show[sno]";
   $query5  = mysqli_query($conn, $display3);
   $Con  = mysqli_num_rows($query5);
 
    echo"<tr>
	<td>$show[name]</td>
	<td style='text-align:center'>$show[age]</td>
	<td style='text-align:center'>$show[gen]</td>
	<td>$show[phoNo]</td>
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
 if($no2>0 && isset($_GET['name']))
   {
     $name = $_GET['name'];
     echo"<h1 id='patientName'> Treatment for '$name has been inserted successfully'</h1>";
    echo"<table border='2'> 
  <th>Name</th>
  <th>Age</th>
  <th>Gender</th>
  <th>Phone Number</th>
  <th>No. of treatment</th>
  <th>Treatment details</th>
  <th>Edit</th>";
   while( $show    = mysqli_fetch_assoc($query))
   {
   $display3 ="select * from treatment where tid=$show[sno]";
   $query5  = mysqli_query($conn, $display3);
   $Con  = mysqli_num_rows($query5);
 
    echo"<tr>
	<td>$show[name]</td>
	<td style='text-align:center'>$show[age]</td>
	<td style='text-align:center'>$show[gen]</td>
	<td>$show[phoNo]</td>
	<td style='text-align:center;'><a href='Info.php?v=$show[sno]' class='ank' title='Click here to view treatment details'>$Con</a></td>
	<td style='text-align:center;'><a href='T1.php?v=$show[sno]' class='ank' title='Click here to add treatment details fast'>Add treatment details</a></td>
	<td style='text-align:center;'><a href='Edit.php?id=$show[sno]' class='ank'>Edit</a></td>
	</tr>"; 	
   }

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