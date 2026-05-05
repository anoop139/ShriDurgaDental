<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['admin_id'])) {
    header("Location: ../LogIn.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];
include("../Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Delete Pateint Record</title>
    <style>
        body{
            
            background-image:url("../Images/DentalPatient2.jpg");
            background-repeat:no-repeat;
            background-size:cover
        }
         #nameDiv{
        position: absolute;
        top: 40px;
        left: 400px;
    }
    #main-div{
        padding-top: 0px;

    }
    #main-div{
             background-image:url("../Images/DentalPatient.jpg");
            background-repeat:no-repeat;
            background-size:cover
    }

    #main-div{
        height: 200px;
    }
    #result-div{
        padding-top:40px;
    }
    #result-div{
     text-align:center
    }
    #delRequ{
        text-align:right;
    } 
    
     
    #delRequ input{
        position: relative;
    //    left: 800px;
        bottom:30px;
    } 
     #yesDiv{
       
        text-align:right;
        /* margin-left:1000px ; */

    }
    #yesDiv input{
        padding: 10px;
        margin-top:0px;
        /* margin-left:1000px ; */

    }
      /* #mainFom input{
        padding: 10px;
    }  */
    .btns{
        border: 2px solid black; 
    }
    .btns{
  background-color: #ffffff;
  color: #008B8B; /* DarkCyan - matches sea theme */
  border: 2px solid #20B2AA; /* LightSeaGreen */
  padding: 8px 16px;
  border-radius: 8px;
  font-weight: bold;
  transition: 0.3s;
  cursor: pointer;
}
    </style>
</head>
<body>
<div id="nameDiv">
        <?php
      if (isset($_POST['id'])) {
              $record = $_POST['id'];
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
               echo"<h1>Are you sure you want to delete record of ".$getName["name"]." ? </h1>";
    
           }
    
    
    ?>
</div>
<form id="mainFom" action=""  method="POST" onsubmit="return checkTreat()">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
<div id="main-div">
        <div id="result-div">
            <?php
            if (!isset($_POST['id']) || (int)$_POST['id'] <= 0) {
             echo "Invalid ID";
               exit();
             }
        $id = (int)$_POST['id'];
                 $treatment =" SELECT treatment FROM treatment where sno=?";
                 $tretPrepare = mysqli_prepare($conn, $treatment);
                 mysqli_stmt_bind_param($tretPrepare, 'i',$id);
                  mysqli_stmt_execute($tretPrepare);
                  $treatQuery = mysqli_stmt_get_result($tretPrepare);
                 $treatNo;
                  if (mysqli_num_rows($treatQuery)>0) {
                    $treatNo =  mysqli_num_rows($treatQuery);
                  }
                  else{
                    $treatNo="";
                  }
                  

               if (isset($_POST['deleteRecord'])) {    
            
               if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    
           die("Invalid CSRF token");
           
           
           }
        
                $deleteRecord ="Delete from patient where sno=? and admin_id=?";
                $prepareForDel = mysqli_prepare($conn, $deleteRecord);
                mysqli_stmt_bind_param($prepareForDel, 'ii', $id, $admin_id);
                mysqli_stmt_execute($prepareForDel);
                // $result = mysqli_stmt_get_result($prepareForDel)//;
                // $deleteQuery = mysqli_fetch_assoc///////////($result);
                if (mysqli_stmt_affected_rows($prepareForDel)>0) {
                   echo"<h1>Deleted successfully</h1>";
                echo"<script>
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
<script>

   function checkTreat() {
   let treatCon = document.getElementById("treatCount").value
     if (treatCon.length>0) {   
      let result = confirm("Treatment for the patient exist, are u sure you want to delete")
     if (result) {
     return true 
     }
     else{
        //  alert("You// chose no to delted")
          return false
     }
    }
    return true

   }
    // else{
    // alert("Safe to  delete")
    // //  return false;
    // }
    
</script>
</body>
</html>
</html>
