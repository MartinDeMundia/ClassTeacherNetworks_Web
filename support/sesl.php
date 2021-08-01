<?php
session_start();
 include_once("dbconn.php");
$_SESSION['formm']=mysqli_real_escape_string($con,$_POST['form']);
$_SESSION['Stream']=mysqli_real_escape_string($con,$_POST['stream']);
echo 1;
?>