<?php
session_start();
include("Connection/Connect.php");

$username = $_POST['username'];
// $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$query = "SELECT * FROM admin WHERE username=?";
$prepare = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($prepare, 's',$username);
mysqli_stmt_execute($prepare);
$result = mysqli_stmt_get_result($prepare);
$count    = mysqli_num_rows($result);
// mysqli_stmt_close($prepare);
if($count==1){

    $row = mysqli_fetch_assoc($result);   // 🔥 THIS WAS MISSING
if(password_verify($_POST['password'], $row['password'])){    
    session_regenerate_id(true); // ✅ HERE

    $_SESSION['user'] = $row['username'];
    $_SESSION['admin_id'] = $row['id'];

    header("Location: DentalHomePage.php");

    exit();

}
 else {
    header("Location: login.php?error=1");
    exit();
}

}
else {
    header("Location: login.php?error=1");
    exit();
}
?>