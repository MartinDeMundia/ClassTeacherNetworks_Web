
<?php
error_reporting(0);
$class_id = $form;
$section_id = $stream;
$exam_id = $exam_name  = $exam  ;
$running_year = $this->db->get_where('settings' , array('type' => 'running_year' ))->row()->description;




$subject=$subject_id;
$class = $class_id=$form;
$school_id=$this->session->userdata('school_id');
$school_image = $this->crud_model->get_image_url('school',$school_id);
$stream=$section_id=strtolower($stream);
$year=$year;
$examdate=$year;
$en=$main_exam=$exam;
$term=$term;      
$exm=strtolower(str_replace("-","",str_replace(" ","",$exam)));


$classname = $qryfilter = $qrySubjfilter = $sreamname = "";
if($class > 0 ) {
$qryfilter .= ' AND e.class_id =  "'.$class .'" ';
$qrySubjfilter .= ' AND class_id =  "'.$class .'" ';
$classname = $this->db->get_where('class' , array('class_id' =>$class))->row()->name;

}
if($stream > 0 ){
$qryfilter .= ' AND e.section_id =  "'.$stream .'" ';
$qrySubjfilter .= ' AND section_id =  "'.$stream .'" ';
$sreamname = $this->db->get_where('section' , array('section_id' =>$stream))->row()->name;
}

$examname = $this->db->get_where('exams' , array('ID' =>$exam_id))->row()->Term1; 
?>

<br>

<script src="http://apps.classteacher.school/assets/js/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" href="http://apps.classteacher.school/assets/js/select2/select2-bootstrap.css">
<script src="http://apps.classteacher.school/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="http://apps.classteacher.school/assets/js/bootstrap.js"></script>
<style type="text/css">
    td {
        padding: 5px;
    }
</style>
<!-- <center>
    <img style="width:10px;height:10px;" src="<?php echo base_url(); ?>uploads/logo.png" style="max-height :10px;"><br>
</center> -->

<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-gray">
		<div class="icon"><i class="entypo-docs"></i></div>
		   <!--  <img width="90" height="40" style="width:10px;height:10px;" src="<?php echo base_url(); ?>uploads/logo.png" style="max-height :10px;"> -->
		    <img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100" height="80" >
			<h3 style="color: #696969;">
				<?php					
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					$subject_name = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;
					print('BROAD SHEET');
				?>
			</h3>			
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> : <?php echo $class_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('section');?> : <?php echo $section_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('Exam'); ?>: <?php echo $exam_id;?> 
			</h4>			
		</div>
	</div>
	<div class="col-md-4"></div>
</div>




