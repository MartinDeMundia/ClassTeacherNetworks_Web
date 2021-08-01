<?php 
$edit_data		=	$this->db->get_where('terms' , array('id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_term');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/terms/do_update/'.$row['id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('title');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="title" value="<?php echo $row['title'];?>"/>
                        </div>
                    </div>
					<!--div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('fees');?></label>
                        <div class="col-sm-5">
                            <input required type="number" class="form-control" name="fees" value="<?php echo $row['fees'];?>"/>
                        </div>
                    </div-->					 
					
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
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('update_term');?></button>
						</div>
					</div>
        		</form>
            </div>
        </div>
    </div>
</div>

<?php
endforeach;
?>


