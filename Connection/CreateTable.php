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
           date DATE,
               sno INT PRIMARY KEY AUTO_INCREMENT,
              name VARCHAR(20),
              age INT,
             gen VARCHAR(10),
            phoNo VARCHAR(10) UNIQUE,
			admin_id int 

            ) ENGINE=InnoDB;";
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
       $ct =" CREATE TABLE treatment(
    date DATE,
    dueDate DATE,
    tid INT PRIMARY KEY AUTO_INCREMENT,
    treatment VARCHAR(255),
    advance INT,
	online  Int,
    amount INT,
    sno INT NOT NULL,
    admin_id INT NOT NULL,
    
    FOREIGN KEY (sno)
    REFERENCES patient(sno)
    ON DELETE CASCADE
) ENGINE=InnoDB;";
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