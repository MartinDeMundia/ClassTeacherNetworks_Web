<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_new_class');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/sections/create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="nick_name" value="" >
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('abbreviations');?></label>
                        
						<div class="col-sm-5">
							
							
							<input maxlength=2 type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus>
						</div> 
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('total_seats');?></label>
						<div class="col-sm-5">
							<input type="number" class="form-control" name="total_seats" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
						</div>
					</div>  
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('couplings');?></label>
						<div class="col-sm-5">
							<input type="number" class="form-control" name="divides" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
						</div>
					</div>  
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('columns');?></label>
						<div class="col-sm-5">
							<input type="number" class="form-control" name="columns" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>"/>
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
									foreach($classes as $row):
										?>
                                		<option value="<?php echo $row['class_id'];?>">
												<?php echo $row['name'];?>
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
                                		<option value="p-<?php echo $prin['principal_id'];?>">
												Principal-<?php echo $prin['name'];?>
                                                </option>
                                    <?php
									endforeach;
									foreach($teachers as $row):
										?>
                                		<option value="t-<?php echo $row['teacher_id'];?>">
												<?php echo $row['name'];?>
                                                </option>
                                    <?php
									endforeach;
								?>
                          </select>
						</div> 
					</div>
                    
                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_class');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>