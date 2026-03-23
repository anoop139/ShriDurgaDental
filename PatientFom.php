<?php
//hi
session_start();

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The form</title>

    <style>
	    
        body{
            background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2ZPZEsAvUt48PqhFubhzvfcaxOPzVzKPcEg&s");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
        }
  	 ul ul li{
      background-color: black;
     }
		 ul li a{
		  color:white;
		}
    .mobErr{
      color: red;
    }
    </style>
	<link rel="stylesheet" href="Header.css">
  <link rel="stylesheet" href="./FormStyle.css">
   
</head>
<body id="body1">
           <!-- <di> -->
    <!-- <div id///="ul" style="background-color: white; height: 40px;"> -->
       <ul style="padding-left: 1050px; background-color:black; height: 40px; width: 280px;">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">number</a></li><br>
        </ul>
        </li>
      </ul>
   <!-- </div> -->
   <!-- </di> -->
 <div id="formEle">
    <h1> Enter Name         :  </h1>
    <h1> Enter Age          : </h1>
    <h1> Enter Gender       : </h1>
    <h1>Enter Mobile Number :</h1>
    <!-- <h1>Enter Date          :</h1> 
    <h1>Enter Amount        :</h1>-->
 </div>
 
 <div id="formInput">
    <form action="InsertPatientRecord.php" method="POST" onsubmit="return insert()">    
    <input type="text" name="name" id="name0" class="error" required><br> 
    <span class="mobErr" id="nameErr"></span><br><br>
    <input type="number" name="age" id="age" required><br>
	   <span class="mobErr" id="errInfo1"></span><br><br><br>
    <input type="radio" name="gen" id="Male" value="Male" required><span class="span" name="Male">Male</span>
  <input type="radio" name="gen" id="Female" value="Female" required>Female<br><br><br>
    <input type="text" name="pho" id="pho" required><br>
    <span class="mobErr" id="errInfo"></span><br><br>
    <!-- <input type="text" name="gen" id="value" value="no" hidden><br><br><br> -->
  <input type="hidden" name="date" value="<?php echo date('d-m-Y'); ?>"><br><br><br>
     <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <input type="submit" value="Submit" id="Submit">
   </form>
 </div>
 <script src="./FomValidation.js?v=3"></script>

</div>
</div>
</body>
</html>		