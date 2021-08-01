<hr />
<a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/fee_add/');?>');" 
	class="btn btn-primary pull-right">
    	<i class="entypo-plus-circled"></i>
			<?php echo get_phrase('add_new_fee');?>
</a> 
<br><br><br>

<div class="row">
	<div class="col-md-12">
	
		<div class="tabs-vertical-env">
		
			<ul class="nav tabs-vertical">
			<?php 
				$terms = $this->db->get_where('terms' , array('school_id' => $row['school_id']))->result_array();
				foreach ($terms as $row):
				$class_name = $this->db->get_where('class', array('class_id' => $row['class_id']))->row()->name; 
			?>
				<li class="<?php if ($row['id'] == $term_id) echo 'active';?>">
					<a href="<?php echo site_url('admin/fee/'.$row['id']);?>">
						<i class="entypo-dot"></i>
						<?php echo $class_name;?> <?php echo $row['title'];?>
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
								<th><?php echo get_phrase('fee');?></th>
								<th><?php echo get_phrase('amount');?></th>								 
								<th><?php echo get_phrase('options');?></th>
							</tr>
						</thead>
						<tbody>

						<?php
							$count    = 1;
							$fees = $this->db->get_where('invoice_content' , array(
								'invoice' => $term_id
							))->result_array();
							foreach ($fees as $row):
						?>
							<tr>
								<td><?php echo $count++;?></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $row['amount'];?></td>
								 
								<td>
									<div class="btn-group">
		                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		                                    Action <span class="caret"></span>
		                                </button>
		                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">
		                                    
		                                    <!-- EDITING LINK -->
		                                    <li>
		                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/fee_edit/'.$row['id']);?>');">
		                                            <i class="entypo-pencil"></i>
		                                                <?php echo get_phrase('edit');?>
		                                            </a>
		                                                    </li>
		                                    <li class="divider"></li>
		                                    
		                                    <!-- DELETION LINK -->
		                                    <li>
		                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/fees/delete/'.$row['id']);?>');">
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