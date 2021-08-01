<hr />


<div class="row">
    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_students');?></span>
                </a>
            </li>
        <?php
            
			$user_id = $this->session->userdata('login_user_id');      
        		  
			$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('teacher_id', $user_id)->where('class_id', $class_id)->group_by("class_id")->get('subject')->row()->sections;
		
			if($sectionsids!='')
			$query = $this->db->where_in('section_id', explode(',',$sectionsids))->get('section');
			else
			$query = $this->db->get_where('section' , array('class_id' => $class_id));
		
		 
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <li>
                <a href="#<?php echo $row['section_id'];?>" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('class');?> <?php echo $row['name'];?> ( <?php echo $row['nick_name'];?> )</span>
                </a>
            </li>
        <?php endforeach;?>
        <?php endif;?>
        </ul>

        <div class="tab-content">
        <br>
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
							<th width="80"><div><?php echo get_phrase('admission_number');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>							
                            <th class="span3"><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						
							$user_id = $this->session->userdata('login_user_id');      
							 
							$classids = $this->db->select("GROUP_CONCAT(class_id) as classes")->where('teacher_id', $user_id)->group_by("class_id")->get('subject')->row()->classes;
													 
							if($classids !=''){							
								
								
								$sectionsids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('teacher_id', $user_id)->where_in('class_id', explode(',',$classids))->group_by("class_id")->get('subject')->row()->sections;
																
								$students = $this->db->where_in('section_id', explode(',',$sectionsids))->get('enroll')->result_array();
							}
							else {			
							
							//
							
								//$students   =   $this->db->get_where('enroll' , array(
                                   // 'class_id' => $class_id , 'year' => $running_year
                               // ))->result_array();
                                $students   = $this->db->query('SELECT e.* FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.class_id = "'.$class_id.'"')->result_array(); // AND e.year = "'.$running_year.'"
						
                            }   
                                foreach($students as $row):?>
                        <tr>
                           
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
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
                                    echo $this->db->get_where('class' , array('class_id' => $row['class_id']
                                    ))->row()->name;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $this->db->get_where('section' , array( 'section_id' => $row['section_id']
                                    ))->row()->name;
                                ?>
                            </td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <!--li>
                                            <a href="<?php echo site_url('teacher/student_marksheet/'.$row['student_id']);?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li-->


                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="<?php echo site_url('teacher/student_profile/'.$row['student_id']);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>

                                        <!-- STUDENT EDITING LINK -->
                                    </ul>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
        <?php
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
                    <thead>
                        <tr>                          
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
							<th width="80"><div><?php echo get_phrase('admission_number');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th class="span3"><div><?php echo get_phrase('stream');?></div></th>
                            <th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                               // $students   =   $this->db->get_where('enroll' , array(
                                  //  'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                               // ))->result_array();
                        $students   = $this->db->query('SELECT e.* FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE  e.section_id = "'.$row['section_id'].'" AND  e.class_id = "'.$class_id.'" ')->result_array();//AND e.year = "'.$running_year.'"


                                foreach($students as $row):?>
                        <tr>
                            
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row['student_id']);?>" class="img-circle" width="30" /></td>
							<td><?php echo $this->db->get_where('student',array('student_id'=>$row['student_id']))->row()->student_code;?></td>
                            <td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $this->db->get_where('class' , array('class_id' => $row['class_id']
                                    ))->row()->name;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $this->db->get_where('section' , array( 'section_id' => $row['section_id']
                                    ))->row()->name;
                                ?>
                            </td>
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_student_profile/'.$row['student_id']);?>');">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
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
        <?php endforeach;?>
        <?php endif;?>

        </div>


    </div>
</div>

