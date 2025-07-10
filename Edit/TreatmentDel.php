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
        height:200px;
    }     
    #result-div{
        padding-left:40px
    } 
     .output{
      padding: 20px;
     }
    .output{
    text-align:center;
     }
  #Yes{
     text-align:right;
   } 
 #Yes{
   position: relative;
   top: -40px;    
   }
   .submit{
    padding: 10px;
   }
.submit{
    border:2px solid black
   }
#deleteAll{
  text-align:center
}
#deleteAll{
  position: absolute;
  top:0px;
  left:25px;
}
#deleteAll{
  padding: 50px;
}
#delAll{
  padding-left:1280px;
  margin-top: -105px;
}
 </style>
</head>
<body>
<form id="mainFom" action=""  method="GET">
<input type="hidden" name="treatId" value="<?php echo $_GET['tid'];?>"> 
<div id="main-div">
         <?php
          $id = $_GET['id'];
         ?>
        <div class="result-div output">
            <?php
              if (isset($_GET['id']) && isset($_GET['tid'])) {
               $id = $_GET['id'];
                $tid = $_GET['tid'];
            //   echo"<h2> Treatment i is $treatId/h2>";
             $getName0 ="select patient.name, treatment.treatment from patient join treatment
             where patient.sno=$id and treatment.tid=$tid"; 
              $query = mysqli_query($conn, $getName0);
             $showName = mysqli_fetch_assoc($query); 
               echo"<h1 '>Are you sure you want to delete treatment record of  "."$showName[name]"."?</h1>";
               echo"<h1 class='dispArea'>Treatment name :  "."$showName[treatment]"."?</h1>";///
              }
              
             if (isset($_GET['deleteTreatment'])) {
                $treatId = $_GET['treatId'];
             $deleteTreat ="delete from treatment where tid=$treatId";
             $deleteTreatQuery = mysqli_query($conn, $deleteTreat);
             if ($deleteTreatQuery) {
                 echo"+<h1>Deleted only 1</h1>";//
            //  echo "<script>window.location.href='../TreatmentDetail.php?id=$id&Delete=$deleteTreatQuery';</script>"; //pass foreign key
              } else {
             # code...
             echo"<h1>Deletion failed </h1>";
               }
            }//
            else if (isset($_GET['id']) && isset($_GET['DeleteAll'])) {
             
              echo"<h2> you are in else $id  </h2>";
            // $id = $_GET['id'];
            //   echo"<h2> Treatment i is $treatId/h2>";
            $getName0 ="select patient.name from patient where sno=$id"; 
              $query = mysqli_query($conn, $getName0);
             $showName = mysqli_fetch_assoc($query); 
               echo"<h1 >Are you sure you want to delete all treatment records of  "."$showName[name]"."?</h1>";
             if (isset($_GET['deleteTreatment'])) {
                 $id = $_GET['id'];//use as forien key
                $deleteAll ="Delete from treatment where sno=11";
                $deleteAllQuery = mysqli_query($conn, $deleteAll);
                if ($deleteAllQuery) {
                  echo"<h1>Success all</h1>";
            // echo "<script>window.location.href='../TreatmentDetail.php?id=$id&DeleteAll=$deleteAllQuery';</script>"; //pass foreign key
//pass foreign key
                }
             else{
                 
                 echo"<h1>Deletion failed  $id </h1>";
             }
                 
            }
          }
            ?>


    </div>

    <!-- <input type="hidden" name="name" value="//<?php ///echo$fid;?>"> -->

    <input type="hidden" name="id" value="<?php echo$_GET['id'];?>">
    <input type="hidden" name="primary" value="<?php echo$patName;?>">
    <input type="hidden" name="n" value="<?php echo$name5;?>">
          </div>   
    <span id="back"><input type="submit" class="submit" value="Back"></span>
<div id="Yes"><input type="submit" class="submit" name="deleteTreatment" value="Yes" class="btns"> </div>
 </form>
    <script>
    // onload =()=>{
     if (document.getElementById("da").value=="Delete All") {
    //   alert("hi")//
//       document.getElementById("delAll").style.display="inline"    
  //     document.getElementById("Yes").style.display="none" //
    }

    </script>
        
</body>
</html>