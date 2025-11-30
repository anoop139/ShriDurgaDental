<?php
include("../Connection/Connect.php");
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="javascriptract">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Date update page</title>
    <style>
        *{
            padding: 0px;
            margin: 0px;
        }
          body{
          background-image:url("../Images/DueDate.png");
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
            left: 700px;
            top: 10px;
            bottom: 10px;
        }
        #buttionArea{
            padding-left:0px;
            /* background:yellow */
        }
        #buttionArea input{
            padding-left:30px;
            padding-right:35px;
         background-color: #AAA17A; /* Coral Orange */
         color:white
        } 
        #Error{
            /* font-size:2em; */
            color:red;
            width: 400px;
        }
    </style>
</head>
<body>
    <div id="main-div">
     <div class="treatDiv">
        <h1>Enter new Date :</h1>
        <form action="" class="inputDiv" onsubmit="return checkInput()" method="POST">
           &nbsp; <input type="date" name="dueDated" id="input">
           &nbsp; <input type="hidden" name="dueDate" id="input2">
            <input type="hidden" name="id" value="<?php echo$_GET['id'];?>"> <br>
            <h2 id="Error">
                <?php
                 $id = $_GET['id'];
                   
              if (isset($_POST['Submit']))
                 {
                   $date = $_POST['dueDate'];
                //    echo"<h1>$date </h1>";
                   $update ="update treatment set dueDate='$date' where tid=$id";//
                   $treatQuery = mysqli_query($conn, $update);
                   if ($treatQuery) {
                    // echo"<h1> new date is $date</h1>";
                    echo"
                    <script>
                    window.location.href='./EditTreatment.php?tid=$id&updateDueDate=true';
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
        let input = document.getElementById("input2");
        let error = document.getElementById("Error");
        function checkInput() {
            if (inpt.value=="") {
                // alert(0)
                error.innerHTML="Enter due date"
                return false
            }
            else{
                let x = inpt.value.split("-").reverse().join(" - ")
                let date = Number(x.charAt(0)+x.charAt(1))
                let month = Number(x.charAt(5)+x.charAt(6))
                let year = Number(x.slice(10,14))
                let currentDate = new Date()
                let currentYear       = currentDate.getFullYear()
                let toDay       = currentDate.getDate()
                let thisMonth       = currentDate.getMonth()+1
                if ((date<toDay || month<thisMonth) || (year<currentYear)) {
                     alert("Wrong due date or year or month")
                    
                    return false
                  
                }
                if (date<10 && month<10) {
                  x = x.replace("0", "")
                 x = x.replace("0", "")
                input.value = x
                // alert("date is "+toDay+" and month is "+thisMo/nth)
                // return false
                }
                else if (date>10 && month<10) {
                 x = x.replace("0", "")
                 input.value = x
                }
                else{
                    input.value=x
                }
            // error.innerHTML="sud"
       ///        return false/////
            }
        }
        oninput =()=>{
            error.innerHTML=""
        }
    </script>
</body>
</html>