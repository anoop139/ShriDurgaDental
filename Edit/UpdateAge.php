<?php
include("../Connection/Connect.php");
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Age</title>
    <style>
        #Main-div{
            border:2px solid black;
            height: 100px;
        }
		#sub-div{
            position: relative;
            top: 30px;
        }
       
    </style>
</head>
<body>

    <div id="Main-div">
     <div style="text-align:center" id="sub-div">
        <?php
        $oldAge = $_GET['oldName'];// THIS IS IS SNO
        $newAge = $_GET['newAge'];
        $update ="update patient set age=$newAge where sno=$oldAge";
        $query = mysqli_query($conn, $update);
        if ($query) {
            # code...
            echo"<h1>Age updated successfully wait for few seconds </h1>";
        }
        else{
            echo"<h1>Updation failed</h1>";
        }

        // echo"id is ".$oldAge."<br>";
        // echo"And the new age is ".$newAge;
        ?>

        <script>
      var up = setTimeout(() => {
   window.location.href=`../Edit.php?newName=<?php echo$oldAge;?>`
        }, 5000);

        </script>
     </div>
    </div>
</body>
</html>