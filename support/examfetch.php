<?php 
	include 'dbconn.php';

		$id = mysqli_real_escape_string($con,$_POST['id']);
		$sql = "SELECT * FROM openexam WHERE id = '$id'";
		$query = $con->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	
?>