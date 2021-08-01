<hr />
<div class="row">
	<div class="col-md-12">

			<ul class="nav nav-tabs bordered">
				<li class="<?php if($active_tab == 'invoices') echo 'active'; ?>">
					<a href="#unpaid" data-toggle="tab">
						<span class="hidden-xs"><?php echo get_phrase('invoices');?></span>
					</a>
				</li>				
			</ul>

			<div class="tab-content">
			<br>
				<div class="tab-pane <?php if($active_tab == 'invoices') echo 'active'; ?>" id="unpaid">


						<table class="table table-bordered datatable example">
                	<thead>
                		<tr>
                			<th>#</th>
                    		<th><div><?php echo get_phrase('student');?></div></th>
							<th><div><?php echo get_phrase('stream');?></div></th>
							<th><div><?php echo get_phrase('class');?></div></th>
							<th><div><?php echo get_phrase('Parent');?></div></th>
                    		<th><div><?php echo get_phrase('term_fee');?></div></th>
                            <th><div><?php echo get_phrase('fees');?></div></th>
                            <th><div><?php echo get_phrase('paid');?></div></th>
                            <th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('date');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                    	<?php
                    		$count = 1;
                    		$this->db->where('year' , $running_year);
                    		$this->db->order_by('creation_timestamp' , 'desc');
							
							$invoices = $this->db->get_where('invoice' , array('school_id' => $this->session->userdata('school_id')))->result_array(); 
                    	 
                    		foreach($invoices as $row):						
							$enroll = $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row();
							$parent = $this->db->get_where('student', array('student_id' => $row['student_id']))->row();
							$class_id = $enroll->class_id;
							$section_id = $enroll->section_id;
							$parent_id = $parent->parent_id;
                    	?>
                        <tr>
                        	<td><?php echo $count++;?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('student',$row['student_id']);?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('class',$class_id);?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('section',$section_id);?></td>
							<td><?php echo $this->crud_model->get_type_name_by_id('parent',$parent_id);?></td>
							<td><?php echo $row['title'];?></td>
							<td><?php echo $row['amount'];?></td>
                            <td><?php echo $row['amount_paid'];?></td>
                            <?php if($row['due'] == 0):?>
                            	<td>
                            		<button class="btn btn-success btn-xs"><?php echo get_phrase('paid');?></button>
                            	</td>                           
                            <?php else:?>
                            	<td>
                            		<button class="btn btn-danger btn-xs"><?php echo get_phrase('unpaid');?></button>
                            	</td>
                            <?php endif;?>
							<td><?php echo date('d M,Y', $row['creation_timestamp']);?></td>
							<td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <?php echo get_phrase('action');?> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                    <?php if ($row['due'] != 0):?>

                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_take_payment/'.$row['invoice_id']);?>');">
                                            <i class="entypo-bookmarks"></i>
                                                <?php echo get_phrase('take_payment');?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <?php endif;?>

                                    <!-- VIEWING LINK -->
                                    <li>
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_view_invoice/'.$row['invoice_id']);?>');">
                                            <i class="entypo-credit-card"></i>
                                                <?php echo get_phrase('view_invoice');?>
                                            </a>
                                                    </li>
                                    <li class="divider"></li>

                                    <!-- EDITING LINK -->
                                    <!--li>
                                        <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_edit_invoice/'.$row['invoice_id']);?>');">
                                            <i class="entypo-pencil"></i>
                                                <?php echo get_phrase('edit');?>
                                        </a>
                                    </li>
                                    <li class="divider"></li-->

                                    <!-- DELETION LINK -->
                                    <li>
                                        <a href="#" onclick="confirm_modal('<?php echo site_url('admin/invoice/delete/'.$row['invoice_id']);?>');">
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
				<div class="tab-pane" id="paid">

					<table class="table table-bordered datatable example">
					    <thead>
					        <tr>
					            <th><div>#</div></th>
					            <th><div><?php echo get_phrase('title');?></div></th>
					            <th><div><?php echo get_phrase('description');?></div></th>
					            <th><div><?php echo get_phrase('method');?></div></th>
					            <th><div><?php echo get_phrase('amount');?></div></th>
					            <th><div><?php echo get_phrase('date');?></div></th>
					            <th></th>
					        </tr>
					    </thead>
					    <tbody>
					        <?php
					        	$count = 1;
					        	$this->db->where('payment_type' , 'income');
					        	$this->db->order_by('timestamp' , 'desc');
					        	$payments = $this->db->get('payment')->result_array();
					        	foreach ($payments as $row):
					        ?>
					        <tr>
					            <td><?php echo $count++;?></td>
					            <td><?php echo $row['title'];?></td>
					            <td><?php echo $row['description'];?></td>
					            <td>
					            	<?php
					            		if ($row['method'] == 1)
					            			echo get_phrase('cash');
					            		if ($row['method'] == 2)
					            			echo get_phrase('check');
					            		if ($row['method'] == 3)
					            			echo get_phrase('card');
					                    if ($row['method'] == 'paypal')
					                    	echo 'paypal';
					            	?>
					            </td>
					            <td><?php echo $row['amount'];?></td>
					            <td><?php echo date('d M,Y', $row['timestamp']);?></td>
					            <td align="center">
					            	<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_view_invoice/'.$row['invoice_id']);?>');"
					            		class="btn btn-default">
					            			<?php echo get_phrase('view_invoice');?>
					            	</a>
					            </td>
					        </tr>
					        <?php endforeach;?>
					    </tbody>
					</table>

				</div>

				<div class="tab-pane <?php if($active_tab == 'student_specific_payment_history') echo 'active'; ?>" id="paid_student_specific">

					<br>
					<?php echo form_open(site_url('admin/income/student_specific_payment_history/filter_history'));?>
						<div class="row">

							<div class="col-md-offset-4 col-md-3">
								<div class="form-group">
									<select name="student_id" class="form-control selectboxit">
										<option value="all" <?php if($student_id == 'all') echo 'selected'; ?>>
											<?php echo get_phrase('all_students');?>
										</option>
										<?php
										$enrolls = $this->db->get_where('enroll', array('year' =>  $running_year))->result_array();
										print_r($enrolls);
										foreach($enrolls as $row) {
											$student_info = $this->db->get_where('student', array('student_id' =>  $row['student_id']))->row(); ?>
											<option value="<?php echo $row['student_id']; ?>" <?php if($student_id == $row['student_id']) echo 'selected'; ?>>
												<?php echo $student_info->name; ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<button type="submit" class="btn btn-info" style="margin-top: 5px;"><?php echo get_phrase('search');?></button>
							</div>

						</div>
					<?php echo form_close();?>

					<table class="table table-bordered datatable example">
					    <thead>
					        <tr>
					            <th><div>#</div></th>
					            <th><div><?php echo get_phrase('title');?></div></th>
					            <th><div><?php echo get_phrase('description');?></div></th>
					            <th><div><?php echo get_phrase('method');?></div></th>
					            <th><div><?php echo get_phrase('amount');?></div></th>
					            <th><div><?php echo get_phrase('date');?></div></th>
					            <th></th>
					        </tr>
					    </thead>
					    <tbody>
					        <?php
				        	$count = 1;
				        	if($student_id != 'all')
				        		$this->db->where('student_id', $student_id);
				        	$this->db->where('payment_type' , 'income');
				        	$this->db->order_by('timestamp' , 'desc');
				        	$payments = $this->db->get('payment')->result_array();
				        	foreach ($payments as $row): ?>
						        <tr>
						            <td><?php echo $count++;?></td>
						            <td><?php echo $row['title'];?></td>
						            <td><?php echo $row['description'];?></td>
						            <td>
						            	<?php
						            		if ($row['method'] == 1)
						            			echo get_phrase('cash');
						            		if ($row['method'] == 2)
						            			echo get_phrase('check');
						            		if ($row['method'] == 3)
						            			echo get_phrase('card');
						                    if ($row['method'] == 'paypal')
						                    	echo 'paypal';
						            	?>
						            </td>
						            <td><?php echo $row['amount'];?></td>
						            <td><?php echo date('d M,Y', $row['timestamp']);?></td>
						            <td align="center">
						            	<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_view_invoice/'.$row['invoice_id']);?>');"
						            		class="btn btn-default">
						            			<?php echo get_phrase('view_invoice');?>
						            	</a>
						            </td>
						        </tr>
					        <?php endforeach; ?>
					    </tbody>
					</table>

				</div>

			</div>


	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($)
	{


		var datatable = $(".example").dataTable({
			"sPaginationType": "bootstrap",

		});

		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
</script>
