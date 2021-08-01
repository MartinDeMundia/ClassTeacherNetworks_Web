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
				<?php $class_id = $this->uri->segment(4); ?>
                <?php echo form_open(site_url('admin/manage_elective_subject_class/create/'.$class_id)  , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
              
					<div class="form-group">
					
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_2');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data1 = $this->db->get_where('class_subjects' , array('subject_group' => 'g2'))->result_array();
						
						foreach ($edit_data1 as $row)						
						{
						echo $row['subject'];?>	
						:<input type="checkbox" name="group2_elective[]" value="<?php echo $row['subject'];?>" /><br />
						
						
						<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_3');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data2 = $this->db->get_where('class_subjects' , array('subject_group' => 'g3'))->result_array();
						
						foreach ($edit_data2 as $row)						
						{
						echo $row['subject'];?>	
						:<input type="checkbox" name="group3_elective[]" value="<?php echo $row['subject'];?>"  /><br />
						
						
						<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_4');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data3 = $this->db->get_where('class_subjects' , array('subject_group' => 'g4'))->result_array();
						
						foreach ($edit_data3 as $row)						
						{
						echo $row['subject'];?>	
						:<input type="checkbox" name="group4_elective[]" value="<?php echo $row['subject'];?>"  /><br />
						
						
						<?php } ?>
						</div>
					</div> 
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_5');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data4 = $this->db->get_where('class_subjects' , array('subject_group' => 'g5'))->result_array();
						
						foreach ($edit_data4 as $row)						
						{
						echo $row['subject'];?>	
						:<input type="checkbox" name="group5_elective[]" value="<?php echo $row['subject'];?>"  /><br />
						
						
						<?php } ?>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_6');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data5 = $this->db->get_where('class_subjects' , array('subject_group' => 'g6'))->result_array();
						
						foreach ($edit_data5 as $row)						
						{
						echo $row['subject'];?>	
						:<input type="checkbox" name="group6_elective[]" value="<?php echo $row['subject'];?>"  /><br />
						
						
						<?php } ?>
						</div>
					</div>
				    <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('group_7');?></label>
                        
						<div class="col-sm-5">
						<?php $edit_data6 = $this->db->get_where('class_subjects' , array('subject_group' => 'g7'))->result_array();
						
						foreach ($edit_data6 as $row)						
						{
						echo $row['subject'];?>	
						:<input type="checkbox" name="group7_elective[]" value="<?php echo $row['subject'];?>"  /><br />
						
						
						<?php } ?>
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


