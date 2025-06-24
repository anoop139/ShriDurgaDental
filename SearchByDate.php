<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
     	#ul{
		padding-left: 1300px;
	}
    body{
            background-image: url("Images/SearchByDate.jpeg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
        }
        ul ul li a{
            background-color: white;
        }
        #dateInput
        {
            margin-left:800px;
            margin-top:0px ;
        }
        #inputAra{
            margin-top:30px;
            float: left;
        }
        #dateInput{
         margin-top:70px;
        } 
    </style>
    <title>Document</title>
<link rel="stylesheet" href="./Header.css">
</head>
<body>
     <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>
   <!-- <di> -->
    <!-- <div id///="ul" style="background-color: white; height: 40px;"> -->
       <ul style=" padding-left:1200px; background-color: white; height: 40px;">
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="PatientFom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul style="">
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            
        </ul>
        </li>
      </ul>
   <!-- </div> -->
   <!-- </di> -->
<h1 id="inputAra">Seach by Date</h1>
<form id="dateInput">
    <input type="date" name="" id="">
    <input type="submit" value="Click here">
</form>
</body>
</html>