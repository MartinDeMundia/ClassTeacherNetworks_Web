<?php 
$edit_data		=	$this->db->get_where('performance_grade' , array('performance_grade_id' => $param2) )->result_array();
foreach ( $edit_data as $row):
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<div class="panel-heading">
            	<div class="panel-title" >
            		<i class="entypo-plus-circled"></i>
					<?php echo get_phrase('edit_performance_grade');?>
            	</div>
            </div>
			<div class="panel-body">
				
                <?php echo form_open(site_url('admin/performance_grade/do_update/'.$row['performance_grade_id']) , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
            <div class="padded">
                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
                    <div class="col-sm-5 controls">
                        <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>" required/>
                    </div>
                </div>                
                <div class="form-group col-md-6">
                    <label class="col-sm-7 control-label"><?php echo get_phrase('mean_from');?></label>
                    <div class="col-sm-5 controls">
                        <input type="text" class="form-control" name="mean_from" value="<?php echo $row['mean_from'];?>" required/>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-sm-5 control-label"><?php echo get_phrase('mean_upto');?></label>
                    <div class="col-sm-5 controls">
                        <input type="text" class="form-control" name="mean_upto" value="<?php echo $row['mean_upto'];?>" required/>
                    </div>
                </div>
                
                  <div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info"><?php echo get_phrase('edit_performance_grade');?></button>
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



