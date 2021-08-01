<?php 
$edit_data		=	$this->db->get_where('class' , array('class_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_student');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/classes/do_update/'.$row['class_id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                        <div class="col-sm-5">
                            <input required type="text" class="form-control" name="name" value="<?php echo $row['name'];?>"/>
                        </div>
                    </div>
					                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo get_phrase('school');?></label>
                        <div class="col-sm-5">
                             <?php 
							$school_id = $this->session->userdata('school_id');
							
							echo $this->crud_model->get_type_name_by_id('school',$school_id,'school_name');
							
							?>
							
							<input type="hidden" name="school_id"  value="<?php echo $school_id;?>" />
                        </div>
                    </div>
            		<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('edit_class');?></button>
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


