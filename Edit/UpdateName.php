<?php
include("../Connection/Connect.php");
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        $newName =$_GET['newName'];
		echo"ID  ".$oldName; 
		// echo"<br> New name is ".$newName; 
        

		$update ="update patient set name='$newName' where sno=$oldName";
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
    //   var up = setTimeout(() => {
    //    window.location.href=`../Edit.php?newName=<?php echo$oldName;?>`
    //     }, 5000);

        </script>
     </div>
    </div>
</body>
</html>