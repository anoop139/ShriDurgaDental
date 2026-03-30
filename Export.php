<?php
include("Connection/Connect.php");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
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
    $_SESSION['token'] = bin2hex(random_bytes(32));
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
        mysqli_stmt_bind_param($stmt, 'si', $getDate, $admin_id);
        mysqli_stmt_execute($stmt);//_stmt
        $result = mysqli_stmt_get_result($stmt);
        $count    = mysqli_num_rows($result);
       $name;
mysqli_stmt_close($stmt);
        if ($count==0) {
              echo"<h1>id "."$admin_id"."</h1>";
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
          echo"</table> <td></td>";   // <-- add space here
          echo"</td><td valign='top'>";

              //  //here right/
              $primery ="SELECT  DISTINCT patient.sno, patient.name from patient 
                 join treatment
                  on patient.sno = treatment.sno WHERE patient.date = ? AND patient.admin_id = ?";
                  $stmt1 = mysqli_prepare($conn, $primery);

                 mysqli_stmt_bind_param($stmt1, 'si', $getDate, $admin_id);
                 mysqli_stmt_execute($stmt1);
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
                $treatment ="select * from treatment where sno=?";
                 $stmt3 = mysqli_prepare($conn, $treatment);
                 mysqli_stmt_bind_param($stmt3, 'i',  $id);
              mysqli_stmt_execute($stmt3);
                $tsum = mysqli_stmt_get_result($stmt3);

              $stmtSum = mysqli_prepare($conn, "SELECT SUM(amount) as total FROM treatment WHERE sno=?");
mysqli_stmt_bind_param($stmtSum, 'i', $id);
mysqli_stmt_execute($stmtSum);
$sumResult = mysqli_stmt_get_result($stmtSum);
$fetchTotal = mysqli_fetch_assoc($sumResult);

$stmtOnline = mysqli_prepare($conn, "SELECT SUM(online) as bank FROM treatment WHERE sno=?");
mysqli_stmt_bind_param($stmtOnline, 'i', $id);
mysqli_stmt_execute($stmtOnline);
$onlineResult = mysqli_stmt_get_result($stmtOnline);
$onlineTotal = mysqli_fetch_assoc($onlineResult);
          $total1 = ($fetchTotal["total"] ?? 0) + ($onlineTotal["bank"] ?? 0);
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
              }
          
               
         }
      echo "</table></td></tr></table>";

        }
      }
       ?>
       <form action="#" id="fom"  method="POST">
    <div id="buttons" style="margin-top: 10px; margin-left:980px;">
      <input type="hidden" name="date" id="dateId">
      <button type="submit" name="p" >Download Today's Record</button>
      <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <button type="button" onclick="expotToExcel()">Export</button>


       </form>
    </div>
	<div id="result"></div>
<!-- download.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>

   <script>
  function expotToExcel() {
  let table = document.getElementById("allTable");
  // let treatment = document.getElementById("treatment");
   let a =table.outerHTML
   alert("All set to download")//
download(a, `${today}.xls`,'application/vnd.ms-excel')
}

   </script>
   
</body>
</html>