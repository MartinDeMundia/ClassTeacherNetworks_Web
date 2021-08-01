<?php
include_once('dbconn.php');
$book_id=mysqli_real_escape_string($con,$_POST['id']);

$insert="UPDATE books SET status='AVAILABLE' WHERE id='$book_id'";
$insert2="UPDATE borrowed SET status='Returned' WHERE book_id='$book_id'";
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