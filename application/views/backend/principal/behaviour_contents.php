<hr />
<a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/behaviour_content_add/');?>');" 
	class="btn btn-primary pull-right">
    	<i class="entypo-plus-circled"></i>
			<?php echo get_phrase('add_new_behaviour_content');?>
</a> 
<br><br><br>

<div class="row">
	<div class="col-md-12">
	
		<div class="tabs-vertical-env">
		
			<ul class="nav tabs-vertical">
			<?php 
				$behaviours = $this->db->get_where('behaviours' , array('school_id' => $school_id))->result_array();
				foreach ($behaviours as $row):
				 
			?>
				<li class="<?php if ($row['id'] == $behaviour_id) echo 'active';?>">
					<a href="<?php echo site_url('admin/behaviour_content/'.$row['id']);?>">
						<i class="entypo-dot"></i>
						<?php echo $row['behaviour_title'];?>
					</a>
				</li>
			<?php endforeach;?>
			</ul>
			
			<div class="tab-content">

				<div class="tab-pane active">
					<table class="table table-bordered responsive">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo get_phrase('title');?></th>
								<th><?php echo get_phrase('actions');?></th>	
								<th><?php echo get_phrase('options');?></th>
							</tr>
						</thead>
						<tbody>

						<?php
							$count    = 1;
							$contents = $this->db->get_where('behaviour_content' , array(
								'behaviour' => $behaviour_id
							))->result_array();
							foreach ($contents as $row):
						?>
							<tr>
								<td><?php echo $count++;?></td>
								<td><?php echo $row['content_name'];?></td>
								<td><?php echo $row['actions'];?></td>
								 
								<td>
									<div class="btn-group">
		                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		                                    Action <span class="caret"></span>
		                                </button>
		                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
		                                    
		                                    <!-- EDITING LINK -->
		                                    <li>
		                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/behaviour_content_edit/'.$row['id']);?>');">
		                                            <i class="entypo-pencil"></i>
		                                                <?php echo get_phrase('edit');?>
		                                            </a>
		                                                    </li>
		                                    <li class="divider"></li>
		                                    
		                                    <!-- DELETION LINK -->
		                                    <li>
		                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/behaviour_contents/delete/'.$row['id']);?>');">
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

			</div>
			
		</div>	
	
	</div>
</div>