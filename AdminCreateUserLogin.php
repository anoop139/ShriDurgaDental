<?php
session_start();
include("Connection/Connect.php");

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (!empty($_SESSION['user']) && !empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header("Location: Signup.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        $error = "Security token is invalid. Please try again.";
    } else {
        $username = trim($_POST['username'] ?? "");
        $password = $_POST['password'] ?? "";

        if ($username === "" || $password === "") {
            $error = "Please enter both username and password.";
        } else {
            $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM admin WHERE username = ? LIMIT 1");
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row && $row['role'] === 'admin' && password_verify($password, $row['password'])) {
                session_regenerate_id(true);
                $_SESSION['super_admin'] = true;
                $_SESSION['user'] = $row['username'];
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                unset($_SESSION['token']);
                header("Location: Signup.php");
                exit();
            } else {
                $error = "Invalid admin username or password.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Shri Durga Dental Clinic</title>
    <link rel="stylesheet" href="Login.css?v=6">
</head>
<body>

<div class="login-container">
    <h2>Admin Login to Create User</h2>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Admin Password" required>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8'); ?>">
        <button type="submit">Admin Login</button>

        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'admin_required') : ?>
            <p class="error">Admin login is required to create a user account.</p>
        <?php endif; ?>

        <h3><a href="LogIn.php">Back to main login</a></h3>
    </form>
</div>

</body>
</html>
