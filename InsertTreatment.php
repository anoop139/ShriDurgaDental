<?php
//92
include("Connection/Connect.php");
error_reporting(0);
session_start();
// session_regenerate_id(true); // 🔥 MUST
if(!isset($_SESSION['user'])){
    header("Location: LogIn.php");
    exit();
}
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
header("Content-Security-Policy:
default-src 'self';
script-src 'self';
base-uri 'self';
img-src 'self' data: https://encrypted-tbn0.gstatic.com;
object-src 'none';
frame-ancestors 'none';
form-action 'self';
");
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Treatment Details</title>
    <style>
	 #ul{ 
      background-color:lightblue; 
     }
	 	ul li ul li{
		background:lightblue;
	}

   	
     body{
        background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBztpBXjR7M2C_AkcfV_0IWiQ48qGrmTgPLw&s");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
     }
     form{
         position: absolute;
         top:93px;
         left:800px;
     }
     .treat{
      border:2px solid black;
     }
     .errorMessage{
      background-color:white;
     }
      #errorMessage1{
      color:red
     }
     .errorMessage{
      height: auto;
      font-weight:bold;
      font-size:20px;
     }
     #div1{
      position: absolute;
      top:70px;
     }
     #errorMessage{
      position: relative;
      top:0px;
     }
     #del{
		position: absolute;
		top:-10px;
		left: 550px;
	}
  #navFom{
    position: absolute;
    top: 450px;
   left: 1210px;
   
  }
  #navFom input{
    padding: 20px;
    background:lightblue;
    
  }
    </style>
	<link rel="stylesheet" href="Header.css?v=8">
</head>
<body>
<div id="header0" >
<?php
$fid =intval($_GET['id']);
$n   = "No name";
if (isset($fid)) {   

  // echo"<h1>Testing with new code</h1>";
$patientName0 ="select name from patient where sno =?";
$smb         = mysqli_prepare($conn,$patientName0);
if ($smb) {

  mysqli_stmt_bind_param($smb, "i", $fid);
      mysqli_stmt_execute($smb);
   mysqli_stmt_bind_result($smb, $patientName);

  mysqli_stmt_fetch($smb);
  mysqli_stmt_close($smb);   // 🔥 CLOSE IT

     if (!empty($patientName)) {
echo "<h1 id='del'>Treatment for ".htmlspecialchars($patientName)."</h1>";
     }         
   else{
    echo"ecf";
   }       
}
 else{
    echo"ecf";
   }     

// mysqli_stmt_close()
}	



?> 
   <ul style="padding-left:955px; height: 40px;" id="ul">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List</a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientFom.php">Add Patient</a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByDate.php">Date</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByNumber.php">Number</a></li><br>
        </ul>
        </li>
</ul>
  <div id="div1">
    <h1>Enter Treatmemt </h1>
    <h1> Enter due date </h1>
    <h1>Enter Advance Amount if any </h1>
    <h1>Enter online Amount </h1>
    <h1>Enter cash Amount </h1>
  </div>
  <form action="" onsubmit="return Submit()" method="POST">
    <textarea name="treat" id="treat1" class="treat"></textarea><br>
    <div class="errorMessage" id="errorMessage1"></div> <br>
   &nbsp; <input type="date" name="dueDate1" id="dueDate">
   &nbsp; <input type="text" name="dueDate" id="dueDateInput" hidden>
    
    <br><br>
    <input type="text" name="advanceAmount" id="Advance" class="treat" ><br><br><br>
    <input type="number" name="onlineAmount" id="onlinePayment" class="treat" ><br><br><br>
    <input type="number" name="amt" id="receivedAmount" class="treat" ><br><br>
  
 
    <input type="hidden" name="pname" value="<?php echo htmlspecialchars($n);?>"/>
    <input type="hidden" name="pr" value="<?php echo htmlspecialchars($_GET['patientRecord']?? '');?>">
    <input type="hidden" name="tp" value="<?php echo htmlspecialchars($_GET['tp']?? '');?>"/>
     <input type="hidden" name="sbm" value="<?php echo htmlspecialchars($_GET['sbm']?? '');?>"/>
     <input type="text" name="date" id="date2"  hidden>
     <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <input type="submit" name="sub" id="sub" class="treat" ><br>
	<?php


 
