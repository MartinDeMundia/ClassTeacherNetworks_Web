
				<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_teacher_list_print/');?>');" class="btn btn-primary pull-right">
				<i class="entypo-pencil"></i><?php echo get_phrase('teacher_print_list'); ?></a>
				
				<a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_teacher_add/');?>');" 
            	class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
            	<?php echo get_phrase('add_new_teacher');?>
                </a> 
                <br><br>
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('tsc_number');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
							<th><div><?php echo get_phrase('role');?></div></th>
							<th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $school_id = $this->session->userdata('school_id');
							$teachers = $this->db->get_where('teacher' , array('school_id' => $school_id))->result_array();
                            foreach($teachers as $row):?>
							
							
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('teacher',$row['teacher_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $row['tsc_number'];?></td>
                            <td><?php echo $row['name'];?></td>
							<td><?php echo $row['designation'];?></td>
							<td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        View <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
									
										 <!-- teacher EDITING LINK -->
                                        <li>
                                        	<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_teacher_edit/'.$row['teacher_id']);?>');">
                                            	<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit');?>
                                               	</a>
                                        				</li>
                                       
                                        
                                        <!-- teacher DELETION LINK -->
                                        <li>
                                        	<a href="#" onclick="confirm_modal('<?php echo site_url('principal/teacher/delete/'.$row['teacher_id']);?>');">
                                            	<i class="entypo-trash"></i>
													<?php echo get_phrase('delete');?>
                                               	</a>
                                        				</li> <li class="divider"></li>

										<li>
										<a href="<?php echo site_url('principal/teacher_profile/'.$row['teacher_id']);?>">
											<i class="entypo-docs"></i>
												<?php echo get_phrase('classes');?>
											</a> 

										</li> 
										<li>
										<a href="<?php echo site_url('principal/teacher_table/'.$row['teacher_id']);?>">
											<i class="entypo-target"></i>
												<?php echo get_phrase('timetable');?>
											</a> 

										</li> 
									</ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>

