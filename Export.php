<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
  #contain{
     border: 2px solid black;
     /* height: 50px; */
     padding: 50px 50px;
  }
  #buttons{
    text-align:right
  }
   table tr th, td{
        padding: 5px;
      }
</style>
<body>
    <script>
   window.onload = ()=>{

  let date = new Date()
  let month =date.getMonth()+1
     let today = date.getDate()+" - "+month+" - "+date.getFullYear()
  let dateId  = document.getElementById("dateId").value=today
    // alert('date '+dateId)
   }
    </script>
    <div id="contain">
       <?php
        if (isset($_POST['p'])) {
            $getDate  = $_POST["date"];        
            $getDate2 =$getDate;
        $todayRecord ="SELECT * FROM patient where date = '$getDate'";
        $dateQuery   = mysqli_query($conn, $todayRecord);
        $count       = mysqli_num_rows($dateQuery);
        $html;//
        if ($count==0) {
            # code...
            echo"<h1>No record for the day </h1>";
        }
        else{
            $html="<center>;
           <table border='2'>
             <tr>
             <th>Date</th>
             <th>Name</th>
             <th>Age</th>
             <th>Phone Number</th>
             </tr>";
          while( $fetch = mysqli_fetch_assoc($dateQuery))
          {
            $html.=" <tr>
             <th>$fetch[date]</th>
             <th>$fetch[name]</th>
             <th>$fetch[age]</th>
             <th>$fetch[phoNo]</th>
             </tr>
            ";
          }
            $html."</table>";
            $html."</center>";
        }
  
       header("content-Type:application/vnd.ms-excel");
       header("content-disposition:attachment;filename=report.xls");
    }
       echo$html
       ?>
       
    </div>
	<!-- <h1>New file</h1> -->
 <form action="#" method="POST">
    <input type="hidden" name="date" id="dateId" value='test'>
     <div id="buttons">
        <button name="p">Export</button>

    </div>
    </form>
</body>
</html>