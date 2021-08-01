<?php

include_once("dbconn.php");

$name=mysqli_real_escape_string($con,$_POST['name']);


	$q="INSERT INTO category(classname) VALUES('$name')";
	
	if($con->query($q)){
		
		echo 1;
		
	}
	else{
		
		echo 0;
		
	}

?>