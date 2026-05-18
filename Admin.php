<?php
session_start();
include("Connection/Connect.php");
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


if ($_SESSION['role'] !== "admin") {
    die("Unauthorized access");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    die("All fields required");
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, "INSERT INTO admin (username, password) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
if (mysqli_stmt_execute($stmt)) {
    echo "Admin created successfully!";
} else {
    echo "Error creating admin";
}
}
?>
<form action="" method="POST">
    <input type="text" name="username">
    <input type="password" name="password" id="">
    <button type="submit">Create Admin</button>
</form>