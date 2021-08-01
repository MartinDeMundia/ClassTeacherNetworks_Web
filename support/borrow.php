<?php
include_once('dbconn.php');
$book_id=mysqli_real_escape_string($con,$_POST['id']);	
$user_code=mysqli_real_escape_string($con,$_POST['user']);	
$duedate=mysqli_real_escape_string($con,$_POST['due']);	
$date=date("m/d/Y");	
$status='Active';

$insert="INSERT INTO borrowed(user_code,book_id,Duedate,Date,status) VALUES('$user_code','$book_id','$duedate','$date','$status')";
$insert2="UPDATE books SET status='Issued' WHERE id='$book_id'";
if ($con->query($insert)){
	
	if ($con->query($insert2)){
	
	echo 1;
}else{
	
	echo 0;
}
}else{
	
	echo 0;
}
?>