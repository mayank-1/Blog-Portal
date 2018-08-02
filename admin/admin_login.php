<?php
session_start();//Start session first to access session variables.
/*if(!isset($_SESSION["manager"])){//If already logged in then it will redirect to the admin_login.php
	header("location: admin_login.php");
	exit();
}*/
if(isset($_SESSION["admin"]))
{
	header("location: index.php");
}
?>

<?php
//Parse the log in form if the user has filled it out and pressed "log In"
if(isset($_POST["username"])&&isset($_POST["password"])){

	$manager = preg_replace('#[^A-Za-z0-9]#i',"",$_POST["username"]);//filter everything but numbers and letters
	$password = preg_replace('#[^A-Za-z0-9]#i',"",$_POST["password"]);//filter everything but numbers and letters

	//Connect to MySQL Database
	$conn = include"../db/connect.php";
	$sql = "SELECT id FROM admin WHERE username='".$manager."' AND password='".$password."' LIMIT 1";
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
			//$_SESSION["manager"]=$manager;//The values of row that is selected and its manager value will be stored in the session variable.
			$_SESSION["admin"]=$manager;
			$_SESSION["password"]=$password;//he values of row that is selected and its password value will be stored in the session variable.
			header("location: index.php");
			exit();
		}

	}else{
		echo 'That information is incorrect, try again <a href="index.php">Click Here</a>';
		exit();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>
<body>
	<?php include 'header.php'; ?>
	<br/><br/><br/>
	<div class="container">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3>Admin Login</h3>
					</div>
					<div class="panel-body">
						<form name="f1" method="post">
						  <div class="form-group">
						    <label for="userN">User Name:</label>
						    <input type="text" class="form-control" id="userN" name="username">
						  </div>
						  <div class="form-group">
						    <label for="pwd">Password:</label>
						    <input type="password" class="form-control" id="pwd" name="password">
						  </div>
						  <button type="submit" class="btn btn-default" name="submit">Login</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-4"></div>
		</div>
	</div>
		<!--<form name="f1" method="post">
			<table>
				<tr>
					<td>
						Username 
					</td>
					<td>
						<input type="text" name="username" />
					</td>
				</tr>
				<tr>
					<td>
						Password 
					</td>
					<td>
						<input type="Password" name="password" />
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" name="submit" value="Login">
					</td>
				</tr>
			</table>
		</form>-->
	
	<br/><br/><br/>
	<?php include 'footer.php'; ?>
</body>
</html>