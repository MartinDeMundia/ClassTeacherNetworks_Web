
<hr />  
<div class="row">
<div class="btn-group" style="float:right; margin:30px 5px 20px 0px; "  >
		<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		Print Option <span class="caret"></span>
		</button>
		<ul class="dropdown-menu dropdown-default pull-right" role="menu">
			<?php 
			$school_id = $this->session->userdata('school_id');
			$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
			$class_idp = ($classes[0]['class_id']);											
			?>
			<li>
			<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_stud_classlist_print/'.$class_idp);?>');">
			<i class="entypo-pencil"></i>
			<?php echo get_phrase('stream_list_student');?>
			</a>
		</li>										
		</ul>
 </div>

    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_students');?></span>
                </a>
            </li>

        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>                           
                            <!--<th width="80"><div><?php //echo get_phrase('photo');?></div></th>-->
							<th style="width: 32px !important;">#</th>       
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
							<th><div><?php echo get_phrase('parent');?></div></th>
							<!--<th><div><?php //echo get_phrase('stream');?></div></th>
                            <th><div><?php //echo get_phrase('options');?></div></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$count = 1;

                             /*   $students   =   $this->db->get_where('enroll' , array(
                                    'class_id' => $class_id , 'year' => $running_year
                                ))->result_array();*/

                        $students   = $this->db->query('SELECT * FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.class_id = "'.$class_id.'" AND e.year = "'.$running_year.'"   ')->result_array();

                        foreach($students as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>    
                           <!-- <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>-->
                            
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row['student_id']
                                ))->row()->student_code;?></td>
							<td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
							
							<td>
							<?php
								$query = $this->db->query("SELECT p.name FROM student s LEFT JOIN parent p ON s.parent_id = p.parent_id WHERE s.student_id =".$row['student_id']);
								$row1 = $query->result_array();
								echo $row1[0]['name'];
                            ?>
							</td>
							
							 <!--<td>
                                <?php
                                    echo $this->db->get_where('section' , array(
                                        'section_id' => $row['section_id']
                                    ))->row()->name;
                                ?>
                            </td> -->                           
                           <!-- <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        View <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                       

                                        <li>
                                            <a href="<?php echo site_url('admin/health_occurence/'.$row['student_id']);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('add_health_occurence');?>
                                                </a>
                                        </li>
                                         
                                    </ul>
                                </div>

                            </td> -->
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
       
        </div>


    </div>
</div>