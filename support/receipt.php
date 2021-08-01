<?php
session_start();
if (isset($_SESSION['id'])){
$q = ($_SESSION['id']);
}else{
	$q =' ';
}
require("dbconn.php");

 

 $t1=0;
 $t2=0;
 $t3=0;
 $en=0;
 $b=0;
 $name="";
 $frm="";
 $Left="";
 $nts=0;
 	
 
 $q1f="SELECT sudtls.AdmDate,DOB,leave.Left,leave.Notes,leave.Adm,sudtls.Name,enrollform,Form FROM school_5.leave LEFT JOIN sudtls ON(sudtls.Adm=leave.Adm) WHERE leave.id='".$q."'";

$r11=mysqli_query($con,$q1f);
while($row21=mysqli_fetch_assoc($r11)){
	 $en=$row21['enrollform'];
	 $name=$row21['Name'];
	$frm=$row21['Form'];
	$nts=$row21['Notes'];
	$Left=$row21['Left'];
		$b=$row21['DOB'];
		$t1=$row21['Adm'];
		$t3=$row21['AdmDate'];
}			
			

require('fpdf/fpdf.php');
class PDF extends FPDF
{
// Page header


// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	
}
}
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage('p','a4',0);
	
	$pdf->SetFont('Courier','B',8);
 $pdf->Cell(0,0,'EDUCATION:',0,0,'R');
	$pdf->Ln();
	// Ari$pdf->Ln(5);al bold 15
	$pdf->SetFont('Courier','B',10);
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


$pdf->Image('logo.png',90,6,30,'C');
	// Title
	$pdf->Ln(25);
	$pdf->Cell(0,10,'REPUBLIC OF KENYA',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,10,'__________',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,10,'MINISTRY OF EDUCATION',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,10,'__________',0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,10,'KENYA SECONDARY SCHOOL LEAVING CERTIFICATE',0,0,'C');
		$pdf->Ln(15);
		$pdf->SetFont('Courier','BU',10);
	$pdf->Cell(0,10,$title,0,0,'R');
	// Line break
	$pdf->Ln(5);

	// Title
	$pdf->Cell(0,10,$address,0,0,'R');
	// Line break
	
	$pdf->Ln(10);

	// Title
	
	// Line break
	$pdf->Ln(10);$pdf->Cell(15);
		$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'Adm/SerialNo. ');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'         '.$t1.'           ');$pdf->Ln(10);$pdf->Cell(5);
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'This is to certify that.');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'    '.strtoupper($name).'                                               ');$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'entered this school on');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'    '.$t3.'                   ');
	
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'and was enrolled in form');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'      '.$en.'          ');
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'and left on');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'     '.strtoupper($Left).'           ');
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'from form');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'      '.$frm.'        ');
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'having satisfactorily completed the approved Course for Form');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'      '.$frm.'        ');
	$pdf->Ln(15);$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'Date of Birth(in Admission Register');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'      '.$b.'        ');
	$pdf->SetFont('Courier','B',10);$pdf->Ln(15);
$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'Headteacher`s report on pupil`s ability, industry and conduct');$pdf->Ln(15);
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,''.strtoupper($nts).' XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX                                                                                                                                                                 ');
	$pdf->Ln(15);
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'Pupil`s Signature');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'                        ');
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'Date of issue');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'  '.Date("d  M  Y").'            ');
	
	
	$pdf->Ln(10);
	$pdf->cell(100);
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'Signature');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Write(10,'                          ');
	$pdf->Ln(3);
	$pdf->cell(125);
	$pdf->SetFont('Arial','',10);
	$pdf->Write(10,'Headteacher');
	
	$pdf->Ln(25);
	
	$pdf->SetFont('Arial','',8);
	$pdf->cell(0,0,'This Certificate was issued without erasure or alteration whatsoever',0,0,'C');
	
	
	//VALUES/DATA
	
	
	
	$pdf->Output();

?>
	