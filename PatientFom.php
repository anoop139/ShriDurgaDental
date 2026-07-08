<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: LogIn.php");
    exit();
}

if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The form</title>
	<link rel="stylesheet" href="./Header.css?v=6">
  <link rel="stylesheet" href="./FormStyle.css?v=5">
   
</head>
<body id="body1">
<!-- test -->
       <ul id="ul">
        <li><a href="DentalHomePage.php">Home </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">number</a></li><br>
        </ul>
        </li>
      </ul>
   <!-- </div> -->
   <!-- </di> -->
 <div id="formEle">
    <h1> Enter Name         :  </h1>
    <h1> Enter Age          : </h1>
    <h1> Enter Gender       : </h1>
    <h1>Enter Mobile Number :</h1>
    <!-- <h1>Enter Date          :</h1> 
    <h1>Enter Amount        :</h1>-->
 </div>
 
 <div id="formInput">
    <form action="InsertPatientRecord.php" method="POST" id="inputPatient"> <br><br>                         
    <input type="text" name="name" id="name0" class="error" required><br> 
    <span class="mobErr" id="nameErr"></span><br><br>
    <input type="number" name="age" id="age" required><br>
	   <span class="mobErr" id="errInfo1"></span><br><br>
    <input type="radio" name="Gender" id="Male" value="Male" required><span class="span" name="Male">Male</span>
    <input type="radio" name="Gender" id="Female" value="Female" required><span class="span">Female</span><br><br>
    <input type="text" name="pho" id="pho" required><br>
    <span class="mobErr" id="errInfo"></span><br><br>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <input type="submit" value="Submit" id="Submit">
 </div>
 <script src="./FomValidation.js?v=<?php echo time(); ?>"></script>
 </form>
</div>
</div>
</body>
</html>		