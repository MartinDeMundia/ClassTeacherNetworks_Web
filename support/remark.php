<?php
	
	require("dbconn.php");
	
	$id=mysqli_real_escape_string($con,$_POST['id']);
	$remark=mysqli_real_escape_string($con,$_POST['remark']);
	$param=mysqli_real_escape_string($con,$_POST['param']);
	
	if($param=="cr"){
		
		$update="UPDATE remarks SET t='$remark' where id='$id'";
		
		if($con->query($update)){
			
			echo 1;
		}else{
			
			echo 0;
			
		}
		echo $update;
		
		
	}else{
		
		
			$update="UPDATE remarks SET p='$remark' where id='$id'";
		
		if($con->query($update)){
			
			echo 1;
		}else{
			
			echo 0;
			
		}
		
	}


?>