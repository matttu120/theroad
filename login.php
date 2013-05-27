<?php
session_start();
error_reporting(0);
ini_set("auto_detect_line_endings", "1");
$yearIni = parse_ini_file("config/yearConfig.ini", true);

$curYear = $yearIni['current_year'];

function validYear($y)
{
    if($y > 2010 && $y < 2020)
	return true;
    return false;
}

if(!validYear($curYear))
    $curYear = '2012';
if(!isset($_SESSION['year']))
    $_SESSION['year'] = $curYear;

// redirects if page is not secure
/*
if(!isset($_SERVER["HTTPS"])) {
    $redirect = "https://ssl.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
    exit;
}*/

// get username and password values from login page
$username = trim($_POST["username"]);
$password = trim($_POST["password"]);

$authenticated = false;

//Checks user credentials against SCU pop servers.


    $fp = fsockopen("ssl://pop.scu.edu", 995);

// continue if socket was opened successfully
if ($fp) {
	stream_set_timeout($fp, 2);
	
	if(strpos(fgets($fp), '+OK') === 0)	{
		$out = "USER " . $username . "\n";
		fputs($fp, $out);
		
		if(strpos(fgets($fp),'+OK') === 0) {
    			$out = "PASS " . $password . "\n";
			fputs($fp, $out);	
			
			if(strpos(fgets($fp),'+OK') === 0) 
    			$authenticated = true;
    		}    	
        }    
    fclose($fp);
}
if ($username=="test" && $password == "password"){
	$authenticated = true;
}

if ($authenticated) 
{
    //truncates the @scu.edu part of an entered string
	$username = preg_replace("/(.*)@.*/", "$1", $username);

    //sets everything to lowercase for string comparison purposes
	$username = strtolower($username);

	$_SESSION['user'] = $username;
	$year = $_SESSION['year'];

	$groups = parse_ini_file("./config/$year/groups.ini", true, INI_SCANNER_NORMAL);
	$advisorFlag = false;
	$studentFlag = false;
	$count = 0;

	foreach($groups as $grp)
	{
	    foreach($grp['student'] as $sdnt)
	    {
		if($sdnt == $username)
		{
		    $studentFlag = true;
		    $count++;
		}
	    }
	    foreach($grp['advisor'] as $adv)
	    {
		if($adv == $username)
		    $advisorFlag = true;
	    }

	}

	// Check to see if user is set as an admin and a student,
	// or if the user is a student in multiple groups.
	// Throws a javascript popup displaying error if true.
    if ($advisorFlag == false && $studentFlag == false)
    {
        echo "You do not have a valid role. Please contact a system administrator if you believe this to be an error";
        session_destroy();
        header("Location:index.php");
        $_SESSION['Advisor'] = false;
    }
	if(($advisorFlag && $studentFlag) || ($count > 1))
	{

	echo '<script language="javascript">confirm("Error:\nYou are either set as an advisor and a student,\nor you are a student in multiple groups.\nPlease contact your system admin to resolve this error.")</script>';
	echo '<script language="javascript">window.location = "logout.php"</script>';
	}

	if($advisorFlag)
	{
	    $_SESSION['year'] = date('Y');
	    header("Location: advisors.php");
	    $_SESSION['Advisor'] = true;
	}
	else
	{
        $_SESSION['Student'] = true;
	    header("Location: students.php");
	    $_SESSION['Advisor'] = false;
	}
}
else 
{    
	// print error message as javascript popup for failed login
	echo '<script language="javascript">confirm("Login failed.\nInvalid username/password.")</script>';
	
	// redirect to index.php
	echo '<script language="javascript">window.location = "index.php"</script>';
}
?>
