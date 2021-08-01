<hr />
<div class="row">
	<div class="col-md-12">

    	<!---CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i>
					<?php echo get_phrase('subject_list');?>
                    	</a></li>
			<li>
            	<a href="#add" data-toggle="tab"><i class="entypo-plus-circled"></i>
					<?php echo get_phrase('add_subject');?>
                    	</a></li>						
		</ul>
    	<!---CONTROL TABS END------>
		<div class="tab-content">
        <br>
            <!---TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">

                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div><?php echo get_phrase('stream');?></div></th>
							<th><div><?php echo get_phrase('class');?></div></th>
                    		<th><div><?php echo get_phrase('subject_name');?></div></th>
                    		<th><div><?php echo get_phrase('teacher');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;
											foreach($subjects as $row):?>
                        <tr>
							<td><?php echo $this->crud_model->get_type_name_by_id('class',$row['class_id']);?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('section',$row['section_id']);?></td>
							<td><?php echo $row['name'];?></td>
							<td>
							<?php 
							  if($row['principal_id'] > 0) 
								echo 'Principal-'.$this->crud_model->get_type_name_by_id('principal',$row['principal_id']);
							  else
							  echo $this->crud_model->get_type_name_by_id('teacher',$row['teacher_id']);
							  ?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_subject/'.$row['subject_id']);?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/subject/delete/'.$row['subject_id'].'/'.$class_id);?>');">
                                            <i class="entypo-trash"></i>
                                                <?php echo get_phrase('delete');?>
                                            </a>
                                                    </li>
                                </ul>
                            </div>
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
            <!----TABLE LISTING ENDS--->


			<!----CREATION FORM STARTS---->
			<div class="tab-pane box" id="add" style="padding: 5px">
                <div class="box-content">
                	<?php echo form_open(site_url('admin/subject/create') , array('class' => 'form-horizontal form-groups-bordered validate','target'=>'_top'));?>
                        <div class="padded">
							
							                         						
							<div class="form-group">
							<label class="col-sm-3 control-label"><?php echo get_phrase('name');?></label>
								
                                <div class="col-sm-5">
								
									<select name="name" class="form-control" style="width:100%;" data-validate="required" >
										<option value=""><?php echo get_phrase('select_subject'); ?></option>
											<?php
											$school_id = $this->session->userdata('school_id');
											$class_subjects = $this->db->get_where('class_subjects' , array('school_id' => $school_id))->result_array();
											foreach($class_subjects as $sub):
											?>
												<option value="<?php echo $sub['id'];?>">
														<?php echo $sub['subject'];?>
												</option>
											<?php
											endforeach;
											?>
									</select>                                    
                                </div>
                            </div>			
							
							
							
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('stream');?></label>
                                <div class="col-sm-5">
                                    <select name="class_id" class="form-control" style="width:100%;" data-validate="required" onchange="return get_class_section(this.value)">
                                    <option value=""><?php echo get_phrase('select_class'); ?></option>
                                    	<?php
										$school_id = $this->session->userdata('school_id');
										$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
										foreach($classes as $row):
										?>
                                    		<option value="<?php echo $row['class_id'];?>"
                                                <?php if($row['class_id'] == $class_id) echo 'selected';?>>
                                                    <?php echo $row['name'];?>
                                            </option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>
							 <div id="section_selection_holder"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><?php echo get_phrase('teacher');?></label>
                                <div class="col-sm-5">
                                    <select data-validate="required" name="teacher_id" class="form-control" style="width:100%;">
                                        <option value=""><?php echo get_phrase('select_teacher');?></option>
                                    	<?php
										$principals = $this->db->get_where('principal' , array('school_id' => $school_id))->result_array(); 
										$teachers = $this->db->get_where('teacher' , array('school_id' => $school_id))->result_array();
										foreach($principals as $prin):
										?>
                                    		<option value="p-<?php echo $prin['principal_id'];?>">Principal-<?php echo $prin['name'];?></option>
                                        <?php
										endforeach;
										foreach($teachers as $row):
										?>
                                    		<option value="t-<?php echo $row['teacher_id'];?>"><?php echo $row['name'];?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                  <button type="submit" class="btn btn-info"><?php echo get_phrase('add_subject');?></button>
                              </div>
						   </div>
                    </form>
                </div>
			</div>
			
			
			</div>
			<!----CREATION FORM ENDS-->
			
			
			<!----Elective subject starts-->
			
			
			<!----Elective subject ends-->
			
			

		</div>
	</div>
</div>




	



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->
<script type="text/javascript">

	jQuery(document).ready(function($)
	{		
		get_class_section(<?php echo $class_id;?>);
	});
	
	jQuery(document).ready(function($)
	{		
		get_class_section_elective(<?php echo $class_id;?>);
	});

</script>

<script type="text/javascript"> 
 
function get_class_section(class_id) {
	jQuery.ajax({
		url: '<?php echo site_url('admin/get_class_section_selector/');?>' + class_id ,
		success: function(response)
		{  
			jQuery('#section_selection_holder').html(response);
		}
	});
}

function get_class_section_elective(class_id) {
	jQuery.ajax({
		url: '<?php echo site_url('admin/get_class_section_selector_elective/');?>' + class_id ,
		success: function(response)
		{  
			jQuery('#section_selection_holder_elective').html(response);
		}
	});
}

jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export_offer").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
	
	
</script>
