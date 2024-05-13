<?php
session_start();

$server="localhost";
$user="root";
$password="";
$name="speed_test";

$connect = mysqli_connect($server, $user, $password, $name);
?>