<?php
session_start();//Secure
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lock_time'] = 0;
}

if ($_SESSION['login_attempts'] >= 5) {
    if (time() - $_SESSION['lock_time'] < 900) {
        die("Too many attempts. Try again after 15 minutes.");
    } else {
        $_SESSION['login_attempts'] = 0;
    }
}
include("Connection/Connect.php");
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("CSRF attack detected");
}
$username = $_POST['username'];

$query = "SELECT * FROM admin WHERE username=?";
$prepare = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($prepare, 's', $username);
mysqli_stmt_execute($prepare);

$result = mysqli_stmt_get_result($prepare);
$row = mysqli_fetch_assoc($result);

if ($row) {

    
    $dbPassword = $row['password'];
    if(password_verify($_POST['password'], $dbPassword)){
        
        session_regenerate_id(true);
    $_SESSION['login_attempts'] = 0; // ✅ ADD THIS
        $_SESSION['user'] = $row['username'];
        $_SESSION['admin_id'] = $row['id'];

        header("Location: DentalHomePage.php");
        exit();

    }
    
  else {
    $_SESSION['login_attempts']++;
    $_SESSION['lock_time'] = time();

    header("Location: login.php?error=1");
    exit();
}
}
  else {
    $_SESSION['login_attempts']++;
    $_SESSION['lock_time'] = time();

    header("Location: login.php?error=1");
    exit();
}
?>