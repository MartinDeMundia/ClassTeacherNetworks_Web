 <?php 
 
  $content="";
 $content.='<img src="'.base_url().'uploads/logo.png" width="70" height="70"><center> 
  <h2 >BROAD SHEET -'.strtoupper($class." ". $stream." ".$main_exam. ' ('.$term .'- '. $year. ')').'</h2></center>
 
 
 <table border="1" cellspacing="0" cellpadding="3" style="font-size:7px; color:;">
                                <tr>
                                  <th width="23"><B>RNK</B></th>
								  <th><B>ADM</B></th> 
                                  <th width="90"><B>NAME</B></th>   
								  <th><B>CLASS</B></th>
								  <th width="20"><B>ST</B></th>
								   <th width="22"><B>POS</B></th>
								   <th><B>TOTAL</B></th>
								  <th><B>MS</B></th> 
                                  <th><B>(%)</B></th>   
								  <th  width="20"><B>MG</B></th>
								  <th width="20"><B>V/A</B></th>';
								
								 
								  if($exam1 != ''){
									 $content.= '<th><B>'.$exam1.'</B></th>';
								  }
								
								  
								 
								  if($exam2 != ''){
									   $content.=  '<th><B>'.$exam2.'</B></th>';
								  }
								
								 
								$subjects=$this->db->query("SELECT Abbreviation FROM subjects  WHERE school_id=".$this->session->userdata('school_id')."  ORDER BY CODE ASC")->result_array();
							foreach($subjects as $row):
							
						 $content.= '<th width="28"><B>'. $row['Abbreviation'] .'</B></th>';
						  
						  
						 endforeach;
						
                               $content.= '</tr> ';
						  
						  foreach($exam as $rs):
						    $paint_red="";
						  $grade = $this->db->query("select rgrade(".round($rs['TotalPercent'],2).",1) AS Grade");
						  $grade1="";
						  $points1=0;
						  $points2=0;
						  foreach ($grade->result_array() as $g):
						  $grade1= $g['Grade'];
						  $points1 = $this->db->get_where("gradingscale",array("Grade"=>$grade1,"school_id"=>1))->row()->Points;
						  if($cutoff !=''){
						  $points2 = $this->db->get_where("gradingscale",array("Grade"=>$cutoff,"school_id"=>1))->row()->Points;
						  }
						  endforeach;
						  if (($points1 < $points2)==1){
							  $paint_red= 'style="font-size:7px; color:red;"';
						  }
						  
						
						  
						    $content.= '<tr '.$paint_red.'>
                              <td>'. $rs['PosClass'] .'</td>
							  <td>'. $rs['Adm'] .'</td>
                              <td>'. 
							  $this->db->get_where("sudtls",array("Adm"=>$rs['Adm'],"school_id"=>1))->row()->Name
							   .'</td>
							  <td>'. $rs['Form'] . '</td>
                              <td>'. substr($rs['Stream'],0,1) . '</td>
							  <td>'. $rs['PosStream'] . '</td>
							  
                              <td>'. round($rs['TotalMarks'],2).'</td>
							  <td>'. round($rs['TotalScore'],2).'</td>
                              <td>'. round($rs['TotalPercent'],2).'</td>
							  <td>'. $grade1.'</td>
                              <td>';

							  if ($grade !='') {
								  echo($this->db->get_where("gradingscale",array("Grade"=>$grade1,"school_id"=>1))->row()->Points)-($this->db->get_where("sudtls",array("Adm"=>$rs['Adm'],"school_id"=>1))->row()->kcpe)
								  ; }
								  
								  $content.= ' </td>';
								 
								  
								  if($exam1 != ''){
									  $m = $this->db->query("SELECT ".str_replace(" ","",$exam1)." from mean_score where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."  and exam_type='$exam1' and term='Term 1' and Year = '2019'")->result_array();
								foreach($m as $r):
									  $content.= ' <td>'.$r[str_replace(" ","",$exam1)].'</td>';
								endforeach;
									 
								  }
								
								  
								  
								  if($exam2 != ''){
									    $m = $this->db->query("SELECT ".str_replace(" ","",$exam2)." from mean_score where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."  and exam_type='$exam1' and term='Term 1' and Year = '2019'")->result_array();
								foreach($m as $r):
									  $content.= ' <td>'.$r[str_replace(" ","",$exam2)].'</td>';
								endforeach;
								  }
								
								 
						  $subjects=$this->db->query("SELECT Abbreviation,code FROM subjects  WHERE school_id=".$this->session->userdata('school_id')."  ORDER BY CODE ASC")->result_array();
							foreach($subjects as $row):
						 $content.= '<td> ';
								$mark1=0;
								$mark2=0;
								$mark3=0;
								$m = $this->db->query("SELECT TotalScore from ".str_replace(" ","",$main_exam)." where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."  and exam_type='$main_exam' and code=".$row['code']." and term='Term 1' and Year = '2019'")->result_array();
								foreach($m as $r):
									$mark1= $r['TotalScore'];
								endforeach;
								if($exam1 != ''){
									$m = $this->db->query("SELECT TotalScore from ".str_replace(" ","",$exam1)." where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."   and code=".$row['code']." and term='Term 1' and Year = '2019'")->result_array();
										foreach($m as $r):
											$mark2= $r['TotalScore'];
										endforeach;
								}
													if($exam2 != ''){
												$m = $this->db->query("SELECT TotalScore from ".str_replace(" ","",$exam2)." where Adm=".$rs['Adm']." and school_id=".$this->session->userdata('school_id')."  and code=".$row['code']." and term='Term 1' and Year = '2019'")->result_array();
													foreach($m as $r):
														$mark3= $r['TotalScore'];
													endforeach;
								}
						  $total= $mark1+$mark2+$mark3;
						  
						   $grade = $this->db->query("select rgrade(".round($total,2).",1) AS Grade");
						  $grade1="";
						  
						  foreach ($grade->result_array() as $g):
						  $grade1= $g['Grade'];
						  endforeach;
						  if($total>0) { $content.=  $total." ".$grade1 ;}else{ $content.=  '-'; }
						 $content.= '</td>';
						  
						 
						 endforeach;
						  
						  
						 $content.= '</tr>';
						  endforeach;
						
						  
						  
						  
						  
						  $content.= '
                  </table>';
				  
			
			$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
    $pdf->SetTitle('BROAD SHEET -'.strtoupper($class.' '. $stream.' '.$main_exam. ' ( '.$term .'- '. $year. ')  ').date('M/d/Y'));  
    $pdf->SetHeaderData('BROAD SHEET -'.strtoupper($class.' '. $stream.' '.$main_exam. ' ( '.$term .'- '. $year. ')  ').date('M/d/Y'), '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
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
    $pdf->Output('BROAD SHEET -'.strtoupper($class.' '. $stream.' '.$main_exam. ' ( '.$term .'- '. $year. ')  ').'.pdf','D');		  
				  
				?>  