<?php
session_start();
error_reporting(0);

include_once('functions.php');	

ini_set("auto_detect_line_endings", "1");
$role = $_SESSION['role'];
$user = $_SESSION['user'];
    
if(!isset($_SERVER["HTTPS"])) {
    $redirect = "https://ssl.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
    exit;
}

if (!isset($_SESSION['user'])) {
    	session_destroy();
	header("Location: index.php");
	exit;
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
            function closeKeepAlive(){
		if (/AppleWebKit|MSIE/.test(navigator.userAgent)){
		    new Ajax.Request("safari-die.php", { asynchronous:false });
                  //new Ajax.Request("/ping/close", {asynchronous:false});
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
    echo ("<table cellspacing=\"0\">");
    
    $username = $_SESSION['user'];
    $year = $_SESSION['year'];
    
    if($_SESSION['Advisor'] == true)
        echo ("<a href=\"advisors.php\">Back to Your Groups</a><br><p>");
    
    $group = $_GET['groupName'];
    
    $groups = parse_ini_file("./config/$year/groups.ini", true);
    $memberFlag = false;
    
    $advisors = "";
    $students = "";
    $userGroups = array();
    
    foreach($groups as $value => $grp)
    {
        foreach($grp['advisor'] as $adv)
        {
            if($adv == $username)
            {
                $memberFlag = true;
                array_push($userGroups, $value);
            }
        }
        foreach($grp['student'] as $sdnt)
        {
            if($sdnt == $username)
            {
                $memberFlag = true;
                array_push($userGroups, $value);
            }
        }
    }
    
    if(strcmp($group, "") == 0)
    $group = $userGroups[0];
    
    foreach($userGroups as $usrGrp)
    {
        if(strcmp($usrGrp, $group) == 0)
        {
            foreach($groups[$usrGrp]['advisor'] as $uAdv)
            $advisors = $advisors . ", " . $uAdv;
            foreach($groups[$usrGrp]['student'] as $uSdnt)
            $students = $students . ", " . $uSdnt;
        }
    }
    
    $students = substr($students, 2);
    $advisors = substr($advisors, 2);
    
    if(!memberFlag)
    echo "You do not belong to this group, please contact an admin if you believe this is an error";
    else
    {
        echo("<p><style=color:black>Advisors: $advisors <br>Students: $students</p><p><p><br>");
        
        include_once ('functions.php');
        $requirements = parse_ini_file("upload/" . $year . "/" . $group . "/reqConfig.ini", true, INI_SCANNER_NORMAL);
        
        foreach($requirements as $reqname)
	{
	    foreach($reqname as $req => $ext)
	    {
		echo "<hr/>";
                echo "<table>";
		echo "<tr colspan=\"5\"><td colspan=\"3\"><h4><strong>" . $req . ":&nbsp;&nbsp;&nbsp;&nbsp;</strong></td><td>";
		
		$reqName = str_replace(" ", "", $req);
		getDownloads($group, $reqName, $year);
		
		echo "</h4></td>";
                echo "</div></tr>";
                echo "<tr colspan=\"5\"><td><form action=\"upload_file.php?req=$req&year=$year&group=$group\"method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"closeKeepAlive()\"></td>";
                echo "<tr><td colspan = \"2\"><label for=\"file\">File Upload:</label>";
                echo "<td><input type=\"file\" name=\"file\" id=\"file\" /></td>"; 
	        echo "<td><input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"btn\"/></td></tr>";
                echo "</form></tr>";
	        echo "</table><br/>";
	        echo "Allowed Extensions for this Deliverable: $ext";
	    }
        }
    } 
    if($_SERVER['SERVER_PORT']!=443)
    {
        $url = "https://". $_SERVER['SERVER_NAME'] . ":443".$_SERVER['REQUEST_URI'];
        header("Location: $url");
    }
    
    ?>
</table>
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
        </div>
    </div> <!-- /container -->
  </body>
</html>

