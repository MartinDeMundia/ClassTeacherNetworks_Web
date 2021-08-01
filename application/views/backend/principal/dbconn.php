<?php 
$servername = "localhost";
$username = "appsuserclass";
$password = ">UKn}6=MK[w^`P5B";
$dbname = "appsclassteacher";

// Create connection
$con = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
?>