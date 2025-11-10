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
     height: 145px;
     width: 100%;
  }
  #buttons{
    position  : relative;
    top       : 128px;
    left:       105px;
  }
 #treatment{
  position: relative;
  left: 350px;
  bottom: 80px;
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
       <?php
      if (isset($_POST['p'])) {
       
            $getDate = $_POST["date"];    
            // $getDate2 =$getDate;
        $todayRecord ="SELECT * FROM patient join treatment
        on patient.sno = treatment.sno where patient.date ='$getDate' ";
        $dateQuery   = mysqli_query($conn, $todayRecord);
        $count    = mysqli_num_rows($dateQuery);
        $html;//
        if ($count==0) {
            # code...
            echo"<h1 style='text-align:center'>No record for the day </h1>";
        }
        else{
         $html="<div id='div1'>
            <table border='2' id='table1'>
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
          {
            $html.="<tr>
            <th>$fetch[date]</th>
             <th>$fetch[name]</th>
             <th>$fetch[age]</th>
             <th>$fetch[phoNo]</th>
               </tr>";
          }
          $html.="</table>
                  </div>";
        echo$html;//;/
   
       // //  echo'hello';
        //  exit;
        }
  
       echo'<table id="treatment" border="2">
       <tr>
       <th colspan="4">Treatment Details</th>
       </tr>
       <tr>

       </tr>
       </table>';
      }
     
       ?>
       <form action="#" id="fom"  method="POST">
    <div id="buttons" style="margin-top: 20px; margin-left:900px;">
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
   let a =table.outerHTML + "  " + treatment.outerHTML;
  download(a, `${today}.xls`,'application/vnd.ms-excel')
}

   </script>
   
</body>
</html>