<?php
session_start();      // Start session

session_unset();      // Remove all session variables
session_destroy();    // Destroy session

header("Location: login.php");  // Go back to login page
exit();
?>
