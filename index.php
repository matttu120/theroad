<?php
session_start();
error_reporting(0);
ini_set("auto_detect_line_endings", "1");

if(!isset($_SERVER["HTTPS"])) {
    $redirect = "https://ssl.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
    exit;
}

if (isset($_SESSION['user']))
{
    if($_SESSION['Advisor'] == true)
    {
	header("Location: advisors.php");
	exit;
    }
    else if($_SESSION['Advisor'] == false && $_SESSION['Student'] == true)
    {
	header("Location: students.php");
	exit;
    }
}
    
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>The Road</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php">The Road</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"></li>
              <!--<li><a href="contact.html">Contact</a></li>-->
			</form></li>
            </ul>
            
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
	<h2> What is The Road?</h2>
	<p> The Road is a deliverable management system designed for Santa Clara University for the School of Engineering's Senior Design program.</p>

	<!-- Authentication -->
	<p>Please login with your SCU Groupwise username and password to access the accessible groups page.</p>
	<p>For testing purposes, login using username "test" and password "password".</p>
	<form id="login "action="login.php" method="post" accept-charset="UTF-8">
		<label for="username">Username:</label>
	    <div><input type="text" name="username" value="" style="width:140px; height:25px;"   /></div>
		<label for="">Password:</label>
	    <div><input type="password" name="password" value="" style="width:140px; height:25px;"   /></div>
	    <input type="submit" name="login" value="Login &raquo;" class="submit" />
	</div>
</form>
            
            
            
    </div> <!-- /container -->
  </body>
</html>
