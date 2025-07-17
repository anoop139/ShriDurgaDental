<?php
include("../Connection/Connect.php");
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name Update Page</title>
    <style>
        #Main-div{
            border:2px solid black
        }
		 #Main-div{
            background:green;
        }
       
    </style>
</head>
<body>

    <div id="Main-div">
     <div style="text-align:center">
        <?php
        $id = $_POST['id'];
        $newName =$_POST['newName'];
		echo"ID  ".$id; 
		// echo"<br> New name is ".$newName; 
        

		$update ="update patient set name='$newName' where sno=$id";
        $query  = mysqli_query($conn, $update);
		if($query)
		{
			echo"<bh><h1>Updated successfully wait for few seconds</h1> ";
		}
		else{
			echo"<h1>Updating failed</h1>";
		}
        ?>

        <script>
      var up = setTimeout(() => {
       window.location.href=`../Edit.php?newName=<?php echo$id;?>`
        }, 5000);

        </script>
     </div>
    </div>
</body>
</html>