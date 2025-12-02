<?php
include("../Connection/Connect.php");
error_reporting(0);
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
    padding-bottom: 25px;
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
       <form action="#" id="fom"  method="POST">
      <h1  style="text-align:center"> <?php
    //   if (isset()) {
       $dueId =$_POST['dueId'];
       $delete ="UPDATE treatment SET  dueDate='' WHERE tid=$dueId";
       $deleteQuery = mysqli_query($conn,$delete);
       if ($deleteQuery) {
         # code...
         echo"<script>
          window.location.href='./EditTreatment.php?tid=$dueId&      =true'
         </script>";
       }
       else{
         echo"Sorry my boy";
       }
    //    echo"The id ".$dueId//;
    //   /}
       ?></h1>
      
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

}

   </script>
   
</body>
</html>