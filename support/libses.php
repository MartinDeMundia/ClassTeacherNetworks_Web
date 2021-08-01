<?php
session_start();
 include_once("dbconn.php");
 
	///// $_SESSION['param']=mysqli_real_escape_string($con,$_POST['param']);

$_SESSION['isbn']=mysqli_real_escape_string($con,$_POST['i']);
$_SESSION['serial']=mysqli_real_escape_string($con,$_POST['s']);
$_SESSION['title']=mysqli_real_escape_string($con,$_POST['t']);
$_SESSION['author']=mysqli_real_escape_string($con,$_POST['a']);
$_SESSION['category']=mysqli_real_escape_string($con,$_POST['c']);
$_SESSION['class']=mysqli_real_escape_string($con,$_POST['cl']);
$_SESSION['subject']=mysqli_real_escape_string($con,$_POST['su']);
if(isset($_SESSION['subject'])){
	
	echo 1;
}
?>