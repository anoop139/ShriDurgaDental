<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
     	#ul{
		padding-left: 1300px;
	}
    body{
            background-image: url("Images/SearchByDate.jpeg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
        }
        ul{
            padding-left:10px
        }
       ul ul li{
        background:white;
      }
        #dateInput
        {
            margin-left:800px;
            margin-top:0px ;
        }
        #inputAra{
            margin-top:4px;
            float: left;
        }
        #dateInput{
         /* margin-top:70px; */
        } 
        .disp{
            margin-left:400px;
        }
        .disp h1{
            text-align:center;
        }
        #err{
            color:red;
            position: relative;
            top:0px;
            left:-100px;
        }
        .disp{
            width: 800px;
            height: auto;
             background:white;
        }
        table{
         margin-left:40px ;
        }
        ul{
    
    padding-left: 0px;
     }
    </style>
    <title>Seach By Date</title>
<link rel="stylesheet" href="./Header2.css">
</head>
<body>
     <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>
   <ul style="background:white; height: 40px; padding-left:1010px; width:340px"  >
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientFom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            <li><a href="http://localhost:8081/Shri/SearchByNumber.php">Number</a></li><br>
    
        </ul>
        </li>
        </li>
</ul>
      <br><br>
<h1 id="inputAra">Seach by Date</h1>
<form id="dateInput" method="POST" onsubmit="return changeFomat()">
    <input type="date" name="Date0" id="date0">   
    <input type="hidden" name="Date" id="date">   
     <input type="submit" name="Sub"value="Click here"><br><br><br><br>
    <h1 id="err"></h1>

</form>
<div id="seeMsg" class="disp">
    <!-- <h1>hello</h1> -->
   		<?php
	if(isset($_POST['Sub']))

{    $date = $_POST['Date'];

if (!preg_match('/^\d{2} - \d{2} - \d{4}$/', $date)) {
    echo "Invalid date format";
    exit();
}
    echo"<h1>Patient record on ".$date."</h1><br>";
   

   $patientInfo = "SELECT * FROM patient WHERE date=?";
//    mysqli_prepare
	$query       = mysqli_prepare($conn, $patientInfo);
    mysqli_stmt_bind_param($query,  's', $date);
	
    mysqli_stmt_execute($query);
   $result = mysqli_stmt_get_result($query);   // important

$no = mysqli_num_rows($result);
   
	//    echo"<h1>Affected ".$no."</h1><br>";
	
	
	if($no>0)
	{
		
		echo" <table border='2'>
	 <tr cellpadding;4px>
	 <th style='padding:3px;'>Name</th>
	 <th style='padding:5px;'>Age</th>
	 <th style='padding:5px;'>Gender</th>
	 <th style='padding:5px;'>No. of treatment</th>
	 <th style='padding:5px;'>Treatment details</th>
	 <th style='padding:5px;'>Phone Number</th>
	 <th style='padding:5px;'>Edit</th>
	 </tr>";
      while($fetch =mysqli_fetch_assoc($result))
	  { 
        $id ="select * from treatment where sno=?";
        $query2 = mysqli_prepare($conn, $id);
        $idContain = $fetch['sno'];
        mysqli_stmt_bind_param($query2, 's', $idContain);
		mysqli_stmt_execute($query2);///
   $result2 = mysqli_stmt_get_result($query2);   // important
 $no2           = mysqli_num_rows($result2);   
      mysqli_stmt_close($query2);///

           		echo "<tr>
<td class='td' style='padding:7px'>".htmlspecialchars($fetch['name'])."</td>
<td style='text-align:center;' class='td'>".htmlspecialchars($fetch['age'])."</td>
<td style='text-align:center' class='td'>".htmlspecialchars($fetch['gen'])."</td>
<td style='text-align:center' class='td'><a id='Number' href='TreatmentDetail.php?id=".$fetch['sno']."'>$no2</a></td>
<td style='text-align:center; padding:7px' class='td'><a id='Number' href='InsertTreatment.php?id=".$fetch['sno']."&tp=True'>Click here to add treatment</a></td>
<td class='td' style='padding:7px'>".htmlspecialchars($fetch['phoNo'])."</td>
<td class='td' style='padding:7px'><a href='Edit.php?id=".$fetch['sno']."'>Edit</a></td>
</tr>";
	  }
       echo"</table><br>";
	}
	else
	{
		echo"<h1 >No recod found</h1>";
	}
mysqli_stmt_close($query);
}

?>
<script>
    let dateVal;
    let error = document.getElementById("err")
   
    function changeFomat() {
        dateVal = document.getElementById("date0").value
        dateVal2 = document.getElementById("date")
       let x;
       let v = "0"
        if (!dateVal) {
           error.innerHTML="Please choose a date";
            return false
            
        }
        else{ 
      
       x = dateVal.split("-").reverse().join(" - ")
    // let date = x.slice(//0,7)   
      dateVal2.value=x;
   }
 }
    window.oninput = ()=>{
        error.innerHTML="";
    }
    //  x = x.replace(v, "")
      //  dateVal2.value=x
</script>
</div>
</body>
</html>