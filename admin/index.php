<?php
session_start();
if(!isset($_SESSION["admin"])){
	header("location: admin_login.php");
	exit();//Only exit if there is no $_SESSION["manager"] variable set. But if the variable exist then execute below
}
//Be sure to check that this manager SESSIOn value is in fact in the Database

$managerID = preg_replace('#[^0-9]#i',"",$_SESSION["id"]);//filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i',"",$_SESSION["admin"]);//filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i',"",$_SESSION["password"]);//filter everything but numbers and letters
//Run mySQL query to be sure that this person is an admin and their password session var equals the database information
//Connect to the MySQL database

$conn = include "../db/connect.php";
$sql = "SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1";
if($result = mysqli_query($conn,$sql))//query the person
	{

	//-------MAKE SURE THE PERSON EXIST IN DATABASE-----------
		$existCount = mysqli_num_rows($result);//count the row numbers exist in table
		if($existCount == 0)//evalute the count
		{
			header("location: ../index.php");
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Admin Page</title>
	<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
	<div id="mainWrapper" align="center">
		<div class="header">
		<!--Header goes here--><?php include 'header.php';?>
		</div>
		
		<div id="pageContent" style="overflow-x: auto;overflow-y: auto; height: 100%;"><br/>
			<div align="left" style="margin-left: 24px;"><h1>Hello <?php echo $manager; ?>, <small>what woud you like to do today?</small></h1>
			<br>
			<a href="http://localhost/sannibh/admin/post_list.php" class="btn btn-danger" role="button">View Post</a>
			</div>
			<br/>
			<br/>
			<br/>
		</div>
		<div>
			<!--Footer goes here-->
			<?php include 'footer.php'; ?>
		</div>
		
	</div>
</body>
</html>