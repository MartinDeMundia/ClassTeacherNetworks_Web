
            <!--a href="javascript:;" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_parent_add/');?>');"
                class="btn btn-primary pull-right">
                <i class="entypo-plus-circled"></i>
                <?php echo get_phrase('add_new_parent');?>
                </a>
                <br><br-->
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th>#</th>                             
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('profession');?></div></th>
                            <th><div><?php echo get_phrase('Class');?></div></th>
                            <th><div><?php echo get_phrase('Admiss No');?></div></th>
                            <th><div><?php echo get_phrase('Student Name');?></div></th>
							<th><div><?php echo get_phrase('status');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;							
							
							$school_id = $this->session->userdata('school_id');      
							
							$parentsids = $this->db->select("GROUP_CONCAT(parent_id) as parents")->where_in('school_id',$school_id)->get('student')->row()->parents;
							
							if($parentsids!='')
							$parents = $this->db->where_in('parent_id', explode(',',$parentsids))->get('parent')->result_array();
							 							
							
                            foreach($parents as $row): ?>
                        <tr>
                            <td><?php echo $count++;?></td>                           
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['profession'];?></td>
                            <td>
							<?php 
							$query = $this->db->query("SELECT e.class_id FROM student s LEFT JOIN enroll e ON s.student_id = e.student_id WHERE s.parent_id =".$row['parent_id']);
								$row_class = $query->result_array();
								$class_id =  $row_class[0]['class_id'];
								$query_classname = $this->db->query("SELECT name FROM class WHERE class_id =".$class_id);
								$row_class_name = $query_classname->result_array();
								echo $row_class_name[0]['name'];
							?>
							</td>
                            <td>
							<?php $query = $this->db->query("SELECT s.student_code FROM student s LEFT JOIN parent p ON s.parent_id = p.parent_id WHERE p.parent_id =".$row['parent_id']);
								$row_code = $query->result_array();
								echo $row_code[0]['student_code'];
							?>
							</td>
                            <td>
							<?php 
							$query = $this->db->query("SELECT s.name FROM student s LEFT JOIN parent p ON s.parent_id = p.parent_id WHERE p.parent_id =".$row['parent_id']);
								$row = $query->result_array();
								echo $row[0]['name'];
							?>
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
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_parent_edit/'.$row['parent_id']);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                                        </li>
                                       <!-- <li class="divider"></li-->
                                        
                                        <li>
                                            <a href="#" onclick="confirm_modal('<?php echo site_url('admin/parent/delete/'.$row['parent_id']);?>');">
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
