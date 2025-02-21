<?php
include("Connection/Connect.php");
error_reporting(0);
?>
<style>
 
    #output{
       
        border: 2px solid black;
      // height: 200px; 
      // width: 400px;
      //padding-top:40px;   
    }
    #output{
     background-color:white;
    }
	#output button{
    margin-left:350px
    }
    #output{
       padding-top:0px
    }
    // #output{
        // position: absolute;
        // top: 50px;
        // left: 400px;
    // }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Page</title>
    <style>
        body{
            background-image:url("Images/professional-dentist-tools-dental-office_1204-235.jpg");
            background-repeat: no-repeat;
            background-size:cover
        }
     #result{
        border: 2px solid black; 
        padding: 200px;
     }
      #fomDiv{
        /* padding-left:890px ; */
        text-align:right;
     }
    #form1{
        float: left;
     }

    
     .btn {
        padding-right: 30px;
        background-color:black;
        color:white;
        font-size: 20px;
        /* padding-right:30px ; */
     }
    

    </style>
</head>
<body>
<div>

<div id="output" style="display:none">
<?php
//echo"<style>#output{background-color:white; text-align:center;}</style><h1 style='color:red; padding-top:0px' >Insetion failed</h1>";
$name   = $_POST['name'];
$age    = $_POST['age'];
$gen    = $_POST['gen'];
$pho    = $_POST['pho'];
  
	
	$insert = "insert into patient(date, name, age, gen, phoNo) 
	values('$date','$name',$age, '$gen', '$pho')";
  $query = mysqli_query($conn, $insert);
	if($query)
	{
	echo"<style>#output{background-color:white; text-align:center;}</style><h1 style='color:green; padding-top:0px' >Inseted succesfully $name</h1>";
		

	}
	else
	{
    echo"<style>#output{background-color:white; text-align:center;}</style><h1 style='color:red; padding-top:0px' >Insetion failed new $name </h1>".mysqli_connect_error();
	}
       	

?>
</div>

</div>
     <script>

        function show() {
            document.getElementById("output").style.display="block";
			
        }
        window.onload=show
     </script>
    <div id="result">
    </div>
    <div id="fomDiv">
    <form action="Fom.html" id="form1">
    
        <input type="submit" value="Back" class="btn">&nbsp;
		
    </form>

    <form action="Display.php" method="post" >
        <input type="submit" value="Next" class="btn">
    </form>

    </div>
</body>
</html>