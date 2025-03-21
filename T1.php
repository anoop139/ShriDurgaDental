<!DOCTYPE html>
<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
	 #header0{
      background-color:lightblue;
     }
	 
     #header{
        position: absolute;
        top:0px;       
        right:20px;
     }
     #header ul li{
      list-style-type:none;
     }
	 #header ul li{
     float:left;
     }
	 #header ul li{
     margin-left:20px
     }
   	
     body{
        background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBztpBXjR7M2C_AkcfV_0IWiQ48qGrmTgPLw&s");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
     }
     form{
         position: absolute;
         top:75px;
         left:800px;
     }
     .treat{
      border:2px solid black;
     }
    </style>
	<link rel="stylesheet" href="Header.css">
</head>
<body>
<div id="header0" style="background-color:lightblue;">
<?php
$fid =$_GET['v'];
$name =$_GET['n'];

 // echo"the fd is ".$fid."<br>";
 // echo"the name ".$name;
?>  <div id="header">
    <ul>
      <li><a href="HomePage.html">Home</a></li>
      <li><a href="http://localhost:8081/Shri/display.php">Patients List</a></li>
      <li><a href="">Search by Name</a></li>
    </ul>
  </div><br><br>
</div>
  <div id="div1">
    <h1>Enter Treatmemt </h1>
    <h1>Enter Amount plas</h1>
  </div>
   <form action="#"><!--http://localhost:8081/Shri/T1.php -->
    <input type="text" name="treat" id="treat1" class="treat"><br><br><br>
    <input type="number" name="amt" id="" class="treat"><br>
    <input type="text" name="name" hidden id="pname"  value="<?php echo$name; ?>" class="treat"><br>
    <input type="number" name="fid" hidden id="pname1"   value="<?php echo$fid; ?>" class="treat"><br>
	<?php

if(isset($_GET['sub']))
{
	$y=$_GET['name'];
	$treat=$_GET['treat'];
	$fid1=$_GET['fid'];
	$amt=$_GET['amt'];
	$insert ="insert into treatment(treatment, amount, tid) value('$treat',$amt,$fid1)";
	$query =  mysqli_query($conn, $insert);
	$treatmentName = "Select treatment from treatment where treatment = '$treat'";
	$query1 =  mysqli_query($conn, $treatmentName);
	$noOf   =  mysqli_num_rows($query1);
	$fetch =  mysqli_fetch_assoc($query1);
   if($query && $noOf==0)
   {
	 echo"<h1 style='background-color:green'>Recorded </h1>";
   echo"<script>
      alert($treat)
//   window.location='http://localhost:8081/Shri/abc.php?n=$y'
	
	 </script>";
   }
   else if($noOf>0)
   {
	   
	echo"<h1 style='text-align:center; background-color:white;'>The treatmt for the patient already exists </h1>";
   }    
    else
    {
	   
	 echo"<h1 style='text-align:center; background-color:white;'>Failed "." ".$y." ".$treat." ".$amt."</h1>";
    }  
   
   
}








?>  
    <input type="submit" name="sub" id="sub" class="treat"><br>
  </form>

</body>
</html>