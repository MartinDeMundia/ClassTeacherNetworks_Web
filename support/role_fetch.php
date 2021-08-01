
 <?php 
	include_once('dbconn.php');
	$user_id=mysqli_real_escape_string($con,$_POST['user_id']);		

			$query="SELECT status,role  FROM user_role  where user_id='$user_id'";
		
			$results=$con->query($query);
			$count=$results->num_rows;
			$c=0;
			//$row = $results->fetch_assoc();
			//echo $query;
$outp = "[";
while($rs = $results->fetch_assoc()) {
	
    if ($outp != "[") {$outp .= ",";}
    $outp .= '{"status":"'  . $rs["status"] . '",';
 
    $outp .= '"role":"'. $rs["role"]     . '"}';
}
$outp .="]";	
		
			echo ($outp);
					   ?>
					   