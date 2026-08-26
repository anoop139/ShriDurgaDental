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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) ||
        !hash_equals($_SESSION['token'], $_POST['token'])) {
        die("CSRF attack detected");
    }
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
   <link rel="stylesheet" href="./TreatmentDel.css">
</head>
<body>
<form id="mainFom" method="POST" >
<input type="hidden" name="treatId1" value="<?php echo isset($_POST['treatId']) ? (int)$_POST['treatId'] : ''; ?>">
<input type="hidden" name="fid1" value="<?php echo isset($_POST['fid']) ? (int)$_POST['fid'] : '';?>"> 
<div id="main-div">
         <?php
$patientId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$no = isset($_POST['noOfTreat']) ? (int)$_POST['noOfTreat'] : 0;
        if ($no==1) {// If only one treatment exists, Delete All is equivalent to Delete One.
          # code..

          unset($_POST['fid']);
          // echo"<h2>fid ".$_POST['fid']."</h2>";
        }
        else if ($no>1) {
          # code..

          // echo"<h2>id ".$_POST['id']."</h2>";
          unset($_POST['id']);
          // echo"<h2>fid ".$_POST['fid']."</h2>";
        }
         ?>
        <div class="result-div output">
            <?php
              if (isset($_POST['id']) && isset($_POST['treatId'])) {
                 if (isset($_POST['id'])) {
                # code...
                $id = $_POST['id'];
               }
               if (isset($_POST['treatId'])) {
                # code...
                $tid = $_POST['treatId'];
               }
              
			  // echo"<h2> Treatment fid is $tid</h2>";///
             $getName0 ="select patient.name, treatment.treatment from patient join  treatment on patient.sno=treatment.sno
             where patient.sno=? and patient.admin_id=? and treatment.tid=? and treatment.admin_id=?";
             $prepare = mysqli_prepare($conn, $getName0);
             mysqli_stmt_bind_param($prepare, 'iiii',$id, $admin_id, $tid,  $admin_id);

if (!mysqli_stmt_execute($prepare)) {
         die("Execution failed");
         }
     $result = mysqli_stmt_get_result($prepare);
     $showName  =  mysqli_fetch_assoc($result);
      echo"<h1>Are you sure you want to delete treatment record of  ".htmlspecialchars($showName['name'], ENT_QUOTES, 'UTF-8')."?</h1>";
               echo"<h1 class='dispArea'>Treatment name :  ".htmlspecialchars($showName['treatment'], ENT_QUOTES, 'UTF-8')."?</h1>";///
            //    /echo"<h1 class='dispArea'>Treatment name :  "."$showName[tm]"."?</h1>";///
              } 
              if (isset($_POST['deleteTreatment'])) {
             if (isset($_POST['treatId']) && isset($_POST['primary'])) {
             $treatmentId =$_POST['treatId'];
             $patientId =$_POST['primary'];
           if (isset($treatmentId)) {
                //  echo"<h1>Deleted one you r on line no. 73 and treat id =$treatmentId  </h1>";
            $deleteTreat ="delete from treatment where tid=? and admin_id=?";
            $deletePrepare = mysqli_prepare($conn,  $deleteTreat);
            mysqli_stmt_bind_param($deletePrepare, 'ii',$treatmentId, $admin_id);
              $deleteTreatQuery = mysqli_stmt_execute($deletePrepare);
          if (!$deleteTreatQuery) {
         die("Execution failed");
         }
  
        
            if ($deleteTreatQuery) {////// execute 1 
            // echo"<h1>Dzeleted one with prepared statment </h1>";
          header("Location: ../TreatmentDetail.php?id=$patientId&Delete=1");
           exit();
          }

             }//
           }
           }
        if (isset($_POST['fid'])) {
            
                $foreignKey = $_POST['fid'];
                // echo"ho".$primaryKey;
              $getName0 ="select patient.name from patient where sno=? and admin_id=?"; 
              $query = mysqli_prepare($conn,  $getName0);
            mysqli_stmt_bind_param($query, 'ii',$foreignKey, $admin_id);
            if (!mysqli_stmt_execute($query)) {

            die("Execution failed");
           
            }

                $result = mysqli_stmt_get_result($query);
                $showName  =  mysqli_fetch_assoc($result);
               echo"<h1>Are you sure you want to delete all  treatment records of ".htmlspecialchars($showName['name'], ENT_QUOTES, 'UTF-8')."?</h1>";
            //    echo"<h1>Are you sure you want to delete all treatment records of  "."$showName[tm]"."?</h1>";
   } 

          if (isset($_POST['deleteAll'])) {
          # code...
          $foreignKey = $_POST['primary'];///
             //echo"<h1>Foriegn key ".$foreignKey."</h1>";
           //  echo"<h1>Foriegn key you got it baby </h1>";////
          $deleteAllTreat ="delete from treatment where sno=? and admin_id=?";
          $deletePrepareAll = mysqli_prepare($conn, $deleteAllTreat);
       mysqli_stmt_bind_param($deletePrepareAll, "ii", $foreignKey, $admin_id);
             $deleteTreatQueryAll = mysqli_stmt_execute($deletePrepareAll);
          if (!$deleteTreatQueryAll) {
         die("Execution failed");
         }
          if ($deleteTreatQueryAll) {
            # code...
            // echo"<h1>Deleted All  </h1>";
        
          header("Location: ../TreatmentDetail.php?id=$foreignKey&DeleteAll=$deleteTreatQueryAll");
           exit();
          }
        //     else {
        //      # code...
        //      echo"<h1>Deletion failed all field </h1>";
        //        }


         }   
        
        
?>


    </div>

    <!-- <input type="hidden" name="name" value="//<?php ///echo$fid;?>"> -->
<input type="hidden" name="treatId" value="<?php echo isset($_POST['treatId']) ? (int)$_POST['treatId'] : ''; ?>">
<input type="hidden" id="da" value="<?php echo isset($_POST['DeleteAll']) ? htmlspecialchars($_POST['DeleteAll'], ENT_QUOTES, 'UTF-8') : ''; ?>">    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8'); ?>">
   <input type="hidden" name="primary" value="<?php echo isset($patientId) ? (int)$patientId : ''; ?>">
 <input type="hidden" name="n" value="<?php echo isset($name5) ? htmlspecialchars($name5, ENT_QUOTES, 'UTF-8') : ''; ?>">
  <input type="hidden" name="no" id="noOfTreat" value="<?php echo isset($_POST['noOfTreat']) ? (int)$_POST['noOfTreat'] : ''; ?>">
          </div>   
<div id="Yes"><input type="submit" class="submit" name="deleteTreatment" id="deleteTreatment" value="Yes" class="btns"> </div>
<!-- <div id="Yes"><input type="submit" class="submit" name="deleteTreatmentAll" id="deleteTreatmentAll1" value="YesAll" class="btns"> </div> -->
</form>  

<script src="./TreatmentDelete.js"></script>
</body>
</html>