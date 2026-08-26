<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
require_once "Connection/Connect.php";

/* This page is deliberately restricted to the session created by the
   superadmin verification in AdminCreateUserLogin.php. */
if (empty($_SESSION['super_admin']) || empty($_SESSION['admin_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    http_response_code(403);
    exit('Unauthorized access');
}

if (empty($_SESSION['account_settings_token'])) {
    $_SESSION['account_settings_token'] = bin2hex(random_bytes(32));
}

$error = '';
$success = '';
$usernameValue = '';
$selectedClientId = (int) ($_POST['client_id'] ?? 0);

$clientsResult = mysqli_query($conn, "SELECT id, username FROM admin WHERE role <> 'admin' ORDER BY username ASC");
$clients = mysqli_fetch_all($clientsResult, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    if (!hash_equals($_SESSION['account_settings_token'], $token)) {
        $error = 'Your security token has expired. Please try again.';
    } else {
        $usernameValue = trim($_POST['username'] ?? '');
        $superadminPassword = $_POST['superadmin_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $superadminId = (int) $_SESSION['admin_id'];

        if ($selectedClientId < 1) {
            $error = 'Select a client account.';
        } elseif ($usernameValue === '' || strlen($usernameValue) > 100) {
            $error = 'Enter a username between 1 and 100 characters.';
        } elseif ($superadminPassword === '') {
            $error = 'Enter your superadmin password to save changes.';
        } elseif ($newPassword !== '' && strlen($newPassword) < 8) {
            $error = 'Your new password must be at least 8 characters long.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'New passwords do not match.';
        } else {
            $superadmin = mysqli_prepare($conn, 'SELECT password FROM admin WHERE id = ? AND role = \'admin\' LIMIT 1');
            mysqli_stmt_bind_param($superadmin, 'i', $superadminId);
            mysqli_stmt_execute($superadmin);
            $superadminAccount = mysqli_fetch_assoc(mysqli_stmt_get_result($superadmin));

            if (!$superadminAccount || !password_verify($superadminPassword, $superadminAccount['password'])) {
                $error = 'Your superadmin password is incorrect.';
            } else {
                $client = mysqli_prepare($conn, 'SELECT id FROM admin WHERE id = ? AND role <> \'admin\' LIMIT 1');
                mysqli_stmt_bind_param($client, 'i', $selectedClientId);
                mysqli_stmt_execute($client);
                $clientAccount = mysqli_fetch_assoc(mysqli_stmt_get_result($client));

                if (!$clientAccount) {
                    $error = 'The selected client account is not available.';
                } else {
                $duplicate = mysqli_prepare($conn, 'SELECT id FROM admin WHERE username = ? AND id <> ? LIMIT 1');
                mysqli_stmt_bind_param($duplicate, 'si', $usernameValue, $selectedClientId);
                mysqli_stmt_execute($duplicate);

                if (mysqli_fetch_assoc(mysqli_stmt_get_result($duplicate))) {
                    $error = 'This username is already in use.';
                } elseif ($newPassword !== '') {
                    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                    $update = mysqli_prepare($conn, 'UPDATE admin SET username = ?, password = ? WHERE id = ?');
                    mysqli_stmt_bind_param($update, 'ssi', $usernameValue, $passwordHash, $selectedClientId);
                    mysqli_stmt_execute($update);
                    $success = 'Client username and password updated successfully.';
                } else {
                    $update = mysqli_prepare($conn, 'UPDATE admin SET username = ? WHERE id = ?');
                    mysqli_stmt_bind_param($update, 'si', $usernameValue, $selectedClientId);
                    mysqli_stmt_execute($update);
                    $success = 'Client username updated successfully.';
                }
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
    <title>Account Settings - Shri Durga Dental Clinic</title>
    <link rel="stylesheet" href="AccountSettings.css?v=1">
</head>
<body>
    <main class="settings-card">
        <div class="page-links">
            <a class="back-link" href="DentalHomePage.php">&larr; Back to dashboard</a>
            <a class="logout-link" href="LogOut.php">Logout</a>
        </div>
        <h1>Client account settings</h1>
        <p class="intro">Change a client username or reset their password.</p>

        <form method="POST" action="AccountSettings.php" autocomplete="off">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['account_settings_token'], ENT_QUOTES, 'UTF-8'); ?>">

            <label for="client_id">Client account</label>
            <select id="client_id" name="client_id" required>
                <option value="">Select a client</option>
                <?php foreach ($clients as $client) : ?>
                    <option value="<?php echo (int) $client['id']; ?>" data-username="<?php echo htmlspecialchars($client['username'], ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedClientId === (int) $client['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($client['username'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="username">New username</label>
            <input id="username" name="username" type="text" maxlength="100" value="<?php echo htmlspecialchars($usernameValue, ENT_QUOTES, 'UTF-8'); ?>" required autocomplete="username">

            <label for="superadmin_password">Your superadmin password</label>
            <input id="superadmin_password" name="superadmin_password" type="password" required autocomplete="current-password">

            <fieldset>
                <legend>Client password <span>(leave blank to keep their current password)</span></legend>
                <label for="new_password">New client password</label>
                <input id="new_password" name="new_password" type="password" minlength="8" autocomplete="new-password">

                <label for="confirm_password">Confirm new password</label>
                <input id="confirm_password" name="confirm_password" type="password" autocomplete="new-password">
            </fieldset>

            <?php if ($error !== '') : ?>
                <p class="message error" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>
            <?php if ($success !== '') : ?>
                <p class="message success" role="status"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php endif; ?>

            <button type="submit">Save changes</button>
        </form>
    </main>
    <script>
        document.getElementById('client_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('username').value = selectedOption.dataset.username || '';
        });
    </script>
</body>
</html>
