<?php 
session_start();
	include 'dbconn.php';
		$form = mysqli_real_escape_string($con,$_POST['form']);
		$id = mysqli_real_escape_string($con,$_POST['year']);
		$_SESSION['form']=$form;
		$_SESSION['year']=$id;
		
		if(isset($_SESSION['year'])){
			echo 1;
			
		}
		?>