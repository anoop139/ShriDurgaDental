<?php
include("../Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="../Header2.css">
    <style>
       
       body {
        background: grey
       }
       #main{
            border: 2px solid black;
            padding: 200px; 
            background:white
        }   
        #main{
            padding-top:100px;
            padding-left:400px;
        }
           #main{
            margin-top:20px ; 
        }
        .num{
            padding-left:10px ;
        }
        #message{
            position: absolute;
            top:      -40px;
            background:white;
            font-weight:bold;
            font-size:2em;
        }
        #message{
            transition:transform, 3s 
        }
     table tr th, td{
        padding: 5px;
     }
    </style>
    <title>Edit Page</title>
</head>
<body>
<div id="header">

           <ul style="background:lightblue; height: 40px; width:320px"  >
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientFom.html"> Add Patient </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientRecord.php">Patient List </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
    
        </ul>
        </li>
        </li>
</ul>

    </div>
    <div id="main">
        <table border="2" cellpadding="5px" style='text-align:center'>
            <tr>
            <th>Treatment name</th>
            <th>Edit Treatment name</th>
            <th>Amount</th>
            <th>Edit Amount</th>
            </tr>
            <?php
              $treatId = $_GET['tid'];
              $selectTreat = "select *from treatment where tid =$treatId";
              $treatQuery  = mysqli_query($conn, $selectTreat);
              while ($fetch = mysqli_fetch_assoc($treatQuery)) {
                    echo"<tr>
                  <td>$fetch[treatment]</td>
                  <td><a href='Treatment.php?id=$treatId' class='num'>Click here to edit treatment</a></td>
                 <td>$fetch[amount]</td>
                <td><a href='Amount.php?id=$treatId'>Click here to edit amount</a></td>
              </tr>";
              }
         
            
            ?>
            <span id="message">
                <?php
                if (isset($_GET['updateTreatment'])) {
                    # code...
                    echo"Treatment updated successfully";
                }
                if (isset($_GET['updateAmount'])) {
                    # code...
                    echo"Amount updated successfully";
                }
                
                ?>
            </span>
        </table>
    </div>
    <script>
    onload =()=>{
        document.getElementById("message").style.transform="translateY(100px)";
        setTimeout(() => {
        document.getElementById("message").style.transform="translateY(-40px)";
            
        }, 5000);
    }

    </script>
</body>
</html>