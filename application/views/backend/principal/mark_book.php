<div class="row" >
	 <div class="col-lg-12">
<div class="ibox">

<div class="ibox-title">

<?php
$class_id = $class;
$section_id = $stream;
$exam = $main_exam;

$classname = $streamname = $subjectname= "";
$classresourcse  = $this->db->get_where("class", array("class_id"=>$class_id));
$rowRescCls =   $classresourcse->row(); 
if($rowRescCls) $classname = $rowRescCls->name;

$sectresourcse  = $this->db->get_where("section", array("section_id"=>$section_id));
$rowResc =   $sectresourcse->row(); 
if($rowResc) $streamname = $rowResc->name;

$subjresourcse  = $this->db->get_where("subject", array("subject_id"=>$subject));
$rowRescSubj =   $subjresourcse->row(); 
if($rowRescSubj) $subjectname = $rowRescSubj->name;

?>

<div class="card"  >
                    <div class="card-header">
					<strong class="card-title "><center>MARKBOOK  <?php echo strtoupper($classname." ". $streamname. " <b>".$main_exam."</b> ". $subjectname." ($term - ". $year. ")"); ?></center></strong>
		
                    </div>
					<div class="ibox-content">
						<div class="table-responsive">
						<span width="100%" height="100%"></span>

						<div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>                           
                            <th width="80"><div>#</div></th>
							<th width="80" style="width:10%;"><div><?php echo get_phrase('admission_no.');?></div></th>
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
                            <th style='text-align:center;'><div>Position</div></th>
                            <th style='text-align:center;'><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                              
                        <?php

                             $subjectsname = "";
                             $subjresourcseInc = $this->db->get_where('subject' , array('subject_id' => $subject));
                             $rowRescSubjInc =   $subjresourcseInc->row(); 
                             if($rowRescSubjInc) $subjectsname = $rowRescSubjInc->name;

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
                                        	<td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
                                            <td style="" ><?php  echo $row['student_code']; ?></td>                                           
                                            <td style="" ><?php  echo $row['name']; ?></td>

                                           <?php
                                           $sumtotal =$sMark=0;$GradeM=$subjRnk="";
                                           if(count($colarrays)){
                                           	foreach ($colarrays as $key => $colname) {
                                           		$sqlincluded = "SELECT `".strtolower($colname)."` mark  FROM exam_processing_marks WHERE student_id ='".$row["student_id"]."' AND subject='".$subjectsname."' AND exam='".urldecode($exam)."'";
												$queryMarkInclude = $this->db->query($sqlincluded);
												$rowExamIncluded =   $queryMarkInclude->row(); 
												if($rowExamIncluded) $sMark = $rowExamIncluded->mark;
                                           		echo '<td style="text-align:center;">'.$sMark.'</td>';
                                           		 $sumtotal =  $sumtotal + $sMark ; 
                                           	}

                                           	//fetch grade
                                           	$sqlGrd = "SELECT name FROM grade g WHERE ".$sumtotal." >= g.mark_from AND ".$sumtotal." <=  g.mark_upto AND g.school_id = '".$this->session->userdata('school_id')."' ";
											$queryGrd = $this->db->query($sqlGrd);
												$rowGrd =   $queryGrd->row(); 
												if($rowGrd)$GradeM = $rowGrd->name;
                                           }

                            

                                           ?>

                                            
                                            <td style="text-align:center;" ><?php echo $sumtotal; ?></td>
                                               <?php
                                                $sqlsubjrank= "SELECT rank  FROM exam_processing_final WHERE student_id ='".$row["student_id"]."' AND subject='".$subjectsname."' AND exam='".urldecode($exam)."'";
												$querysubjRnk = $this->db->query($sqlsubjrank);
												$rowRnk=   $querysubjRnk->row(); 
												if($rowRnk)$subjRnk= $rowRnk->rank;
												?>
                                            <td style="text-align:center;" ><?php echo (int)$subjRnk; ?></td>
                                            <td style="text-align:center;"><?php echo $GradeM; ?></td>

                                        </tr>
                                    <?php endforeach;?>


                  



                    </tbody>
                </table>

            </div>    

        </div>
		 
                          