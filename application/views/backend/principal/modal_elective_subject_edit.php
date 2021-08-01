<?php 
$school_id = $this->session->userdata('school_id');
$edit_data		=	$this->db->get_where('enroll' , array(
	'student_id' => $param2 , 'year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
))->result_array();
foreach ($edit_data as $row):
$school_id = $this->session->userdata('school_id');
?>


<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('elective_subject');?>
            	</div>
            </div>
			
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/manage_elective_subject_student_edit/update/'.$row['student_id'].'/'.$row['class_id'].'/'.$row['section_id'])  , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
              
					<div class="form-group">
					
						<label for="field-1" class="col-sm-3 control-label" style="padding-top:0px !important;"><?php echo get_phrase('group_2');?></label>
                        
						<div class="col-sm-5">
						<?php 
						$class_subject = $this->db->get_where('class_subjects' , array('school_id' => $school_id,'is_elective' =>1,'subject_group' =>'g2'))->result_array();
						$subject_get = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						
						foreach ($subject_get as $row)					
						{
							$all_subs = $row['group2_elective'];
							$subsArr = explode(",",$all_subs);
						}
						foreach($class_subject as $subject_list)
						{
						     $checkedStatus = "";
						    if(in_array($subject_list['subject'],$subsArr)) { $checkedStatus ="checked"; }
						    echo "&nbsp;&nbsp;<input type='checkbox' ".$checkedStatus." name='group2_elective[]' value='".$subject_list['subject']."'/>&nbsp;&nbsp;".$subject_list['subject'].""; 
						}
						?>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="padding-top:0px !important;"><?php echo get_phrase('group_3');?></label>
                        
						<div class="col-sm-5">
						<?php 
						$class_subject_3 = $this->db->get_where('class_subjects' , array('school_id' => $school_id,'is_elective' =>1,'subject_group' =>'g3'))->result_array();
						//print_r($class_subject_3);
						$subject_get_3 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						if(count($class_subject_3) == 0)
						{
						        echo 'N/A';
						}else
						{
    						foreach ($subject_get_3 as $row)					
    						{
    							$all_subs = $row['group3_elective'];
    							$subsArr = explode(",",$all_subs);
    						}
    						foreach($class_subject_3 as $subject_list)
    						{
    						    $checkedStatus = "";
    						    if(in_array($subject_list['subject'],$subsArr)) { $checkedStatus ="checked"; }
    						    echo "&nbsp;&nbsp;<input type='checkbox' ".$checkedStatus." name='group3_elective[]' value='".$subject_list['subject']."'/>&nbsp;&nbsp;".$subject_list['subject'].""; 
    						}
						}
						?>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="padding-top:0px !important;"><?php echo get_phrase('group_4');?></label>
                        
						<div class="col-sm-5">
						<?php 
						$class_subject_4 = $this->db->get_where('class_subjects' , array('school_id' => $school_id,'is_elective' =>1,'subject_group' =>'g4'))->result_array();
						$subject_get_4 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						if(count($class_subject_4) == 0)
						{
						        echo 'N/A';
						}else
						{
    						foreach ($subject_get_4 as $row)					
    						{
    							$all_subs = $row['group4_elective'];
    							$subsArr = explode(",",$all_subs);
    						}
    						foreach($class_subject_4 as $subject_list)
    						{
    						    $checkedStatus = "";
    						    if(in_array($subject_list['subject'],$subsArr)) { $checkedStatus ="checked"; }
    						    echo "&nbsp;&nbsp;<input type='checkbox' ".$checkedStatus." name='group4_elective[]' value='".$subject_list['subject']."'/>&nbsp;&nbsp;".$subject_list['subject'].""; 
    						}
						}
						 ?>
						</div>
					</div> 
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="padding-top:0px !important;"><?php echo get_phrase('group_5');?></label>
                        
						<div class="col-sm-5">
						<?php 
						$class_subject_5 = $this->db->get_where('class_subjects' , array('school_id' => $school_id,'is_elective' =>1,'subject_group' =>'g5'))->result_array();
						$subject_get_5 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						if(count($class_subject_5) == 0)
						{
						        echo 'N/A';
						}else
						{
    						foreach ($subject_get_5 as $row)					
    						{
    							$all_subs = $row['group5_elective'];
    							$subsArr = explode(",",$all_subs);
    						}
    						foreach($class_subject_5 as $subject_list)
    						{
    						    $checkedStatus = "";
    						    if(in_array($subject_list['subject'],$subsArr)) { $checkedStatus ="checked"; }
    						    echo "&nbsp;&nbsp;<input type='checkbox' ".$checkedStatus." name='group5_elective[]' value='".$subject_list['subject']."'/>&nbsp;&nbsp;".$subject_list['subject'].""; 
    						}
						}
						?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="padding-top:0px !important;"><?php echo get_phrase('group_6');?></label>
                        
						<div class="col-sm-5">
						<?php 
						$class_subject_6 = $this->db->get_where('class_subjects' , array('school_id' => $school_id,'is_elective' =>1,'subject_group' =>'g6'))->result_array();
						$subject_get_6 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						if(count($class_subject_6) == 0)
						{
						        echo 'N/A';
						}else
						{
    						foreach ($subject_get_6 as $row)					
    						{
    							$all_subs = $row['group6_elective'];
    							$subsArr = explode(",",$all_subs);
    						}
    						foreach($class_subject_6 as $subject_list)
    						{
    						    $checkedStatus = "";
    						    if(in_array($subject_list['subject'],$subsArr)) { $checkedStatus ="checked"; }
    						    echo "&nbsp;&nbsp;<input type='checkbox' ".$checkedStatus." name='group6_elective[]' value='".$subject_list['subject']."'/>&nbsp;&nbsp;".$subject_list['subject'].""; 
    						}
						}
						?>
						</div>
					</div>
				    <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" style="padding-top:0px !important;"><?php echo get_phrase('group_7');?></label>
                        
						<div class="col-sm-5">
						<?php 
                         $class_subject_7 = $this->db->get_where('class_subjects' , array('school_id' => $school_id,'is_elective' =>1,'subject_group' =>'g7'))->result_array();
						$subject_get_7 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						if(count($class_subject_7) == 0)
						{
						        echo 'N/A';
						}else
						{
    						foreach ($subject_get_7 as $row)					
    						{
    							$all_subs = $row['group7_elective'];
    							$subsArr = explode(",",$all_subs);
    						}
    						foreach($class_subject_7 as $subject_list)
    						{
    						    $checkedStatus = "";
    						    if(in_array($subject_list['subject'],$subsArr)) { $checkedStatus ="checked"; }
    						    echo "&nbsp;&nbsp;<input type='checkbox' ".$checkedStatus." name='group7_elective[]' value='".$subject_list['subject']."'/>&nbsp;&nbsp;".$subject_list['subject'].""; 
    						}
						}
						?>
						</div>
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('save_elective_subject');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>