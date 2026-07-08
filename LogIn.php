
<?php
session_start();

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(isset($_SESSION['user'])){
  $admin_id = $_SESSION['admin_id'];
    header("Location: dashboard.php");
    exit();
}
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; object-src 'none'; frame-ancestors 'none';");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Shri Durga Dental Clinic</title>
    <link rel="stylesheet" href="login.css?v=5">
</head>
<body>

<div class="login-container">
    <h2>Shri Durga Dental Clinic</h2>
    <form action="Session.php" method="POST">
        
        <input type="text" name="username" placeholder="Username" required>
        
        <input type="password" name="password" placeholder="Password" required>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <button type="submit">Login</button>


        <?php
        if(isset($_GET['error'])){
            echo "<p class='error'>Invalid Username or Password</p>";
        }
        ?>
        <h3>If not a user <a href="./Signup.php" target="_blank" rel="noopener noreferrer">click here</a> To Sign Up</h3>
    </form>
</div>

</body>
</html>
