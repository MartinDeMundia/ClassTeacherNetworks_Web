<?php
$class_id = $class;
$section_id = $stream;
$exam = $main_exam;
//$classname  = $this->db->get_where("class", array("class_id"=>$class_id))->row()->name;
//$streamname  = $this->db->get_where("section", array("section_id"=>$section_id))->row()->name;

$classname = $qryfilter = $qrySubjfilter = $streamname = "";
if($class > 0 ) {
	$qryfilter .= ' AND e.class_id =  "'.$class .'" ';
	$qrySubjfilter .= ' AND class_id =  "'.$class .'" ';
	$classname = $this->db->get_where('class' , array('class_id' =>$class))->row()->name;

}
if($stream > 0 ){
	$qryfilter .= ' AND e.section_id =  "'.$stream .'" ';
	$qrySubjfilter .= ' AND section_id =  "'.$stream .'" ';
	$streamname = $this->db->get_where('section' , array('section_id' =>$stream))->row()->name;

} 

?>
<div class="row " id="">
	 <div class="col-lg-12">
<div class="ibox" id="ibox2">
                    <div class="ibox-title">
                        <h2>BROAD SHEET -   <?php echo strtoupper($classname." ". $streamname." ".$main_exam. " ($term - ". $year. ")"); ?></h2>
                       
                    </div>
                    <div class="ibox-content">

					<div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-responsive table-sm table-bordered dataTables-example"  >
                              <thead class="">
                                <tr>
                                  <th>RNK</th>
								  <th>ADM</th> 
                                  <th width="10%">NAME</th> 
		                             <?php
/*										$qryIncludes = "
											SELECT s.name subject,eps.subject_id 
											FROM exam_processing ep 
											JOIN exam_processing_subjects eps ON eps.exam_processing_id = ep.id AND eps.is_active=1 
											JOIN subject s ON s.subject_id = eps.subject_id 
											WHERE ep.class_id = '".$class_id."' 
											AND ep.stream_id = '".$section_id."' 
											AND ep.term = '".urldecode($term)."' 
											AND ep.year='".$year."' 
											AND exam = '".urldecode($main_exam)."'
											ORDER BY s.name 
										 ";	*/

										 $qryIncludes = "
                                          SELECT  id,subject  FROM  class_subjects WHERE  school_id = '".$this->session->userdata('school_id')."'   AND  is_elective <> 2 ;
										 ";														 
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

/*							            foreach($queryInclude as $rowExamsIncluded){	
							               echo "<th style='text-align:center;'><div>".$rowExamsIncluded['subject']."</div></th>";
							               $colpersubjarrays[] = $rowExamsIncluded['subject'];
							            }*/
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
										  echo '<td style="width:5%;">'.$rowStud['student_code'].'</td>';
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
                                           		echo '<td style="text-align:center;">'.(int)$sMark.'</td>';
                                           		 $sumtotal =  $sumtotal + $sMark ; 
                                           	}
                                           }

										  echo '<td>'.(int)$rowStud['rank'].'</td>';
			                              echo '<td>'.(int)$sumtotal.'</td>';
										  echo '<td>'.$rowStud['mean'].'</td>';
										 // echo '<td>ff</td>';
			                              echo '<td>'.$rowStud['grade'].'</td>'	;						
									     // echo '<td>0</td>';
									    	
								      }
									echo '</tr>';
								     ?>
							    
						       </tbody>
                           </table>
                        </div>
						</div></div></div>
						<!-- Footer -->

    	                   </div>
						</div>  
						  
						  
						  
						  
						  
	
<script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: false,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'BROAD SHEET -   <?php echo strtoupper($class." ". $stream." ".$main_exam. " ($term - ". $year. ")"); ?>'},
                    {extend: 'pdf', title: 'BROAD SHEET -   <?php echo strtoupper($class." ". $stream." ".$main_exam. " ($term - ". $year. ")"); ?>',pageSize: 'A4',orientation: 'landscape'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>					  
						  
						  
						  
						  
						  
						  