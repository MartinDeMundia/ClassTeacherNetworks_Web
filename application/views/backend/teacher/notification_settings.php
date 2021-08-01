<div class="row">
	<div class="col-md-12">

    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-user"></i>
					<?php echo get_phrase('notification_setting');?>
                    	</a></li>
		</ul>
    	<!------CONTROL TABS END------>


		<div class="tab-content">
        	<!----EDITING FORM STARTS---->
			<div class="tab-pane box active" id="list" style="padding: 5px">
                <div class="box-content">
					<?php
                    foreach($edit_data as $row):
                        ?>
                        <?php echo form_open(site_url('teacher/manage_notification/update_notification') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' ));?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('sound');?></label>
                                <div class="col-sm-5">
                                   <select name="sound" id="sound" data-validate="required"  class="form-control " >								
								   <option value="1" <?php echo ($row['sound'] == 1)?"selected":"";?>>On</option>
								   <option value="0" <?php echo ($row['sound'] == 0)?"selected":"";?>>Off</option>
								   </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('vibrate');?></label>
                                <div class="col-sm-5">
                                   <select name="vibrate" id="vibrate" class="form-control" >																
								   <option value="1" <?php echo ($row['vibrate'] == 1)?"selected":"";?>>On</option>
								   <option value="0" <?php echo ($row['vibrate'] == 0)?"selected":"";?>>Off</option>
								   </select>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('dnd');?></label>
								<div class="col-sm-5">
                                 <select name="dnd" id="dnd" class="form-control" >																	
								   <option value="1" <?php echo ($row['dnd'] == 1)?"selected":"";?>>Allow</option>
								   <option value="0" <?php echo ($row['dnd'] == 0)?"selected":"";?>>Not allow</option>
								   </select>
								  </div>
                            </div>
                             
                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('update');?></button>
                              </div>
								</div>
                        </form>
						<?php
                    endforeach;
                    ?>
                </div>
			</div>
            <!----EDITING FORM ENDS-->

		</div>
	</div>
</div>