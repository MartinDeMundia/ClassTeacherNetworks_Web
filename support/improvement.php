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
$subject=mysqli_real_escape_string($con,$_POST['subject']);
$form=mysqli_real_escape_string($con,$_POST['form']);
//$f2=str_replace("form";mysqli_real_escape_string($con,$_POST['form']);
$stream=strtolower(mysqli_real_escape_string($con,$_POST['stream']));
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$en=mysqli_real_escape_string($con,$_POST['exam']);
$en2=mysqli_real_escape_string($con,$_POST['exam2']);
$term=mysqli_real_escape_string($con,$_POST['term']);
$term1=mysqli_real_escape_string($con,$_POST['term1']);
$best=mysqli_real_escape_string($con,$_POST['best']);
$sub=mysqli_real_escape_string($con,$_POST['sub']);
$lmt=mysqli_real_escape_string($con,$_POST['lmt']);

if(strtolower($en=="END OF TERM")){
	$en="END OF";
$exm='term';
}else{	

$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam']))));
}

if(strtolower($en2=="END OF TERM")){
	$enb='term'; 
$en2="END OF";
}else{	
$enb=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam2'])))); 

}



 if(strtolower($stream)=="all"){
							$str=""; 
						 }else{
						  $str=" and Stream ='".$stream."' ";
						 }


		if(file_exists('PDFS/uu.pdf')){
rename('PDFS/markbook.pdf','PDFS/'.date('dmyh:i:sa').'pdf');
		}
$q1s="select description from settings where type='address'";
  $qs="SELECT code from subjects where Abbreviation='".$subject."'";
 // echo $qs;
								  $rs1=mysqli_query($con,$qs);
								  while($rows1=mysqli_fetch_assoc($rs1)){
									$code=$rows1['code'];
								  }
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
	global $title,$tel,$address,$con,$form,$term,$en,$stream,$year,$subject,$best,$lmt,$sub,$enb,$en2,$term1;

	$this->Image('uploads/logo.png',170,6,20);
	// Arial bold 15
	$this->SetFont('Arial','B',9);
	
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

	if($sub=="Yes"){
	 $this->Cell(0	,10,strtoupper($en.' '.$subject.' improvement index    - form '.$form. ' '.$stream. ' '.$year) ,0,0,'C');
	}else{
		
		 $this->Cell(0	,10,strtoupper($en.' improvement index   - form '.$form. ' '.$stream. ' '.$year) ,0,0,'C');
	}
	
$this->Line(10,32,200,32);
//$this->Line(6,46,185,46);
$this->SetLineWidth(0.5);
$this->Line(10,33,200,33);
$this->Ln(5);

