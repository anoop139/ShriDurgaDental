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
          $pt =" create table patient(
           date VARCHAR(20),
               sno INT PRIMARY KEY AUTO_INCREMENT,
              name VARCHAR(20),
              age INT,
             gen VARCHAR(10),
            phoNo VARCHAR(10) UNIQUE

            )";
			$query = mysqli_query($conn, $pt);
			if($query)
			{
				echo"Parent table created succesfully ";
			}
			else{
				echo"Failed";
			}
        }
       
       else if (isset($_GET['c'])) {
         $ct =" create table treatment(
           date varchar(20),                  
           advanceDate varchar(20),                  
                tid int primary key auto_increment,  
                treatment varchar(20),               
                 amount int,                          
                  sno int,                           
               foreign key(sno) references patient(sno) on delete cascade
           );";
		   $query1 = mysqli_query($conn, $ct);
			if($query1)
			{
				echo"Child table created succesfully ";
			}
			else{
				echo "Failed: " . mysqli_error($conn);
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