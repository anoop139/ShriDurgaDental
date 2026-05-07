<?php  //88–92% secure
include("Connection/Connect.php");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_set_cookie_params([
    'httponly' => true,
    'secure' => true,
    'samesite' => 'Strict'
]);
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])){
    header("Location: LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];

if (isset($_POST['p'])) {

    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        die("CSRF attack detected");
    }
// /if (empty($_SESSION['token'])) {
    // $_SESSION['token'] = bin2hex(random_bytes(32));
// }
    // your main logic here
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export to excel</title>
</head>
<style>
  #contain{
     border: 2px solid black;
     height: auto;
     width: 100%;
  }
   #contain{
    padding-left: 40px;
  }
  #buttons{
    position  : absolute;
    top       : auto; 
    left:       105px;
  }
  #table1{
    margin-bottom: 97px;
  }
 
 #TotalAmount{
  float: left;
 }
</style>
<body>
    <script>
      let today
   window.onload = ()=>{

  let date = new Date()
  let date1 =date.getDate()
  let month =date.getMonth()+1
  if (date1<10) {
    date1 = 0+date1.toString()
  }
  if (month<10) {
    month = 0+month.toString()
  }
      today = date1+" - "+month+" - "+date.getFullYear()
  let dateId  = document.getElementById("dateId").value=today
    // alert('date '+date1)///
   }
    </script>
    <div id="contain">
      <h1  style="text-align:center">Click download button and export</h1>
       <?php
      if (isset($_POST['p'])) {
         function safeExcel($value) {
    if (preg_match('/^[=+\-@]/', $value)) {
        return "'" . $value; // add single quote
    }
    return $value;
}
            $getDate = $_POST["date"];    
            // $getDate2 =$getDate;
if (!preg_match("/^\d{2} - \d{2} - \d{4}$/", $getDate)) {
    die("Invalid date format");
}
        $todayRecord ="SELECT * FROM patient  where patient.date =? AND patient.admin_id = ?";
        $stmt        = mysqli_prepare($conn,$todayRecord);
        if (!$stmt) {
    
        die("Query failed");
     
    }
        mysqli_stmt_bind_param($stmt, 'si', $getDate, $admin_id);
        // mysqli_stmt_execute($stmt);//_stmt
      
        if (!mysqli_stmt_execute($stmt)) {
         die("Execution failed");
         }
        $result = mysqli_stmt_get_result($stmt);
        $count    = mysqli_num_rows($result);
       $name;
        if ($count==0) {
              // echo"<h1>id "."$admin_id"."</h1>";
            # code...
            echo"<h1 style='text-align:center'>No record for the day</h1>";
        }
        else{
         echo"<table border='0'  id='allTable'>
         <tr>
         <td>
         <table border='2' id='table1' cellpadding='10'>
         <tr>
         </tr>
            <tr>
              <th colspan='4'>Patient Details</th>
             </tr>
              <tr>
                <th  class='td'>Date  </th>
                <th>Name</th>
              <th>Age</th>
             <th>Phone Number</th>
             </tr>";
            
          while( $fetch = mysqli_fetch_assoc($result))
          {//NOT HERE
            $name ="$fetch[sno]";
          echo"<tr>
            <td>".htmlspecialchars(safeExcel($fetch['date']), ENT_QUOTES, 'UTF-8')."</td>".
            "<td>".htmlspecialchars(safeExcel($fetch['name']), ENT_QUOTES, 'UTF-8')."</td>". 
            "<td>".htmlspecialchars(safeExcel($fetch['age']), ENT_QUOTES, 'UTF-8')."</td>" .
            "<td>".htmlspecialchars(safeExcel($fetch['phoNo']), ENT_QUOTES, 'UTF-8')."</td>". 
               "</tr>";
               
            }
           mysqli_stmt_close($stmt);
       
          echo"</table> <td></td>";   // <-- add space here
          echo"</td><td valign='top'>";

              //  //here right/
              $primery ="SELECT  DISTINCT patient.sno, patient.name from patient 
                 join treatment
                  on patient.sno = treatment.sno WHERE patient.date = ? AND patient.admin_id = ?";
                  $stmt1 = mysqli_prepare($conn, $primery);
                    if (!$stmt1) {
    
                   die("Query failed");
     
              }

                 mysqli_stmt_bind_param($stmt1, 'si', $getDate, $admin_id);
                //  mysqli_stmt_execute($stmt1);
                    if (!mysqli_stmt_execute($stmt1)) {
                      die("Execution failed");
                     }
                $tresult = mysqli_stmt_get_result($stmt1);
                // $joinedQuery = mysqli_query($conn, $primery);
               $tcount    = mysqli_num_rows($tresult);
                // echo"<h1 style='text-align:center'>count = $tcount </h1>";
                if ($tcount>0)
                 {
                echo" 
               <table border='2' id='treatment' cellpadding='6'>  
                <tr>
               </tr>
                <tr>
                <th colspan='6'>Treatment Detail </th>
                </tr>";   # code...             
              
                # code...
               
               while ( $fetch0 = mysqli_fetch_assoc($tresult)) {
              $id = (int)$fetch0['sno'];
                $treatment ="select * from treatment where sno=? and admin_id=?";
                 $stmt3 = mysqli_prepare($conn, $treatment);
                 if (!$stmt3) {
    
                   die("Query failed");
     
              }
                 mysqli_stmt_bind_param($stmt3, 'ii',  $id, $admin_id);
        if (!mysqli_stmt_execute($stmt3)) {
         die("Execution failed");
         }
                $tsum = mysqli_stmt_get_result($stmt3);

              $stmtSum = mysqli_prepare($conn, "SELECT SUM(amount) as total, SUM(online) as bank FROM treatment WHERE sno=? and admin_id=?");
              if (!$stmtSum) {
    
                   die("Query failed");
     
              }
       mysqli_stmt_bind_param($stmtSum, 'ii', $id, $admin_id);
       if (!mysqli_stmt_execute($stmtSum)) {
                die("Execution failed");
            }
          $sumResult = mysqli_stmt_get_result($stmtSum);
         $fetchTotal = mysqli_fetch_assoc($sumResult);

          $total1 = ($fetchTotal["total"] ?? 0) + ($fetchTotal["bank"] ?? 0);
               echo"
                <tr>".
                "<th colspan='6' style='text-align:center'>".htmlspecialchars(safeExcel($fetch0['name']), ENT_QUOTES, 'UTF-8')."</th>
                </tr>
                <tr>
                <th>Date</th>
                <th>Due Date</th>
                <th style='text-align:left; padding-left:10px'>Treatment</th>
                <th>Advance</th>
                <th>Online</th>
                <th>Amount</th>
                </tr>
                ";
               while ($treatmentDeatil = mysqli_fetch_assoc($tsum))
               {
                
                echo"<tr>
                <td>".htmlspecialchars(safeExcel($treatmentDeatil['date']), ENT_QUOTES, 'UTF-8')."</td>".
                "<td>".htmlspecialchars(safeExcel($treatmentDeatil['dueDate']), ENT_QUOTES, 'UTF-8')."</td>".
                "<td>".htmlspecialchars(safeExcel($treatmentDeatil['treatment']), ENT_QUOTES, 'UTF-8')."</td>".
                "<td style='text-align:center'>".htmlspecialchars(safeExcel($treatmentDeatil['advance']), ENT_QUOTES, 'UTF-8')."</td>".
                "<td style='text-align:center'>".htmlspecialchars(safeExcel($treatmentDeatil['online']), ENT_QUOTES, 'UTF-8')."</td>".
                "<td style='text-align:center'>".htmlspecialchars(safeExcel($treatmentDeatil['amount']), ENT_QUOTES, 'UTF-8')."</td>".
             "</tr>";
             }
              echo"<tr>
              <th colspan='5' style='text-align:left'>Total</th>".
              "<th id='dwTotalAmount'>".htmlspecialchars($total1)."</th>".
            "</tr>";
                mysqli_stmt_close($stmt3);
              mysqli_stmt_close($stmtSum);


              }
          
                 mysqli_stmt_close($stmt1);
         }
      echo "</table></td></tr></table>";

        }
      
        $_SESSION['token'] = bin2hex(random_bytes(32));
      }
       ?>
       <form action="#" id="fom"  method="POST">
    <div id="buttons" style="margin-top: 10px; margin-left:980px;">
      <input type="hidden" name="date" id="dateId">
      <button type="submit" name="p" >Download Today's Record</button>
      <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <button type="button" onclick="exportToExcel()">Export</button>


       </form>
    </div>
	<div id="result"></div>
<!-- download.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>

   <script>
  function exportToExcel() {
  let table = document.getElementById("allTable");
  // let treatment = document.getElementById("treatment");
   let a =table.outerHTML
   alert("All set to download")//
download(a, `${today}.xls`,'application/vnd.ms-excel')
}

   </script>
   
</body>
</html>