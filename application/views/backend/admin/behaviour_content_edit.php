<?php 
	$edit_data = $this->db->get_where('behaviour_content' , array(
		'id' => $param2
	))->result_array();
	foreach ($edit_data as $row):
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_behaviour_content');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/behaviour_contents/edit/'. $row['id']) , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="title" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
								value="<?php echo $row['content_name'];?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('actions');?></label>
                        
						<div class="col-sm-5">
							<input required type="text" class="form-control" name="actions" 
								value="<?php echo $row['actions'];?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('behaviours');?></label>
                        
						<div class="col-sm-5"> 
							<select name="behaviour_id" class="form-control" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									//$school_id = $this->session->userdata('school_id');
									$behaviours = $this->db->get_where('behaviours')->result_array();
									foreach($behaviours as $row2):
										 
										?>
                                		<option value="<?php echo $row2['id'];?>"
                                			<?php if ($row['behaviour'] == $row2['id'])
                                				echo 'selected';?>>
													<?php echo $row2['behaviour_title'];?>
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