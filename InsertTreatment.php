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
	 ul{
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
         top:75px;
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
     
     #errorMessage{
      position: relative;
      top:0px;
     }
     #del{
		position: absolute;
		top:-10px;
		left: 600px;
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
$fid =$_GET['id'];
$n   = "No name";
if (isset($fid)) {
  // echo"<h1>Testing with new code</h1>";
$patientName0 ="select name from patient where sno =$fid";
$nameQuery0   = mysqli_query($conn, $patientName0);
$queryName  =mysqli_fetch_assoc($nameQuery0);
 echo"<h1 id='del'>Treatment for  "."$queryName[name]"."</h1>";
}

?> 
   <ul style="padding-left:1050px;  background-color:lightblue; height: 40px;">
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientFom.html">Add Patient</a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByDate.php">Date</a></li>
        </ul>
        </li>
</ul>
  <div id="div1">
    <h1>Enter Treatmemt </h1>
    <h1> Enter due date </h1>
    <h1>Enter Advance Amount if any </h1>
    <h1>Enter total Amount </h1>
  </div>
  <form action="" onsubmit="return Submit()" method="POST">
    <textarea name="treat" id="treat1" class="treat"></textarea><br>
    <div class="errorMessage" id="errorMessage1"></div> <br>
   &nbsp; <input type="date" name="dueDate" id="dueDate">
   &nbsp; <input type="text" name="dueDate" id="dueDateInput" hidden>
    
    <br><br>
    <input type="text" name="advanceAmount" id="Advance" class="treat" ><br><br><br>
    <input type="number" name="amt" id="receivedAmount" class="treat" ><br>
  
    <input type="text" name="name" hidden id="pname"  value="<?php echo$name; ?>" class="treat">
    <input type="number" name="fid" hidden id="pname1"   value="<?php echo$fid; ?>" class="treat">
    <input type="hidden" name="pname" value=<?php echo $n;?>/>
    <input type="hidden" name="pr" value=<?php echo $_GET['patientRecord'];?>>
    <input type="hidden" name="tp" value=<?php echo $_GET['tp'];?>/>
    <input type="hidden" name="tp" value=<?php echo $_GET['tp'];?>/>
     <input type="hidden" name="sbm" value=<?php echo $_GET['sbm'];?>>
     <input type="text" name="date" id="date2"  hidden>
    <input type="submit" name="sub" id="sub" class="treat" ><br>
	<?php


 
if(isset($_POST['sub']))
{  
  
   $date = $_POST['date'];
   $dueDate = $_POST['dueDate'];
   $name = $_POST['name'];
$treat = $_POST['treat'];
$fid1 = $_POST['fid'];
$advance = $_POST['advanceAmount']; //200
$amt = $_POST['amt'];//totoal 1000 
$pr = $_POST['pr'];
$sbm = $_POST['sbm'];
$td1 = $_POST['tp'];

// echo"<h1 style='background:white;'>treat =  $treat</h1>";///
	$treatmentName = "Select treatment from treatment where treatment = '$treat' and sno=$fid1";
	$query1 =  mysqli_query($conn, $treatmentName);
	$treatCont   =  mysqli_num_rows($query1);
	$fetch =  mysqli_fetch_assoc($query1); 

 
  
	if(isset($name) && $treatCont==0) {
if ($dueDate!="" && $dueDate!=$date) {
    
	$insert ="insert into treatment(date, dueDate, treatment, advance, amount, sno) value('$date','$dueDate','$treat',$advance,$amt,$fid1)";
	$treatQuery =  mysqli_query($conn, $insert);
  //  echo'hello';
   if($treatQuery)
    {
       
        echo"<h3 style='position:absolute; top:0px; background:white; color:green;' id='treatExisted'>Treatment inserted successfully<br>hi <a href='TreatmentDetail.php?id=$fid1&treatInserted=$treatQuery'>Click here to view  </a>treatment 
        </h3>";

}

     
      }
      else{
	$insert ="insert into treatment(date, treatment, advance, amount, sno) value('$date', '$treat',$advance,$amt,$fid1)";
	$treatQuery =  mysqli_query($conn, $insert);
   
   if($treatQuery)
    {
          // echo"<span class='errorMessage'>Treatment /nserted".$dueDate."</span><br>";
        echo"<h3 style='position:absolute; top:0px; background:white; color:green;' id='treatExisted'>Treatment inserted successfully<br> <a href='TreatmentDetail.php?id=$fid1&treatInserted=$treatQuery'>Click here to view </a>treatment </h3>";

}

        // echo"<span class='errorMessage'>Treatment /nserted".$td."</span><br>";
      }

      }
if ($treatCont!=0) {
  # code...
  echo"<h3 style='position:absolute; top:0px; background:white; color:red;' id='treatExisted'>Sorry treatment for the patient already exis<a href='TreatmentDetail.php?id=$fid1&treatInserted=$treatQuery'>Click here to view </a></h3>";
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
 let cashReceived = document.getElementById("receivedAmount")
  let advan =  Number(advance.value) 
  let tot =  Number(cashReceived.value)
  let v   ="0";  
    if (!treat) {
      
      msg.innerHTML="Enter treatment"
      // alert("date is "+date)
          return false 
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
  // alert(""+dueDate.value.length)
//  return false
  
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
    //         alert("jw "+x)
      dueDateInput.value=x
        }
       
    } 
}
}
 // }
 window.oninput=(()=>{
  // alert("testion")
  msg.innerHTML="";
  treatExisted.innerHTML="";
 })
</script>  
  </form>

</body>
</html>