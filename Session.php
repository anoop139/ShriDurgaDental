<?php
session_start();
include("Connection/Connect.php");

$username = $_POST['username'];

$query = "SELECT * FROM admin WHERE username=?";
$prepare = mysqli_prepare($conn, $query);

mysqli_stmt_bind_param($prepare, 's', $username);
mysqli_stmt_execute($prepare);

$result = mysqli_stmt_get_result($prepare);
$count  = mysqli_num_rows($result);

if($count == 1){

    $row = mysqli_fetch_assoc($result);
    $dbPassword = $row['password'];
    if(password_verify($_POST['password'], $dbPassword)){
        
        session_regenerate_id(true);

        $_SESSION['user'] = $row['username'];
        $_SESSION['admin_id'] = $row['id'];

        header("Location: DentalHomePage.php");
        exit();

    }
    
     
    else if($_POST['password'] === $dbPassword){
        // ⚠️ Old plain password → upgrade to hash
session_regenerate_id(true);

$_SESSION['user'] = $row['username'];
$_SESSION['admin_id'] = $row['id'];
        $newHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $update = "UPDATE admin SET password=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt, 'si', $newHash, $row['id']);
        mysqli_stmt_execute($stmt);

        header("Location: DentalHomePage.php");
        exit();
        // now password is hashed in DB
    } 
    
    else {
        header("Location: login.php?error=1");
        exit();
    }
}
 else {
    header("Location: login.php?error=1");
    exit();
}
?>