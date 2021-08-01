<?php
session_start();
$Stream="";
$form="";
if (isset($_SESSION['formm'])){
$Stream="where stream like('%".strtoupper($_SESSION['Stream'])."%')";
$form="AND  Form like ('%".$_SESSION['formm']."%')";
}



require("dbconn.php");

 $q1 = "SELECT Adm,Name,Form,Stream,House FROM sudtls $Stream  $form";
			
echo $q1;
require('fpdf/fpdf.php');
$name="";
$adm=0;
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
class PDF extends FPDF
{
// Page header
function Header()
{
	global $form,$stream,$title,$address,$tel;
		// Logo

	$this->Image('uploads/logo.png',10,6,20);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	
	// Title
	$this->Cell(0,10,$title,0,0,'R');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,$address,0,0,'R');
$this->Ln(5);
	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'R');
	// Line break
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,'CLASS LIST',0,0,'C');
	// Line break
	$this->Ln(7);
	$this->Line(10,39,200,39);
	$this->SetFont('Arial','B',8);
//$this->Line(6,46,185,46);
$this->Cell(10,10,'#',0,0);
$this->Cell(20,10,'ADM NO',0,0);
$this->Cell(50,10,'NAME',0,0);
$this->Cell(10,10,'FORM',0,0);
$this->Cell(30,10,'STREAM',0,0);
$this->Cell(70,10,'HOUSE',0,0);
$this->SetLineWidth(0.8);
$this->Line(10,40,200,40);
$this->Ln();
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->SetFont('Arial','',8);

$result=$con->query($q1);
$i=0;
while($row=$result->fetch_assoc()){
	$i+=1;
	$pdf->Cell(10,5,$i,'B',0);
$pdf->Cell(20,5,$row['Adm'],'B',0);
$pdf->Cell(50,5,strtoupper($row['Name']),'B',0);
$pdf->Cell(10,5,strtoupper($row['Form']),'B',0);
$pdf->Cell(30,5,strtoupper($row['Stream']),'B',0);
$pdf->Cell(70,5,strtoupper($row['House']),'B',1);
}
$pdf->Output('f','PDFS/list.pdf');