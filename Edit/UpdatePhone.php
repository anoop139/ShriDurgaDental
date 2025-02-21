<?php
include("../Connection/Connect.php");
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Updating Phone number</title>
    <style>
        #Main-div{
            border:2px solid black
        }
		
       
    </style>
</head>
<body>

    <div id="Main-div">
     <div style="text-align:center">
        <?php
        $oldName = $_GET['oldName'];
        $newPhone =$_GET['newPhone'];
		// echo"ID  ".$oldPhone; 
		// echo"<br> New name is ".$newPhone; 
		$update ="update patient set phoNo='$newPhone' where sno=$oldName";
        $query1  = mysqli_query($conn, $update);
		if($query1)
		{
			echo"<br><h1>Updated successfully wait for few seconds</h1> ";
		}
		else{
			echo"<h1>Updating failed</h1>";
		}
        ?>

        <script>
      var up = setTimeout(() => {
       window.location.href=`../Edit.php?newName=<?php echo$oldName;?>`
        }, 5000);

        </script>
     </div>
    </div>
</body>
</html>