<?php
include_once('dbconn.php');


include 'simplexlsx.class.php';
			
			$xlsx = new SimpleXLSX('uploads/issue.xlsx');
			
			list($num_cols, $num_rows) = $xlsx->dimension();
			$f = 0;
			foreach( $xlsx->rows() as $r ) 
			{
				// Ignore the inital name row of excel file
				
				if ($f == 0)
				{
					$f++;
					continue;
				}
				
						////print($r[0]);
				if($r[0] !=""){
					
					$query="select id from books WHERE serial='$r[1]' ";
				$result=$con->query($query);
					$row=$result->fetch_assoc();
					//echo $r[0];
					
					
					
					
$book_id=$row['id'];;	
$user_code=$r[0];	
$duedate=$r[2];	
$date=date("Y-m-d");	
$status='Active';

$insert="INSERT INTO borrowed(user_code,book_id,Duedate,Date,status) VALUES('$user_code','$book_id',ADDDATE('1900-01-01',INTERVAL ".($duedate-2)." DAY),'$date','$status')";
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

}
					
			}
?>