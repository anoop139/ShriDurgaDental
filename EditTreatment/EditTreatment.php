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
       ul li ul li{
        background-color:lightblue;
       }
       #main{
            border: 2px solid black;
            padding-bottom: 200px; 
            background:white
        }   
        #main{
            padding-top:100px;
            padding-left:20px;
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
            left:       400px;
            background:white;
            font-weight:bold;
            font-size:2em;
        }
        #message{
            transition:transform, 3s 
        }
     table tr th, td{
        padding: 7px;
     }
     #clearBtn{
        position: relative;
         top: auto;
         left: 20px;
     }
    </style>
    <title>Edit Page</title>
</head>
<body>
<div id="header">

                <ul style="background:lightblue; height: 40px; width:340px; padding-left:1000px"  >
        <li><a href="../DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientFom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByDate.php">Date</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByNumber.php">Number</a></li><br>
    
        </ul>
        </li>
        </li>
</ul
    </div>
    <div id="main">
        <table border="2" cellpadding="10" id="table"style="text-align:center">
            <tr>
            <th>Due date</th>
            <th>Edit due date</th>
            <th>Treatment name</th>
            <th>Edit Treatment name</th>
            <th>Advance Amount</th>
            <th>Edit Advance Amount</th>
            <th>Online Amount</th>
            <th>Edit Online Amount</th>
            <th>Amount</th>
            <th>Edit Amount</th>
            </tr>
            <?php
              $treatId = $_GET['tid'];              
              $try =  $_GET['tid'];

              $selectTreat = "select *from treatment where tid =$treatId";
              $treatQuery  = mysqli_query($conn, $selectTreat);
              while ($fetch = mysqli_fetch_assoc($treatQuery)) {
                    echo"<tr>
                     <td>".htmlspecialchars(date('d-m-Y', strtotime($fetch['dueDate'])))."</td>
                  <td><a href='DueDate.php?id=$treatId'>Click here to edit or add due date</a></td>
                  <td>$fetch[treatment]</td>
                  <td><a href='Treatment.php?id=$treatId'>Click here to edit treatment</a></td>
                 <td>$fetch[advance]</td>
                        <td><a href='AdvanceAmount.php?id=$treatId'>Click here to edit advance amount</a></td>
                                         <td>$fetch[online]</td>
<td><a href='Online.php?id=$treatId'>Click here to edit Online amount</a></td>
                 <td>$fetch[amount]</td>

                <td><a href='Amount.php?id=$treatId'>Click here to edit amount</a></td>
              </tr>";
              }
         
            
            ?>
            <h1></h1>
            <span id="message">
                <?php
                if (isset($_GET['updateDueDate'])) {
                    # code...
                    echo"Due date updated successfully";
                }
                  if (isset($_GET['updateTreatment'])) {
                    # code...
                    echo"Treatment updated successfully";
                }
                if (isset($_GET['updateAmount'])) {
                    # code...
                    echo"Amount updated successfully";
                }
                
                if (isset($_GET['updatAdvance'])) {
                    # code...
                    echo"Advance amount updated successfully";
                }
                
                     if (isset($_GET['deletedDue'])) {
                    # code...
                    echo"Deleted Due date successfully";
                }
                ?>
            </span>
        </table>
        </form>
        <form action="clearDate.php" method="POST" name="clearDate" id="clearBtn"> 
        <input type="hidden" name="dueId" value="<?php echo"$treatId";?>">
    <input type="submit" value="Clear here to clear date">
            </form>
        
    </div>
    <script>
    onload =()=>{
        document.getElementById("message").style.transform="translateY(100px)";
        setTimeout(() => {
        document.getElementById("message").style.transform="translateY(-40px)";
            
        }, 5000);
    }
   onsubmit =()=>{
   let table = document.getElementById("table")
   const date=table.rows[1].cells[0].innerText.trim();
   if (date.length>0) 
    {
      result =confirm('Are you sure you want to delete due date ? ')
   }
   else{
    alert('No due date to be deleted')
        return false
   }

    }
//    return false
   //}
    </script> 



</body>
</html>