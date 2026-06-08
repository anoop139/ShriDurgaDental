<?php//xs
include("../Connection/Connect.php");
include("../Connection/Init.php");
if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    header("Location: ../LogIn.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
 $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
      if ($id <= 0) {
    
      exit("Invalid ID");

      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delete Pateint Record</title>
    <style>

    </style>
    <link rel="stylesheet" href="DeletePatientRecord.css">
</head>
<body>
<div id="nameDiv">
        <?php
        
      if($id > 0)  {
            $record = $id;
            //   echo"<h1>Id is $record</h1>";
               $patName = "select name from patient where sno=? and admin_id=?";
               $prepare = mysqli_prepare($conn, $patName);
               mysqli_stmt_bind_param($prepare, 'ii', $record, $admin_id);
               mysqli_stmt_execute($prepare);
               $result = mysqli_stmt_get_result($prepare);
            //    $query   = mysqli_query($conn, $patName);
               $getName = mysqli_fetch_assoc($result);
              if (!$getName) {
              echo "Record not found";
                   exit();
                }
               echo"<h1>Are you sure you want to delete record of ".htmlspecialchars($getName["name"], ENT_QUOTES, 'UTF-8')." ? </h1>";
    
           }
    
    
    ?>
</div>
<form id="mainFom" action=""  method="POST">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
<div id="main-div">
        <div id="result-div">
            <?php
             $treatment =" SELECT treatment FROM treatment where sno=? AND admin_id=?";
                 $tretPrepare = mysqli_prepare($conn, $treatment);
                 mysqli_stmt_bind_param($tretPrepare, 'ii',$id, $admin_id);
                  mysqli_stmt_execute($tretPrepare);
                  $treatQuery = mysqli_stmt_get_result($tretPrepare);
                $treatNo=0;

             if (mysqli_num_rows($treatQuery)>0) {
            $treatNo = mysqli_num_rows($treatQuery);
           
            }
        else{
        
        $treatNo="";
   
    } 
 
        
        if (isset($_POST['deleteRecord'])) {    
    
               if (!isset($_POST['token']) || !hash_equals($_SESSION['token'], $_POST['token'])) {
    
           die("Invalid CSRF token");
           
           
           }
               if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
               
                 exit("Invalid request");
               }
                 $deleteRecord ="Delete from patient where sno=? and admin_id=?";
                $prepareForDel = mysqli_prepare($conn, $deleteRecord);
                mysqli_stmt_bind_param($prepareForDel, 'ii', $id, $admin_id);
                mysqli_stmt_execute($prepareForDel);
                // $result = mysqli_stmt_get_result($prepareForDel)//;
                // $deleteQuery = mysqli_fetch_assoc///////////($result);
                if (mysqli_stmt_affected_rows($prepareForDel)>0) {
                   echo"<h1>Deleted successfully</h1>";
                   $_SESSION['token'] = bin2hex(random_bytes(32));
               echo "<script nonce='$nonce'>
              window.location.href='../DentalHomePage.php?recordDeleted=true';
               </script>";
                }
                else{
                   echo"<h1>Deletion failed</h1>";

                }
               }
               
            ?>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php  echo htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="tr" id="treatCount" value="<?php echo$treatNo;?>">
<div id="yesDiv"><input type="submit" name="deleteRecord" class="btns" value="yes"></div>
</form>
<script nonce="<?php echo htmlspecialchars($nonce, ENT_QUOTES, 'UTF-8'); ?>">
  document.getElementById("mainFom").onsubmit= ()=> {
   let treatCon = document.getElementById("treatCount").value
    if (parseInt(treatCon) > 0){   
      let result = confirm("Treatment for the patient exist, are u sure you want to delete")
     if (result) {
       return true; 
     }
     else{
        //  alert("You// chose no to delted")
          return false
     }
    }
    return true
//   alert("Safe to  delete")
// return false;
   }
    // else{
 
    // }
    
</script>

</body>
</html>
