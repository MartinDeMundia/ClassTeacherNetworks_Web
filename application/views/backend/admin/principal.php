
            <a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_principal_add/');?>');" 
            	class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
            	<?php echo get_phrase('add_new_principal');?>
                </a> 
                <br><br>
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
							 <th><div><?php echo get_phrase('phone');?></div></th>
							 <th><div><?php echo get_phrase('school');?></div></th>
							 <th><div><?php echo get_phrase('school_type');?></div></th>							
							<th><div><?php echo get_phrase('county');?></div></th>
							  <th><div><?php echo get_phrase('status');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                $principals	=	$this->db->get('principal' )->result_array();
                                foreach($principals as $row):?>
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('principal',$row['principal_id']);?>" class="img-circle" width="30" />
                            </td>
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['email'];?></td>
							<td><?php echo $row['phone'];?></td>
							<td><?php echo $this->db->get_where('school' , array('school_id' => $row['school_id']))->row()->school_name;?>
							</td>
							<td><?php echo ($row['school_type'] == 1)?"Primary":"Secondary";?></td>							
							<td><?php echo $row['county'];?></td>
							<td><?php echo ($row['status'] == 1)?"Active":"Suspend";?></td>
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- principal EDITING LINK -->
                                        <li>
                                        	<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_principal_edit/'.$row['principal_id']);?>');">
                                            	<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit');?>
                                               	</a>
                                        				</li>
                                       <!-- <li class="divider"></li>
                                        
                                         principal DELETION LINK -->
                                        <li>
                                        	<a href="#" onclick="confirm_modal('<?php echo site_url('admin/principal/delete/'.$row['principal_id']);?>');">
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
