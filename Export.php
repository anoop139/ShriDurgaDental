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
    position:absolute;
    top     :  10px;
    left:      300px;
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
        $todayRecord ="SELECT * FROM patient where date = '6 - 11 - 2025'";
        $dateQuery   = mysqli_query($conn, $todayRecord);
        $count    = mysqli_num_rows($dateQuery);
        $html;//
        if ($count==0) {
            # code...
            echo"<h1 style='text-align:center'>No record for the day </h1>";
        }
        else{
         $html="
            <table border='2' style='margin-left:120px' id='table1'>
              <tr>
              <td></td>
              <th colspan='4'>Patient details</th>
             </tr>
               <tr>
               <td></td>z
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
               </tr>
            ";
          }
        echo$html;//;/

       // //  echo'hello';
        //  exit;
        }
  
  
      }
     
       ?>
    </div>
	<!-- <h1>New file</h1> -->
 <form action="#"  method="POST">
    <input type="hidden" name="date" id="dateId" value='test'>
     <div id="buttons">
        <input type="submit" name='p' value="Download">
        <button  onclick="expotToExcel()">Today's record</button>

    </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
   <script>
   function expotToExcel()
   {
    let table = document.getElementById("table1");
    let fp   = XLSX.utils.table_to_book(table, {sheet:'sheet1'})
    XLSX.write(fp, {
      bookType:"xlsx",
      type    :"base64"
    })
    XLSX.writeFile(fp, 'test.xlsx')
    alert("test the ")
   } 
   </script>
</body>
</html>