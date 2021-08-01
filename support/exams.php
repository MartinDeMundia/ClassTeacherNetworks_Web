<?php
include_once("dbconn.php");

$param=mysqli_real_escape_string($con,$_POST['param']);
if($param=="activate"){
	
	$form=mysqli_real_escape_string($con,$_POST['form']);
$Stream=mysqli_real_escape_string($con,$_POST['stream']);
$year=mysqli_real_escape_string($con,$_POST['year']);
$term=mysqli_real_escape_string($con,$_POST['term']);
$exam=mysqli_real_escape_string($con,$_POST['exam']);
$limit=mysqli_real_escape_string($con,$_POST['limit']);

$q="INSERT INTO openexam(openexam.limit,form,exam,year,stream,status,term) VALUES('$limit','$form','$exam','$year','$Stream','Active','$term')";
//echo $q;	
$qe="SELECT * FROM openexam where form='$form' and exam='$exam' and year='$year' and stream='$Stream'  and term='$term' and status='Active'";
$result=$con->query($qe);
$numrows=$result->num_rows;
if($numrows>=1){
	
	echo 12;
	
}else{
			if($con->query($q)){
	
	
				echo 1;
	
			}else{
	
				echo 0;
				}
				}

}else{
	

$id=mysqli_real_escape_string($con,$_POST['id']);	
$q="UPDATE openexam SET status='Inactive' WHERE id='$id'";
	if($con->query($q)){
	
	
	echo 11;
	
}else{
	
	echo 00;
}
}


?>