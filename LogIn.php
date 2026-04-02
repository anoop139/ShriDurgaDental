<?php
session_start();
if(isset($_SESSION['user'])){
  $admin_id = $_SESSION['admin_id'];
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Shri Durga Dental Clinic</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-container">
    <h2>Shri Durga Dental Clinic</h2>
    <form action="Session.php" method="POST">
        
        <input type="text" name="username" placeholder="Username" required>
        
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit">Login</button>

        <?php
        if(isset($_GET['error'])){
            echo "<p class='error'>Invalid Username or Password</p>";
        }
        ?>
    </form>
    <h2>Welcome <span id="welcome"></span></h2>
</div>
<script>
    fetch("GetUser.php")
    .then(response => response.text())
    .then((value) => {
        document.getElementById("welcome").textContent=value;
    })
</script>
</body>
</html>
