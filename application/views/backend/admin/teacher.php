
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
                            <th><div><?php echo get_phrase('email');?></div></th>
							<th><div><?php echo get_phrase('phone');?></div></th>
							<th><div><?php echo get_phrase('school');?></div></th>                            
							<th><div><?php echo get_phrase('status');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                $teachers	=	$this->db->order_by('school_id')->get('teacher' )->result_array();
                                foreach($teachers as $row):?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('teacher',$row['teacher_id']);?>" class="img-circle" width="30" />
                            </td>
							<td><?php echo $row['tsc_number'];?></td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['email'];?></td>
							<td><?php echo $row['phone'];?></td>
							<td><?php echo $this->db->get_where('school' , array('school_id' => $row['school_id']))->row()->school_name;?>
							</td>
							<td><?php echo ($row['status'] == 1)?"Active":"Suspend";?></td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- teacher EDITING LINK -->
                                        <li>
                                        	<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_teacher_edit/'.$row['teacher_id']);?>');">
                                            	<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit');?>
                                               	</a>
                                        				</li>
                                        <!--<li class="divider"></li>
                                        
                                         teacher DELETION LINK -->
                                        <li>
                                        	<a href="#" onclick="confirm_modal('<?php echo site_url('admin/teacher/delete/'.$row['teacher_id']);?>');">
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


