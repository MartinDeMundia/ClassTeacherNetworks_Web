<hr />
<div class="row">
	<div class="col-md-12">
		<?php echo form_open(site_url('admin/score_sheet'));?>
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label"><?php echo get_phrase('class');?></label>
					<select name="class_id" class="form-control selectboxit" id = 'class_id' onchange="select_section(this.value)">
                        <option value=""><?php echo get_phrase('select_a_class');?></option>
                        <?php 
                        $classes = $this->db->get_where('class' , array('school_id' => $this->session->userdata('school_id')))->result_array();
                        foreach($classes as $row):
                        ?>
                            <option value="<?php echo $row['class_id'];?>"
                            	<?php if ($class_id == $row['class_id']) echo 'selected';?>>
                            		<?php echo $row['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>
			<div id="section_holder">
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('stream'); ?></label>
						<select class="form-control selectboxit" name="section_id" >
							<option value=""><?php echo get_phrase('select_class_first') ?></option>
							 <?php 
								$sections = $this->db->get_where('section' , array('class_id' => $class_id))->result_array();
								foreach($sections as $row):
								?>
									<option value="<?php echo $row['section_id'];?>"
										<?php if ($section_id == $row['section_id']) echo 'selected';?>>
											<?php echo $row['name'];?>
									</option>
								<?php
								endforeach;
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
				<label class="control-label"><?php echo get_phrase('exam');?></label>
					<select name="exam_id" class="form-control selectboxit" id = 'exam_id'>
                        <option value=""><?php echo get_phrase('select_an_exam');?></option>
                        <?php 
                        $exams = $this->db->get_where('exam' , array('year' => $running_year,'school_id' => $this->session->userdata('school_id')))->result_array();
                        foreach($exams as $row):
                        ?>
                            <option value="<?php echo $row['exam_id'];?>"
                            	<?php if ($exam_id == $row['exam_id']) echo 'selected';?>>
                            		<?php echo $row['name'];?>
                            </option>
                        <?php
                        endforeach;
                        ?>
                    </select>
				</div>
			</div>
			<input type="hidden" name="operation" value="selection">
			<div class="col-md-4" style="margin-top: 20px;">
				<button type="submit" id = 'submit' class="btn btn-info"><?php echo get_phrase('view');?></button>
			</div>
		<?php echo form_close();?>
	</div>
</div>

<?php if ($class_id != '' && $section_id != '' && $exam_id != ''):?>
<br>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4" style="text-align: center;">
		<div class="tile-stats tile-gray">
		<div class="icon"><i class="entypo-docs"></i></div>
			<h3 style="color: #696969;">
				<?php
					$exam_name  = $this->db->get_where('exam' , array('exam_id' => $exam_id))->row()->name; 
					$class_name = $this->db->get_where('class' , array('class_id' => $class_id))->row()->name; 
					$section_name = $this->db->get_where('section' , array('section_id' => $section_id))->row()->name;
					echo get_phrase('report_card');
				?>
			</h3>			
			<h4 style="color: #696969;">
				<?php echo get_phrase('class');?> : <?php echo $class_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('section');?> : <?php echo $section_name;?>
			</h4>
			<h4 style="color: #696969;">
				<?php echo get_phrase('Exam'); ?>: <?php echo $exam_name;?> 
			</h4>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>


<hr />

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
				<td style="text-align: center;">
					<?php echo get_phrase('students');?> <i class="entypo-down-thin"></i> | <?php echo get_phrase('subjects');?> <i class="entypo-right-thin"></i>
				</td>
				<?php 
					$subjects = $this->db->get_where('subject' , array('class_id' => $class_id ,'section_id' => $section_id , 'year' => $running_year))->result_array();
					foreach($subjects as $row):
				?>
					<td style="text-align: center;"><?php echo $row['name'];?><?php echo $row['offer_subject'];?></td>
				<?php endforeach;?>
				<td style="text-align: center;"><?php echo get_phrase('total');?></td>
				<td style="text-align: center;"><?php echo get_phrase('average_grade_point');?></td>
				</tr>
			</thead>
			<tbody>
			<?php
				
				$students = $this->db->get_where('enroll' , array('class_id' => $class_id , 'section_id' => $section_id ,'year' => $running_year))->result_array();
				foreach($students as $row):
			?>
				<tr>
					<td style="text-align: center;">
						<?php echo $this->db->get_where('student' , array('student_id' => $row['student_id']))->row()->name;?>
					</td>
				<?php
					$total_marks = 0;
					$total_grade_point = 0;  
					foreach($subjects as $row2):
				?>
					<td style="text-align: center;">
						<?php 
							$obtained_mark_query = 	$this->db->get_where('mark' , array(
													'class_id' => $class_id , 
														'exam_id' => $exam_id , 
															'subject_id' => $row2['subject_id'] , 
																'student_id' => $row['student_id'],
																	'year' => $running_year
												));
							if ( $obtained_mark_query->num_rows() > 0) {
								$obtained_marks = $obtained_mark_query->row()->mark_obtained;
								echo $obtained_marks;
								if ($obtained_marks >= 0 && $obtained_marks != '') {
									$grade = $this->crud_model->get_grade($obtained_marks);
									$total_grade_point += $grade['grade_point'];
								}
								$total_marks += $obtained_marks;
							}
							

						?>
					</td>
				<?php endforeach;?>
				<td style="text-align: center;"><?php echo $total_marks;?></td>
				<td style="text-align: center;">
					<?php 
						$this->db->where('class_id' , $class_id);
						$this->db->where('section_id' , $section_id);
						$this->db->where('year' , $running_year);
						$this->db->from('subject');
						$number_of_subjects = $this->db->count_all_results();
						echo ($total_grade_point / $number_of_subjects);
					?>
				</td>
				</tr>

			<?php endforeach;?>

			</tbody>
		</table>
		<!--center>
			<a href="<?php echo site_url('admin/tabulation_sheet_print_view/'.$class_id.'/'.$exam_id.'/'.$section_id);?>" 
				class="btn btn-primary" target="_blank">
				<?php echo get_phrase('print');?>
			</a>
		</center-->
	</div>
</div>
<?php endif;?>
<script type="text/javascript">
	var class_id = '';
	var section_id  = '';
	var exam_id  = '';
	jQuery(document).ready(function($) {
		<?php if($section_id > 0){?>
			$('#submit').removeAttr('disabled');
		<?php }else{?>
			$('#submit').attr('disabled', 'disabled');
		<?php } ?>
	});
	function check_validation(){
		var class_id = $('#class_id').val();
		var exam_id = $('#exam_id').val();
		if(class_id !== '' && exam_id !== ''){
			$('#submit').removeAttr('disabled');
		}
		else{
			$('#submit').attr('disabled', 'disabled');	
		}
	}
	$('#class_id').change(function() {
		
		check_validation();
	});
	
	$('#exam_id').change(function() {
				
		check_validation();
	});
</script>
<script type="text/javascript">
    function select_section(class_id) {

        $.ajax({
            url: '<?php echo site_url('admin/get_section/'); ?>' + class_id,
            success: function (response)
            {

                jQuery('#section_holder').html(response);
            }
        });
    }
</script>