<head>

<style>
*{
    margin: 0px;
    padding: 0px;
}
body{
    background-image:url("Images/Admin.png");
     background-size: cover;
    background-position: center;
   background-attachment: fixed;
}
    form{
        margin-left:500px;
        margin-top:100px;
    }
    button{
      position:relative;
      left    : 40px;
    }
</style>
</head>
<?php
session_start();
include("Connection/Connect.php");
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


if ($_SESSION['role'] !== "admin") {
    die("Unauthorized access");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
   header("Location: admin.php?error=emptyfields");
      exit();
}
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    die("CSRF attack detected");
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$check = mysqli_prepare($conn, "SELECT id FROM admin WHERE username=?");
mysqli_stmt_bind_param($check, "s", $username);
mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);

if (mysqli_num_rows($result) > 0) {
    die("<h1 style='color:red; margin:200px; margin-left:500px'>Username already exists</h1>");
}

}

?>

<form action="" name="fom" method="POST" >
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <input type="text" name="username"><br><br>
    <input type="password" name="password" id=""><br>
    <?php
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = mysqli_prepare($conn, "INSERT INTO admin (username, password) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);
if (mysqli_stmt_execute($stmt)) {
    echo "<span style='color:green; font-size:20px; background:white'>Admin created successfully!</span>";
} else {
    echo "Error creating admin";
}
     }
    ?><br>
    <button type="submit">Create Admin</button>
</form>