if(isset($_POST['sub']))
{  
  if (!isset($_POST['token']) || trim($_POST['token']) !== $_SESSION['token']) {
    die("CSRF attack detected");
} // not d-m-Y
$dueDate = $_POST['dueDate'] ?? '';
$date = date('d-m-Y');
if (!empty($dueDate) && $dueDate !== "None") {
    if ($dueDate == "None") {
        // skip
    } else if (strtotime(str_replace(" - ", "-", $dueDate)) < strtotime(str_replace(" - ", "-", $date))) {
        die("Invalid date");
    }
}

   $name = $patientName;
$treat = strtolower(trim($_POST['treat']));
$fid1 = $fid;
$advance = intval($_POST['advanceAmount']);///200
$online =intval($_POST['onlineAmount']);//200
$amt = intval($_POST['amt']);
$pr = $_POST['pr'];
$sbm = $_POST['sbm'];
$td1 = $_POST['tp'];
$admin_id = $_SESSION['admin_id'];

// if (!empty($dueDate) && $dueDate !== "None" && strtotime($dueDate) < strtotime($date)) {
//     die("Invalid due date");
// }
if (empty($treat)) {
    die("Invalid treatment");
}
if ($fid1 <= 0) {
    die("Invalid patient");
}$check = "SELECT sno FROM patient WHERE sno = ? AND admin_id = ?";
$stmt = mysqli_prepare($conn, $check);

mysqli_stmt_bind_param($stmt, "ii", $fid, $admin_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 0) {
    die("Unauthorized access");
}

mysqli_stmt_close($stmt);
  	$treatmentName = "Select treatment from treatment where treatment = ? and admin_id= ? and sno= ? and date =?";
  $query1        = mysqli_prepare($conn, $treatmentName);
mysqli_stmt_bind_param($query1, 'siis', $treat, $admin_id, $fid1,$date);
   mysqli_stmt_execute($query1);
 mysqli_stmt_store_result($query1);   // important

$treatCont41 = mysqli_stmt_num_rows($query1);
   mysqli_stmt_close($query1);
$treatQuery=0;
// $rowCount = 0;
	if(!empty($name))
     {
//  echo"<h1 style='background:white;'>test $treatCont41 </h1>";////
if (!empty($dueDate) && $dueDate !== "None"){
 ///echo"<h1 style='background:white;'> and  $fid1 </h1>";////
  if ($dueDate!=$date && $treatCont41===0) {
    # code...
    $insert = "INSERT INTO treatment 
(dueDate, date, treatment, advance, online, amount, sno, admin_id) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $smt= mysqli_prepare($conn, $insert);
 if ($smt) {
  # code...
  mysqli_stmt_bind_param($smt, "sssiiiii",
    $dueDate,
    $date,
    $treat,
    $advance,
    $online,
    $amt,
    $fid1,
    $admin_id
);
      mysqli_stmt_execute($smt);
    $treatQuery = mysqli_stmt_affected_rows($smt);

        mysqli_stmt_close($smt);
 }
  //  echo'hello';
   if($treatQuery>0)
    {
       $id_safe = urlencode($fid1);
$count_safe = urlencode($treatQuery);
        echo"<h3 style='position:absolute; top:0px; background:white; color:green;' id='treatExisted'>Treatment inserted successfully<br>
 <a href='TreatmentDetail.php?id=$id_safe&treatInserted=$count_safe'>Click here to view     </a>treatment  
        </h3>";    $_SESSION['token'] = bin2hex(random_bytes(32));
    $_SESSION['token_time'] = time();
 }
    // ✅ Correct place to refresh token



  }
      else if($treatCont41>0){
 
      $id_safe = urlencode($fid1);
$count_safe = urlencode($treatQuery);
        echo"<h3 style='position:absolute; top:0px; background:white; color:red;' id='treatExisted'>Treatment existed<br>
 <a href='TreatmentDetail.php?id=$id_safe&treatInserted=$count_safe'>Click here to view  </a>treatment 
        </h3>";
 }
      }
    
   else{
 if ($treatCont41==0) {
  # code...
  //  echo"<h1/ style='background:white;'>else part new $date</h1>";/////

  	$insert ="insert into treatment(date, treatment, advance, online, amount, sno, admin_id) values(?, ?, ?, ?, ?, ?, ?)";
	$smt1 =  mysqli_prepare($conn, $insert);
   if ($smt1) {
    # code...
      mysqli_stmt_bind_param($smt1, "ssiiiii",
    $date,
    $treat,
    $advance,
    $online,
    $amt,
    $fid1,
    $admin_id
    
);

  mysqli_stmt_execute($smt1);
  $rowCount = mysqli_stmt_affected_rows($smt1);
$id_safe = htmlspecialchars($fid1);
   $row_safe = htmlspecialchars($rowCount);
        mysqli_stmt_close($smt1);
        echo"<h3 style='position:absolute; top:0px; background:white; color:green;' id='treatExisted'>Treatment inserted successfully<br> <a href='TreatmentDetail.php?id=$id_safe&treatInserted=$row_safe'>Click here to view </a>treatment  </h3>";

   }
 
if (!$smt1) {
    echo "Prepare failed: ".mysqli_error($conn);
}
          // echo"<span class='errorMessage'/>Treatment /nserted".$rowCount."</span><br>";

}
else {
    $id_safe = htmlspecialchars($fid1, ENT_QUOTES, 'UTF-8');
    $row_safe = 0;
        echo"<h3 style='position:absolute; top:0px; background:white; color:red;' id='treatExisted'>Treatment existed<br>
 <a href='TreatmentDetail.php?id=$id_safe&treatInserted=$row_safe'>Click here to view  </a>treatment 
        </h3>";
}
 }
//    

}if ($rowCount > 0) {
   $_SESSION['token'] = bin2hex(random_bytes(32));
   $_SESSION['token_time'] = time();
}
}

    

