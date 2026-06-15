<?php  //88–92% secure
include("../Connection/Connect.php");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_set_cookie_params([
    'httponly' => true,
    'secure' => true,
    'samesite' => 'Strict'
]);
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])){
    header("Location: LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];

if (isset($_POST['p'])) {

    if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
        die("CSRF attack detected");
    }
// /if (empty($_SESSION['token'])) {
    // $_SESSION['token'] = bin2hex(random_bytes(32));
}
$nonce = base64_encode(random_bytes(16));

header("Content-Security-Policy: default-src 'self'; script-src 'self' 'nonce-$nonce'; style-src 'self'; object-src 'none';");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment Deletion page</title>
   <link rel="stylesheet" href="./treatmentDel.css">
</head>
<body>
<form id="mainFom" method="POST">
<input type="hidden" name="treatId1" value="<?php echo $_POST['treatId'];?>"> 
<input type="hidden" name="fid1" value="<?php echo $_POST['fid'];?>"> 
<div id="main-div">
         <?php
          $patientId = $_POST['id'];
        //   echo"hi ".$patientId  ;
         ?>
        <div class="result-div output">
            <?php
              if (isset($_POST['id']) && isset($_POST['treatId'])) {
               $id = $_POST['id'];
               $tid = $_POST['treatId'];
            //   echo"<h2> Treatment i is $id</h2>";
			//   echo"<h2> Treatment fid is $tid</h2>";/
             $getName0 ="select patient.name, treatment.treatment from patient join treatment
             where patient.sno=$id and treatment.tid=$tid"; 
              $query = mysqli_query($conn, $getName0);
             $showName = mysqli_fetch_assoc($query); 
               echo"<h1>Are you sure you want to delete treatment record of  "."$showName[name]"."?</h1>";
               echo"<h1 class='dispArea'>Treatment name :  "."$showName[treatment]"."?</h1>";///
              } 
              if (isset($_POST['deleteTreatment'])) {
             if (isset($_POST['treatId'])) {
             $treatmentId =$_POST['treatId'];
             $patientId =$_POST['primary'];
             echo"<h1>id".$patientId."</h1>";
             $deleteTreat ="delete from treatment where tid=$treatmentId";
             $deleteTreatQuery = mysqli_query($conn, $deleteTreat);
             if ($deleteTreatQuery) {
            echo"<h1>Deleted only 1 new inside treatid</h1>";//
             echo "<script  nonce='$nonce'>
            window.location.href='../TreatmentDetail.php?id=$patientId&Delete=$deleteTreatQuery';
             //</script>"; //pass foreign key
              } 
              else {
             # code...
             echo"<h1>Deletion failed </h1>";
               }
             }
    
                   }
///              }
            // }
        if (isset($_GET['fid'])) {
            
                // echo"else ";
                $primaryKey = $_GET['fid'];
              $getName0 ="select patient.name from patient where sno=$primaryKey"; 
              $query = mysqli_query($conn, $getName0);
             $showName = mysqli_fetch_assoc($query); 
               echo"<h1>Are you sure you want to delete all treatment records of  "."$showName[name]"."?</h1>";
   } 
          if (isset($_GET['deleteAllTreatment'])) {
          # code...
          $foreignKey = $_GET['fid1'];
             echo"<h1>Foreign key is  $foreignKey</h1>";
          $deleteAllTreat ="delete from treatment where sno=$foreignKey";
          $deleteAllQuery=mysqli_query($conn, $deleteAllTreat);
          if ($deleteAllQuery) {
            # code...
            echo"<h1>Deleted All</h1>";
             echo "<script>window.location.href='../TreatmentDetail.php?id=$foreignKey&DeleteAll=$deleteAllQuery';</script>"; //pass foreign key

          }
            else {
             # code...
             echo"<h1>Deletion failed </h1>";
               }


         }   
        
        
?>


    </div>

    <!-- <input type="hidden" name="name" value="//<?php ///echo$fid;?>"> -->

    <input type="hidden" name="treatId" value="<?php echo$_POST['treatId'];?>">
    <input type="hidden"  id="da" value="<?php echo$_POST['DeleteAll'];?>">
    <input type="hidden" name="primary" value="<?php echo$patientId;?>">
    <input type="hidden" name="n" value="<?php echo$name5;?>">
          </div>   
    <span id="back"><input type="submit" class="submit" value="Back"></span>
<div id="Yes"><input type="submit" class="submit" name="deleteTreatment" id="deleteTreatmentAll" value="Yes" class="btns"> </div>
 </form>  
</body>
</html>