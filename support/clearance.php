<?php
session_start();
if (isset($_SESSION['id'])){
$q = ($_SESSION['id']);



unset($_SESSION['id']);
}else{
	$q =' ';
}
require("dbconn.php");

 

 $t1="";
 $t2="";
 $t3="";
 $en="";
 $b="";
 $name="";
 $frm="";
 $Left="";
 $nts="  						                                                                            ";
 	
 
		

require('fpdf/fpdf.php');
class PDF extends FPDF
{
// Page header


// Page footer
function Footer()
{
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	
}
}
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage('p','a4',0);
	
	$pdf->SetFont('Arial','B',8);
 //$pdf->Cell(0,0,'EDUCATION:',0,0,'R');
	$pdf->Ln();
	// Ari$pdf->Ln(10);al bold 15
	$pdf->SetFont('Arial','B',9);
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


$pdf->SetTitle(strtoupper($name).'Clearance');

$pdf->Image('uploads/logo.png',95,6,20,'C');
	// Title
$pdf->Ln(13);
	$pdf->Cell(0,10,$title,0,0,'C');
	$name="";
	$class="";
	$adm=20019;
	$borrow_query = mysqli_query($con,"SELECT * FROM sudtls
									LEFT JOIN borrowed ON sudtls.adm = borrowed.user_code 
									LEFT JOIN books ON books.id = borrowed.book_id 
									WHERE sudtls.adm = '$adm'
									ORDER BY borrowed.book_id DESC");
									
								$borrow_count = mysqli_num_rows($borrow_query);
								while($borrow_row = mysqli_fetch_array($borrow_query)){
									$name = $borrow_row ['Name'];
									$class = $borrow_row ['Form'].' '.substr($borrow_row ['Stream'],0,1);
									$user_id = $borrow_row ['Adm'];
								}
	$pdf->Ln(10);
	$pdf->Cell(0,10,'CLEARANCE FORM',0,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10,10,'YEAR',0,0,'');
	$pdf->SetFont('Courier','U',10);
	$pdf->Cell(10,10,' '.Date("Y").' ',0,1,'');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(10,10,'NAME',0,0,'');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Cell(70,10,'      '.strtoupper($name).'          ',0,0,'');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(13,10,'CLASS',0,0,'');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Cell(50,10,'   '.strtoupper($class).'      ',0,0,'');
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(15,10,'ADM NO',0,0,'');
	$pdf->SetFont('Courier','UB',10);
	$pdf->Cell(10,10,'  '.strtoupper($adm).'   ',0,0,'');
		$pdf->SetFont('Arial','B',9);
	
	$pdf->Ln(10);

				//echo $qs;		
$c=0;	$cc=0;			
$pdf->Cell(10	,5,'S/NO',1,0);
$pdf->Cell(60	,5,'SUBJECT',1,0);
$pdf->Cell(60	,5,'CLEARANCE STATUS',1,0);
$pdf->Cell(60	,5,'TEACHER SIGNATURE',1,1);
$pdf->SetFont('Arial','',8);$id2="'a'";$id="";$status1a="Cleared";
$qs="SELECT Abbreviation, Description AS subs FROM  subjects  ORDER BY subjects.code asc ";
								  $subs=mysqli_query($con,$qs);
		$status2a="Cleared";
		$status3a="";
		while($sr=mysqli_fetch_assoc($subs)){
		$status1="Cleared";
		$status2="Cleared";
		$status3="";
		
		$borrow_query = mysqli_query($con,"SELECT borrowed.status,borrowed.book_id,user_code FROM borrowed
									LEFT JOIN books ON borrowed.book_id = books.id 
									LEFT JOIN sudtls ON sudtls.adm = borrowed.user_code 
									WHERE sudtls.adm = '$adm' and subject='".$sr['Abbreviation']."'
									ORDER BY borrowed.book_id DESC");
									
									
								$borrow_count = mysqli_num_rows($borrow_query);
								while($borrow_row = mysqli_fetch_array($borrow_query)){
									if($borrow_row ['status']=="Active"){
										$status1="Not Cleared";
									}
									else{
										
										$status2="Cleared";
									}
									$book_id = $borrow_row ['book_id'];
									$user_id = $borrow_row ['user_code'];
								}
								
								if($status1=="Cleared"){
									$status3="Cleared";
									
								}else{
									$status3="Not Cleared";
								}
		$pdf->Cell(10	,5,$c+=1,1,0);
	$pdf->Cell(60	,5,strtoupper($sr['subs']),1,0);
	if($status3=="Not Cleared"){
		$pdf->SetTextColor(255,0,0);
	}
	$pdf->Cell(60	,5,$status3,1,0);
	$pdf->SetTextColor(0,0,0);
$pdf->Cell(60	,5,$borrow_row ['status'],1,1);


		}
	// Title
	$pdf->Ln(2);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'23.ITEMS NOT SURRENDERED',0,1,'');
	$c=0;	$cc=0;			
$pdf->Cell(60	,5,'ITEM',1,0);
$pdf->Cell(60	,5,'NOTES',1,0);
$pdf->Cell(60	,5,'CLEARANCE STATUS',1,1);
$pdf->SetFont('Arial','',8);$id2="'a'";$id="";$status1a="Cleared";

		$status2a="Cleared";
		$status3a="";
	
		$status1="Cleared";
		$status2="Cleared";
		$status3="";
		
		$borrow_query = mysqli_query($con,"select * from damages where user='$adm'");
									
									
								$borrow_count = mysqli_num_rows($borrow_query);
								while($borrow_row = mysqli_fetch_array($borrow_query)){
									if($borrow_row ['status']=="Active"){
										$status1="Not Cleared";
									}
									else{
										
										$status2="Cleared";
									}
									$book_id = $borrow_row ['id'];
									$user_id = $borrow_row ['user'];
								
								
								if($status1=="Cleared"){
									$status3="Cleared";
									
								}else{
									$status3="Not Cleared";
								}
		
	$pdf->Cell(60	,5,strtoupper($borrow_row['name']),1,0);
	$pdf->Cell(60	,5,($borrow_row['notes']),1,0);
	if($status3=="Not Cleared"){
		$pdf->SetTextColor(255,0,0);
	}
	$pdf->Cell(60	,5,$status3,1,0);
	$pdf->SetTextColor(0,0,0);
}

	
	// Line break
	$pdf->Ln(10);
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'24.CLASS TEACHER REMARKS',0,0,'');

	$pdf->Cell(70,10,'SIGNATURE',0,0,'');
	
	$pdf->Cell(50,10,'DATE',0,1,'');
	
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'-----------------------------------------------',0,0,'');

	$pdf->Cell(70,10,'--------------------',0,0,'');
	
	$pdf->Cell(50,10,'----------------',0,1,'');
	
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',9);
	
		
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'25. ACCOUNTS (SCHOOL FEES & OTHERS)',0,0,'');
$pdf->SetFont('Arial','B',9);
	$pdf->Cell(70,10,'SIGNATURE',0,0,'');
	
	$pdf->Cell(50,10,'DATE',0,1,'');
	
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'-----------------------------------------------',0,0,'');

	$pdf->Cell(70,10,'--------------------',0,0,'');
	
	$pdf->Cell(50,10,'----------------',0,1,'');	
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'26. BOARDING ITEM(S)',0,0,'');
$pdf->SetFont('Arial','B',9);
	$pdf->Cell(70,10,'SIGNATURE',0,0,'');
	
	$pdf->Cell(50,10,'DATE',0,1,'');
	
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'-----------------------------------------------',0,0,'');

	$pdf->Cell(70,10,'--------------------',0,0,'');
	
	$pdf->Cell(50,10,'----------------',0,1,'');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'27. PRINCIPAL',0,0,'');
