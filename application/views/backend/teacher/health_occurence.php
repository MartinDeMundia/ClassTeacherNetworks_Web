<div class="row">
	<div class="col-md-8">
		<div class="panel panel-primary" data-collapsed="0">
        	<!--div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('');?>
            	</div>
            </div-->
			<div class="panel-body">

                <?php echo form_open(site_url('teacher/health_occurence_create/') , array('class' => 'form-horizontal form-groups-bordered validate', 'enctype' => 'multipart/form-data'));?>					
					
					<div class="form-group">
						<label class="col-sm-3 control-label"><?php echo get_phrase('student_name');?></label>
						<div class="col-sm-5">
							<?php 
							
							echo $this->crud_model->get_type_name_by_id('student',$student_id,'name');
							
							?>
						 	<input type='hidden' name='student_id' value='<?php echo $student_id;?>' />				
						</div>
                    </div>
                    
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('occurence');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="occurence" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('action_taken');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="action1" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" autofocus required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label"><?php echo get_phrase('further_action_need');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control" name="action2"  value="" autofocus required>
						</div>
					</div>
					 
                     <div class="form-group">
						<label for="field-2" class="col-sm-3 control-label"><?php echo get_phrase('date');?></label>

						<div class="col-sm-5">
							<input type="text" class="form-control datepicker" name="date" data-validate="required" data-message-required="<?php echo get_phrase('value_required');?>" value="" data-start-view="2">
						</div>
					</div>

                    <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('add_health_occurence');?></button>
						</div>
					</div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
</div>