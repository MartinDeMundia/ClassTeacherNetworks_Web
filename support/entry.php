<?php
include_once("dbconn.php");

$param=mysqli_real_escape_string($con,$_POST['param']);
if($param=="activate"){
	
	$form="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$Stream=mysqli_real_escape_string($con,$_POST['stream']);
$year=mysqli_real_escape_string($con,$_POST['year']);
$term=mysqli_real_escape_string($con,$_POST['term']);
$exam=mysqli_real_escape_string($con,$_POST['exam']);
$entry=mysqli_real_escape_string($con,$_POST['entry']);
$subject=mysqli_real_escape_string($con,$_POST['subject']);
$q="INSERT INTO entry(entry.entry,form,exam,year,stream,status,term,subject) VALUES('$entry','$form','$exam','$year','$Stream','Active','$term','$subject')";
//echo $q;	
$qe="SELECT * FROM entry where form='$form' and exam='$exam' and year='$year' and stream='$Stream'  and term='$term' and subject='$subject'";
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