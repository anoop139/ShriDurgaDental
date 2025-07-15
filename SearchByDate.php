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
    </style>
    <title>Seach By Date</title>
<link rel="stylesheet" href="./Header2.css?v=1">
</head>
<body>
     <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>
   <     <ul style="background:white; height: 40px; width:320px"  >
        <li><a href="DentalHomePage.html">Home </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientFom.html"> Add Patient </a></li>&nbsp;
        <li><a href="http://localhost:8081/Shri/PatientRecord.php">Patient List </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="http://localhost:8081/Shri/SearchByName.php">Name</a></li><br>
    
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

{    
	$date =  $_POST['Date'];
    echo"<h1>Patient recod on ".$date."</h1><br>";
   

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
	 <td style='text-align:center; padding:7px' class='td'><a id='Number' href='InsertTreatment.php?id=$fetch[sno]&tp=True'>Click here to add treatment</a></td>
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
    let date = x.slice(0,7)
    if (Number(x.slice(0,2))<10 && Number(x.slice(5,8))<10) //date less than 10 and moth
    {    
        // alert("yes if part get ready date "+x.slice(1,2))
       date=date.replace(v, "")
      date=date.replace(v, "")+x.slice(x.lastIndexOf(" - "))
     dateVal2.value=date//date

    }   
    else if (x.slice(1, 2)==0 && Number(x.slice(5,8))<10) 
    { 
    
      x1 = x.split("-")
      x2 = x1[1]*1
      //if (x[1]=='0')
       {
        dateVal2.value=x.slice(0, x.indexOf("-")+1)+" "+x2+" "+x.slice(x.lastIndexOf("-"))
    //   alert(dateVal2.value)/
       }  
      //
 
    }    
    else if (Number(x.slice(0, 2))>10 && Number(x.slice(5,8))<10) 
    {
       date=date.replace(v, "")
     date=date.replace(v, "")+x.slice(x.lastIndexOf(" - "))
      dateVal2.value=date//date
    // alert("you r else part get ready date "+Number(x.slice(0,2)))
    }   
else if (Number(x.slice(5, 8))>=10) 
    {   
        if (Number(x.slice(0, 2))<10) {
       dateVal2.value=x.replace(v, ""); 
    //    alert("you r else part get ready date<10 and mmont >=10 ")
        }       
        else if (Number(x.slice(0, 2))>=10) { 
            //  alert("you r else part get ready date>=10 and mmont >=10 ")
       dateVal2.value=x
        }
    } 
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