
<!--===================================USED TO GENERATE SESSION===================================================-->
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
<!--========================DELETE ITEM QUESTION TO ADMIN & DELETE post IF THEY CHOOSE=============================-->
<?php

// $conn = include "../db/connect.php";
// if(isset($_GET['deleteid'])){
// 	echo '<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script></head><body style="padding: 16px; margin:auto;"><center><div class="panel panel-default panel-body"><h2>Do you really want to delete post with ID of <strong>'.$_GET['deleteid'].'</strong> ?</h2><br><br><hr>&nbsp;<a class="btn btn-danger" href="post_list.php?yesdelete='.$_GET['deleteid'].'">Yes</a><a class="btn" href="post_list.php">No</a></div></center></body>';
// 	//echo 'Do you really want to delete post with ID of'.$_GET['deleteid'].'? <a href="post_list.php?yesdelete='.$_GET['deleteid'].'">Yes</a> | <a href="post_list.php">No</a>';
// 	exit();

$conn = include "../db/connect.php";
if(isset($_GET['deleteid'])){
	echo '<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script></head><body style="padding: 16px; margin:auto;"><center><div class="panel panel-default panel-body"><h2>Do you really want to delete post with ID of <strong>'.$_GET['deleteid'].'</strong> ?</h2><br><br><hr>&nbsp;<a class="btn btn-danger" href="post_list.php?yesdelete='.$_GET['deleteid'].'">Yes</a><a class="btn" href="post_list.php">No</a></div></center></body>';
	//echo 'Do you really want to delete post with ID of'.$_GET['deleteid'].'? <a href="post_list.php?yesdelete='.$_GET['deleteid'].'">Yes</a> | <a href="post_list.php">No</a>';
	exit();
}

if(isset($_GET['yesdelete'])){
	//remove item from system and delete its picture
	//delete from database first
	$id_to_delete=$_GET['yesdelete'];

	//Get the item details and from that item detail get the filename. Store filename in a variable and then
	//delete the record from the database and then after delete the file.
	$sql1 = "SELECT filename FROM news where id=$id_to_delete limit 1";
	if($result1=mysqli_query($conn,$sql1))
	{
		while($row=mysqli_fetch_assoc($result1))
		{
			$file_to_delete=$row["filename"];
		}
	}
	$sql="DELETE FROM news WHERE id='$id_to_delete' LIMIT 1";
	if($result=mysqli_query($conn,$sql)){
		$filetodelete=("../file/$file_to_delete");
		if(file_exists($filetodelete)){
			unlink($filetodelete);
		}
		header("location: post_list.php");
		//exit();
	}else{
		echo 'No such record found !';
	}
	//unlink the image from the server
	//Remove The Pic---------------
	//$filename=$_GET['filename'];//new line added
	
	//header("location: post_list.php");
	//exit();
	}
	
?>

<!--===================PARSE THE FORM DATA AND ADD INVENTORY ITEM TO THE SYSTEM=======================================-->
<?php
$conn = include "../db/connect.php";
if(isset($_POST['button'])){

	$title = mysqli_real_escape_string($conn,$_POST['title']);//this method will filter your data before you send it to the database, and you must be connected to the database to execute this function.
	$post = mysqli_real_escape_string($conn,$_POST['post']);
	$category = mysqli_real_escape_string($conn,$_POST['category']);
	$pos=mysqli_real_escape_string($conn,$_POST['pos']);

	//See if the post match is an identical match to another post in the system
	$sql = "SELECT id FROM news WHERE title='$title' LIMIT 1";
	if($result=mysqli_query($conn,$sql))
	{
		$postMatch = mysqli_num_rows($result);
		if($postMatch > 0){
			echo 'Sorry you tried to place a duplicate "post Name" into the system, <a href="post_list.php">Click here</a>';
			exit();
		}
	}

	$filename=$_FILES['fileField']['name'];
	//print_r($_FILES);

	
	//Add this post into database now
	$sql = "INSERT INTO news(title,category,content,date_added,view,filename) VALUES ('$title','$category','$post',now(),'$pos','$filename')";//now() will add todays date in database

//------------------------------------------------------------------------------------------------------
//-------------This php code will fetch the image file from the form and save it in a folder on the server----
//------------------------------------------------------------------------------------------------------
	if($result = mysqli_query($conn,$sql)){
	$pid = mysqli_insert_id($conn);//Generated an auto-generated id

	//Place file in folder
	move_uploaded_file($_FILES['fileField']['tmp_name'],"../file/".$filename);//$_FILES is a global variable.

	header("location: post_list.php");//if you will not include this line then it will add the same product again if you refresh the page.
	exit();
	}
	else{
		echo"Data didn't inserted in the database";
	}	
	
}

