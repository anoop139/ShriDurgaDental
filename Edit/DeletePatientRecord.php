<?php
include("../Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
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
      if (isset($_GET['id'])) {
              $record = $_GET['id'];
            //   echo"<h1>Id is $record</h1>";
               $patName = "select name from patient where sno=$record";
               $query   = mysqli_query($conn, $patName);
               $getName = mysqli_fetch_assoc($query);

               echo"<h1>Are you sure you want to delete record of ".$getName["name"]." ? </h1>";

           }
    
    
    ?>
</div>
<form id="mainFom" action=""  method="GET">
<div id="main-div">
        <div id="result-div">
            <?php
         
               if (isset($_GET['deleteRecord'])) {
                $id = $_GET['id'];
                $deleteRecord ="Delete from patient where sno=$id";
                $deleteQuery = mysqli_query($conn, $deleteRecord);
                if ($deleteQuery) {
                   echo"<h1>Deleted successfully</h1>";
                echo"<script>
                 window.location.href='../DentalHomePage.html?recordDeleted=true';
                
                </script>";
                }
                else{
                   echo"<h1>Deletion failed</h1>";

                }
               }
            ?>
        </div>
    </div>
    <input type="hidden" name="id" value="<?php echo$_GET['id'];?>">
<div id="yesDiv"><input type="submit" name="deleteRecord" class="btns" value="yes"></div>
</form>

</body>
</html>
</html>
