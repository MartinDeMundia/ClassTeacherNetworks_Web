<?php
include_once("dbconn.php");
session_start();

$_SESSION['id']=mysqli_real_escape_string($con,$_POST['id']);
if(isset($_SESSION['id'])){

echo 1;
}
?>