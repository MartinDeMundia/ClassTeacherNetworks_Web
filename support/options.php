<?php
session_start();
if (isset($_SESSION['form'])){
$subjectno=0;
$lmt = 0; 
$form=($_SESSION['ff']);
$f2=$_SESSION['f2'];
$Stream=strtoupper($_SESSION['Stream']);
$year=$_SESSION['year'];
$examdate=$_SESSION['examdate'];
$en=$_SESSION['en'];
$term=$_SESSION['term'];
$exm=$_SESSION['exm'];
$cat1 = "True";
$cat2 = "False";
$cat3 = "False";
}
require("dbconn.php");

 $q="SELECT * from cur_class limit 1";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 
$form=$row['frm'];
$Stream=$row['cls'];
}
			

require('fpdf/fpdf.php');

$name="";
$adm=0;

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
	$this->Image('logo.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	
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
	$this->Ln(10);

	// Title
	$this->Cell(0,10,'FORM'.$form.' STUDENTS SUBJECTS OPTIONS LIST',0,0,'C');
	// Line break
	$this->Ln(15);
	
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'frijotech softwares-Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$i=0;
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L');
$q12222 = "SELECT adm,Name from sudtls where form='$form'";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 $pdf->Ln(10);
	 $i+=1;
	$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,$i.'. '.strtoupper($rs22['Name']));
	 $pdf->Ln(8);	
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(25	,10,'SUBJECT',1,0,'L');
	 $q1 = "SELECT DISTINCT(SUBJECT) AS sub   from subjectoptionsa where adm='".$rs22['adm']."';";
	 //echo $q1;
 $qq=mysqli_query($con,$q1);
 while($rs=mysqli_fetch_assoc($qq)){


	$pdf->Cell(20	,10,strtoupper($rs['sub']),1,0,'C');
	
	
	//VALUES/DATA
	
		//
		
		
	
		}
		$pdf->Ln(10);
//echo $q1;
 }
$pdf->SetTitle(strtoupper('Form'.$form.' STUDENTS SUBJECTS OPTIONS LIST'));
$pdf->Output('','Form'.$form.' STUDENTS SUBJECTS OPTIONS LIST.pdf');
?>
	