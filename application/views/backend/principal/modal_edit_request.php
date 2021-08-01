<?php 
$edit_data		=	$this->db->get_where('change_request' , array('id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('profile_change_request');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/requests/do_update/'.$row['id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    
					<?php if($row['name'] !='') {?>
						<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
							<div class="col-sm-5">
								<input readonly required type="text" class="form-control" name="name" value="<?php echo $row['name'];?>"/>
							</div>
						</div>		
					<?php } ?>
					
					
					<?php if($row['email'] !='') {?>
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                        <div class="col-sm-5">
                            <input readonly required type="text" class="form-control" name="email" value="<?php echo $row['email'];?>"/>
                        </div>
                    </div>	
					
					<?php } ?>
					
					<?php if($row['phone'] !='') {?>
					
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('phone');?></label>
                        <div class="col-sm-5">
                            <input readonly required type="text" class="form-control" name="phone" value="<?php echo $row['phone'];?>"/>
                        </div>
                    </div>	
					
					<?php } ?>
					
					<?php if($row['image'] !='') {?>
					
					<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('Photo');?></label>
                        <div class="col-sm-5">
                            <img src="http://shamlatech.net/school/<?php echo $row['image'];?>" width="100px"/>
                        </div>
                    </div>	
					
					<?php } ?>
					
            		<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('approve');?></button>
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


