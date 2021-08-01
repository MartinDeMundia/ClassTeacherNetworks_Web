            <a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_school_add/');?>');" 
            	class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
            	<?php echo get_phrase('add_new_school');?>
                </a> 
                <br><br>
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>                            
                            <th><div><?php echo get_phrase('school_name');?></div></th>
							<th><div><?php echo get_phrase('license_code');?></div></th>
							<th><div><?php echo get_phrase('activation_date');?></div></th>
							<th><div><?php echo get_phrase('payment_date');?></div></th>
							<th><div><?php echo get_phrase('amount');?></div></th>
							<th><div><?php echo get_phrase('payment_by');?></div></th>
							<th><div><?php echo get_phrase('payment_method');?></div></th>
							<th><div><?php echo get_phrase('expiry_date');?></div></th>
							<th><div><?php echo get_phrase('school_type');?></div></th>							
							<th><div><?php echo get_phrase('county');?></div></th>
							<th><div><?php echo get_phrase('status');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                                $schools =$this->db->get('school' )->result_array();
                                foreach($schools as $row):?>
                        <tr>
                            
                            <td><?php echo $row['school_name'];?></td>
							<td><?php echo $row['license_code'];?></td>
							<td><?php echo $row['activation_date'];?></td>
							<td><?php echo $row['payment_date'];?></td>
							<td><?php echo $row['amount'];?></td>
							<td><?php echo $row['paid_by'];?></td>
							<td><?php echo $row['payment_method'];?></td>
							<td><?php echo $row['expiry_date'];?></td>
							<td><?php echo ($row['school_type'] == 1)?"Primary":"Secondary";?></td>							
							<td><?php echo $row['county'];?></td>
							<td><?php echo ($row['status'] == 1)?"Active":"Suspend";?></td>                        
                            <td>
                                
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                        
                                        <!-- school EDITING LINK -->
                                        <li>
                                        	<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_school_edit/'.$row['school_id']);?>');">
                                            	<i class="entypo-pencil"></i>
													<?php echo get_phrase('edit');?>
                                               	</a>
                                        				</li>
                                       <!-- <li class="divider"></li>
                                        
                                         school DELETION LINK -->
                                        <li>
                                        	<a href="#" onclick="confirm_modal('<?php echo site_url('admin/school/delete/'.$row['school_id']);?>');">
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



