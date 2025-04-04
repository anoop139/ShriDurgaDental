<?php
include("../Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
      top:61px;
    }
    #back{
      /* ///float:right; */
      position: absolute;
      top:200px;
    }
    </style>
</head>
<body>
<form id="mainFom" action=""  method="GET"> 
<div id="main-div">
         <?php
        //   $fid = $_GET['id'];////////////

            //  echo"<h1>id is $fid</h1>";
         
         ?>
        <div id="result-div">
            <?php
              if ($_GET['fid2']) {
                $patName = $_GET['fid2'];
            //   echo"<h2>Todays id is $patName</h2>";
             $getName0 ="select name from patient  where sno=$patName";
             $query = mysqli_query($conn, $getName0);
             $showName = mysqli_fetch_assoc($query); 
               echo"<h1>Are you sure you want to delete treatment record of  "."$showName[name]"."?</h1>";
              }
             if (isset($_GET['deleteTreatment'])) {
             $fid = $_GET['primary'];
             $id = $_GET['id'];
        //    echo"<h1>fid =".$fid1."</h1>";
        //    echo"<h1>tratmentt id is =".$id."</h1>";
             $deleteTreat ="delete from treatment where sno=$id";
             $deleteTreatQuery = mysqli_query($conn, $deleteTreat);
             if ($deleteTreatQuery) {
                 echo"<h1>Deleted</h1>";
             echo "<script>window.location.href='../Info.php?id=$fid &delete=$$deleteTreatQuery';</script>"; //pass foreign key
              } else {
             # code...
             echo"<h1>Deletion failed </h1>";
               }
            }
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