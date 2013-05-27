<?php
session_start();
error_reporting(0);

$user = $_SESSION['user'];
$year = $_SESSION['year'];

    if($_SESSION['Advisor'] == false)
	header("Location: students.php");

    if(isset($_REQUEST['year']))
    {
	if($year != $_REQUEST['year'])
        {
	    $_SESSION['year'] = $_REQUEST['year'];
	    $year = $_SESSION['year'];
        }
    }
    $list = scandir("./config");

    if($_SERVER['SERVER_PORT']!=443)
    {
        $url = "https://". $_SERVER['SERVER_NAME'] . ":443".$_SERVER['REQUEST_URI'];
        header("Location: $url");
    }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <script type="text/javascript">
        $(document).ready(function(){
            function closeKeepAlive(){
                if (/AppleWebKit|MSIE/.test(navigator.userAgent)){
                  new Ajax.Request("/ping/close", {asynchronous:false});
                }
                return true;
            }
        });
    </script>
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
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

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
			</form></li>

	    </ul>
<form action="logout.php" style="float:right;">
<button type="submit" class="btn" name="logout" value="Logout"> Log Out</button>
</form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
        <div class="hero-unit">	
	<h2>Welcome, <?php echo $user . "!"; ?> </h2>


<?php
    echo "Select A Year: ";
    echo "<form action='advisors.php' method='post'>";
    echo "<select name='year'>";

    foreach($list as $value)
    {
	if(($value != ".") && ($value != "..") && ($value != "yearConfig.ini"))
	    echo "<option value=$value>$value</option>";
    }
    echo "</select>";
    echo "<br/>";
    echo "<input type='submit' class='btn'/>";
    echo "</form>";


    echo ("<table cellspacing=\"0\">");
    $user = $_SESSION['user'];
    $groups = parse_ini_file("./config/$year/groups.ini", true);
    
    foreach($groups as $value => $grp)
    {
        foreach($grp['advisor'] as $adv)
	{
            if($adv == $user)
            {
                $memberList = "";
                if($grp['student'] != NULL)
                {
		    foreach($grp['student'] as $sdnt)
		    {
			$memberList = $memberList . "<br/>" . $sdnt;
		    }
                    
		    $memberList = substr($memberList, 5) . "&nbsp;";

                    echo("<td align=\"center\"><h3>$value</h3>$memberList</td>");
		    echo("<td align=\"center\"><a href=\"students.php?year=$year&groupName=$value\">&nbsp;&nbsp;Select This Group&nbsp;&nbsp;</a href></td>");
		    echo("<br/>");
		    echo("</tr>");
                }
            }
        }
    }
    
    echo ("</table>");
    ?>


	</div>
        <div class="row">
	    <div class="span4">
                <h3>Contact Information: </h3>
		<p>Loquen Jones - lrjones@scu.edu</p>
		<p>Matt Tu - mtu@scu.edu</p>
		<p>Graham Turbyne - gturbyne@scu.edu</p>
            </div>
        <div class="span4">
                <h3></h3>
                <p></p>
        </div
    </div> <!-- /container -->
  </body>
</html>
