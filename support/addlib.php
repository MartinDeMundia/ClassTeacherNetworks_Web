<?php
include('dbconn.php');
include 'simplexlsx.class.php';
			$category=mysqli_real_escape_string($con,$_POST['category']);
			$form=mysqli_real_escape_string($con,$_POST['form']);
			$subject=mysqli_real_escape_string($con,$_POST['subject']);
			$serial="";
			$isbn="";
			$author="";
			$publisher="";
			$pubyear="";
			$title="";
			$price="";
			$date=date("Y-m-d");
			$condation="";
			$xlsx = new SimpleXLSX('uploads/items.xlsx');
			
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
					$serial=$r[0];
					$isbn=$r[1];
					$author=$r[2];
					$publisher=$r[3];
					$pubyear=$r[4];
					$title=$r[5];
					$price=$r[6];
					$condition=$r[7];
					
					
					$q="INSERT INTO books(books.serial,isbn,author,publisher,pubyear,title,price,books.condition,form,books.subject,category,books.date) VALUES('$serial','$isbn','$author','$publisher','$pubyear','$title','$price','$condition','$form','$subject','$category','$date')";
					
					if($con->query($q)){
						echo 1;
					}
					else{
						echo 0;
					}
				}
					
			}
			
					?>