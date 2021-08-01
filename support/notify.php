<?php
include_once("dbconn.php");

$id=mysqli_real_escape_string($con,$_POST['id']);
	$param=mysqli_real_escape_string($con,$_POST['param']);
	
	if($param=="new")
	{
		$exam=mysqli_real_escape_string($con,$_POST['exam']);
	$query="INSERT INTO notify(exam,user_id,status) VALUES('$exam','$id','New')";
	if($con->query($query)){
		
		echo 1;
		
	}
	} else if ($param=="seen"){
		$query="UPDATE  notify SET notification='0'";
	if($con->query($query)){
		
		echo 11;
		
	}
		
	}else if ($param=="seen2"){
		$query="UPDATE  notify SET status='seen'";
	if($con->query($query)){
		
		echo 11;
		
	}
		
	}else if ($param=="count"){
		$query="SELECT exam,msg,id from notify where status='New' and user_id='$id'";
		$result=$con->query($query);
		$row=$result->fetch_assoc();
		
		echo $result->num_rows;
		
	}
	else{
		
		$query="SELECT exam,msg,id from notify where notification='1' and user_id='$id'";
		$result=$con->query($query);
		$row=$result->fetch_assoc();
		
		echo json_encode($row);
		
	}
?>