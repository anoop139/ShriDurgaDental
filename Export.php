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
 
</style>
<body>
    <script>
   window.onload = ()=>{

  let date = new Date()
  let month =date.getMonth()+1
     let today = date.getDate()+" - "+month+" - "+date.getFullYear()
  let dateId  = document.getElementById("dateId").value=today
    // alert('date '+dateId)/
   }
    </script>
    <div id="contain">
       <?php
      if (isset($_POST['p'])) {
       
            $getDate = $_POST["date"];    
            // $getDate2 =$getDate;
        $todayRecord ="SELECT * FROM patient where date ='$getDate'";
        $dateQuery   = mysqli_query($conn, $todayRecord);
        $count    = mysqli_num_rows($dateQuery);
        $html;//
        if ($count==0) {
            # code...
            echo"<h1 style='text-align:center'>No record for the day </h1>";
        }
        else{
         $html="<center>
            <table border='2' style='margin-left:120px' id='table1'>
              <tr>
              
              <th colspan='6' style='text-align:center'>Patient details</th>
             </tr>
               <tr>
               <td></td>
                <th>Date</th>
                <th>Name</th>
              <th>Age</th>
             <th>Phone Number</th>
             </tr>";
          while( $fetch = mysqli_fetch_assoc($dateQuery))
          {
            $html.="<tr>
            <td></td>

             <th>$fetch[date]</th>
             <th>$fetch[name]</th>
             <th>$fetch[age]</th>
             <th>$fetch[phoNo]</th>
               </tr>";
          }
          $html.="</table>
                  </center>";
        echo$html;//;/

       // //  echo'hello';
        //  exit;
        }
  
  
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

 
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
   <script>
  function expotToExcel() {
  let table = document.getElementById("table1");
 let  html  = table.outerHTML;
 window.open("data:application/vnd.ms-excel,"+encodeURIComponent(html))
}

   </script>
   
</body>
</html>