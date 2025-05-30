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
	<style>
	#header0{
		background-color:black

	}
  
  #patientName{
    background-color:white; 
  }
  .res{
    background-color:white;
     font-size:32px; margin-left:500px; 
     font-weight:bold;
  
  }
  
   .res:hover{
    top:-50px
   }
   #trefo{
    position: absolute;
    top:-40px;
    margin-left:80px;
    background:white
   }
   #trefo{
    transition:transform, 3s
   }
   /* #trefo:hover{
    transform:translateY(-80px)
   } */

  
	</style>
    <link rel="stylesheet" href="Header.css?v=8">
</head>
<body id="body">
<?php


?>
<div id="header0" style="background-color:lightblue">

<div id="header">

        <ul>
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="PatientFom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="SearchByName.php">Search by Name</a></li>
        </ul>
	
</ul><br><br><br><br><br>
</div>
</div>
<div id="dis">     
<form action="" id="dateForm">
  
<input type="hidden" name="toDate" id="date" value="he"/>
<!-- <input type="hidden" name="ss" id="h" value="he"/> -->
<input type="hidden" name="fid1" id="fid1" value="<?php echo$_GET['fid']; ?>"/>
</form>
  <?php
  
  // 
  if (isset($_GET['fid1'])) {
    
    $treamentInsert = $_GET['fid1'];
    if ($treamentInsert=="true") {
          echo"<h1 id='trefo'>Treatment Inseted </h1>";

    }
  }///
  ?>
<script>
  let date = new Date()
     let today = date.getDate()+" - "+date.getMonth()+" - "+date.getFullYear()
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
      document.getElementById("trefo").style.transform="translateY(80px)"
  }
    setTimeout(() => {
      document.getElementById("trefo").style.transform="translateY(-80px)"
    }, 5000);


</script>

 <?php
 //"17 - 3 - 2025";
  $todayDate = $_GET['toDate'];
  // echo"<h1>Testing". $todayDate."</h1>";
     $display ="SELECT * FROM patient where date = '$todayDate'";
   $query   =  mysqli_query($conn, $display);
   $dateQuery   =  mysqli_query($conn, $display);
  $no    = mysqli_num_rows($query);
  // $no2    = mysqli_num_rows($query2);//////////
  // $recodedDate   = mysqli_fetch_assoc($dateQuery)/;
  // echo"<h1>The patient till "."$recodedDate[date]"." has been recoded</h1>";
  // echo"<h1>Todzay i"."$todayDate</h1>";
 if($no>0 && !isset($_GET['name']))
{
  //  echo"<h1>Today is ".$todayDate."</h1>";
	echo"<table border='2' cellpadding='4'>
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
    echo"<table border='2' cellpadding='4'> 
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
 

 ?>
 
 </table>
  <script>
    let name = document.getElementById("patientName")   
     let del = document.getElementById("del")
     setTimeout(() => {
      name.style.transform="translateY(-85px)"
     }, 5000);   
       setTimeout(() => {
      del.style.transform="translateY(-85px)"
     }, 5000);
     localStorage.setItem("name", "AE");
   alert(date3)
    //  alert("The date "+date3)
   // Submit form only if `toDate` is not already in the URL (prevents infinite loop)
  //  if (!window.location.search.includes("toDate=") ) {
  //   document.getElementById("dateForm").submit();
  // }///
  </script> 
</div>
<div>
<div id="button">
 <button class="btn">Back</button>
 <button id="next" class="btn">Next</button>
 
</div>
</div>
</body>
</html>