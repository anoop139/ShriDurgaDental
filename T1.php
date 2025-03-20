<!DOCTYPE html>
<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Treatment Details</title>
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
     .errorMessage{
      background-color:white;
     }
     .errorMessage{
      height: auto;
      font-weight:bold;
      font-size:20px;
     }
     
     #errorMessage{
      position: relative;
      top:0px;
     }
     
    </style>
	<link rel="stylesheet" href="Header.css?v=5">
</head>
<body>
<div id="header0" style="background-color:lightblue;">
<?php
$fid =$_GET['v'];
$n   = "No name";
if (isset( $_GET['n'])) {
  $n =  $_GET['n'];
}

echo"<h1>n = $n</h1>";
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
    <h1>Enter Amount </h1>
  </div>
  <form action="http://localhost:8081/Shri/T1.php" onsubmit="return Submit()">
    <input type="text" name="treat" id="treat1" class="treat"><br>
   
     <div class="errorMessage" id="errorMessage1"> <?php
    ?></div>
    <br><br>
    <input type="number" name="amt" id="" class="treat"><br>
    <input type="text" name="name" hidden id="pname"  value="<?php echo$name; ?>" class="treat">
    <input type="number" name="fid" hidden id="pname1"   value="<?php echo$fid; ?>" class="treat">
    <input type="hidden" name="pname" value=<?php echo $n;?>/>
	<?php
  $pn0=$_GET['pname'];
if(isset($_GET['sub']))
{  
    $name=$_GET['name'];
	$treat=$_GET['treat'];
	$fid1=$_GET['fid'];
	$amt=$_GET['amt'];	


  
	if (isset($name)) {
    # code...
    //  echo"hi ".$treat;
	$insert ="insert into treatment(treatment, amount, tid) value('$treat',$amt,$fid1)";
	$query =  mysqli_query($conn, $insert);
	$treatmentName = "Select treatment from treatment where treatment = '$treat'";
	$query1 =  mysqli_query($conn, $treatmentName);
	$noOf   =  mysqli_num_rows($query1);
	$fetch =  mysqli_fetch_assoc($query1);

   if($query)
    {
      if ($pn0!="No") {
        header("location:Display.php");
        // echo"<span class='errorMessage'>Treatment inserted $pn0 </span><br>";
      }
      else {
        header("location:Info.php?name3='Anoop Shetty'");
        // echo"<span class='errorMessage'>Treatment inserted without name  $pn0</span><br>";
      }

////      echo"<span class='errorMessage'>Treatment inserted $pn0 </span><br>";
      //echo"<script>window.location.href='Display.php?name=$name'</script>";
    }
  
  // else if($query && !isset($pno))
  //   {
  //      echo"<span class='errorMessage'>Treatment inserted 2 </span><br><>";
  //}
       
 else{
  echo"<span class='errorMessage'>Failed</span><br>";
}
}
 
}
?>
<script>
   let msg = document.getElementById("errorMessage1")
   let treat 
   function Submit() {
     treat = document.getElementById("treat1").value 
    if (!treat) {
      // 

        msg.innerHTML="Enter treatment";///
      // alert("obj/ect")
          return false 
    }
  }
 window.oninput=(()=>{
  // alert("testion")
  msg.innerHTML="";
 })
</script>  
    <input type="submit" name="sub" id="sub" class="treat" ><br>
  </form>

</body>
</html>