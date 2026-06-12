<?php
include("Connection/Connect.php");

ini_set('log_errors', 1);
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
$_SESSION['token'] = bin2hex(random_bytes(32));
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
      <link rel="stylesheet" href="UpdateAge.css">
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
        if ($id <= 0) {
    die("Invalid ID");
    }
        if ($newAge<=0 || $newAge>=120) {
            die("Change the age to a valid one");
        }

        $update ="update patient set age=? where sno=? and admin_id=?";
            $stmt = mysqli_prepare($conn, $update);
            if (!$stmt) {
  
            die("Database error");
        }
            mysqli_stmt_bind_param($stmt, "iii", $newAge, $id, $admin_id);
            $query = mysqli_stmt_execute($stmt);
 
       $result =0;
   if (!$query) {

    echo "<h1 class='msg'>Database update failed.</h1>";
} elseif (mysqli_stmt_affected_rows($stmt) > 0) {
    $result =1;
    echo "<h1 class='msg'>Age updated successfully. Wait for a few seconds...</h1>";
} else {
    echo "<h1 class='msg'>No changes were made. Please add new age</h1>";
}
         mysqli_stmt_close($stmt); // echo"id is ".$oldAge."<br>";
        // echo"And the new age is ".$newAge;
        ?>

        <script>
            const value = <?php echo $result; ?>;
     if (value===1) {
        setTimeout(() => {
   window.location.href=`../Edit.php?id=<?php echo$id;?>&updated=age`;
        }, 5000);
     }

        </script>
     </div>
    </div>
</body>
</html>