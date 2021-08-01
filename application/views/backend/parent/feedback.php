<div class="row">
	<div class="col-md-12">

    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">

			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-user"></i>
					<?php echo get_phrase('feedback');?>
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
                        <?php echo form_open(site_url('parents/feedback/update_feedback') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top' ));?>
                            <div class="form-group">
                                <!--label class="col-sm-3 control-label"><?php echo get_phrase('feedback');?></label-->
                                <div class="col-sm-5">
								  <textarea class="form-control" rows="5" style="width: 1000px;" name="feedback"><?php echo $row['feedback'];?></textarea>
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