
<div class="btn-group" style="float:right; margin:0px; "  >
		<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		Print Option <span class="caret"></span>
		</button>
		<ul class="dropdown-menu dropdown-default pull-right" role="menu">
			<?php 
			$school_id = $this->session->userdata('school_id');
			$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
			$class_idp = ($classes[0]['class_id']);											
			?>
			<li>
			<a href="#" onclick="showAjaxModal('<?php $subject_id =  $this->uri->segment('6'); echo site_url('modal/popup/modal_marks_manage_subject_view/'.$exam_id.'/'.$class_idp.'/'.$section_id.'/'.$subject_id);?>');">
			<i class="entypo-pencil"></i>
			<?php echo get_phrase('print_mark_book');?>
			</a>
		</li>										
		</ul>
 </div>
 
  <?php $query_primary = $this->db->query("SELECT * FROM school WHERE school_id =$school_id"); 
					 $data = $query_primary->result_array();
					 $school_type = ($data[0]['school_type']);                     
  ?>

<hr />
<?php 
$school_id = $this->db->get_where('class' , array('class_id' => $class_id))->row()->school_id;
echo form_open(site_url('admin/marks_subject_selector'));
?>
<div class="row">

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('exam');?></label>
			<select name="exam_id" class="form-control" required>
				<?php
					 $exams = $this->db->get_where('exam' , array('school_id' => $school_id,'year' => $running_year))->result_array();
					foreach($exams as $row):
				?>
				<option value="<?php echo $row['exam_id'];?>"
					<?php if($exam_id == $row['exam_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="col-md-2">
		<div class="form-group">
		<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class');?></label>
			<select id="class_id" name="class_id" class="form-control selectboxit" onchange="get_class_section(this.value)">
				<option value=""><?php echo get_phrase('select_class');?></option>
				<?php
					$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
					foreach($classes as $row):
				?>
				<option value="<?php echo $row['class_id'];?>"
					<?php if($class_id == $row['class_id']) echo 'selected';?>><?php echo $row['name'];?></option>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div>
		<div class="col-md-2">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream');?></label>
				<select name="section_id" id="section_holder" onchange="get_class_subject(this.value)" class="form-control">
					<?php 
						$sections = $this->db->get_where('section' , array(
							'class_id' => $class_id 
						))->result_array();
						foreach($sections as $row):
					?>
					<option value="<?php echo $row['section_id'];?>" 
						<?php if($section_id == $row['section_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
			<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('subject');?></label>
				<select name="subject_id" id="subject_holder" class="form-control">
					<?php 
						
						$user_id = $this->session->userdata('login_user_id');      
						$role = $this->session->userdata('login_type');

						if($role =='teacher')		
        					$subjects = $this->db->get_where('subject' , array('teacher_id' => $user_id,'class_id' => $class_id,'section_id' => $section_id ))->result_array();
						else									
						$subjects = $this->db->get_where('subject' , array(
							'class_id' => $class_id , 'section_id' => $section_id ,'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
						))->result_array();
			
						
						foreach($subjects as $row):
					?>
					<option value="<?php echo $row['subject_id'];?>"
						<?php if($subject_id == $row['subject_id']) echo 'selected';?>>
							<?php echo $row['name'];?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="col-md-2" style="margin-top: 20px;">
			<center>
				<button type="submit" class="btn btn-info"><?php echo get_phrase('view_marks');?></button>
			</center>
		</div>
	</div>

</div>
<?php echo form_close();?>

<hr />



<div class="tab-content">
            <div class="tab-pane active" id="home">
			<?php 
			$query = $this->db->query("SELECT * FROM class_subjects WHERE id =$subject_id"); 
					 $data = $query->result_array();
					 $parts = ($data[0]['parts']);                     
                     if($parts == '0') {?>
					 
						 <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           
                            <th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>							
                            <th><div><?php echo get_phrase('Total /100');?></div></th>
                            <th><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							//$students   =   $this->db->get_where('mark' , array(
							//	'class_id' => $class_id , 'year' => $running_year
							//))->result_array();
							$subject_id =  $this->uri->segment('6');
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id"); 
							$students = $query->result_array();
							$count = 1; foreach($students as $row): 
						 ?>
                        <tr>
                            
                            <td><?php echo $count++;?></td>
                            
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?>
							</td>
							<td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
							<td>
                                <?php
                                    echo $row['mark_obtained'];
                                ?>
                            </td>  
							 <td>
                                <?php
                                    echo $row['mark_obtained'];
                                ?>
                            </td> 
							 <td>
                              <?php
								$marks = $row['mark_obtained'];
								$grade = '';
								if($marks >=1 && $marks<= 29){
										echo $grade = 'E';
									}else if($marks > 30 && $marks <= 34){
										echo $grade = 'D-';
									}else if($marks > 35 && $marks <=39){
										echo $grade = 'D';
									}else if($marks > 40 && $marks <=44){
										echo $grade = 'D+';
									}else if($marks > 45 && $marks <=49){
										echo $grade = 'C-';
									}else if($marks > 50 && $marks <= 54){
										echo $grade = 'C';
									}else if($marks > 55 && $marks <= 59){
										echo $grade = 'C+';
									}else if($marks > 60 && $marks <= 64){
										echo $grade = 'B-';
									}else if($marks > 65 && $marks <= 69){
										echo $grade = 'B';
									}else if($marks > 70 && $marks <= 74){
										echo $grade = 'B+';
									}else if($marks > 75 && $marks <= 79){
										echo $grade = 'A-';
									}else if($marks > 80 && $marks <= 100){
										echo $grade = 'A';
									}
							  ?> 
                            </td> 
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
					    

					 <?php }elseif ($parts == '2') { ?>
					  <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           
                            <th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>
							<th><div><?php echo get_phrase('M1');?></div></th>
							<th><div><?php echo get_phrase('M2');?></div></th>							
                            
                            <th><div><?php echo get_phrase('Total /100');?></div></th>
                            <th><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							//$students   =   $this->db->get_where('mark' , array(
							//	'class_id' => $class_id , 'year' => $running_year
							//))->result_array();
							$subject_id =  $this->uri->segment('6');
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id"); 
							$students = $query->result_array();
							$count = 1; foreach($students as $row): 
						 ?>
                        <tr>
                            
                            <td><?php echo $count++;?></td>
                            
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?>
							</td>
							<td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
							<td>
                                <?php
                                    echo $row['mark_obtained'];
                                ?>
                            </td>  
							
							
							 <td>
                                <?php
                                     echo $row['mark_obtained1'];
                                ?>
                            </td> 
							
							 <td>
                                <?php
                                    echo $row['mark_obtained2'];
                                ?>
                            </td> 							 
							 <td>
                                <?php
									$total_obtained_mark = $row['mark_obtained1']+$row['mark_obtained2'];
									$obtained_workScore_total = ($total_obtained_mark/2);
                                    echo round($obtained_workScore_total);
                                ?>
                            </td> 
							  
							 <td>
                              <?php
								$marks = $row['mark_obtained'];
								$grade = '';
								if($marks >=1 && $marks<= 29){
										echo $grade = 'E';
									}else if($marks > 30 && $marks <= 34){
										echo $grade = 'D-';
									}else if($marks > 35 && $marks <=39){
										echo $grade = 'D';
									}else if($marks > 40 && $marks <=44){
										echo $grade = 'D+';
									}else if($marks > 45 && $marks <=49){
										echo $grade = 'C-';
									}else if($marks > 50 && $marks <= 54){
										echo $grade = 'C';
									}else if($marks > 55 && $marks <= 59){
										echo $grade = 'C+';
									}else if($marks > 60 && $marks <= 64){
										echo $grade = 'B-';
									}else if($marks > 65 && $marks <= 69){
										echo $grade = 'B';
									}else if($marks > 70 && $marks <= 74){
										echo $grade = 'B+';
									}else if($marks > 75 && $marks <= 79){
										echo $grade = 'A-';
									}else if($marks > 80 && $marks <= 100){
										echo $grade = 'A';
									}
							  ?> 
                            </td> 
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
					 
					 <?php }elseif ($parts == '3') { ?>
					 <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           
                            <th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>
							<th><div><?php echo get_phrase('M1');?></div></th>
							<th><div><?php echo get_phrase('M2');?></div></th>
							<th><div><?php echo get_phrase('M3');?></div></th>							
                            
                            <th><div><?php echo get_phrase('Total /100');?></div></th>
                            <th><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							//$students   =   $this->db->get_where('mark' , array(
							//	'class_id' => $class_id , 'year' => $running_year
							//))->result_array();
							$subject_id =  $this->uri->segment('6');
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id"); 
							$students = $query->result_array();
							$count = 1; foreach($students as $row): 
						 ?>
                        <tr>
                            
                            <td><?php echo $count++;?></td>
                            
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?>
							</td>
							<td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
							<td>
                                <?php
                                    echo $row['mark_obtained'];
                                ?>
                            </td>  
							
							
							 <td>
                                <?php
                                     echo $row['mark_obtained1'];
                                ?>
                            </td> 
							
							 <td>
                                <?php
                                    echo $row['mark_obtained2'];
                                ?>
                            </td> 
							 <td>
                                <?php
                                    echo $row['mark_obtained3'];
                                ?>
                            </td> 							  
							 <td>
                                <?php
								$total_obtained_mark = $row['mark_obtained1']+$row['mark_obtained2']+$row['mark_obtained3'];
									$obtained_workScore_total = ($total_obtained_mark/3);
                                    echo round($obtained_workScore_total);
                                ?>
                            </td> 
							 
							 <td>
                              <?php
								$marks = $row['mark_obtained'];
								$grade = '';
								if($marks >=1 && $marks<= 29){
										echo $grade = 'E';
									}else if($marks > 30 && $marks <= 34){
										echo $grade = 'D-';
									}else if($marks > 35 && $marks <=39){
										echo $grade = 'D';
									}else if($marks > 40 && $marks <=44){
										echo $grade = 'D+';
									}else if($marks > 45 && $marks <=49){
										echo $grade = 'C-';
									}else if($marks > 50 && $marks <= 54){
										echo $grade = 'C';
									}else if($marks > 55 && $marks <= 59){
										echo $grade = 'C+';
									}else if($marks > 60 && $marks <= 64){
										echo $grade = 'B-';
									}else if($marks > 65 && $marks <= 69){
										echo $grade = 'B';
									}else if($marks > 70 && $marks <= 74){
										echo $grade = 'B+';
									}else if($marks > 75 && $marks <= 79){
										echo $grade = 'A-';
									}else if($marks > 80 && $marks <= 100){
										echo $grade = 'A';
									}
							  ?> 
                            </td> 
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
					 
					 <?php }elseif ($parts == '4') { ?>
					    
						<table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           
                            <th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>
							<th><div><?php echo get_phrase('M1');?></div></th>
							<th><div><?php echo get_phrase('M2');?></div></th>
							<th><div><?php echo get_phrase('M3');?></div></th>
							<th><div><?php echo get_phrase('M4');?></div></th>
                            
                            <th><div><?php echo get_phrase('Total /100');?></div></th>
                            <th><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
							//$students   =   $this->db->get_where('mark' , array(
							//	'class_id' => $class_id , 'year' => $running_year
							//))->result_array();
							$subject_id =  $this->uri->segment('6');
							$query = $this->db->query("SELECT * FROM `mark` WHERE subject_id=$subject_id"); 
							$students = $query->result_array();
							$count = 1; foreach($students as $row): 
						 ?>
                        <tr>
                            
                            <td><?php echo $count++;?></td>
                            
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?>
							</td>
							<td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
							<td>
                                <?php
                                    echo $row['mark_obtained'];
                                ?>
                            </td>  
							
							
							 <td>
                                <?php
                                     echo $row['mark_obtained1'];
                                ?>
                            </td> 
							
							 <td>
                                <?php
                                    echo $row['mark_obtained2'];
                                ?>
                            </td> 
							 <td>
                                <?php
                                    echo $row['mark_obtained3'];
                                ?>
                            </td> 
							 <td>
                                <?php
                                    echo $row['mark_obtained4'];
                                ?>
                            </td> 
							 <td>
                                <?php
									$total_obtained_mark = $row['mark_obtained1']+$row['mark_obtained2']+$row['mark_obtained3']+$row['mark_obtained4'];
									$obtained_workScore_total = ($total_obtained_mark/4);
                                    echo round($obtained_workScore_total);
                                ?>
                            </td> 
							 <td>
                                <?php
                                    echo $row['mark_obtained'];
                                ?>
                            </td> 
							 <td>
                              <?php
								$marks = $row['mark_obtained'];
								$grade = '';
								if($marks >=1 && $marks<= 29){
										echo $grade = 'E';
									}else if($marks > 30 && $marks <= 34){
										echo $grade = 'D-';
									}else if($marks > 35 && $marks <=39){
										echo $grade = 'D';
									}else if($marks > 40 && $marks <=44){
										echo $grade = 'D+';
									}else if($marks > 45 && $marks <=49){
										echo $grade = 'C-';
									}else if($marks > 50 && $marks <= 54){
										echo $grade = 'C';
									}else if($marks > 55 && $marks <= 59){
										echo $grade = 'C+';
									}else if($marks > 60 && $marks <= 64){
										echo $grade = 'B-';
									}else if($marks > 65 && $marks <= 69){
										echo $grade = 'B';
									}else if($marks > 70 && $marks <= 74){
										echo $grade = 'B+';
									}else if($marks > 75 && $marks <= 79){
										echo $grade = 'A-';
									}else if($marks > 80 && $marks <= 100){
										echo $grade = 'A';
									}
							  ?> 
                            </td> 
							
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
					 
					 <?php }?>
                     					 
			         

                

            </div>
        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            
							<th width="80"><div>#</div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('M');?></div></th>
							<th><div><?php echo get_phrase('M1');?></div></th>
							<th><div><?php echo get_phrase('M2');?></div></th>
							<th><div><?php echo get_phrase('M3');?></div></th>
							<th><div><?php echo get_phrase('M4');?></div></th>
                            <th><div><?php echo get_phrase('Exam /90');?></div></th>
                            <th><div><?php echo get_phrase('Total /100');?></div></th>
                            <th><div><?php echo get_phrase('Grade');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $students   =   $this->db->get_where('enroll' , array(
                                    'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                                ))->result_array();
                               $count = 1; foreach($students as $row):?>
								
                        <tr>
                            
                            <td><?php echo $count++;?></td>
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?></td>
                            <td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
                            
      
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php endforeach;?>
        <?php endif;?>

        </div>




<script type="text/javascript">
    jQuery(document).ready(function($) {
	   $("#submit").attr('disabled', 'disabled');
	   
	 
    });
	function get_class_section(class_id) {
		 jQuery('#subject_holder').html("<option value=''>select section first</option>");
		if (class_id !== '') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_section/');?>' + class_id,
            success: function(response)
            {
                jQuery('#section_holder').html(response);
            }
        });         
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
	}
	
	function get_class_subject(section_id) {
		
		var class_id =  jQuery('#class_id').val();
		if (class_id !== '' && section_id !='') {
		$.ajax({
            url: '<?php echo site_url('admin/get_class_subject/');?>' + class_id + '/'+ section_id ,
            success: function(response)
            {
                jQuery('#subject_holder').html(response);
            }
        });
        $('#submit').removeAttr('disabled');
	  }
	  else{
	  	$('#submit').attr('disabled', 'disabled');
	  }
	}
	
	
</script>