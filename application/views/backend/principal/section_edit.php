<?php 
	$edit_data = $this->db->get_where('section' , array(
		'section_id' => $param2
	))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_class');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/sections/edit/'. $row['section_id']) , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						
						
						<div class="col-sm-5">
							<input type="text" class="form-control" name="nick_name" 
								value="<?php echo $row['nick_name'];?>" >
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('abbreviations');?></label>
                        <div class="col-sm-5">
							<input maxlength=2 type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
								value="<?php echo $row['name'];?>">
						</div>
						 
					</div>
					
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('total_seats');?></label>
                        <div class="col-sm-5">
                            <input required type="number" class="form-control" name="total_seats" value="<?php echo $row['total_seat'];?>"/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('couplings');?></label>
                        <div class="col-sm-5">
                            <input required type="number" class="form-control" name="divides" value="<?php echo $row['divides'];?>"/>
                        </div>
                    </div>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('columns');?></label>
                        <div class="col-sm-5">
                            <input required type="number" class="form-control" name="columns" value="<?php echo $row['columns'];?>"/>
                        </div>
                    </div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
                        
						<div class="col-sm-5"> 
							<select name="class_id" class="form-control" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$school_id = $this->session->userdata('school_id');
									$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
									foreach($classes as $row2):
										?>
                                		<option value="<?php echo $row2['class_id'];?>"
                                			<?php if ($row['class_id'] == $row2['class_id'])
                                				echo 'selected';?>>
													<?php echo $row2['name'];?>
                                        </option>
                                    <?php
									endforeach;
								?>
                          </select>
						</div> 
					</div>

					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('teacher');?></label>
                        
						<div class="col-sm-5">
							<select name="teacher_id" class="form-control" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$principals = $this->db->get_where('principal' , array('school_id' => $school_id))->result_array(); 
									$teachers = $this->db->get_where('teacher' , array('school_id' => $school_id))->result_array();
									foreach($principals as $prin):
										?>
                                		<option value="p-<?php echo $prin['principal_id'];?>"
                                			<?php if ($row['principal_id'] == $prin['principal_id'])
                                				echo 'selected';?>>
													<?php echo 'Principal-'.$prin['name'];?>
                                        </option>
                                    <?php
									endforeach;
									foreach($teachers as $row3):
										?>
                                		<option value="t-<?php echo $row3['teacher_id'];?>"
                                			<?php if ($row['teacher_id'] == $row3['teacher_id'])
                                				echo 'selected';?>>
													<?php echo $row3['name'];?>
                                        </option>
                                    <?php
									endforeach;
								?>
                          </select>
						</div> 
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('update');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>