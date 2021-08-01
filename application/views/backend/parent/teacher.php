
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
							 <th><div><?php echo get_phrase('subject');?></div></th>
                            <th><div><?php echo get_phrase('teacher_name');?></div></th>
							<th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
							foreach($subject as $row){
								
								if($row['teacher_id'] >0){
									$teacher_id = $row['teacher_id'];
									$list = $this->db->get_where('teacher', array('teacher_id' => $teacher_id))->row();
									$image = $this->crud_model->get_image_url('teacher',$teacher_id);
								}
								elseif($row['principal_id'] >0){
									$principal_id = $row['principal_id'];
									$list = $this->db->get_where('principal', array('principal_id' => $principal_id))->row();
									$image = $this->crud_model->get_image_url('principal',$principal_id);
								}                            
                            ?>
								<tr>
								<td><img src="<?php echo $image;?>" class="img-circle" width="30" /></td>
								<td><?php echo $row['name'];?></td>
								<td><?php echo $list->name;?></td>
								<td><?php echo $list->phone;?></td>
								<td><?php echo $list->email;?></td>
								
								</tr>
						<?php 
							
						    } 
						?>
                    </tbody>
                </table>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ----->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>

