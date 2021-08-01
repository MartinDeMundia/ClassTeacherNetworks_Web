<?php   

	include_once("dbconn.php");
	$skin=mysqli_real_escape_string($con,$_POST['skin']);
	
	$q="UPDATE skins SET name='$skin' where id='1'";
	
	if($con->query($q)){
		
		echo 1;
	}

?>