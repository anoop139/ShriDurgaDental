<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<style>
 
    #output{
       
        border: 2px solid black;
      /* // height: 200px; 
      // width: 400px;
      //padding-top:40px;*/   
    } 
    #output{
     background-color:white;
    }
	#output button{
    margin-left:350px
    }
    #output{
       padding-top:0px
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Page</title>
    <style>
        body{
            background-image:url("Images/professional-dentist-tools-dental-office_1204-235.jpg");
            background-repeat: no-repeat;
            background-size:cover
        }
        #output{
        background:white;
        padding-left: 5px;
        text-align:center;
     }
     #output{
       width: auto;
       height: 40px;
       margin-left: 100px;

     }
     #blank{
        border: 2px solid black; 
        padding: 200px;
     }
     
    #back{
        float: left;
     }
  #next{
        
    text-align:right
     }

    
     .btn {
        padding-right: 30px;
        background-color:black;
        color:white;
        font-size: 20px;
        /* padding-right:30px ; */
     }


    </style>
</head>
<body>
    <div id="output">
 <?php
  $date = $_POST['date'];
  $name = $_POST['name'];
  $age = $_POST['age'];
  $gender = $_POST['gen'];
  $phone = $_POST['pho'];
  // echo"<h1>Age = $date</h1>";
$fetch = "select sno, name,  phoNo from  patient where phoNo='$phone'";
$fetchQuery   = mysqli_query($conn, $fetch);
$num   = mysqli_num_rows($fetchQuery);
$queryId = mysqli_fetch_assoc($fetchQuery);
// echo"$queryId[sno]";
if ($num>0) {
   echo"<h1 style='color:red; margin-top:100px'>$queryId[name]'s recod exists, to add treatment
    <a href='./InsertTreatment.php?id=$queryId[sno]&tp=True' >Click here  </a> 
    </h1>".mysqli_connect_error();
    echo"<h1>OR</h1>";
       echo"<h1 style='color:red; margin-top:100px'>to view treatment details
    <a href='./TreatmentDetail.php?id=$queryId[sno]&tp=True' >Click here  </a> 
    </h1>".mysqli_connect_error();
}
else{
 
$insert ="insert into patient(date, name, age, gen, phoNo) values('$date','$name', $age, '$gender', '$phone' )";
$insertQuery = mysqli_query($conn, $insert);

if ($insertQuery) {
    # code...
    echo"<h1 style='margin-top:0px; margin-left:50px; color:green'>Record inserted successfully</h1>";
}
}

//    echo"<h1 style='color:red; margin-top:100px'>As phone number or the patient record exists, to add treatment
//     <a href='./InsertTreatment.php?id=$queryId[sno]&tp=True' >Click here  </a> 
//     </h1>".mysqli_connect_error();
?>

</div>
<div id="blank">
  </div>
  <form action="./PatientFom.html" id="back">
    <input type="submit" value="Back" class="btn">
  </form>
  <form action="./PatientRecord.php" id="next">
    <input type="submit" value="Next" class="btn">
  </form>
</html>