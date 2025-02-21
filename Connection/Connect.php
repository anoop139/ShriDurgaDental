<?php
$hostName = "localhost";
$userName = "root";
$pass     = "";
$db       = "shriDuruga";

$conn     = mysqli_connect($hostName, $userName, $pass, $db);

if ($conn) {
  //echo"Connected successfuly";
}
else{
    echo"Failed";
}

?>