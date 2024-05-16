<?php
session_start();

$_SESSION = array();

session_destroy();
unset($_COOKIE['userData']);

header("location: login.php");
exit;
?>
