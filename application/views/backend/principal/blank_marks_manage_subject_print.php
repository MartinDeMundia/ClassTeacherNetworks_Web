
<?php
error_reporting(0);
$class_id = $form;
$section_id = $stream;
$exam_id = $exam_name  = $exam  ;
$running_year = $this->db->get_where('settings' , array('type' => 'running_year' ))->row()->description;




$subject=$subject_id;
$subjectsname = $this->db->get_where('subject' , array('subject_id' => $subject))->row()->name;
$class = $class_id=$form;
$school_id=$this->session->userdata('school_id');
$school_image = $this->crud_model->get_image_url('school',$school_id);
$stream=$section_id=strtolower($stream);
$year=$year;
$examdate=$year;
$en=$exam;
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
		    <!-- <img width="90" height="40" style="width:10px;height:10px;" src="<?php echo base_url(); ?>uploads/logo.png" style="max-height :10px;"> -->
            <img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100" height="80" >
			<h3 style="color: #696969;">
				<?php					
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					$subject_name = $this->db->get_where('subject' , array('subject_id' => $subject_id))->row()->name;
					print('MARK BOOK REPORT FOR '.$subjectsname);
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
                    <thead>
                        <tr style="background-color:grey;color:white;font-weight:900;padding:10px;">                           
                            <th style="width:2%;"><div>#</div></th>
							<th><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>	

                             <?php
								$qryIncludes = "
									SELECT
									Term1 exam,percentage 
									FROM exam_processing ep
									JOIN exam_processing_includes epi ON epi.exam_processing_id = ep.id AND epi.is_active=1
									JOIN exams e ON e.ID = epi.exam_id
									WHERE ep.class_id = '".$class_id."' AND ep.stream_id = '".$section_id."' AND ep.term = '".urldecode($term)."' AND ep.year='".$year."' AND exam = '".urldecode($exam)."'
								 ";
								 
					            $queryInclude = $this->db->query($qryIncludes)->result_array(); 
					           
					            foreach($queryInclude as $rowExamsIncluded){	
					               echo "<th style='text-align:center;'><div>".$rowExamsIncluded['exam']."/<b>".$rowExamsIncluded['percentage']."</b></div></th>";
					            }
						     ?>	
                            <th style='text-align:center;'><div><?php echo get_phrase('Total /100');?></div></th>
                            <th style='text-align:center;'><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>



                              
                             <?php

                            

                                 $qryincludes = '
									SELECT
									Term1 exam,percentage 
									FROM exam_processing ep
									JOIN exam_processing_includes epi ON epi.exam_processing_id = ep.id AND epi.is_active=1
									JOIN exams e ON e.ID = epi.exam_id
									WHERE ep.class_id = "'.$class_id.'" AND ep.stream_id = "'.$section_id.'" AND ep.term = "'.urldecode($term).'" AND ep.year="'.$year.'" AND exam = "'.urldecode($exam).'"
					                                        ';

							       $includexams  = $this->db->query($qryincludes)->result_array();
							       $colarrays = array();
							       $colpercarrays = array();
							       foreach($includexams as $rowexams){
							       	$colarrays[] = preg_replace('/\s+/', '', $rowexams['exam']);
							       	$colpercarrays[] = $rowexams['percentage'];
							       }
							       $colstring = implode("`,`",$colarrays);


                             $qry = '
        
                              SELECT * 
                                        FROM enroll e 
                                        JOIN student s ON s.student_id = e.student_id  
                                        LEFT JOIN student_marks sm ON sm.studentid = s.student_id AND sm.term = "'.urldecode($term).'" AND sm.subject = "'.$subject.'" AND sm.examtype = "'.urldecode($exam).'" 
                                        WHERE 
                                        school_id =  "'.$this->session->userdata('school_id').'"
                                        ';

						          if($class_id > 0 ) $qry .= ' AND e.class_id =  "'.$class_id .'" ';
						          if($section_id > 0 ) $qry .= ' AND e.section_id =  "'.$section_id .'" ';
						         $qry .= ' GROUP BY s.student_id ';

                                    $students   = $this->db->query($qry)->result_array();

                                      foreach($students as $row):?>
                                        <tr>
                                        	<td style="width:2%;"><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                                            <td style="" ><?php  echo $row['student_code']; ?></td>                                           
                                            <td style="" ><?php  echo $row['name']; ?></td>

                                           <?php
                                           $sumtotal = 0;$GradeM="";
                                           if(count($colarrays)){
                                           	foreach ($colarrays as $key => $colname) {
                                           		$sqlincluded = "SELECT `".strtolower($colname)."` mark  FROM exam_processing_marks WHERE student_id ='".$row["student_id"]."' AND subject='".$subjectsname."' AND exam='".urldecode($exam)."'";
												$queryMarkInclude = $this->db->query($sqlincluded);
												$rowExamIncluded =   $queryMarkInclude->row(); 
												$sMark = $rowExamIncluded->mark;
                                           		echo '<td style="text-align:center;">'.$sMark.'</td>';
                                           		 $sumtotal =  $sumtotal + $sMark ; 
                                           	}

                                           	//fetch grade
                                           	$sqlGrd = "SELECT name FROM grade g WHERE ".$sumtotal." >= g.mark_from AND ".$sumtotal." <=  g.mark_upto AND g.school_id = '".$this->session->userdata('school_id')."' ";
											$queryGrd = $this->db->query($sqlGrd);
												$rowGrd =   $queryGrd->row(); 
												$GradeM = $rowGrd->name;
                                           }                           

                                         ?>


                                            <td style="text-align:center;" ><?php echo $sumtotal; ?></td>
                                            <td style="text-align:center;"><?php echo $GradeM; ?></td>

                                        </tr>
                                    <?php endforeach;?>

                    </tbody>
                </table>









<?php
//echo $content ; exit();
	$content = ob_get_contents();
	$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
	$this->session->set_userdata('pdf', md5(time()));
    $pdf->SetTitle('MARK BOOK REPORT');  
    $pdf->SetHeaderData('MARK BOOK REPORT', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
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
    $filename = "Markbook.pdf";
    $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/reports/".$filename;	
    $pdf->Output($file, 'F');
    $externallink = "http://apps.classteacher.school/assets/reports/".$filename;
    echo json_encode(array("pdfpath"=>$externallink));	  
			
	