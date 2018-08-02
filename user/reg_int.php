<html>
	<header>
	</header>
	<body>
		<center>
			<?php
			session_start();
			error_reporting(E_ALL ^ E_DEPRECATED);
			if(isset($_REQUEST['submit']))
			{
				error_reporting(E_ALL ^ E_DEPRECATED);
				$n=$_REQUEST['name'];
				$u=$_REQUEST['username'];
				$pa=$_REQUEST['password'];
				$i=$_REQUEST['email'];
				$m=$_REQUEST['mobile'];
			
			
				$count=0;
				$conn=mysql_connect("localhost","root","");
				$db=mysql_select_db("sannibh",$conn);
				$result=mysql_query("select username from user where username='$u'");
				$r=mysql_num_rows($result);
				if($r!=0)
				{
					echo "<script>alert('Username already taken')</script>";
					header("location: ../index.php");
				}
				else
				{

					$qry=mysql_query("insert into user(name,username,password,email,mobile,last_log_date) values('$n','$u','$pa','$i','$m',now())");
					if(mysql_affected_rows($conn) > 0)
					{
						$_SESSION['manager']=$u;
						header("location: ../index.php");
					}
					else
					{
						echo 'No record found';
					}
				}
				mysql_close($conn);
			}	
?>
</body>
</html>