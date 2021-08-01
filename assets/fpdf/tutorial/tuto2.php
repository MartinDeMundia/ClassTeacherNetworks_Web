<?php
require('../fpdf.php');
$form="4";
$name="Jobuh Kianga";
$adm=5467;
$stream="NORTH";
class PDF extends FPDF
{
// Page header
function Header()
{
	global $form,$name,$adm,$stream;
		// Logo
	$this->Image('logo.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	
	// Title
	$this->Cell(0,10,'MASENO SCHOOL',0,0,'C');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,'P.O BOX 713-09000 MASENO',0,0,'C');
	// Line break
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,'TEL:0741727548',0,0,'C');
	// Line break
	// Line break
	$this->Ln(10);

	// Title
	$this->Cell(0,10,'ACADEMIC PROGRESS REPORT',0,0,'C');
	// Line break
	$this->Ln(15);
	$this->Cell(40);
	$this->SetFont('Arial','B',10);
	$this->Write(5,'NAME');
	$this->SetFont('Arial','U',10);
	$this->Write(5,'      '.$name.'       ');
	$this->SetFont('Arial','B',10);
	$this->Write(5,'ADM No.');
	$this->SetFont('Arial','U',10);
	$this->Write(5,'    '.$adm.'    ');
	$this->SetFont('Arial','B',10);
	$this->Write(5,'FORM');
	$this->SetFont('Arial','U',10);
	$this->Write(5,'    '.$form.'-'.$stream.'    ');
	$this->Ln(20);
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

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Output();

