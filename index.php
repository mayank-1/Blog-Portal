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
  .verticalright {
    border-right: thin solid #000;
  }
  </style>

  <script type="text/javascript">
    //for resizing iFrame
    function resizeiF(obj) {
      obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
  </script>
</head>
<body>
<div class="jumbotron text-center" id="home">
  <h1>Client</h1> 
  <p>Education first</p> 
</div>
<div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
	<li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    <h4><img src="carousel_image/1.jpg" class="img-rounded" alt="carousel-image" width="50%" height="393 px" ></h4>
    </div>
    <div class="item">
      <h4><img src="carousel_image/2.jpg" class="img-rounded" alt="carousel-image" width="50%" height="393 px" ></h4>
    </div>
    <div class="item">
      <h4><img src="carousel_image/3.jpg" class="img-rounded" alt="carousel-image" width="50%" height="393 px" ></h4>
    </div>
    <div class="item">
      <h4><img src="carousel_image/4.jpg" class="img-rounded" alt="carousel-image" width="50%" height="393 px" ></h4>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<?php
  session_start();
  if(isset($_SESSION['manager']))
  {
    echo '<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="480.75" id="services_vir">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#home">HOME</a></li>
      <li><a data-toggle="collapse" data-parent="#accordian" href="#collapse2">SERVICES</a></li>
      <li><a data-toggle="collapse" data-parent="#accordian" href="#collapse3">WORKSHOP</a></li>
      <li><a href="/sannibh/charts/index.php">CHARTS</a></li>
      <li><a href="#contact">CONTACT US</a></li>
      <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="user/user_login.php"> Hi,'.$_SESSION['manager'].'
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="user/user_logout.php">LOGOUT</a></li>
          </ul>
        </li>
    </ul>
    </div>
  </div>
</nav>
';
  }
  else
  {
    echo '<nav class="navbar navbar-inverse" data-spy="affix" data-offset-top="480.75" id="services_vir">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#home">HOME</a></li>
      <li><a data-toggle="collapse" data-parent="#accordian" href="#collapse2">SERVICES</a></li>
      <li><a data-toggle="collapse" data-parent="#accordian" href="#collapse3">WORKSHOP</a></li>
      <li><a href="#contact">CONTACT US</a></li>
      <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown">Log In <strong class="caret"></strong></a>
          <div class="dropdown-menu" style="padding: 15px; padding-bottom: 5px;">
            <form action="user/user_login.php" method="post"> 
                    Username:<br /> 
                    <input type="text" name="username" value="" /> 
                    <br /><br /> 
                    Password:<br /> 
                    <input type="password" name="password" value="" /> 
                    <br /><br /> 
                    <input type="submit" class="btn btn-info" value="Login" /> 
            </form> 
          </div>
      </li>
      <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown">Register<strong class="caret"></strong></a>
          <div class="dropdown-menu" style="padding: 15px; padding-bottom: 5px;">
            <form action="user/reg_int.php" method="post"> 
                    
                        Name:<br />
                        <input type="text" name="name" />
                        <br /><br />
                        Username: <br />
                        <input type="text" name="username" pattern="[A-Za-z0-9_]{8,12}" />
                        <br /><br />
                        Password:<br />
                        <input type="password" name="password" pattern="([A-Za-z0-9_]{6,20}" />
                        <br /><br />
                        Email: <br />
                        <input type="text" name="email" pattern="([A-Za-z0-9_]{8,20}*@[A-Za-z]{5,10}/.[A-Za-z]{2,5})" />
                        <br /><br />
                        Mobile No:<br />
                        <input type="text" name="mobile" pattern="[0-9]{10}" />
                        <br /><br />
                        <input type="submit" name="submit" value="SUBMIT" class="btn btn-info" /> 
            </form> 
          </div>
      </li>
    </ul>
    </div>
  </div>
</nav>
';
  }

?>

<div class="container">  
  <div class="panel-group" id="accordian">
    <div class="panel panel-default">
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body text-center">
          <div id="services">
            <div class="container-fluid text-center" ><h2>SERVICES</h2><h4>What we offer</h4><br>
            <div class="row">
            <div class="col-sm-4">
              <span class="glyphicon glyphicon-briefcase"></span><h4>Study Materials</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla congue semper metus, vel cursus quam aliquam non. Etiam ut neque quis neque sagittis volutpat quis et metus. In non efficitur libero. Aliquam iaculis molestie tortor vel dictum. Praesent fermentum sit amet augue vitae euismod. Phasellus congue cursus sapien quis convallis.</p></div>
              <div class="col-sm-4"><span class="glyphicon glyphicon-phone"></span><h4>Online Query</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla congue semper metus, vel cursus quam aliquam non. Etiam ut neque quis neque sagittis volutpat quis et metus. In non efficitur libero. Aliquam iaculis molestie tortor vel dictum. Praesent fermentum sit amet augue vitae euismod. Phasellus congue cursus sapien quis convallis.</p></div>
            <div class="col-sm-4"><span class="glyphicon glyphicon-tower"></span><h4>Institution</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla congue semper metus, vel cursus quam aliquam non. Etiam ut neque quis neque sagittis volutpat quis et metus. In non efficitur libero. Aliquam iaculis molestie tortor vel dictum. Praesent fermentum sit amet augue vitae euismod. Phasellus congue cursus sapien quis convallis.</p></div></div><br>
            <div class="row"><div class="col-sm-4"><span class="glyphicon glyphicon-blackboard"></span><h4>Technical Workshopes</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla congue semper metus, vel cursus quam aliquam non. Etiam ut neque quis neque sagittis volutpat quis et metus. In non efficitur libero. Aliquam iaculis molestie tortor vel dictum. Praesent fermentum sit amet augue vitae euismod. Phasellus congue cursus sapien quis convallis.</p></div>
            <div class="col-sm-4"><span class="glyphicon glyphicon-education"></span><h4>Result Review</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla congue semper metus, vel cursus quam aliquam non. Etiam ut neque quis neque sagittis volutpat quis et metus. In non efficitur libero. Aliquam iaculis molestie tortor vel dictum. Praesent fermentum sit amet augue vitae euismod. Phasellus congue cursus sapien quis convallis.</p></div>
            <div class="col-sm-4"><span class="glyphicon glyphicon-question-sign"></span><h4>Are You Satisfied?</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla congue semper metus, vel cursus quam aliquam non. Etiam ut neque quis neque sagittis volutpat quis et metus. In non efficitur libero. Aliquam iaculis molestie tortor vel dictum. Praesent fermentum sit amet augue vitae euismod. Phasellus congue cursus sapien quis convallis.</p></div></div>         
            </div>
          </div>
         </div>
      </div>
    </div>

    <div class="panel panel-default">
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body text-center">
          <h2>Workshop on technical analysis</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla congue semper metus, vel cursus quam aliquam non. Etiam ut neque quis neque sagittis volutpat quis et metus. In non efficitur libero. Aliquam iaculis molestie tortor vel dictum. Praesent fermentum sit amet augue vitae euismod. Phasellus congue cursus sapien quis convallis.</p>
        </div>
      </div>
    </div>

  </div>
</div>	
<div id="googleMap" style="height:400px;width:100%;"></div>
<script type="text/javascript">
    function initMap(){
        var uluru = {lat:22.3071588, lng:73.1812187};
        
        var map = new google.maps.Map(document.getElementById('googleMap'),{
                  center:uluru,
                  scrollwheel:false,
                  zoom:9
        });
        
        var marker = new google.maps.Marker({
                     map:map,
                     position:uluru,
                     title: 'My Location'
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy2IU55pOkdx0xlZGsW9o5YDfby1cVJ2U&callback=initMap" async="" defer="defer" type="text/javascript"></script>


<div id="contact"></div>
<div class="container-fluid bg-grey">
  <div class="flaot-left">
  <h2 align=center>Contact Us</h2>
  </div>
  <div class="row">
    <div class="col-sm-5">
      <p>Contact us and we'll get back to you within 24 hours.</p>
      <p><span class="glyphicon glyphicon-map-marker"></span> Chicago, US</p>
      <p><span class="glyphicon glyphicon-phone"></span> +00 1515151515</p>
      <p><span class="glyphicon glyphicon-envelope"></span> myemail@something.com</p> 
    </div>

<div class="col-sm-7">
  <form action="contact.php" method="post">
      <div class="row">
          <div class="col-sm-6 form-group">
            <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
          </div>
          <div class="col-sm-6 form-group">
            <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
          </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
      <div class="row">
        <div class="col-sm-12 form-group">
          <button class="btn btn-default pull-right" type="submit" name="submit">Send</button>
        </div>
      </div> 
      </form>
</div>
  </div>
</div>
	
<footer class="container-fluid text-center">
  <a href="#top" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>Site Made By <a href="http://localhost/sannibh/admin/admin_login.php" title="Visit Sannibh" target="_blank">&copy; Students &amp; Team</a></p>
</footer>


</body>

</html>