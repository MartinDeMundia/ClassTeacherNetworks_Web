<?php 
$school_id = $this->session->userdata('school_id');
$edit_data		=	$this->db->get_where('enroll' , array('year' => $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description
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
					<?php echo get_phrase('bulk_elective_subject');?>
            	</div>
            </div>
			
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/manage_elective_subject_class_edit/update/'.$row['class_id'])  , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
              
					<div class="form-group">
					
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_2');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data1 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						foreach ($edit_data1 as $row)					
						{
							$all_subs = $row['group2_elective'];
							$subsArr = explode(",",$all_subs);
							foreach ($subsArr as $subs){
							$checkedStatus = "";
							if(in_array($subs,$subsArr)) { $checkedStatus ="checked"; }
							echo "<input type='checkbox' ".$checkedStatus." value='".$subs."'/>".$subs.""; 
							}
						} 
						?>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_3');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data2 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						
						foreach ($edit_data2 as $row)						
						{
							$all_subs = $row['group3_elective'];
							$subsArr = explode(",",$all_subs);
							foreach ($subsArr as $subs){
							$checkedStatus = "";
							if(in_array($subs,$subsArr)) { $checkedStatus ="checked"; }
							echo "<input type='checkbox' ".$checkedStatus." value='".$subs."'/>".$subs.""; 
							}
						
						}
						?>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_4');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data3 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						
						foreach ($edit_data3 as $row)						
						{
							$all_subs = $row['group4_elective'];
							$subsArr = explode(",",$all_subs);
							foreach ($subsArr as $subs){
							$checkedStatus = "";
							if(in_array($subs,$subsArr)) { $checkedStatus ="checked"; }
							echo "<input type='checkbox' ".$checkedStatus." value='".$subs."'/>".$subs.""; 
							}
						}
						 ?>
						</div>
					</div> 
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_5');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data4 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						
						foreach ($edit_data4 as $row)						
						{
							$all_subs = $row['group5_elective'];
							$subsArr = explode(",",$all_subs);
							foreach ($subsArr as $subs){
							$checkedStatus = "";
							if(in_array($subs,$subsArr)) { $checkedStatus ="checked"; }
							echo "<input type='checkbox' ".$checkedStatus." value='".$subs."'/>".$subs.""; 
							}
						} 
						?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_6');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data5 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						
						foreach ($edit_data5 as $row)						
						{
							$all_subs = $row['group6_elective'];
							$subsArr = explode(",",$all_subs);
							foreach ($subsArr as $subs){
							$checkedStatus = "";
							if(in_array($subs,$subsArr)) { $checkedStatus ="checked"; }
							echo "<input type='checkbox' ".$checkedStatus." value='".$subs."'/>".$subs.""; 
							}
						} 
						?>
						</div>
					</div>
				    <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_7');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data6 = $this->db->get_where('elective_subjects' , array('student_id' => $row['student_id']))->result_array();
						
						foreach ($edit_data6 as $row)						
						{
							$all_subs = $row['group7_elective'];
							$subsArr = explode(",",$all_subs);
							foreach ($subsArr as $subs){
							$checkedStatus = "";
							if(in_array($subs,$subsArr)) { $checkedStatus ="checked"; }
							echo "<input type='checkbox' ".$checkedStatus." value='".$subs."'/>".$subs.""; 
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

