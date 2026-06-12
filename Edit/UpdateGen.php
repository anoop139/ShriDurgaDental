<?php
include("../Connection/Connect.php");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Gender</title>
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
        if (!isset($_POST['id']) || !isset($_POST['gender'])) {
            die("Invalid request");
        }   
        $sno = (int)$_POST['id'];// THIS IS THE SNO
        if ($sno <= 0) {
        die("Invalid ID");
        }
     
   $gender = $_POST['gender'];
    $allowed = ["Male", "Female"];
if (!in_array($gender, $allowed, true)) {
    die("Invalid gender");
}

        // echo"<h1> id is $sno</h1>";
        $updateGen ="update patient set gen=? where sno=? and admin_id=?";
        $stmt = mysqli_prepare($conn, $updateGen);
        if (!$stmt) {
         die("Database error");
        }
        mysqli_stmt_bind_param($stmt, "sii", $gender, $sno, $admin_id);
        $query1 = mysqli_stmt_execute($stmt);
             $result =0;
   if (!$query1) {

    echo "<h1 class='msg'>Database update failed.</h1>";
} elseif (mysqli_stmt_affected_rows($stmt) > 0) {
    $result =1;
    echo "<h1 class='msg'>Gender updated successfully. Wait for a few seconds...</h1>";
} else {
    echo "<h1 class='msg'>No changes were made. Please select gender</h1>";
}
         mysqli_stmt_close($stmt);
         $_SESSION['token'] = bin2hex(random_bytes(32));
        ?>

      <script>
            const value = <?php echo $result; ?>;
            // alert(value)
     if (value===1) {
        setTimeout(() => {
   window.location.href=`../Edit.php?id=<?php echo$sno;?>&updated=gender`;
        }, 5000);
     }

        </script>
     </div>
    </div>
</body>
</html>