$this->Cell(15	,10,'',0,0,'L');
								  $this->Cell(10	,10,'',0,0,'L'); 
                                  $this->Cell(20	,10,'',0,0,'L');   
								  $this->Cell(50	,10,'',0,0,'L');
								  
						  $this->Cell(0	,10,'' ,0,1,'C');
						   
						  $this->Cell(15	,7,'#','B',0,'L');
								  $this->Cell(10	,7,'ST','B',0,'L'); 
                                  $this->Cell(20	,7,'ADM','B',0,'L');   
								  $this->Cell(40	,7,'NAME ','B',0,'L');
								   $this->Cell(30	,7,$en.'('.str_replace("erm","",$term).')','B',0,'C');
								      $this->Cell(30	,7,$en2.'('.str_replace("erm","",$term1).')','B',0,'C');
								    $this->Cell(20	,7,'IMPR(+/-)','B',0,'C');
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
$pdf->SetLeftMargin(20);
$pdf->AliasNbPages();
$pdf->AddPage('P');
$pdf->SetFont('Times','B',8);
							
						  
						 //where Form='$form' and Stream='$stream'
						 if($best=="Yes"){
		$t="top";
		$order="DESC";
	}else{
		$t="Bottom";
		$order="ASC";
	}
						 if($sub=="Yes"){
							 
							 if($en=="END OF TERM"){
					 $qs1="SELECT TotalScore AS count,adm,grade FROM ve where  code='$code' and  term='$term' and year='$year'   $str ";
						
					}else {
		
		 $qs1="SELECT TotalScore AS count,adm,grade FROM ".$exm." where  code='$code' and  term='$term' and year='$year'   $str ";
		 
					}
		
		 
		 
	}else{
			 $qs1="SELECT TotalPercent  AS count,adm,grade FROM form".$form."".$exm." where   term='$term' and year='$year' $str ";
			 
			
			 
	}
		$subs1=mysqli_query($con,$qs1);
		$res=0;
		$lmt=0;
		$p=0;
		//echo $qs1;
		 $NUM=0;
		while($sr2=mysqli_fetch_assoc($subs1)){
						 
						 if($sub=="Yes"){
		
		if($en2=="END OF TERM"){
					 $qs12="SELECT TotalScore AS count,adm,Grade FROM ve where  code='$code' and  term='$term1' and year='$year' and adm='".$sr2['adm']."' $str ";
						
					}else {
		  $qs12="SELECT TotalScore AS count,adm,grade FROM ".$enb." where  code='$code' and  term='$term1' and year='$year' and adm='".$sr2['adm']."' $str ";
					}
		 
	}else{
			
			 $qs12="SELECT TotalPercent  AS count,adm,grade FROM form".$form."".$enb." where   term='$term1' and year='$year' and adm='".$sr2['adm']."' $str ";
			 
	}
						 echo  $qs12;
						  $results2=mysqli_query($con,$qs12);
						//echo $qs12;
						 $NUM+=1;
						 $exam2=0;
						 while($row2=mysqli_fetch_assoc($results2)){
							  
							 $exam2=$row2['count'];
								
							}
						 
						 
						 
						 
						$query="SELECT * from sudtls where adm='".$sr2['adm']."'";
						  $results=mysqli_query($con,$query);
						//echo $query;
						 $NUM+=1;
						 while($row=mysqli_fetch_assoc($results)){
							  
							 
								 
								  $pdf->Cell(15	,5,$NUM,'B',0,'L');
								  $pdf->Cell(10	,5, substr($row['Stream'],0,1),'B',0,'L'); 
                                  $pdf->Cell(20	,5, $row['Adm'],'B',0,'L');   
								  $pdf->Cell(40	,5,$row['Name'],'B',0,'L');
	 }
			/////////// }
						  $res=$sr2['count'];
						
						 
						 $p=$res;
						 $i="";
						  if($res>=1){
							  if((round($exam2,2)-$res)>0){
								  $i="+";
							  }elseif((round($exam2,2)-$res)<0){
								 $i=""; 
							  }
						  $pdf->Cell(30	,5,round($res,2) ,'B',0,'C');
						   $pdf->Cell(30	,5,round($exam2,2) ,'B',0,'C');
						  $pdf->Cell(20	,5,$i.(round($exam2,2)-round($res,2)) ,'B',0,'C');
						   $qs1U="SELECT grade   AS count FROM gradingscale where min>=$p and max<=$p";
		$subs1U=mysqli_query($con,$qs1U);
		$res1=0;
		//echo $qs1U;
		while($sr2U=mysqli_fetch_assoc($subs1U)){
						   $res1=$sr2U['count'];
		}
						  
						  }else{
							   $pdf->Cell(20	,5,'-' ,'B',0,'C');
							  $pdf->Cell(20	,5,'-' ,'B',0,'L');
							 
						  }
						  
						 $pdf->Cell(0	,5,'' ,0,1,'L'); }
						 $pdf->SetFont('Arial','B',8);
						  $pdf->Ln(5);
						
						 
						 
						 
$pdf->Output('f','PDFS/improve.pdf');

	?>
	