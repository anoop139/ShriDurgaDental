<?php
include("Connection/Connect.php");

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
mysqli_query($conn, $query);

echo "Admin created successfully!";
?>