//------------------------------------------------------------------------------------------------------
//----------This php code will fetch the video file from the form and save it in a folder on the server-
//------------------------------------------------------------------------------------------------------
/*if($result = mysqli_query($conn,$sql)){
	$pid = mysqli_insert_id($conn);//Generated an auto-generated id

	//Place image in the folder
	$newname = "$pid.mp4";
	move_uploaded_file($_FILES["fileField2"]["tmp_name"],"../video/".$newname);//$_FILES is a global variable.
	header("location: post_list.php");//if you will not include this line then it will add the same product again if you refresh the page.
	exit();
	}
	else{
		echo"Data didn't inserted in the database";
	}	
	
}
*/
?>
<!--=======================================================ENDS HERE==================================================-->


<!--=======================THIS PHP IS FETCHING THE postS DETAILS FOR VIEWING======================================-->
<?php
$conn = include "../db/connect.php";
$post_list="";
$sql="SELECT * FROM news ORDER BY id DESC" ;
if($result=mysqli_query($conn,$sql))
{
	$postCount = mysqli_num_rows($result);//count the output amount
	if($postCount > 0){
		$post_list="<ul class='list-group'>";
		while($row=mysqli_fetch_assoc($result))
		{
			$id=$row["id"];//Accessing each rows id in the posts table.
			$post_title=$row["title"];
			$date_added=strftime("%b %d, %Y",strtotime($row["date_added"]));//strtime is stringtime function and strtotime is string to time function in php to format te date to look the way we want.
			$post_list.="<li class='list-group-item'><div>$date_added - $id - $post_title &nbsp;&nbsp;&nbsp;<a href='post_edit.php?pid=$id'><span class='glyphicon glyphicon-pencil'></span></a> | <a href='post_list.php?deleteid=$id'><span class='glyphicon glyphicon-trash'></span></a></div></li>";//&nbsp is a space charachter 
			//and i have inserted a (.) before (=) so that all the values will be shown compundedly.
			//invenory_edit.php?pid=$id points to that post whose post id matches with the requested id. 
		}
		$post_list.="</ul>";
	}else{
		$post_list="You have no posts listed in your store yet";
	}
}


?>
<!--=========================================ENDS HERE===============================================================-->



<!--=================================INVENTORY PAGE HTML CODE HERE===================================================-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../style/style.css" media="screen">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		function validateForm(){
			if(document.forms["myForm"]["title"].value ==""){
				alert("Please type post Name");
				isValid = false;
			}else if(document.forms["myForm"]["content"].value ==""){
				alert("Please Enter post Price");
				isValid = false;
			}else if(document.forms["myForm"]["fileField"].value ==""){
				alert("Please upload an Image");
				isValid = false;
			}
			return isValid;
		}

		$(document).ready(function(){
			$("#list").show();
			$("#inputs").hide();
  			$("#add_btn").click(function() {
  				$("#list").hide();
				$("#inputs").show();
  			});
  			$("#back_btn").click(function() {
  				$("#list").show();
				$("#inputs").hide();
  			});
  		});
	</script>
