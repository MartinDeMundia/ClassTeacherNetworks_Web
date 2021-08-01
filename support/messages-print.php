<?php
	
	session_start();
	include("dbconn.php");
$date=Date("d/m/Y");
$cat="";
$type="";
$c="";
		if(isset($_SESSION['date'])){
         $date=$_SESSION['date'];
		 $cat=$_SESSION['cat'];
		 $type=$_SESSION['type'];
          unset($_SESSION['date']);
        }
	
	$from = date('M/01/Y');
	$to = date('M/d/Y');

	$query="SELECT count(*) as c  FROM messages where Category like('%".$cat."%') and Date like('%".$date."%')  and Status like('%".$type."%')";
	//echo $query;
	$da=$con->query($query);
	while($row=$da->fetch_assoc()){
		$c=$row['c'];
	}
//echo $query;

	$from_title = date('M/01/Y');
	$to_title = date('M/d/Y');

	require_once('library/tcpdf/tcpdf.php');  
    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('('.$c.') '.strtoupper($cat.' - '.$type).' MESSAGES: '.$date);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('Arial');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 9);  
    $pdf->AddPage(); 
    $contents = '<center><h3>('.$c.') '.strtoupper($cat.' - '.$type).' MESSAGES: '.$date.'</h3 style="color:red;"><center>';
				 $contents .= '<table border="1" cellspacing="0" cellpadding="3">
				<thead>
				<tr>
				<th width="10%"><b>ID</b></th>
				<th width="30%"><b>NAME</b></th>
				<th width="60%"><b>MESSAGE</b></th>
				</tr>
				</thead>
				<tbody>';
	
	
	$query="SELECT uniques,Name,Message FROM messages  where Category like('%".$cat."%') and Date like('%".$date."%')  and Status like('%".$type."%')";
	$da=$con->query($query);
	while($row=$da->fetch_assoc()){
	
	
		$contents .= '<tr>
        <td width="10%">'.$row['uniques'].'</td>
        <td width="30%">'.$row['Name'].'</td>
        <td width="60%">'.$row['Message'].'</td>
		</tr>';
    
	}
	
	
				$contents .= '</tbody>
				</table>';
	
    $pdf->writeHTML($contents);  
    $pdf->Output(strtoupper($cat.' - '.$type).' MESSAGES: '.$date.'.pdf', 'I');

?>