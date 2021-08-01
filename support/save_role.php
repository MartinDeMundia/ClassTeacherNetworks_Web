<?php
include_once('dbconn.php');
	$user_id=mysqli_real_escape_string($con,$_POST['user_id']);
	$role=mysqli_real_escape_string($con,$_POST['role']);
	$status=mysqli_real_escape_string($con,$_POST['status']);
	$count=0;

	$q1="select * from user_role where user_id='$user_id' and role='$role'";
	$result=$con->query($q1);
	$count=$result->num_rows;
	
	if($count>0)
	{
		$query="update user_role set status = '$status' where  user_id='$user_id' and role='$role'";
	}else{
		$query="insert into user_role(user_id,role,status) values('$user_id','$role','$status')";
	}
	if($con->query($query)){
		echo 1;
	}else{
			echo 0;
	}
	
?>