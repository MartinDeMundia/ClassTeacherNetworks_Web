<?php
session_start();
 include_once("dbconn.php");
$adm=$_SESSION["jd"];
$message=mysqli_real_escape_string($con,$_POST['message']);
$phone=$_SESSION["jp"];
$cat="Parents";
$name=$_SESSION["jn"];
$dt=date("d/m/Y");
$q="INSERT INTO messages(Message,Phone,Category,Name,Status,uniques,Date) VALUES('$message','$phone','$cat','$name','Inbox','$adm','$dt')";
		if (mysqli_query($con,$q)){
			
			echo 1;
		}
		else{
			
			echo 0;
		}
?>