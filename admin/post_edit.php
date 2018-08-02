<!--===================================USED TO GENERATE SESSION & MANAGE IT==========================================-->
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
$sql = "SELECT * FROM admin WHERE id='".$managerID."' AND username='".$manager."' AND password='".$password."' LIMIT 1";
if($result = mysqli_query($conn,$sql))//query the person
	{

	//-------MAKE SURE THE PERSON EXIST IN DATABASE-----------
		$existCount = mysqli_num_rows($result);//count the row numbers exist in table
		if($existCount == 0)//evalute the count
		{
			echo "Your login session data is not matching any record in the database";
			exit();
		}
	}
?>
<!--========================================ENDS HERE=================================================================-->
<!--============================THIS PHP CODE IS USED FOR ERROR REPORTING=============================================-->
<?php

error_reporting(E_ALL);//Report all the errors
ini_set('display_errors','1');

?>
<!--========================================ENDS HERE=================================================================-->


<!--===================PARSE THE FORM DATA AND ADD INVENTORY ITEM TO THE SYSTEM=======================================
<?php
//$conn = include "../storescripts/connect_to_mysql.php";
/*if(isset($_POST['product_name'])){

	$pid = mysqli_real_escape_string($conn,$_POST['thisID']);
	$title = mysqli_real_escape_string($conn,$_POST['title']);//this method will filter your data before you send it to the database, and you must be connected to the database to execute this function.
	$post = mysqli_real_escape_string($conn,$_POST['post']);
	$pos=mysqli_real_escape_string($conn,$_POST['pos']);

	

	//See if the product match is an identical match to another product in the system
	$sql = "UPDATE news SET title='$title',content='$post',view='$pos' WHERE id='$pid'";

	mysqli_query($conn,$sql);

	if($_FILES['fileField']['temp_name'] != ""){//they must have a new image selected before updation or overwriting the existing image.
		//Place image in the folder
		
		move_uploaded_file($_FILES['fileField2']['temp_name'],"../file/".$newnameimage);//$_FILES is a global variable.
		
	}
	echo "<body><h1>TATATATTATA</h1></body>";
	header("location: ../admin/post_list.php");//if you will not include this line then it will add the same product again if you refresh the page.
		exit();
	
}
*/
?>
=======================================================ENDS HERE==================================================-->

<!--=========GATHER THIS PRODUCT's FULL INFO FOR INSERTING AUTOMATICALLY INTO THE EDIT FORM BELOW ON PAGE=============-->
<?php

$conn = include "../db/connect.php";


if(isset($_GET['pid'])){
	$targetID = $_GET['pid'];
	$product_list="";
	$sql="SELECT * FROM news WHERE id='".$targetID."' LIMIT 1";
	if($result=mysqli_query($conn,$sql))
	{
		$productCount = mysqli_num_rows($result);//count the output amount
		if($productCount > 0){
			while($row=mysqli_fetch_assoc($result))
			{
				
				$title=$row["title"];
				$content=$row["content"];
				$pos=$row["view"];
				$category=$row["category"];
				$date_added=strftime("%b %d, %Y",strtotime($row["date_added"]));//strtime is stringtime function and strtotime is string to time function in php to format the date to look the way we want.
			}
		}else{
			$product_list="You have no products listed in your store yet";
			exit();
		}
	}
}
?>


<!--=================================INVENTORY PAGE HTML CODE HERE===================================================-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Post | Edit</title>
	<link rel="stylesheet" type="text/css" href="../style/style.css" media="screen">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script>
		function validateForm(){
			if(document.forms["myForm"]["content"].value ==""){
				alert("Please Enter post Price");
				isValid = false;
			}else if(document.forms["myForm"]["fileField"].value ==""){
				alert("Please upload file");
				isValid = false;
			}
			return isValid;
		}
	</script>
