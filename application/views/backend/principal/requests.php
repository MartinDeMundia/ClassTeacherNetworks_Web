<hr />
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('profile_change_requests_list');?>
                    	</a></li>
			 
		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
        <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>							 
                    		<th><div><?php echo get_phrase('name');?></div></th>  			 
                    		<th><div><?php echo get_phrase('role');?></div></th>
							<th><div><?php echo get_phrase('email');?></div></th>
							<th><div><?php echo get_phrase('phone');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php $count = 1;
						 
						foreach($requests as $row):
							if($row['role_id'] == 1){ 
								$role='Parent'; 
								$data = $this->db->get_where('parent' , array('parent_id' => $row['user_id']))->row();
								
								$name = $data->name;
								$email = $data->email;
								$phone = $data->phone;
							}
							elseif($row['role_id'] == 2){ 
								$role='Teacher'; 
								$data = $this->db->get_where('teacher' , array('teacher_id' => $row['user_id']))->row();
								
								$name = $data->name;
								$email = $data->email;
								$phone = $data->phone;
							
							}
							elseif($row['role_id'] == 3){
								$role='Principal'; 
								$data = $this->db->get_where('principal' , array('principal_id' => $row['user_id']))->row();
								
								$name = $data->name;
								$email = $data->email;
								$phone = $data->phone;							
							}
						?>
                        <tr>
                            <td><?php echo $count++;?></td>							 	
							<td><?php echo $name;?></td>		
							<td><?php echo $role;?></td>	
							<td><?php echo $email;?></td>	
							<td><?php echo $phone;?></td>				
							 
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                    
                                    <!-- EDITING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_request/'.$row['id']);?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('view');?>
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
	</div>
</div>

