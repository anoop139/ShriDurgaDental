<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
	 #header0{
      background-color:lightblue;
     }
	 
     #header{
        position: absolute;
        top:0px;       
        right:20px;
     }
     #header ul li{
      list-style-type:none;
     }
	 #header ul li{
     float:left;
     }
	 #header ul li{
     margin-left:20px
     }
   	
     body{
        background-image: url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBztpBXjR7M2C_AkcfV_0IWiQ48qGrmTgPLw&s");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;  
     }
     form{
         position: absolute;
         top:75px;
         left:800px;
     }
     .treat{
      border:2px solid black;
     }
    </style>
	<link rel="stylesheet" href="Header.css?v=6">
</head>
<body>
<div id="header0" style="background-color:lightblue;">
  <div id="header">
    <ul>
      <li><a href="HomePage.html">Home</a></li>
      <li><a href="http://localhost:8081/Shri/display.php">Patients List</a></li>
      <li><a href="">Search by Name</a></li>
    </ul>
  </div><br><br>
</div>
  <div id="div1">
    <h1>Enter Treatmemt </h1>
    <h1>Enter Amount </h1>
  </div>
  <form action="http://localhost:8081/Shri/Display.php">
    <input type="text" name="treat" id="treat1" class="treat"><br><br><br>
    <input type="number" name="amt" id="" class="treat"><br>
    <input type="submit" name="" id="sub" class="treat"><br>
  </form>    
</body>
</html>