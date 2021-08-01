<?php


include('dbconn.php');
ini_set('max_execution_time', 1000);
if(move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/items.xlsx')){
	echo 1;
	
}else{
	echo 0;
}
			// Importing excel sheet for bulk student uploads
