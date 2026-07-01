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
       <link rel="stylesheet" href="../Header2.css">
    <style>
       
    
    </style>
    <title>Edit Page</title>
    <link rel="stylesheet" href="EditTreatment.css">
</head>
<body>
<div id="header">

                <ul id="ul">
        <li><a href="../DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="../PatientRecord.php">Patient List </a></li>&nbsp;
        <li><a href="../PatientFom.php">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by</a>
   <ul>
            <li><a href="../SearchByName.php">Name</a></li><br>
            <li><a href="../SearchByDate.php">Date</a></li><br>
            <li><a href="../SearchByNumber.php">Number</a></li><br>
    
        </ul>
        </li>
        </li>
</ul> 
    </div>
    <div id="main">
        <table border="2" cellpadding="10" id="table"style="text-align:center">
            <tr>
            <th>Due date</th>
            <th>Edit due date</th>
            <th>Treatment name</th>
            <th>Edit Treatment name</th>
            <th>Advance Amount</th>
            <th>Edit Advance Amount</th>
            <th>Online Amount</th>
            <th>Edit Online Amount</th>
            <th>Amount</th>
            <th>Edit Amount</th>
            </tr>
            <?php
       $treatId = isset($_GET['tid']) ? (int)$_GET['tid'] : 0; 
           if ($treatId <= 0) {
            
           die("Invalid ID");
            }         

              $selectTreat = "select *from treatment where tid =? and admin_id=?";
              $treatPrepare = mysqli_prepare($conn, $selectTreat);
                   if (!$treatPrepare) {
             
                   die("Database error");
                }
      mysqli_stmt_bind_param($treatPrepare, 'ii', $treatId, $admin_id);
    
      if (!mysqli_stmt_execute($treatPrepare)) {
 
      die("Database error");

      }
$result = mysqli_stmt_get_result($treatPrepare);
if (!$result) {
    die("Database error");
}
if (mysqli_num_rows($result) == 0) {
    echo "<tr><td colspan='10'>No treatment found.</td></tr>";
}
else {
                  while ($fetch = mysqli_fetch_assoc($result)) {
               echo "<tr>
<td>" .
(
    !empty($fetch['dueDate'])
        ? htmlspecialchars(date('d-m-Y', strtotime($fetch['dueDate'])), ENT_QUOTES, 'UTF-8')
        : "-"
) .
"</td>

<td><a href='DueDate.php?id=" . urlencode($treatId) . "'>Click here to edit or add due date</a></td>

<td>" . htmlspecialchars($fetch['treatment'], ENT_QUOTES, 'UTF-8') . "</td>
<td><a href='Treatment.php?id=" . urlencode($treatId) . "'>Click here to edit treatment</a></td>

<td>" . htmlspecialchars($fetch['advance'], ENT_QUOTES, 'UTF-8') . "</td>
<td><a href='AdvanceAmount.php?id=" . urlencode($treatId) . "'>Click here to edit advance amount</a></td>

<td>" . htmlspecialchars($fetch['online'], ENT_QUOTES, 'UTF-8') . "</td>
<td><a href='Online.php?id=" . urlencode($treatId) . "'>Click here to edit Online amount</a></td>

<td>" . htmlspecialchars($fetch['amount'], ENT_QUOTES, 'UTF-8') . "</td>
<td><a href='Amount.php?id=" . urlencode($treatId) . "'>Click here to edit amount</a></td>
</tr>";
              
    }
  
}


mysqli_stmt_close($treatPrepare);
            ?>
            <h1></h1>
            <span id="message">
                <?php
                if (isset($_GET['updateDueDate'])) {
                    # code...
                    echo"Due date updated successfully";
                }
                  if (isset($_GET['updateTreatment'])) {
                    # code...
                    echo"Treatment updated successfully";
                }
                if (isset($_GET['updateAmount'])) {
                    # code...
                    echo"Amount updated successfully";
                }
                
                if (isset($_GET['updatAdvance'])) {
                    # code...
                    echo"Advance amount updated successfully";
                }
                
                     if (isset($_GET['deletedDue'])) {
                    # code...
                    echo"Deleted Due date successfully";
                }
                ?>
            </span>
        </table>

        <form action="clearDate.php" method="POST" name="clearDate" id="clearBtn"> 
<input type="hidden" name="dueId" value="<?php echo htmlspecialchars($treatId, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="Clear here to clear date">
            </form>
        
    </div>
    <script src="./EditTreat.js">    </script> 



</body>
</html>