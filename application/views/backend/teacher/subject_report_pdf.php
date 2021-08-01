<?php
ob_end_clean();
error_reporting(0);
 $content='';


						  $content.='<table  cellspacing="0" cellpadding="3" style="font-size:9px; color:;" border="0">
						 
						    <tr border="0" style="background-color:rgb(163, 206, 201);">';
							   
							 $name=$this->db->get_where("school", array('school_id'=>$this->session->userdata('school_id')))->row()->school_name;
							  $address=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->address;
							  $telephone=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->phone;
							  $location=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->county;
							  
							   $content.='<th colspan="3" bgcolor="" align="center"> 
							   
							  <B>
							   <br>
							   '.strtoupper($name).'
							   <br>
							   '.strtoupper($address).'-
							   
							   '.strtoupper($location).'
							   <br>
							   '.$telephone.' <center><br><U><strong class="card-title ">'.strtoupper($exam).'  SUBJECTS REPORT  '.strtoupper(" ($term - ". $year. ")").'</strong>	</U></B> </center>
							   </th>
							  </tr>
							  <tr border="0" style="background-color:rgb(163, 206, 201);">
							 <th colspan="3" bgcolor="" align="center">  
							<br>'.strtoupper($student).'  '.strtoupper($adm).'
							   </th>
							  </tr>
						  <tr>
						  <th width="25"></th>
								 <th width="200">ITEM</th> 
                                 <th width="100%">DESCRIPTION</th>   
								 
						  </tr>';
							$content.='';
							$this->db->order_by("Code","ASC");
							$s= $this->db->get_where("subjects")->result_array();
						
							foreach($s as $subject) :
						
								$sub = $subject["Abbreviation"];
								$query= $this->db->get_where("subject_reports",array("adm"=>$adm,"exam"=>$exam,"term"=>$term,"year"=>$year,"subject"=>$sub))->result_array();
								
								$count = count($query);
								if($count > 0){
									$content.='<tr style="background-color:#40c3bb; color:#fff;"><td width="25"></td>';
								$content.='<td  align="center">'.$subject["Description"];
								$content.='</td><td width="100%"></td></tr>';
								}
						  $NUM=0;
						 foreach($query as $row):
						 
						 if($row['item']!=''){
							 
							 $items 		= explode(',',$row['item']);
					
							$description 	= explode(',',$row['description']);
							
								  for($i = 0; $i< count($description);$i++){
									  $NUM+=1;
								  $content.='
								  <tr>
								 <td width="25">'.$NUM .'</td>
								  <td width="200"> '.$items[$i] .'</td> 
                                  <td width="100%"> '.$description[$i] .'</td>'   
								  ;
								  
						$content.='</tr> ';
								  }
								  }
						 endforeach;
						 
						 
					 endforeach;
	
	$content.='
	</table>
	</div>
	</div>';
						
	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
   
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(5, '5', 5);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 7);  
    $pdf->AddPage(); 	  
    $pdf->writeHTML($content);
    //$pdf->Output(__DIR__ .$this->session->userdata('pdf').'.pdf','I');
    ob_clean();
    $filename = "Subject Report.pdf";
    $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/reports/".$filename;	
    $pdf->Output($file, 'I');
    exit();	

?>
	