</head>
<body>
	<div id="mainWrapper" align="center">
		<?php include 'header.php';?>
		<div id="inputs">
				<a id="back_btn" class="btn btn-danger" role="button" href="post_list.php">&larr; Back</a>
				<div class="container">
					<hr>
					<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-hading"> 
							<h3 class="text-center"> Edit Post </h3>		
						</div>
						<div class="panel-body text-left">
							<form action="post-edit-half-point.php" enctype="multipart/form-data" method="post" name="myForm" id="myForm" onsubmit="return validateForm()">
								<div class="form-group">
									<label for="title">Title:</label>
									<input type="text" name="title" id="title" size="65" placeholder="Enter title here" value="<?php echo $title;?>" />
								</div>	
								<div class="form-group">
									<label for="post">Post:</label>
									<textarea class="form-control" name="post" id="post" cols="64" rows="6"><?php echo $content;?></textarea>
								</div>	
								<div class="form-group">
									<div class="col-md-offset-1 col-md-11">
										<div class="radio "><input type="radio" name="category" value="daily" <?php if($category=='daily') echo 'checked'; ?>>Daily</div>
										<div class="radio"><input type="radio" name="category" value="weekly" <?php if($category=='weekly') echo 'checked'; ?>>Weekly</div>
										<div class="radio"><input type="radio" name="category" value="quaterly" <?php if($category=='quaterly') echo 'checked'; ?>>Quaterly</div>
										<div class="radio"><input type="radio" name="category" value="yearly" <?php if($category=='yearly') echo 'checked'; ?>>Yearly</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-1 col-md-11">
										
										<div class="radio "><input type="radio" name="pos" value="0" <?php if($pos==0) echo 'checked'; ?>>Right</div>
										<div class="radio"><input type="radio" name="pos" value="1" <?php if($pos==1) echo 'checked'; ?>>Left</div>
										<div class="radio"><input type="radio" name="pos" value="2" <?php if($pos==2) echo 'checked'; ?>>Up</div>
										<div class="radio"><input type="radio" name="pos" value="3" <?php if($pos==3) echo 'checked'; ?>>Down</div>
									</div>
								</div>
								&nbsp;
								<hr>
								<div class="form-group">
									<label>File:<input type="file" name="fileField" id="fileField"></label>
								</div>
								<div class="text-center">
									<input type="text" name="thisID" value="<?php echo $targetID;?>">
									<input class="btn btn-primary" type="submit" name="button" id="button" value="Post">
								</div>
							</form>		
						</div>
					</div><!--yaha khatam hita hai-->
					</div>
					<div class="col-md-2"></div>
					</div>
				</div>
			</div>
		<?php include 'footer.php';?>
	</div>
</body>
</html>

<!--=========================================================ENDS HERE================================================-->
<!--<div class="logout">
			<table>
				<tr>
					<td>&nbsp;</td>
					<td><a style="float: right; padding:5px;" href="http://localhost/sannibh/admin/admin_logout.php">LOGOUT</a></td>
				</tr>
			</table>
		</div>
		<div id="pageContent" style="height: 700px;"><br/>
			<div align="right" style="margin-right: 34px"><a href="post_list.php#inventoryFrom">+ Add New Post</a></div>
			<hr>
			<a name="inventoryFrom" id="inventoryForm"></a>

			<h3>&darr; Add New Post &darr;</h3>
			<form action="post_list.php" enctype="multipart/form-data" method="post" name="myForm" id="myForm" onsubmit="return validateForm()">
			<table width="90%" border="0" cellpadding="6" cellspacing="0">
				<tr>
					<td width="20%">Title</td>
					<td width="80%"><input type="text" name="title" id="title" size="65" placeholder="Enter title here" value="<?php echo $title;?>" /></td>
				</tr>
				<tr>
					<td>Post</td>
					<td><textarea name="post" id="post" cols="64" rows="6"><?php echo $content;?></textarea></td>
				</tr>
				<tr>
					<td>Image</td>
					<td><input type="file" name="fileField" id="fileField"></td>
				</tr>
				<tr>
					<td width="20%">Image Description</td>
					<td width="80%"><input type="text" name="imagedescription" id="imagedescription" size="65" placeholder="Enter the Image Description" value="<?php echo $imagedescription;?>" /></td>
				</tr>
				<tr>
					<td>Video</td>
					<td><input type="file" name="fileField2" id="fileField2"></td>
				</tr>
				<tr>
					<td width="20%">Video Description</td>
					<td width="80%"><input type="text" name="videodescription" id="videodescription" size="65" placeholder="Enter the Video Description" value="<?php echo $videodescription;?>" /></td>
				</tr>
				<tr>
					<td>&nbsp</td>
					<td><input type="submit" name="button" id="button" value="Post"></td>
				</tr>
			</table>
			</form>
		</div> -->