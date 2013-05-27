<?php
session_start();
error_reporting(0);

$group = $_GET["groupName"];

echo '<h2>File Upload Error</h2>';
echo "Invalid File: File format not supported, or file is too large";
echo '<br/>';
echo '<br/>';	
echo ("<a href=\"students.php?groupName=$group\">&nbsp;&nbsp;Back To Group Page&nbsp;&nbsp;</ahref>");
?>
