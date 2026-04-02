<?php
session_start();
include("Connection/Connect.php");

$username = $_POST['username'];

$query = "SELECT * FROM admin WHERE username=?";
$prepare = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($prepare, 's', $username);
mysqli_stmt_execute($prepare);

$result = mysqli_stmt_get_result($prepare);
$count  = mysqli_num_rows($result);

if($count == 1){

    $row = mysqli_fetch_assoc($result);

    // 🔥 Plain password check (OLD)
    if($_POST['password'] === $row['password']){
        
        session_regenerate_id(true);

        $_SESSION['user'] = $row['username'];
        $_SESSION['admin_id'] = $row['id'];

        header("Location: DentalHomePage.php");
        exit();

    } else {
        header("Location: login.php?error=1");
        exit();
    }

} else {
    header("Location: login.php?error=1");
    exit();
}
?>