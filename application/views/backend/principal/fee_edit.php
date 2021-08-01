<?php 
	$edit_data = $this->db->get_where('invoice_content' , array(
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
					<?php echo get_phrase('edit_fee');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/fees/edit/'. $row['id']) , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>
	
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        
						<div class="col-sm-5">
							<input type="text" class="form-control" name="name" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" 
								value="<?php echo $row['name'];?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
                        
						<div class="col-sm-5">
							<input required type="number" class="form-control" name="amount" 
								value="<?php echo $row['amount'];?>" >
						</div> 
					</div>
					
					<div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('term');?></label>
                        
						<div class="col-sm-5"> 
							<select name="term_id" class="form-control" required>
                              <option value=""><?php echo get_phrase('select');?></option>
                              <?php 
									$school_id = $this->session->userdata('school_id');
									$terms = $this->db->get_where('terms' , array('school_id' => $school_id))->result_array();
									foreach($terms as $row2):
										$class_name = $this->db->get_where('class', array('class_id' => $row2['class_id']))->row()->name; 
										?>
                                		<option value="<?php echo $row2['id'];?>"
                                			<?php if ($row['invoice'] == $row2['id'])
                                				echo 'selected';?>>
													<?php echo $class_name." ".$row2['title'];?>
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