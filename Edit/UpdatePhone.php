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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Phone Number</title>
    <link rel="stylesheet" href="Phone.css">
</head>
<body>

    <div id="Main-div">
     <div id="sub-div">
        <?php

        if (!isset($_POST['id']) || !isset($_POST['newNumber'])) {
                
              die("Invalid request");
        }
        $id = (int)$_POST['id'];// THIS IS IS SNO
        if ($id <= 0) {
    die("Invalid ID");
    }
 $newNumber = trim($_POST['newNumber']);
     
 if ($newNumber === '') {
    die("Number cannot be empty");
    }

     if (!preg_match('/^[0-9]{10}$/', $newNumber)) {
    die("Invalid phone number");
}

        $update ="update patient set phoNo=? where sno=? and admin_id=?";
            $stmt = mysqli_prepare($conn, $update);
            if (!$stmt) {
    die("Database error");
}
            mysqli_stmt_bind_param($stmt, "sii", $newNumber, $id, $admin_id);
            $query = mysqli_stmt_execute($stmt);
    $result =0;
   if (!$query) {

    echo "<h1 class='msg'>Database update failed.</h1>";
} elseif (mysqli_stmt_affected_rows($stmt) > 0) {
    $result =1;
    echo "<h1 class='msg'>Phone Number updated successfully. Wait for a few seconds...</h1>";
} else {
    echo "<h1 class='msg'>No changes were made.</h1>";
}
    mysqli_stmt_close($stmt);
$_SESSION['token'] = bin2hex(random_bytes(32));
        ?>
<input type="hidden" name="" id="Val" value="<?php echo$result;?>">
        <script>
              let value = parseInt(document.getElementById("Val").value, 10);
          //alert(typeof value)
        if (value===1) {
             var up = setTimeout(() => {
    window.location.href=`../Edit.php?id=<?php echo$id;?>&updated=number`;
            }, 5000);
        }

        </script>
     </div>
    </div>
</body>
</html>