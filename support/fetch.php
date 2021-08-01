<?php 
	include 'dbconn.php';

		$id = mysqli_real_escape_string($con,$_POST['id']);
		$sql = "SELECT Form FROM sudtls WHERE Adm = '$id'";
		$query = $con->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	
?>