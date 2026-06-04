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
$admin_id = $_SESSION['admin_id'];
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

        if (!isset($_POST['id']) || !isset($_POST['newName'])) {
            die("Invalid request");
        }
        $id = (int)$_POST['id'];// THIS IS IS SNO
        if ($id <= 0) {
    die("Invalid ID");
    }
 $newName = trim($_POST['newName']);
     
 if ($newName === '') {
    die("Name cannot be empty");
    }

     if (strlen($newName) > 100) {
        die("Name too long");
       }

        $update ="update patient set name=? where sno=? and admin_id=?";
            $stmt = mysqli_prepare($conn, $update);
            if (!$stmt) {
    die("Database error");
}
            mysqli_stmt_bind_param($stmt, "sii", $newName, $id, $admin_id);
            $query = mysqli_stmt_execute($stmt);
    
     if ($query && mysqli_stmt_affected_rows($stmt) > 0) {
      echo "<h1>Name updated successfully wait for few seconds...</h1>";
   }
        else{
            echo"<h1>Updation failed as id is $id</h1>";
        }
    mysqli_stmt_close($stmt);
$_SESSION['token'] = bin2hex(random_bytes(32));
        ?>

        <script>
        var up = setTimeout(() => {
    window.location.href=`../Edit.php?id=<?php echo$id;?>&updated=name`;
            }, 5000);

        </script>
     </div>
    </div>
</body>
</html>