$pdf->SetFont('Arial','B',9);
	$pdf->Cell(70,10,'SIGNATURE',0,0,'');
	
	$pdf->Cell(50,10,'DATE',0,1,'');
	
		$pdf->SetFont('Arial','B',9);
		$pdf->SetFont('Arial','B',9);
	$pdf->Cell(80,10,'-----------------------------------------------',0,0,'');

	$pdf->Cell(70,10,'--------------------',0,0,'');
	
	$pdf->Cell(50,10,'----------------',0,1,'');
		
		
		$pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
		
		
	
	//VALUES/DATA
	$pdf->AddPage('p','a4',0);                                              
	
	$pdf->SetFont('Arial','B',8);
 //$pdf->Cell(0,0,'EDUCATION:',0,0,'R');
	$pdf->Ln();
	// Ari$pdf->Ln(10);al bold 15
	$pdf->SetFont('Arial','B',9);
	//n$pdf->Image('../logo.png',90,6,30,'C');
	// Title
//$pdf->Ln(5);
	$pdf->Cell(0,10,$title,0,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(0,10,'CAREER REGISTRATION FORM',0,0,'C');
	$pdf->Ln(15);
	
	
	$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'1.	Name in the school register');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                           '.$name.'                                                         ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
$pdf->Write(5,'2.	Admission');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                           '.$adm.'                                                                                                    ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'3.	Year of Birth');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'4.	Name registered for KCSE');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                           '.$name.'                                                         ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'5.	KCSE index Number');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                  ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'6.	Clubs and society you belonged to');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                             ');
	
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Cell(10);
	$pdf->Write(5,'i. Name of the club or society');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                                                                          ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Cell(10);
	$pdf->Write(5,'ii. Office held');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                                                                                           ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Cell(10);
	$pdf->Write(5,'ii. Patron Signature');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                                                                                    ');
	$pdf->Ln(15);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'7.	Sports (specify)');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                          ');
	//$pdf->Ln(10);$pdf->SetFont('Arial','',9); 
	
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	//$pdf->Cell(0);
	$pdf->Write(5,'Team Member');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                                                                                                ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'Official');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                            ');
	
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'8.	Leadership');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                  ');
	
	$pdf->Ln(15);$pdf->SetFont('Arial','',9);
	$pdf->Cell(10);
	$pdf->Write(5,'i. School Prefect');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                                          ');$pdf->SetFont('Arial','',9);$pdf->Write(5,'Principal Signature');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                         ');
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Cell(10);
	$pdf->Write(5,'ii. Class Monitor');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                                          ');$pdf->SetFont('Arial','',9);$pdf->Write(5,'Class Teacher Signature');$pdf->SetFont('Arial','U',15);$pdf->Write(5,'                    ');
	
	$pdf->Ln(10);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,'10.	Class Teacher`s comments on conduct, initiative industry regularity, personality and any other aspect of the student`s character');$pdf->Ln(5);$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                                        ');
	
	$pdf->Ln(5);$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                                        ');$pdf->Ln(5);$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                                        ');
	
	$pdf->Ln(15);$pdf->SetFont('Arial','',9);
	$pdf->Write(5,' Class Teacher Signature');$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                  ');
	
	$pdf->Ln(10);$pdf->SetFont('Arial','B',10);
	$pdf->Write(5,'	Principal comments');$pdf->Ln(5);$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                                        ');$pdf->Ln(5);$pdf->SetFont('Arial','U',10);$pdf->Write(5,'                                                                                                                                                                        ');
	
		$pdf->SetFont('Arial','B',9);$pdf->Ln();$pdf->Cell(0,10,'Page '.$pdf->PageNo().'/{nb}',0,0,'C');
		$pdf->Output('',strtoupper($name).'-Clearance form.pdf');

?>
	