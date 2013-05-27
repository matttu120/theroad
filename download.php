<?php
session_start();
error_reporting(0);

$group = $_GET["group"];
$file = $_GET['filename'];
$year = $_GET['year'];
$fullpath = "upload/$year/$group/".$file;

if(file_exists($fullpath))
{
    $mimetype = mime_content_type($fullpath);
    header('Content-Description: File Transfer'); 
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($fullpath));
    ob_clean();
    flush();
    readfile($fullpath);
    exit();
}
?>
