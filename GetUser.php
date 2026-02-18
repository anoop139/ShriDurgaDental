<?php
session_start();

// Check if user is logged in
if(isset($_SESSION['user'])){
    echo $_SESSION['user'];
} else {
    echo "Not logged in";
}
?>
