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
 #treatment{
  position:relative;
  bottom  : 120px;
  left:     600px;
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
  let month =date.getMonth()+1
      today = date.getDate()+" - "+month+" - "+date.getFullYear()
  let dateId  = document.getElementById("dateId").value=today
    // alert('date '+dateId)/
   }
    </script>
    <div id="contain">
      <h1  style="text-align:center">Click download button and export</h1>
       <?php
      if (isset($_POST['p'])) {
       
            $getDate = $_POST["date"];    
            // $getDate2 =$getDate;
        $todayRecord ="SELECT * FROM patient  where patient.date ='$getDate' ";
        $dateQuery   = mysqli_query($conn, $todayRecord);
        $count    = mysqli_num_rows($dateQuery);
       $name;

        if ($count==0) {
            # code...
            echo"<h1 style='text-align:center'>No record for the day old code </h1>";
        }
        else{
         echo"<div id='allTable'>
         <table border='2' id='table1' cellpadding='5'>
              <tr>
                <br>
              </tr> 
               <tr>
                 <th colspan='4'>Patient Details</th>
              </tr>
               <tr>
                <th>Date</th>
                <th>Name</th>
              <th>Age</th>
             <th>Phone Number</th>
             </tr>";
          while( $fetch = mysqli_fetch_assoc($dateQuery))
          {//NOT HERE
            $name ="$fetch[sno]";
          echo"<tr>
            <th>$fetch[date]</th>
             <th>$fetch[name]</th>
             <th>$fetch[age]</th>
             <th>$fetch[phoNo]</th>
               </tr>";
          }
          echo"</table>";
              //  //here right/
              $primery ="SELECT  DISTINCT patient.sno, patient.name from patient 
                natural join treatment where patient.date='$getDate'";
                $joinedQuery = mysqli_query($conn, $primery);
                $tcount    = mysqli_num_rows($joinedQuery);

                echo"<table border='2' id='treatment' cellpadding='5'>
                <tr>
                <th colspan='5'>treatment Detail </th>
                </tr>";
               while ( $fetch0 = mysqli_fetch_assoc($joinedQuery)) {
                # code...             
              //  echo"<h1>id is   $fetch0[sno]</h1>";//`; /.
                $treatment ="select * from treatment where sno=$fetch0[sno]";
                $treatmenQuery = mysqli_query($conn, $treatment);


                $sum ="SELECT SUM(amount) as total from treatment where sno=$fetch0[sno]";
                $sumQuery = mysqli_query($conn, $sum);
                $fetchTotal =  mysqli_fetch_assoc($sumQuery);//
               echo"
                <tr>
                <th colspan='5'>$fetch0[name] </th>
                </tr>
                <tr>
                <th>Date</th>
                <th>Due Date</th>
                <th>Treatment</th>
                <th>Advance</th>
                <th>Amount</th>
                </tr>
                ";
               while ($treatmentDeatil = mysqli_fetch_assoc($treatmenQuery))
               {
              //   # code...
                echo"<tr>
                <td>$treatmentDeatil[date] </td>
                <td>$treatmentDeatil[dueDate] </td>
                <td>$treatmentDeatil[treatment] </td>
                <td style='text-align:center'>$treatmentDeatil[advance] </td>
                <td style='text-align:center'>$treatmentDeatil[amount] </td>
                </tr>
                ";}
              echo"<tr>
              <th colspan='4' style='text-align:left'>Total</th>
              <th id='dwTotalAmount'>$fetchTotal[total]</th>
              </tr>";
          
               
         }
       echo"
       </table>
       </div>";
        }
      }
       ?>
       <form action="#" id="fom"  method="POST">
    <div id="buttons" style="margin-top: 10px; margin-left:980px;">
      <input type="hidden" name="date" id="dateId">
      <button type="submit" name="p" >Download Today's Record</button>
    <button type="button" onclick="expotToExcel()">Export</button>


       </form>
    </div>
	<div id="result"></div>
<!-- download.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/downloadjs/1.4.8/download.min.js"></script>

   <script>
  function expotToExcel() {
  let table = document.getElementById("table1");
  let treatment = document.getElementById("treatment");
   let a =table.outerHTML+"<br>"+treatment.outerHTML;
   //alert(a)//
  download(a, `${today}.xls`,'application/vnd.ms-excel')
}

   </script>
   
</body>
</html>