<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
if(!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])){

    header("Location: LogIn.php");
    exit();
}
$nonce = bin2hex(random_bytes(16));
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; object-src 'none'; base-uri 'self';");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
<?php 
echo "Welcome to " . htmlspecialchars($_SESSION['user']) . " dental clinic"; 
?>
</title>
    <link rel="stylesheet" href="Header2.css?v=10">
    <!-- <link rel="stylesheet" href="Styl.css"> -->
    <style> 
    body{
            background-image: url("Images/image1s.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    #deleted{
        margin-top: 0px;
    }
    #deleted{
        /* margin-left: 400px; */
        text-align: center;
       
    }
    #deleted{
        transition: transform 3s;

    } 
     #ul{
        transition: transform 3s;

    }
    ul{
        /* margin-top: -10px; */
        margin-left: 20px;
    }
    ul ul li{
        background-color: white;
    }
    ul li a{
        color:blue
    }    /* #deleted:hover{
     transform: translateY(-100px);
    }  */
   /* ul{
     position: absolute;
     top:-10px;      
    } */
    </style>
</head>
<body>
      <h1 style="background-color: white; margin-top: 10px;" id="deleted"></h1>

    <!-- <div id///="ul" style="background-color: white; height: 40px;"> -->
       <ul id="ul" style="padding-left:800px; background-color: white; height: 40px; width: 350px">
        <li><a href="LogOut.php">Log Out </a></li>&nbsp;
        <li><a href="./PatientFom.php">Add Patient </a></li>&nbsp;
        <li><a href="PatientRecord.php">Patient List </a></li>&nbsp;
        
        <li><a href="">Search by</a>
        <ul>
            <li><a href="SearchByName.php">Name</a></li><br>
            <li><a href="SearchByDate.php">Date</a></li><br>
            <li><a href="SearchByNumber.php">number</a></li>
        </ul>
        </li>
      </ul>
<script nonce="<?php echo $nonce; ?>">
   window.onload =()=>{
     let x   = new URLSearchParams(window.location.search)
     let d   = document.getElementById("deleted")
     let val = x.get("recordDeleted")
     if (val==="true") {
    d.textContent = "Record deleted successfully"
        //   document.getElementById("ul").style.marginTop="-10px";

    //  alert("x = "+x.get("recordDeleted")//
    setTimeout(() => {
        d.style.transform="translateY(-100px)";
    document.getElementById("ul").style.transform="translateY(-50px)";  
        
    }, 4000);
   }
   }
</script>
</body>
</html>