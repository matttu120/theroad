<?php
session_start();
error_reporting(0);

if(!isset($_SERVER["HTTPS"])) {
    $redirect = "https://ssl.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
    exit;
}

unset($_SESSION['user']); 

$_SESSION = array(); 

session_destroy(); 

header('Location: index.php'); 
?>
