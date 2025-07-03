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
        ul ul li a{
            background-color: white;
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
            top:-10px;
        }
        .disp{
            width: 800px;
            height: auto;
             background:white;
        }
        table{
         margin-left:40px ;
        }
    </style>
    <title>Seach By Date</title>
<link rel="stylesheet" href="./Header.css?v=3">
</head>
<body>
     <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>
   <!-- <di> -->
    <!-- <div id///="ul" style="background-color: white; height: 40px;"> -->
       <ul style="padding-left:980px; background-color: white; height: 40px;" id="ul">
        <!-- <h1>hello</h1> -->
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="PatientFom.html">Add Patient </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="">Search by</a>
        <ul style="">
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
            
        </ul>
        </li>
      </ul>
      <br><br>
<h1 id="inputAra">Seach by Date</h1>
<form id="dateInput" method="POST" onsubmit="return changeFomat()">
    <input type="date" name="Date0" id="date0">   
    <input type="hidden" name="Date" id="date">   
     <input type="submit" name="Sub"value="Click here">
    <h1 id="err"></h1>

</form>
<div id="seeMsg" class="disp">
    <!-- <h1>hello</h1> -->
   		<?php
	if(isset($_POST['Sub']))

{    
	$date =  $_POST['Date'];
    echo"<h1>Patient recod for ".$date."</h1>";
   

   $patientInfo = "SELECT * FROM patient WHERE date= '$date'";

	$query       = mysqli_query($conn, $patientInfo);
	$no           = mysqli_num_rows($query);
	 
	
	
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
      while($fetch =mysqli_fetch_assoc($query))
	  { 
        $id ="select * from treatment where sno=$fetch[sno]";
		$query2       = mysqli_query($conn, $id);
	    $no2           = mysqli_num_rows($query2);   
		 ///  echo"hi $fetch[sno]";
           		echo"<tr>
		  <td class='td' style='padding:7px'>$fetch[name]</td>
	 <td style='text-align:center;' class='td'>$fetch[age]</td>
	 <td style='text-align:center' class='td'>$fetch[gen]</td>
	 <td style='text-align:center' class='td'><a id='Number' href='TreatmentDetail.php?id=$fetch[sno]'>$no2</a></td>
	 <td style='text-align:center; padding:7px' class='td'><a id='Number' href='InsertTreatment.php?id=$fetch[sno]&sbm=True'>Click here to add treatment</a></td>
	 <td class='td'style='padding:7px'>$fetch[phoNo]</td>
	 <td class='td'style='padding:7px'><a href='Edit.php?id=$fetch[sno]'>Edit</a></td>
	 </tr>";		  
	  }
       echo"</table><br>";
	}
	else
	{
		echo"<h1 >No recod found</h1>";
	}

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
    let z = x.slice(1, x.length)
      if (x.charAt(0)=="0") {
        z = z.replace(v, "")
        dateVal2.value=z
        
         
      }
      else{
        x = x.replace(v, "")
        dateVal2.value=x
      }
        }
        
    }
    window.oninput = ()=>{
        error.innerHTML="";
    }
</script>
</div>
</body>
</html>