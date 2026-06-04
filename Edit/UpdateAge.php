<?php
include("Connection/Connect.php");

ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    header("Location: LogIn.php");
    exit();
}
if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['token'], $_POST['csrf_token'])) {
    die("Invalid CSRF token");
}

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

        if (!isset($_POST['id']) || !isset($_POST['newAge'])) {
            die("Invalid request");
        }
        $id = (int)$_POST['id'];// THIS IS IS SNO
       $newAge = (int)$_POST['newAge'];
        if ($newAge<=0 || $newAge>=120) {
            die("Change the age to a valid one");
        }

        $update ="update patient set age=? where sno=?";
            $stmt = mysqli_prepare($conn, $update);
            mysqli_stmt_bind_param($stmt, "ii", $newAge, $id);
            $query = mysqli_stmt_execute($stmt);
        // $query = mysqli_query($conn, $update);
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
   window.location.href=`../Edit.php?id=<?php echo$id;?>&newAge=true`;
        }, 5000);

        </script>
     </div>
    </div>
</body>
</html>