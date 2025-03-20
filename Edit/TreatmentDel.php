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
    </style>
</head>
<body>
<form id="mainFom" action="../info.php?"  method="GET">
<div id="main-div">
        <div id="result-div">
            <?php
             $fid = $_GET['t'];
             $fid2 = $_GET['fid2'];
           $name5 = $_GET['name3'];
             $getName0 ="select name from patient  where name='$name5'";
             $query = mysqli_query($conn, $getName0);
             $showName = mysqli_fetch_assoc($query); 
             echo"<h1> The primary key is   ".$fid."</h1>";
            //  echo"id ".$showName;
               echo"<h1>Are you sure you want to delete treatment record of  ".$name5."?</h1>";
               
            ?>
        </div>
    </div>
    <input type="hidden" name="name" value="<?php echo$fid;?>">
    <input type="submit" class="btns" value="Back">
</form>
<form action="../Info.php?" id="delRequ">
    <input type="hidden" name="name3" value="<?php echo$fid2;?>">
    <input type="hidden" name="primary" value="<?php echo$fid;?>">
    <input type="hidden" name="name4" value="<?php echo$name5;?>">
    <input type="submit" class="btns" value="yes">
</form>
</body>
</html>