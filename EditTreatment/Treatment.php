<?php
include("../Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treatment update page</title>
    <style>
        *{
            padding: 0px;
            margin: 0px;
        }
          body{
  background-image:url("../Images/DelTreat2.jpg");
  background-repeat:no-repeat;
  background-size:cover;

		 
	 }
	
        #main-div{
           margin-top:100px;
        
        }   
        #main-div{
            /* border: //2px solid black; */
            height:60px
        
        }
        .treatDiv{
            position: absolute;
            top:10px;
        }
        .inputDiv{
            position: absolute;
            left: 690px;
            top: 10px;
            bottom: 10px;
        }
        #buttionArea{
            padding-left:10px
        }
        #buttionArea input{
            padding-left:50px;
            padding-right:50px;
         background-color: #FFA07A; /* Coral Orange */
         color:white
        } 
        #Error{
            /* font-size:2em; */
            color:red;
        }
    </style>
</head>
<body>
    <div id="main-div">
     <div class="treatDiv">
        <h1>Enter new name :</h1>
        <form action="" class="inputDiv" onsubmit="return checkInput()" method="get">
            <input type="text" name="treatment" id="input">
            <input type="hidden" name="id" value="<?php echo$_GET['id'];?>">
            <h2 id="Error">
                <?php
                 $id = $_GET['id'];
                   
              if (isset($_GET['Submit']))
                 {
                   $treatment = $_GET['treatment'];
                   $update ="update treatment set treatment='$treatment' where tid=$id";//
                   $treatQuery = mysqli_query($conn, $update);
                   if ($treatQuery) {
                    // echo"Treatment update";
                    echo"
                    <script>
                    window.location.href='./EditTreatment.php?tid=$id&update=true';
                    </script>
                    
                    ";
                     
                   }
                  else {
                  
                     echo"Updation failed ".$id." and  ".$treatment;

                  }

                }
                ?>
            </h2>
          <div id="buttionArea">  <input type="submit" name="Submit" value="Update"></div>
        </form>
     </div>
    </div>
    <script>
        let inpt = document.getElementById("input");
        let error = document.getElementById("Error");
        function checkInput() {
            if (inpt.value=="") {
                // alert(0)
                error.innerHTML="Enter treatment"
                return false
            }
        }
        oninput =()=>{
            error.innerHTML=""
        }
    </script>
</body>
</html>