<?php 
error_reporting(E_ALL & ~E_NOTICE);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
		<ul class="nav navbar-nav">
			<li><a href="../index.php">Home</a></li>
	      	<li><a id="s_d" href="index.php">Daily</a></li>
	      	<li><a id="s_w" href="weekly.php">Weekly</a></li>
	      	<li class="active"><a id="s_q">Quaterly</a></li>
	      	<li><a id="s_y" href="yearly.php">Yearly</a></li>
	    </ul>
        <ul class="nav navbar-nav pull-right">
	      <li class="dropdown">
	        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<?php 

		        session_start();

		        if(isset($_SESSION["manager"]))
                {

                  echo 'Hi,'.$_SESSION["manager"];

                }                

                else if(isset($_SESSION["admin"]))

                {

                  echo 'Hi,'.$_SESSION["admin"];      

                }

                else

                {
                	echo 'Hi, User';
                } 
            ?>
	        <span class="caret"></span></a>
	        <ul class="dropdown-menu">
	          <li><a href="../user/user_logout.php">LOGOUT</a></li>
	        </ul>
	      </li>
    	</ul>
	    </div>
	    </div>
	</nav>
<div style="padding:10px ">
<?php
	$conn = include "../db/connect.php";

	isset($_GET['page']);
		$page = $_GET["page"];

		if($page=="" || $page=="1")
		{
			$page1=0;
		}
		else
		{
			$page1 = ($page*10)-10;
		}

	$post_list="";
	$sql="SELECT * FROM news WHERE category='quaterly' ORDER BY id DESC LIMIT $page1,10"; //Edited line
	if($result=mysqli_query($conn,$sql))
	{
		$postCount = mysqli_num_rows($result);//count the output amount
		if($postCount > 0){
			while($row=mysqli_fetch_assoc($result))
			{
				$id=$row["id"];//Accessing each rows id in the posts table.
				$post_title=$row["title"];//Post Title
				$post_desc=$row["content"];//Post desc
				$label=$row["category"];//Post Lable
				$view=$row["view"];//View type
				$filename=$row["filename"];
				
				//$view=$row["view"];
				$date_added=strftime("%b %d, %Y",strtotime($row["date_added"]));//strtime is stringtime function and strtotime is string to time function in php to format te date to look the way we want.

				/* view codes
					0 -fileR-post
					1 -fileL-post
					2 -fileU-post
					3 -fileD-post
				*/
				$post_list.='<div class="panel panel-default">';

				switch ($view) {
					case 0:
							$post_list.='<div class="panel-body ">
								<div class="container">
									<div class="row">
										<div class="col-md-6">
											<h2>'.$post_title.'</h2>
											<h2 class="small">'.$date_added.'</h2><br><hr>
											<p>'.$post_desc.'</p>
										</div>
										<div class="col-md-6">
											<iframe width="600" height="400" frameborder="0" src="http://docs.google.com/gview?url=../file/'.$filename.'&embedded=true"></iframe> 
										</div>
									</div>
								</div>
							</div>';
						break;
					case 1:
							$post_list.='<div class="panel-body">
								<div class="container">
									<div class="row">
										<div class="col-md-6 col-md-push-6">
											<h2>'.$post_title.'</h2>
											<h2 class="small">'.$date_added.'</h2><br><hr>
											<p>'.$post_desc.'</p>
										</div>
										<div class="col-md-6 col-md-pull-6">
											<iframe width="600" height="400" frameborder="0" src="http://docs.google.com/gview?url=../file/'.$filename.'&embedded=true"></iframe> 
										</div>
									</div>
								</div>
							</div>';
						break;
					case 3:
							$post_list.='<div class="panel-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<h2>'.$post_title.'</h2>
											<h2 class="small">'.$date_added.'</h2><br><hr>
											<p>'.$post_desc.'</p>
										</div>
										<div class="col-md-12">
											<iframe width="600" height="400" frameborder="0" src="http://docs.google.com/gview?url=../file/'.$filename.'&embedded=true"></iframe> 
										</div>
									</div>
								</div>
							</div>';
						break;
					case 2:
							$post_list.='<div class="panel-body">
								<div class="container">
									<div class="row">
										<div class="col-md-12">
											<iframe width="600" height="400" frameborder="0" src="http://docs.google.com/gview?url=../file/'.$filename.'&embedded=true"></iframe> 
										</div>
										<div class="col-md-12">
											<h2>'.$post_title.'</h2>
											<h2 class="small">'.$date_added.'</h2><br><hr>
											<p>'.$post_desc.'</p>
										</div>
									</div>
								</div>
							</div>';
						break;
					default:
						# code...
						break;
				}

				$post_list.="</div>";

	//&nbsp is a space charachter 
				//and i have inserted a (.) before (=) so that all the values will be shown compundedly.
				//invenory_edit.php?pid=$id points to that post whose post id matches with the requested id. 
			}
		}else{
			$post_list="<h1>You have no posts yet</h1>";
		}
	}
		echo $post_list;
		echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
	//This is for counting number of pages.
	$sql="SELECT * FROM news WHERE category='quaterly'";
	$result1 = mysqli_query($conn,$sql);
	$cou = mysqli_num_rows($result1);

	$a = $cou/10;
	$a = ceil($a); 

	for($b=1;$b<=$a;$b++)
	{
		?><a href="index.php?page=<?php echo $b;?>" style="text-decoration: none; margin-left: 10px; margin-bottom: 5px;" class="btn btn-primary btn-small"><?php echo $b; ?></a><?php 
	}
?>
</div>

</body>
</html>