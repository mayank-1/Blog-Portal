
<?php
//session_start();

?>
<?php 
error_reporting(E_ALL & ~E_NOTICE);

?>

<?php
	session_start();
	if(isset($_POST["username"])&&isset($_POST["password"])){

		$manager = preg_replace('#[^A-Za-z0-9]#i',"",$_POST["username"]);//filter everything but numbers and letters
		$password = preg_replace('#[^A-Za-z0-9]#i',"",$_POST["password"]);//filter everything but numbers and letters

		//Connect to MySQL Database
		$conn = include"../db/connect.php";
		$sql = "SELECT id FROM user WHERE username='".$manager."' AND password='".$password."' LIMIT 1";
		if($result=mysqli_query($conn,$sql))
		{
			$existCount = mysqli_num_rows($result);
			if($existCount == 1)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$id = $row["id"];
				}
				$_SESSION["id"]=$id;//The values of row that is selected and its id value will be stored in the session variable.
				$_SESSION["manager"]=$manager;//The values of row that is selected and its manager value will be stored in the session variable.
				$_SESSION["password"]=$password;//he values of row that is selected and its password value will be stored in the session variable.
				$result=mysqli_query($conn,"update user set last_log_date=now() where username='$manager'");
				header("location: ../index.php");
				//echo "<script>window.open('../../index.php','_SELF');</script>";
				//exit();
			}

		}else{
			echo 'That information is incorrect, try again <a href="../index.php">Click Here</a>';
			exit();
		}
	}
//}

?>
