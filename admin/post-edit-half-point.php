<!--===================PARSE THE FORM DATA AND ADD INVENTORY ITEM TO THE SYSTEM=======================================-->
<?php
$conn = include "../db/connect.php";
//$conn = include "../storescripts/connect_to_mysql.php";
if(isset($_POST['title'])){
	$pid = mysqli_real_escape_string($conn,$_POST['thisID']);
	$title = mysqli_real_escape_string($conn,$_POST['title']);//this method will filter your data before you send it to the database, and you must be connected to the database to execute this function.
	$post = mysqli_real_escape_string($conn,$_POST['post']);
	$pos=mysqli_real_escape_string($conn,$_POST['pos']);
	$filename = $_FILES['fileField']['name'];

	
	//See if the product match is an identical match to another product in the system
	$sql = "UPDATE news SET title='$title',content='$post',view='$pos' WHERE id='$pid'";
	mysqli_query($conn,$sql);
	if($filename != ""){//they must have a new image selected before updation or overwriting the existing image.
		//Place image in the folder
		move_uploaded_file($_FILES['fileField']['tmp_name'],"../file/".$filename);//$_FILES is a global variable.
	}
header("location: post_list.php");//if you will not include this line then it will add the same product again if you refresh the page.
exit();
	
}

?>
<!--=======================================================ENDS HERE==================================================-->