<?php
session_start();
if(isset($_SESSION['isbn'])){
	$param="and books.status LIKE('%".$_SESSION['param']."%')";
$isbn="and isbn LIKE('%".$_SESSION['isbn']."%')";
$serial="and serial LIKE('%".$_SESSION['serial']."%')";
$title="and title LIKE('%".$_SESSION['title']."%')";
$author="and author LIKE('%".$_SESSION['author']."%')";
$category="and category LIKE('%".$_SESSION['category']."%')";
$class="and form LIKE('%".$_SESSION['class']."%')";
$subject="and subject LIKE('%".$_SESSION['subject']."%')";
} else{
	
	$serial="";  $isbn=""; $title=""; $author=""; $category=""; $subject="";
}
require("dbconn.php");

 
			

require('fpdf/fpdf.php');


class PDF extends FPDF
{
// Page header
function Header()
{
	global $form,$name,$adm,$stream,$con;
		// Logo
		$q1s="select description from settings where type='system_title'";
$title='';
$address='';
$tel='';
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}

$q1s="select description from settings where type='address'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$address=$row2s['description'];
	
}

$q1s="select description from settings where type='phone'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}
	$this->Image('uploads/logo.png',10,6,20);
	// Arial bold 15
	$this->SetFont('Arial','B',8);
	
	// Title
	$this->Cell(0,10,$title,0,0,'C');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,$address,0,0,'C');
	$this->Ln(5);
	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'C');
	// Line break
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,strtoupper($_SESSION['subject']."  ".$_SESSION['category']."  ".$_SESSION['class'].'  borrowing history' ) ,0,0,'C');
	$this->Line(56,32,155,32);
//$this->Line(6,46,185,46);
$this->SetLineWidth(0.5);
$this->Line(56,33,155,33);

	$this->Ln(15);
	 $this->Cell(15,10,'SERIAL',0,0,'C');
						 
                        $this->Cell(40,10,'TITLE',0,0,'C');
                        $this->Cell(15,10,'CLASS',0,0,'C');
                        $this->Cell(20,10,'CATEGORY',0,0,'C');
                        $this->Cell(20,10,'SUBJECT',0,0,'C');
						$this->Cell(30,10,'BORROWER CODE',0,0,'C');
						$this->Cell(30,10,'DATE ISSUED',0,0,'C');
						$this->Cell(20,10,'DUE DATE',0,0,'C');
					$this->SetLineWidth(0.2);	
				$this->Line(10,47,200,47);
//$this->Line(6,46,185,46);
$this->SetLineWidth(0.3);
$this->Line(10,47.5,200,47.5);
		$this->Ln(8);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$q="SELECT borrowed.date,date_format(duedate,'%d %M %Y') as duedate,books.status,user_code,serial,isbn,title,form,category,subject from books LEFT JOIN borrowed ON (borrowed.book_id=books.id) where books.status in ('Lost','Issued')  $serial  $isbn $title $author $category $subject ";
		//echo $q;
					$result=$con->query($q);
					while($row=$result->fetch_assoc()){
					$pdf->Cell(15,7,$row['serial'],'B',0,'C');
                        $pdf->Cell(40,7,$row['title'],'B',0,'C');
                        $pdf->Cell(15,7,$row['form'],'B',0,'C');
                        $pdf->Cell(20,7,$row['category'],'B',0,'C');
                        $pdf->Cell(20,7,$row['subject'],'B',0,'C');
						$pdf->Cell(30,7,$row['user_code'],'B',0,'C');
							$pdf->Cell(30,7,$row['date'],'B',0,'C');
							$pdf->Cell(20,7,$row['duedate'],'B',1,'C');

					}


$pdf->SetTitle(strtoupper(strtoupper($_SESSION['subject']."  ".$_SESSION['category']."  ".$_SESSION['class'].'  borrowing history' )));
$pdf->Output('F','PDFS/history.pdf');

