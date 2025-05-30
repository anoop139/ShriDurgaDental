<?php
include("Connection/Connect.php");
error_reporting(0);
$name = $_GET['n'];
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Edit Page</title>
	<style>
        
	#header0{
		background-color:black

	}
    #updateMessage{
        position: absolute;
        top:-80px;
        color:green;
        transition: transform 3s 
     }
    #updateMessage{
       background-color:white
    }
   
	</style>
    <link rel="stylesheet" href="Header.css?v=7">
    <link rel="stylesheet" href="StlyEdit.css?v=9">
	<div id="header0" style="background-color:lightblue">

<div id="header">

        <ul>
        <li><a href="HomePage.html">Home </a></li>&nbsp;
        <li><a href="Fom.html">Add Patient </a></li>&nbsp;
        
        <li><a href="">Search by Name</a></li>
        </ul>
	
</ul><br><br><br><br><br>
</div>
</div>
<body id="editBody">

<div id="EidtSection">
<?php
if(isset($_GET['id'])){
$id =$_GET['id'];
$newName =$_GET['newName'];
// echo"id id $id<br>";
$query ="Select *from patient where sno=$id";
$query1 = mysqli_query($conn, $query);
$show   = mysqli_fetch_assoc($query1);
}
else if(isset($_GET['newName'])){
	echo"<h1 id='updateMessage'>updated successfully</h1>";
	$newName =$_GET['newName'];
	//Kecho"val in $newName after updation <br>";
$query ="Select *from patient where sno=$newName";
$query1 = mysqli_query($conn, $query);
$show   = mysqli_fetch_assoc($query1);
}
?>

<script>
   

</script>
<table border='2' cellpadding="4">
<tr style='padding:2px'>
<th>Name</th>
<th>Edit name</th>
<th>Age</th>
<th>Edit age</th>
<th>Gender</th>
<th>Edit Gender</th>
<th>Phone Number</th>
<th> Edit Phone Number</th>
<th>Delete</th>
</tr>
<tr>
<td><?php echo$show['name'];?></td>
<td><a href="Edit/Name.html?id=<?php echo $show['sno'];?>">Edit name</a></td>
<td style="text-align:center;"><?php echo$show['age'];?></td>
<td style="text-align:center;"><a href="Edit/Age.html?id=<?php echo $show['sno'];?>">Edit age</a></td>
<td style="text-align:center;"><?php echo$show['gen'];?></td>
<td style="text-align:center;"><a href="Edit/Gender.html?id=<?php echo $show['sno'];?>">Edit gender</a></td>
<td><?php echo$show['phoNo'];?></td>
<td><a href="Edit/Phone.html?id=<?php echo $show['sno'];?>">Edit phone number</a></td>
<td><a href="Edit/DeletePatientRecord.php?id=<?php echo $show['sno'];?>">Delete</a></td>
</tr>
</table>
<script>
  let mess = document.getElementById("updateMessage")
window.onload=(()=>{
    mess.style.transform="translateY(80px)";
})

  setTimeout(() => {
      mess.style.transform="translateY(-80px)";
  }, 5000);
</script>
</div>
<body>
<?php
$id = $_GET['id'];
$name2 = $_GET['name'];
//echo"Devoloping editing anna's edit page om sai";
?>
</html>