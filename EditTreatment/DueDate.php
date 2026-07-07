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
    header("Location:../LogIn.php");
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Date update page</title>
    <link rel="stylesheet" href="DueDate.css?v=<?php echo time(); ?>">
</head>
<body>
    <div id="main-div">
     <div class="treatDiv">
        <h1>Enter new Due Date :</h1>
        <form action="" class="inputDiv" id="dueDate" method="POST">
         <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8'); ?>">
           &nbsp; <input type="date" name="dueDate" id="input">
           &nbsp; <input type="hidden" name="dueDate1" id="input2">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? (int)$_GET['id'] : 0; ?>"> <br>
            <h2 id="Error">
                <?php
          $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            
              if (isset($_POST['Submit']))
                 {
                   $due= $_POST['dueDate'];
        if (empty($due) || strtotime($due) <= strtotime(date('Y-m-d'))) {
 
               die("Invalid due date");
            }
                //    echo"<h1>date $date </h1>";
                   $update ="update treatment set dueDate=? where tid=? and admin_id=?";//
                   $prepareDue = mysqli_prepare($conn, $update);
                   if (!$prepareDue) {
             
                   die("Database error");
                }
      mysqli_stmt_bind_param($prepareDue, 'sii',$due, $id, $admin_id);
 if (!mysqli_stmt_execute($prepareDue)) {
    mysqli_stmt_close($prepareDue);
    die("Database error");
}

$treatQuery = mysqli_stmt_affected_rows($prepareDue);
               if ($treatQuery != -1) {
     
               mysqli_stmt_close($prepareDue);
               header("Location: ./EditTreatment.php?tid=$id&updateDueDate=true");
             exit();
             }
          else {
    mysqli_stmt_close($prepareDue);
   
    die("Update failed");
   }
                    
    

                }
                ?>
            </h2>
          <div id="buttonArea">  <input type="submit" name="Submit" value="Update"></div>
        </form>
     </div>
    </div>
    <script src="./DueDate.js">
    </script>
</body>
</html>