</head>
<body>
	<div class="header">
		<!--Header goes here--><?php include 'header.php';?>
	</div>
	
	<div id="mainWrapper" align="center">
		<div id="pageContent"><br/>
			<div id="list">
				<a id="add_btn" class="btn btn-danger" role="button">+ Add New Post</a>
				<div align="left" style="margin-left: 24px;">
					<h2 class="">In List</h2>
					<?php echo $post_list; ?>
				</div>
			</div>

			<div id="inputs">
				<a id="back_btn" class="btn btn-danger" role="button">&larr; Back</a>
				<div class="container">
					<hr>
					<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-hading"> 
							<h3 class="text-center"> Add New Post </h3>		
						</div>
						<div class="panel-body text-left">
							<form action="post_list.php" enctype="multipart/form-data" method="post" name="myForm" id="myForm" onsubmit="return validateForm()">
								<div class="form-group">
									<label for="title">Title:</label>
									<input type="text" name="title" id="title" size="65" placeholder="Enter title here" />
								</div>	
								<div class="form-group">
									<label for="post">Post:</label>
									<textarea class="form-control" name="post" id="post" cols="64" rows="6"></textarea>
								</div>	
								<div class="form-group">
									<div class="col-md-offset-1 col-md-11">
										<div class="radio "><input type="radio" name="category" value="daily" checked>Daily</div>
										<div class="radio"><input type="radio" name="category" value="weekly">Weekly</div>
										<div class="radio"><input type="radio" name="category" value="quaterly">Quaterly</div>
										<div class="radio"><input type="radio" name="category" value="yearly">Yearly</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-1 col-md-11">
										<div class="radio "><input type="radio" name="pos" value="0" checked>Right</div>
										<div class="radio"><input type="radio" name="pos" value="1">Left</div>
										<div class="radio"><input type="radio" name="pos" value="2">Up</div>
										<div class="radio"><input type="radio" name="pos" value="3">Down</div>
									</div>
								</div>
								&nbsp;
								<hr>
								<div class="form-group">
									<label>File:<input type="file" name="fileField" id="fileField"></label>
								</div>
								<div class="text-center">
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
		</div>
	</div>
	<!--Footer goes here-->
	<?php include 'footer.php'; ?>
</body>
</html>
<!--=========================================================ENDS HERE================================================-->
<!--<form action="post_list.php" enctype="multipart/form-data" method="post" name="myForm" id="myForm" onsubmit="return validateForm()">
			<table width="90%" border="0" cellpadding="6" cellspacing="10px">
				<tr>
					<td width="20%">Title</td>
					<td width="80%"><input type="text" name="title" id="title" size="65" placeholder="Enter title here" /></td>
				</tr>
				&nbsp;
				<tr>
					<td>Post</td>
					<td><textarea name="post" id="post" cols="64" rows="6"></textarea></td>
				</tr>
				&nbsp;
				<tr>
					<td>Category</td>
					<td>
						<input type="radio" name="category" value="daily" checked>Daily
						<input type="radio" name="category" value="weekly">Weekly
						<input type="radio" name="category" value="quaterly">Quaterly
						<input type="radio" name="category" value="yearly">Yearly
					</td>
				</tr>
				&nbsp;
				<tr>
					<td>Image</td>
					<td><input type="file" name="fileField" id="fileField"></td>
				</tr>
				&nbsp;
				<tr>
					<td width="20%">Image Description</td>
					<td width="80%"><input type="text" name="imagedescription" id="imagedescription" size="65" placeholder="Enter the Image Description" /></td>
				</tr>
				&nbsp;
				<tr>
					<td>Video</td>
					<td><input type="file" name="fileField2" id="fileField2"></td>
				</tr>
				&nbsp;
				<tr>
					<td width="20%">Video Description</td>
					<td width="80%"><input type="text" name="videodescription" id="videodescription" size="65" placeholder="Enter the Video Description" /></td>
				</tr>
				<p>&nbsp;</p>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="button" id="button" value="Post"></td>
				</tr>
			</table>
			</form>-->