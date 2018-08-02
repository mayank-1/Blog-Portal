<?php

	
	if(isset($_POST["submit"]))
	{
		$name=$_POST['name'];
		$email=$_POST['email'];
		$content=$_POST['comments'];
		$conn = include('db/connect.php');
		$sql="INSERT INTO feedback(name,email,message) VALUES ('$name','$email','$content')";
		if(mysqli_query($conn,$sql))
		{
			
			echo 'inserted successfully';
			header('location: index.php');
		}	
		else
		{
				echo 'not inserted';
				header('location: index.php');
		}
	}
?>