<style>
/*table{
    width: 100%;
    border-collapse:collapse;
}

td{
    width: 2%;
    text-align: left;
    border: 1px solid black;
}
table{
    width: 100%;
    table-layout: fixed;
}*/
table, th, td {
  border: 0.1px solid black;
  padding-top:5px;
  padding-bottom:5px;
}
table{
        width:100%;
        table-layout: fixed;
        overflow-wrap: break-word;
}
margin-left: auto;
margin-right: auto;
</style>


                 <table  class="table table-bordered datatable" id="table_export" style="width:100%;margin: 0px auto;" >                          
                           <thead class="">
                                <tr style="background-color:grey;color:white;font-weight:900;padding:10px;"> 
                                  <th style="width:3%;">RNK</th>
								  <th style="width:7%;">ADM</th> 
                                  <th style="width:10%;">NAME</th> 
		                             <?php
										/*$qryIncludes = "
											SELECT s.name subject,eps.subject_id 
											FROM exam_processing ep 
											JOIN exam_processing_subjects eps ON eps.exam_processing_id = ep.id AND eps.is_active=1 
											JOIN subject s ON s.subject_id = eps.subject_id 
											WHERE ep.class_id = '".$class_id."' AND ep.stream_id = '".$section_id."' AND ep.term = '".urldecode($term)."' AND ep.year='".$year."' AND exam = '".urldecode($main_exam)."'
										 ";	*/	
										$qryIncludes = "
                                          SELECT  id,subject  FROM  class_subjects WHERE  school_id = '".$this->session->userdata('school_id')."'   AND  is_elective <> 2 ;
										";	

										//var_dump($qryIncludes); exit();													 
							            $queryInclude = $this->db->query($qryIncludes)->result_array();
							            $colpersubjarrays = array(); 
							            foreach($queryInclude as $rowExamsIncluded){
							               echo "<th style='text-align:center;'><div>".$rowExamsIncluded['subject']."</div></th>";
							            

							            $qrySubIncludes = "
                                          SELECT  subject  FROM  class_subjects WHERE  parentid = '".$rowExamsIncluded['id']."' ;
										";	
										$querySubInclude = $this->db->query($qrySubIncludes)->result_array();

										$colpersubjarrays[] = $rowExamsIncluded['subject'];
											foreach($querySubInclude as $rowExamsSubIncluded){
												 echo "<th style='text-align:center;'><div>".$rowExamsSubIncluded['subject']."</div></th>";
												  $colpersubjarrays[] = $rowExamsSubIncluded['subject'];
											}


							               
							            }
								     ?>

								  <th>POS</th>
								  <th>TOTAL</th>
								  <th>MS</th> 
                                 <!--  <th>(%)</th>   --> 
								  <th>MG</th>
								 <!--  <th>V/A</th> -->
                              </tr>
                             </thead>
                             <tbody>  
						     <?php
									$qry = '
									SELECT sm.rank,s.student_code,s.name,s.student_id,sm.mark ,sm.mean,sm.grade 
									FROM enroll e 
									JOIN student s ON s.student_id = e.student_id  
									LEFT JOIN exam_processing_rank sm ON sm.student_id = s.student_id AND sm.term = "'.$term.'"  AND LOWER(sm.exam) = "'.$main_exam.'" 
									WHERE 
									s.school_id =  "'.$this->session->userdata('school_id').'" 
									';  

									$qry =  $qry." ".$qryfilter; 

									$qry .= ' GROUP BY s.student_id  ORDER BY  sm.rank ASC';

									$students   = $this->db->query($qry)->result_array();
								
									foreach($students as $rowStud){
										echo '<tr>';
			                              echo '<td style="width:3%;">'.(int)$rowStud['rank'].'</td>';							
										  echo '<td style="width:7%;">'.$rowStud['student_code'].'</td>';
										  echo '<td style="width:10%;">'.$rowStud['name'].'</td>';

                                          $sumtotal=$sMark = 0;
                                          if(count($colpersubjarrays)){
                                           	foreach ($colpersubjarrays as $key => $subjname) {
                                           		$sqlincluded = "SELECT  mark subjmark  FROM exam_processing_final WHERE student_id ='".$rowStud["student_id"]."' AND subject='".$subjname."' AND LOWER(exam)='".urldecode($main_exam)."'";
											
												$queryMarkInclude = $this->db->query($sqlincluded);
												$rowMakIncluded =   $queryMarkInclude->row(); 									       
												if($rowMakIncluded){
													$sMark = $rowMakIncluded->subjmark;
												}else{
													$sMark = 0;
												}
                                           		echo '<td style="text-align:center;">'.(int)$sMark.'</td>'; //$sMark
                                           		 $sumtotal =  $sumtotal + $sMark ; 
                                           	}
                                           }

										  echo '<td>'.(int)$rowStud['rank'].'</td>';
			                              echo '<td>'.(int)$sumtotal.'</td>';
										  echo '<td>'.$rowStud['mean'].'</td>';
										 // echo '<td>ff</td>';
			                              echo '<td>'.$rowStud['grade'].'</td>'	;						
									     // echo '<td>0</td>';
									   echo '</tr>'; 	
								      }
									
								     ?>
							    
						       </tbody>
                           </table>





<?php
//echo $content ; exit();
	$content = ob_get_contents();
	$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
    $pdf->SetTitle('BROAD SHEET PDF '.strtoupper($form." ". $stream. " ".$en." ". $subject." ($term - ". $year. ")"));  
    $pdf->SetHeaderData('BROAD SHEET  '.strtoupper($form." ". $stream. " ".$en." ". $subject." ($term - ". $year. ")").date('M/d/Y'), '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
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
    ob_end_clean();
    $pdf->writeHTML($content);
    ob_clean();
    $filename = "Broad-Sheet.pdf";
    $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/reports/".$filename;	
    $pdf->Output($file, 'F');
    $externallink = "http://apps.classteacher.school/assets/reports/".$filename;
    echo json_encode(array("pdfpath"=>$externallink));	  
			
	