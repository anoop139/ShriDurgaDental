<?php
session_start();
include("Connection/Connect.php");

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) == 1){
    $_SESSION['user'] = $username;
    header("Location:DentalHomePage.html?name='$username'");
} else {
    header("Location: login.php?error=1");
}
?>
