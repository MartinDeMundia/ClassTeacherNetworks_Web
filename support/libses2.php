<?php
session_start();
 include_once("dbconn.php");
$_SESSION['id']=mysqli_real_escape_string($con,$_POST['id']);
$_SESSION['serial']=mysqli_real_escape_string($con,$_POST['s']);
if(isset($_SESSION['serial'])){
	
	echo 1;
}
?>