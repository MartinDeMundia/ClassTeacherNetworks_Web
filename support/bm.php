<?php
session_start();
require("dbconn.php");
require('fpdf/diag.php');
$title='';
$address='';
$tel='';
$q1s="select description from settings where type='system_title'";
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}
$form=mysqli_real_escape_string($con,$_POST['form']);
$f2=mysqli_real_escape_string($con,$_POST['form']);
$stream=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$en=mysqli_real_escape_string($con,$_POST['exam']);
$term=mysqli_real_escape_string($con,$_POST['term']);
$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
		if(file_exists('PDFS/markbook.pdf')){
rename('PDFS/markbook.pdf','PDFS/'.date('dmyh:i:sa').'pdf');
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
protected $col = 0; // Current column
protected $y0;      // Ordinate of column start

function Header()
{
	// Page header
	global $title,$tel,$address,$con,$form,$term,$en,$stream,$year;

	$this->Image('logo.png',265,6,20);
	// Arial bold 15
	$this->SetFont('Arial','B',10);
	
	// Title
	$this->Cell(0,10,$title,0,0,'l');
	// Line break
	$this->Ln(5);

	// Title
	$this->Cell(0,10,$address,0,0,'l');
$this->Ln(5);
	// Title
	$this->Cell(0,10,'TEL: '.$tel,0,0,'l');
	// Line break
	// Line break
	$this->Ln(5);
	 $this->Cell(0	,10,strtoupper($en.' mark sheet   - form '.$form. ' '.$stream. ' '.$year) ,0,0,'C');
$this->Line(10,32,286,32);
$this->SetLineWidth(0.5);
$this->Line(10,33,286,33);
$this->Ln(20);
$this->SetFont('Arial','B',9);
$this->Cell(15	,10,'',0,0,'L');
								  $this->Cell(10	,10,'',0,0,'L'); 
                                  $this->Cell(20	,10,'',0,0,'L');   
								  $this->Cell(50	,10,'',0,0,'L');
								  
								   $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  $this->Cell(10,10,$sr['subs'] ,'RLT',0,'C');
						  
						  
						  }
						  $this->Cell(0	,10,'' ,0,1,'C');
						   $query="SELECT * from sudtls ";
						  $this->Cell(15	,10,'#',1,0,'L');
								  $this->Cell(10	,10,'ST',1,0,'L'); 
                                  $this->Cell(20	,10,'ADM',1,0,'L');   
								  $this->Cell(50	,10,'NAME OF STUDENT',1,0,'L');
								   $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  $this->Cell(10	,10,'' ,'RT',0,'C');
						  
						  
						  }
						  $this->Cell(0	,10,'' ,0,1,'C');
}

function Footer()
{
	// Page footer
	$this->SetY(-15);
	$this->SetFont('Arial','I',8);
	$this->SetTextColor(128);
	$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('l');
$pdf->SetFont('Times','B',10);
							
						  $pdf->SetFont('Times','',10);
						 //where Form='$f' and Stream='$Stream'
						  $query="SELECT * from sudtls where Form='$form' and Stream='$stream'";
						  $results=mysqli_query($con,$query);
						  $NUM=0;
						  while($row=mysqli_fetch_assoc($results)){
							  $NUM+=1;
							  $qs="SELECT Code AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
								  $pdf->Cell(15	,5,$NUM,1,0,'L');
								  $pdf->Cell(10	,5, substr($row['Stream'],0,1),1,0,'L'); 
                                  $pdf->Cell(20	,5, $row['Adm'],1,0,'L');   
								  $pdf->Cell(50	,5,$row['Name'],1,0,'L');
		while($sr=mysqli_fetch_assoc($subs)){
			 $qs1="SELECT count(*) AS count FROM subjectoptionsa where Adm='".$row['Adm']."' and code='".$sr['subs']."' ";
		$subs1=mysqli_query($con,$qs1);
		$res=0;
		while($sr2=mysqli_fetch_assoc($subs1)){
			
						  $res=$sr2['count'];
						  
						  
						  }
						  if($res>=1){
						  $pdf->Cell(10	,5,'' ,1,0,'C');
						  }else{
							  $pdf->Cell(10	,5,'' ,1,0,'C'); 
						  }
						  
						  }$pdf->Cell(0	,5,'' ,0,1,'C'); 
						  }
$pdf->Output('f','PDFS/markbook.pdf');

	?>
	