<?php
session_start();
include("Connection/Connect.php");
if (!isset($_SESSION['super_admin'])) {
    header("Location: AdminCreateUserLogin.php");
    exit();
}
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (empty($_SESSION['user']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: AdminCreateUserLogin.php?error=admin_required");
    exit();
}

$error = "";
$message = "";
$usernameValue = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        $error = "Security token is invalid. Please try again.";
    } else {
        $usernameValue = trim($_POST['username'] ?? "");
        $password = $_POST['password'] ?? "";
        $confirmPassword = $_POST['confirm_password'] ?? "";

        if ($usernameValue === "") {
            $error = "Username is required.";
        } elseif (strlen($password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } elseif ($password !== $confirmPassword) {
            $error = "Passwords do not match.";
        } else {
            $check = mysqli_prepare($conn, "SELECT id FROM admin WHERE username = ?");
            mysqli_stmt_bind_param($check, "s", $usernameValue);
            mysqli_stmt_execute($check);
            $result = mysqli_stmt_get_result($check);

            if (mysqli_num_rows($result) > 0) {
                $error = "This username is already taken.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($conn, "INSERT INTO admin (username, password, role) VALUES (?, ?, 'user')");
                mysqli_stmt_bind_param($stmt, "ss", $usernameValue, $hashedPassword);

                if (mysqli_stmt_execute($stmt)) {
                 $_SESSION = [];      // Clear all session data
               
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
                session_destroy();   // Destroy the session
            header("Location: LogIn.php");
             exit();
                   
        
                } else {
                    $error = "Unable to create your account. Please try again.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Shri Durga Dental Clinic</title>
    <link rel="stylesheet" href="SignUp.css?v=2">
</head>
<body>
    <div class="signup-card">
        <div class="brand">
            <h1>Welcome To Dental Management System</h1>
            <div class="signup-illustration" aria-hidden="true">
                <svg viewBox="0 0 260 180" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="130" cy="60" r="34" fill="#7ed6d3"/>
                    <circle cx="130" cy="54" r="24" fill="#f2c49b"/>
                    <path d="M92 150c5-28 25-42 38-42s33 14 38 42" fill="#2f6b7a"/>
                    <rect x="86" y="96" width="88" height="54" rx="18" fill="#2f6b7a"/>
                    <path d="M72 64c0-33 20-54 58-54s58 21 58 54" fill="#3b8d9b"/>
                    <path d="M70 154h120" stroke="#1e4f5b" stroke-width="8" stroke-linecap="round"/>
                    <rect x="168" y="52" width="58" height="44" rx="12" fill="#ffffff"/>
                    <path d="M182 62h30" stroke="#2f6b7a" stroke-width="8" stroke-linecap="round"/>
                    <path d="M182 76h22" stroke="#2f6b7a" stroke-width="8" stroke-linecap="round"/>
                    <path d="M182 90h16" stroke="#2f6b7a" stroke-width="8" stroke-linecap="round"/>
                    <path d="M176 116c16 12 34 12 50 0" stroke="#1e4f5b" stroke-width="8" stroke-linecap="round"/>
                </svg>
            </div>
            <p>Create your account and join our dental care team with a simple, secure sign-up.</p>
        </div>

        <form action="" method="POST" novalidate autocomplete="off">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8'); ?>">

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username" autocomplete="new-username" value="" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" autocomplete="new-password" value="" required>
            <div id="password-message" class="helper-text"></div>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" autocomplete="new-password" value="" required>
            <div id="confirm-password-message" class="helper-text"></div>

            <?php if (!empty($error)) : ?>
                <p class="message error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <?php if (!empty($message)) : ?>
                <p class="message success"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <button type="submit">Sign Me Up</button>
        </form>

        <p class="footer-link">
        <a href="DentalHomePage.php">Back to Dashboard</a></p>
    </div>

    <script src="SingUp.js?v=2"></script>
</body>
</html>