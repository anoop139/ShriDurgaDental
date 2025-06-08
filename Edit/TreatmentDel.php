<?php
include("../Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment Deletion page</title>
    <style>
    /* //DentalTreratment.jpg */
        body{
            background-image:url("../Images/DentalTreratment2.jpg");
            background-repeat:no-repeat;
            background-size:cover
        }
        #main-div{
            background-image:url("../Images/DelTreat.jpg");
            background-repeat:no-repeat;
            background-size:cover
        }
    #main-div{
        padding: 0px;
        margin: 0px;
    }
    #main-div{
        border: 2px solid black;
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
    #mainFom input{
        padding: 10px;
        margin-top:20px
    }
      #delRequ input{
        padding: 10px;
    } 
    .btns{
        border: 2px solid black; 
    }
    #Yes{
      float:right;
      position: relative;
      /* top:51px; */
    }
    #back{
      /* ///float:right; */
      position: absolute;
      top:190px;
    }
    .dispArea{
        /* color:lightblue; */
    }
    </style>
</head>
<body>
<form id="mainFom" action=""  method="GET">
<input type="hidden" name="treatId" value="<?php echo $_GET['tid'];?>"> 
<div id="main-div">
         <?php
          $id = $_GET['id'];
        

            //  echo"<h1>Treatment id is $treatId</h1>";
         
         ?>
        <div id="result-div">
            <?php
              if (isset($_GET['id']) && isset($_GET['tid'])) {
               $id = $_GET['id'];
                $tid = $_GET['tid'];
            //   echo"<h2> Treatment i is $treatId/h2>";
             $getName0 ="select patient.name, treatment.treatment from patient natural join treatment
             where patient.sno=$id and treatment.tid=$tid"; 
              $query = mysqli_query($conn, $getName0);
             $showName = mysqli_fetch_assoc($query); 
               echo"<h1 class='dispArea'>Are you sure you want to delete treatment record of  "."$showName[name]"."?</h1>";
               echo"<h1 class='dispArea'>Treatment name :  "."$showName[treatment]"."?</h1>";///
              }
             if (isset($_GET['deleteTreatment'])) {
                $treatId = $_GET['treatId'];
        // //      $id = $_GET['id'];
        //    echo"<h1> hello</h1>";
        //   echo"<h1>tratmentt id is =".$treatId."</h1>";
             $deleteTreat ="delete from treatment where tid=$treatId";
             $deleteTreatQuery = mysqli_query($conn, $deleteTreat);
             if ($deleteTreatQuery) {
                //  echo"<h1>Deleted</h1>";
             echo "<script>window.location.href='../TreatmentDetail.php?id=$id&Delete=$deleteTreatQuery';</script>"; //pass foreign key
              } else {
             # code...
             echo"<h1>Deletion failed </h1>";
               }
            }//
            ?>


    </div>

    <input type="hidden" name="name" value="<?php echo$fid;?>">
    <div id="back"><input type="submit" class="btns" value="Back"></div>
    <input type="hidden" name="id" value="<?php echo$_GET['id'];?>">
    <input type="hidden" name="primary" value="<?php echo$patName;?>">
    <input type="hidden" name="n" value="<?php echo$name5;?>">

    <div id="Yes"><input type="submit" name="deleteTreatment" value="Yes" class="btns"></div>
   </form>
    <form id="submitFom">
</form>
</body>
</html>