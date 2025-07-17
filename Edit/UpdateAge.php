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
            /* border:2px solid black; */
            height: 100px;
        }
		#sub-div{
            position: relative;
            top: 0px;
        }
      body {
    background-color: #f0f4f8; /* soft light blue/grey */
}


    </style>
</head>
<body>

    <div id="Main-div">
     <div style="text-align:center" id="sub-div">
        <?php
        $id = $_POST['id'];// THIS IS IS SNO
        $newAge = $_POST['newAge'];
        $update ="update patient set age=$newAge where sno=$id";
        $query = mysqli_query($conn, $update);
        if ($query) {
            # code...
            echo"<h1>Age updated successfully wait for few seconds </h1>";
        }
        else{
            echo"<h1>Updation failed as id is $id</h1>";
        }

        // echo"id is ".$oldAge."<br>";
        // echo"And the new age is ".$newAge;
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