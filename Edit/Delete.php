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
<form id="mainFom" action="../Info.php?"  method="GET">
<div id="main-div">
        <div id="result-div">
            <?php
               $record = $_GET['d'];
               $patName = "select name from patient where sno=$record";
               $query   = mysqli_query($conn, $patName);
               $getName = mysqli_fetch_assoc($query);

               echo"<h1>Are you sure you want to delete record of ".$getName["name"]." ? </h1>";
               
            ?>
        </div>
    </div>
    <input type="hidden" name="name" value="<?php echo$record;?>">
    <input type="submit" class="btns" value="Back">
</form>
<form action="../Info.php" id="delRequ">
    <input type="hidden" name="name2" value="<?php echo$record;?>">
    <input type="hidden" name="name3" value="<?php echo$getName['sno'];?>">
    <input type="submit" class="btns" value="yes">
</form>
</body>
</html>