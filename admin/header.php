<!DOCTYPE html>
<html lang="en">
<head>
  <title>Client</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  .jumbotron {
      background-color: Black;
      color: white;
	  padding: 16px;
	  margin: 1px;
	  
  }
  .affix {
      top: 0;
      width: 100%;
	  z-index:100;
  }
.affix + .container-fluid {
      padding-top: 70px;
  }
  </style>
</head>
<body>
<div class="jumbotron text-center" id="home">
  <h1>Client</h1> 
  <p>Welcome to the admin dashboard</p> 
</div>
<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="529">
  <div class="container">
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
      <?php
          if(isset($_SESSION['admin']))
          {
		        echo '<li><a href="admin_logout.php">LOGOUT</a></li>';
          }
          else
          {
            echo '';
          }
      ?>
        <li><a href="../index.php">HOME</a></li>
        <li><a href="../charts/index.php">POSTS</a></li> 
      </ul>
    </div>
  </div>
</nav>
    </body>
</html>