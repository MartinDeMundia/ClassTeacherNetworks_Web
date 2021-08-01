<?php
$school_id=$this->session->userdata('school_id');
$school_image = $this->crud_model->get_image_url('school',$school_id);

$content='';
						$content.='
		
                    
		 
                            <table  cellspacing="0" cellpadding="3" style="font-size:9px; color:;">
                             
							  <tr >';
							   
							  $name=$this->db->get_where("school", array('school_id'=>$this->session->userdata('school_id')))->row()->school_name;
							  $address=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->address;
							  $telephone=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->phone;
							  $location=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->county;							  
							  $content.='<th colspan="10" bgcolor="" align="center">							   
							  <img class="health_logo" src='.($school_image !='')?$school_image:base_url("/uploads/logo.png").' width="100" height="80" >
							   <B>
							   <br>
							   '.$name.'
							   <br>
							   '.$address.'-
							   
							   '.$location.'
							   <br>
							   '.$telephone.' <br><U><strong class="card-title "><center>MARKBOOK  '.strtoupper($class." ". $stream. " ".$main_exam." ". $subject." ($term - ". $year. ")").'</strong>	</U></B>						   </center>
							   </th>
							  </tr>
							 <br>
                                <tr >
								 <th ></th> 
                                  <th width="100"></th> 
								   <th colspan="3" width="120" border="0.5" align="center"><center><B>'.strtoupper($main_exam) .'</center></B></th>';
								  
								  if($exam1 != ''){
									  $content.='<th colspan="3" width="120" border="0.5" align="center"><center><B>'.strtoupper($exam1).'</center></B></th>';
								  }
								  
								  
								  
								  if($exam2 != ''){
									  $content.='<th colspan="3" width="120" align="center"><center>'.strtoupper($exam2).'</center></th>';
								  }
								  
								    $content.='<th ></th>
									  <th ></th>
								 
                              </tr>
							   <tr border="0.5">
								 <th border="0.5"><B>ADM</B></th> 
                                  <th border="0.5"><B>NAME</B></th> 
								   <th border="0.5"><B>SCORE</B></th><th border="0.5"><B>RANK</B></th> <th border="0.5"><B>POS</B></th>';
								  
								  if($exam1 != ''){
									   $content.=' <th border="0.5"><B>SCORE</B></th><th border="0.5"><B>RNK</B></th> <th border="0.5"><B>POS</B></th>';
								  }
								  
								  
								  
								  if($exam2 != ''){
									 $content.=' <th border="0.5"><B>SCORE</B></th><th border="0.5"><B>RNK</B></th> <th border="0.5"><B>POS</B></th>';
								  }
								  
								    $content.='<th border="0.5"><B>TOTAL</B></th>
									  <th border="0.5"><B>GRADE</B></th>
								 
                              </tr>';
							  
                         
						   
						  
						 
						  
						  
						  foreach($exam as $row):
						  
						  $sum=0;
						   $total = count($this->db->get_where(str_replace(" ","",$main_exam), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"subject"=>$subject))->result_array());
						  $sum+=$row['TotalScore'];
						  $total2 = count($this->db->get_where(str_replace(" ","",$main_exam), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$main_exam,"form"=>$class,"term"=>$term,"year"=>$year,"stream"=>$row['Stream'],"subject"=>$subject))->result_array());
						  
						  $content.='<tr  border="0.5">
								 <td border="0.5">'.$row['Adm'].'</td> 
                                  <td border="0.5">'.$this->db->get_where("sudtls",array("Adm"=>$row['Adm'],"school_id"=>$this->session->userdata('school_id')))->row()->Name.'</td> 
								   <td border="0.5">'.$row['TotalScore'].'</td><td border="0.5">'.'<sup>'.$row['PosClass'].'</sup>/<sub>'.$total.'</sub>'.'</td> <td border="0.5">'.'<sup>'.$row['PosStream'].'</sup>/<sub>'.$total2.'</sub>'.'</td>';
								  
								  if($exam1 != ''){
									 
									 $e1 = $this->db->get_where(str_replace(" ","",$exam1), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$exam1,"form"=>$class,"term"=>$term,"year"=>$year,"Adm"=>$row['Adm'],"subject"=>$subject))->result_array();
									 $totale1 = count($this->db->get_where(str_replace(" ","",$exam1), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$exam1,"form"=>$class,"term"=>$term,"year"=>$year,"subject"=>$subject))->result_array());
									 
									  $total2e1 = count($this->db->get_where(str_replace(" ","",$exam1), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$exam1,"form"=>$class,"term"=>$term,"year"=>$year,"stream"=>$row['Stream'],"subject"=>$subject))->result_array());
									  foreach($e1 as $rw):
									   $sum+=$rw['TotalScore'];
									  
									  $content.='<td border="0.5">'.$rw['TotalScore'].'</td><td border="0.5">'.'<sup>'.$rw['PosClass'].'</sup>/<sub>'.$totale1.'</sub>'.'</td> <td border="0.5">'.'<sup>'.$rw['PosStream'].'</sup>/<sub>'.$total2e1.'</sub>'.'</td>';
									  
									  
									  endforeach;
									 
								  }
								  
								  
								  
								  if($exam2 != ''){
									 
									 $e1 = $this->db->get_where(str_replace(" ","",$exam2), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$exam2,"form"=>$class,"term"=>$term,"year"=>$year,"Adm"=>$row['Adm'],"subject"=>$subject))->result_array();
									 $totale2 = count($this->db->get_where(str_replace(" ","",$exam2), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$exam2,"form"=>$class,"term"=>$term,"year"=>$year,"subject"=>$subject))->result_array());
									 
									  $total2e2 = count($this->db->get_where(str_replace(" ","",$exam2), array('school_id'=>$this->session->userdata('school_id'),"exam_type"=>$exam2,"form"=>$class,"term"=>$term,"year"=>$year,"stream"=>$row['Stream'],"subject"=>$subject))->result_array());
									  foreach($e1 as $rw):
									   $sum+=$rw['TotalScore'];
									  
									 $content.=' <td border="0.5">'.$rw['TotalScore'].'</td><td border="0.5">'.'<sup>'.$rw['PosClass'].'</sup>/<sub>'.$totale2.'</sub>'.'</td> <td border="0.5">'.'<sup>'.$rw['PosStream'].'</sup>/<sub>'.$total2e2.'</sub>'.'</td>';
									  
									  
									  endforeach;
								  }
								 
								   $grade = $this->db->query("select rgrade(".round($sum,2).",".$this->session->userdata('school_id').") AS Grade");
								   foreach ($grade->result_array() as $g):
						  $grade1= $g['Grade'];
						  endforeach;
								  
								    $content.='<td border="0.5">'.$sum.'</td>
									  <td border="0.5">'.$grade1.'</td>
								 
                              </tr>';
						  
						  endforeach;
						    $content.='</table>';
						 
						  
					$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
    $pdf->SetTitle('MARKBOOK  '.strtoupper($class." ". $stream. " ".$main_exam." ". $subject." ($term - ". $year. ")"));  
    $pdf->SetHeaderData('MARKBOOK  '.strtoupper($class." ". $stream. " ".$main_exam." ". $subject." ($term - ". $year. ")").date('M/d/Y'), '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
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
		 ob_end_clean();
    $pdf->Output('MARKBOOK  '.strtoupper($class." ". $stream. " ".$main_exam." ". $subject." ($term - ". $year. ")").'.pdf','D');		  
				  ?>