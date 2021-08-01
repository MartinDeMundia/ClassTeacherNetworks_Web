<?php 
    $child_of_parent = $this->db->get_where('enroll' , array(
        'student_id' => $student_id , 'year' => $running_year
    ))->result_array();
	$school_id = $this->db->get_where('student' , array('student_id' => $student_id))->row()->school_id;
    foreach ($child_of_parent as $row):
?>
<hr />
    <div class="label label-primary pull-right" style="font-size: 14px; font-weight: 100;">
        <i class="entypo-user"></i> <?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
    </div>
<br><br>
<div class="row">
    <div class="col-md-12">
    
        <div class="tabs-vertical-env">
        
            <ul class="nav tabs-vertical">
                <?php 
                    $exams = $this->db->get_where('exam' , array('school_id' => $school_id,'year' => $running_year))->result_array();
                    foreach ($exams as $row2):
                ?>
                <li class="">
                    <a href="#<?php echo $row2['exam_id'];?>" data-toggle="tab">
                        <?php echo $row2['name'];?>  <small>( <?php echo $row2['date'];?> )</small>
                    </a>
                </li>
            <?php endforeach;?>
            </ul>
            
            <div class="tab-content">
            
            <?php 
                foreach ($exams as $exam):
                    $this->db->where('exam_id' , $exam['exam_id']);
                    $this->db->where('student_id' , $student_id);
                    $this->db->where('year' , $running_year);
                    $marks = $this->db->get_where('mark' , array('student_id' => $student_id))->result_array();
            ?>
                <div class="tab-pane" id="<?php echo $exam['exam_id'];?>">
                    <table class="table table-bordered responsive">
                        <thead>
                            <tr>                                
                                <th><?php echo get_phrase('subject');?></th>                              
                                <th><?php echo get_phrase('mark_obtained');?></th>
								<th><?php echo get_phrase('grade');?></th>
                                <th width="33%"><?php echo get_phrase('comment');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
						
						   $total_grade_point = 0;
						   $total_marks =0;
						   foreach ($marks as $mark):
						   $class_id = $mark['class_id'];
						   ?>
                            <tr>                                
                                <td>
                                    <?php echo $this->db->get_where('subject' , array(
                                        'subject_id' => $mark['subject_id']
                                    ))->row()->name;?>
                                </td>                                
                                <td><?php echo $mark['mark_obtained']; $total_marks += $mark['mark_obtained']; ?></td>
								 <td style="text-align: center;">
								   <?php
									   
									   if ($mark['mark_obtained'] >= 0 || $mark['mark_obtained'] != '') {
										   $grade = $this->crud_model->get_grade($mark['mark_obtained']);
										   echo $grade['name'];
										   $total_grade_point += $grade['grade_point'];
									   }
									   
								   ?>
							   </td>
                                <td><?php echo $mark['comment'];?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
					
					  <hr />

					  <?php echo get_phrase('total_marks');?> : <?php echo $total_marks;?>
					  <br>
					  <?php echo get_phrase('average_grade_point');?> :
						   <?php
							   $this->db->where('class_id' , $class_id);
							   $this->db->where('year' , $running_year);
							   $this->db->from('subject');
							   $number_of_subjects = $this->db->count_all_results();
							   echo ($total_grade_point / $number_of_subjects);
						   ?>
					<br><br>
					
                    <a href="<?php echo site_url('parents/student_marksheet_print_view/'.$student_id.'/'.$exam['exam_id']);?>"
                        class="btn btn-primary" target="_blank">
                        <?php echo get_phrase('print_marksheet');?>
                    </a>
                </div>
            <?php endforeach;?>

            </div>
            
        </div>  
    
    </div>
</div>
<?php endforeach;?>