?>

<script>
   let msg = document.getElementById("errorMessage1")
   let treatExisted = document.getElementById("treatExisted")
   let treat;
         
   function Submit() {
 let date2 = document.getElementById("date2")
 let dueDate = document.getElementById("dueDate")
 let dueDateInput = document.getElementById("dueDateInput")
     treat = document.getElementById("treat1").value 
 let  advance = document.getElementById("Advance") 
 let  online = document.getElementById("onlinePayment") 
 let cashReceived = document.getElementById("receivedAmount")
  let advan =  Number(advance.value) 
  let tot =  Number(cashReceived.value)
  let v   ="0";  
    if (!treat) {
      
      msg.innerHTML="Enter treatment"
      // alert("date is "+date)
          return false 
    }

    if (advance.value<0 || online.value<0) {
        
    alert("Enter positive number");
         return false;
    }
    if (tot<0) {
        alert("Enter valid number");
         return false;
    }
 if (isNaN(advan) || advance.value.trim() === "") {
    advance.value=0;
  // alert("Enter advance number");
    // return false;
}
 else{
         let date = new Date();
         let d = date.getDate()
         let mo = date.getMonth()+1
        let y = date.getFullYear()
        let toDate = ""
        toDate=d.toString()+" - "+mo.toString()+" - "+y
	date2.value=toDate;
  dueDateInput.value =dueDate.value;
  // alert("You came here "+dueDateInput.value)
//  return fals/e
  
    }
if (advan> 0 && tot==0) {
  
  cashReceived.value = advance.value
  // alert("cash is converted "+cashReceived.value)
  // return false
}

if (dueDate.value.length==0) {
  // alert("no due date And advance is "+dueDate.value)///
  dueDate.value="None"
  }
if (advance.value=="") {
     advance.value=0;
  //alert("no due date And advance is "+dueDate.value)///
  //return false
  
}
else{
  
  let x =dueDate.value.split("-").reverse().join(" - ")
  let date = x.slice(0, 7)
  let todayDate = Number(date2.value.slice(0, 2))
  let currentMonth = Number(date2.value.slice(4, 7))
  let due = Number(x.slice(0,2))
  let dueMonth = Number(x.slice(5,7))
  let dueYear = Number(x.slice(10,14))
  let currentYear =Number(date2.value.slice(9))// Change to 9

//  alert(advance) 
  if (todayDate>due && currentMonth==dueMonth) {
    alert("Sorry you entered wrong due date ")
    return false
    
  } 
    if (currentMonth>dueMonth && currentYear==dueYear) {
    alert("Sorry you entered wrong due month")
    return false
    
  }
  if (currentYear>dueYear && x.length!=0) {
    alert("Sorry you entered wrong due year ")
    return false
    
  }
  // else if
   if (Number(x.slice(0,2))<10 && Number(x.slice(5,8))<10) //date less than 10 and moth
    {    
        // alert("yes if part get ready date "+x.slice(1,2))
       date=date.replace(v, "")
      date=date.replace(v, "")+x.slice(x.lastIndexOf(" - "))
     dueDateInput.value=date//date
   }
   else if (x.slice(1, 2)==0 && Number(x.slice(5,8))<10) 
    { 
    
      x1 = x.split("-")
      x2 = x1[1]*1
      // if (x[1]=='0')
       {
        dueDateInput.value=x.slice(0, x.indexOf("-")+1)+" "+x2+" "+x.slice(x.lastIndexOf("-"))
      //alert("yes im 10")
       }  
     }
      else if (Number(x.slice(0, 2))>10 && Number(x.slice(5,8))<10) 
    {
       date=date.replace(v, "")+x.slice(x.lastIndexOf(" - "))

      dueDateInput.value=date//date
    // alert("now date is "+date)
    } 
      
    else if (Number(x.slice(5, 8))>=10) 
    {   
        if (Number(x.slice(0, 2))<10) {
       dueDateInput.value=x.replace(v, ""); 
      //  alert("you/ r else part get ready date<10 and mmont >=10 ")////
        }       
        else if (Number(x.slice(0, 2))>=10) { 

      dueDateInput.value=x
        }
       
    } 
}
            // alert('hi'/)
}

 window.oninput = (() => {
  msg.innerHTML = "";

  if (treatExisted) {
    treatExisted.innerHTML = "";
  }
});
</script>  
  </form>

</body>
</html>