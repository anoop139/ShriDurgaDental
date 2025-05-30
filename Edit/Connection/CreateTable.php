<?php
include("Connect.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
  #contain{
     border: 2px solid black;
     /* height: 50px; */
     padding: 50px 50px;
  }
  #buttons{
    text-align:right
  }

</style>
<body>
    <div id="contain">
       <?php
        if (isset($_GET['p'])) {
          $pt ="create table patient(
                date varchar(255),
                sno int(255) primary key auto_increment,
                name varchar(255),
                age int(255),
                gen varchar(255),
                phoNo varchar(255) unique

            )";
			$query = mysqli_query($conn, $pt);
			if($query)
			{
				echo"Parent table created succesfully hello ";
			}
			else{
				echo"Failed";
			}
        }
       
       else if (isset($_GET['c'])) {
         $ct ="create table treatment(
              tid int(255) primary key auto_increment,
              treatment varchar(255),  
               amount int(255),
               sno int(255),
             foreign key(sno) references patient(sno) on delete cascade
           );";
		   $query1 = mysqli_query($conn, $ct);
			if($query1)
			{
				echo"Child table created succesfully hello ";
			}
			else{
				echo"Failed";
			}
       }
       ?>
       
    </div>
	<h1>New file</h1>
 <form action="#">
     <div id="buttons">
        <button name="p">Create Parent table</button>
          <button name="c">Create Child table</button>
    </div>
    </form>
</body>
</html>