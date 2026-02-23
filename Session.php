<?php
session_start();
include("Connection/Connect.php");

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 1){

    $row = mysqli_fetch_assoc($result);   // 🔥 THIS WAS MISSING

    $_SESSION['user'] = $row['username'];
    $_SESSION['admin_id'] = $row['id'];

    header("Location: DentalHomePage.php?name=$username");
    exit();

} else {
    header("Location: login.php?error=1");
    exit();
}
?>