
<?php
include("../Connection/Connect.php");

// Error & session security secure 8.5/10
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('session.cookie_httponly', 1);
//ini_set('session.cookie_secure', 0); // only if HTTPS
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
// header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
// CSRF token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// Nonce for CSP
$nonce = bin2hex(random_bytes(16));

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; style-src 'self'; img-src 'self' data:; object-src 'none'; base-uri 'self';");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

// Session timeout (15 minutes)
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    session_unset();
    session_destroy();
    header("Location: LogIn.php");
    exit();
}


$_SESSION['LAST_ACTIVITY'] = time();

// User authentication check
if (!isset($_SESSION['user'])) {
    header("Location: LogIn.php");
    exit();
}
$admin_id = isset($_SESSION['admin_id']) ? (int)$_SESSION['admin_id'] : 0;
if ($admin_id <= 0) {
    die("Unauthorized");
}
// CSRF check for POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        die("CSRF validation failed its me");
    }
}

?>      <?php
        
              if (isset($_POST['Submit']))
                 {
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            if ($id <= 0) {
    
          
                 die("Invalid ID");
            }
                   $amount = (int)$_POST['amount'];
                   if ($amount <= 0) {
                    die("Invalid amount");
                   }
                   $update ="UPDATE treatment SET amount=? WHERE tid=? AND admin_id=?";//
                   $prepare = mysqli_prepare($conn, $update);
                        if (!$prepare) {
                    
                        die("Query failed");
                    }
                   mysqli_stmt_bind_param($prepare, 'iii', $amount, $id, $admin_id);
                   $treatQuery = mysqli_stmt_execute($prepare);
                   if (!$treatQuery) {
    
                   die("Query failed");
                   }

                   mysqli_stmt_close($prepare);
                   if ($treatQuery) {
                    // echo"Treatment update";
                 header("Location: ./EditTreatment.php?tid=$id&updateAmount=true");
                  exit();
                     
                   }
                  else {
                  
                     echo"Updation failed ".$id." and  ".$treatment;

                  }

                }
                ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amount update page</title>
  <link rel="stylesheet" href="Amount.css">
</head>
<body>
    <div id="main-div">
     <div class="treatDiv">
        <h1>Enter new amount :</h1>
        <form action="" class="inputDiv" id="amountFom" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="number" name="amount" id="input">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? (int)$_GET['id'] : 0; ?>">
            <h2 id="Error">
          
            </h2>
          <div id="buttionArea">  <input type="submit" name="Submit" value="Update"></div>
        </form>
     </div>
    </div>
    <script src="./Amount.js?v=1">
  
    </script>
</body>
</html>