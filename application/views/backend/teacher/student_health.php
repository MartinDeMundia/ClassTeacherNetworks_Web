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
						
			$subsectionids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('class_id', $class_id)->where('teacher_id', $user_id)->get('subject')->row()->sections;

			$query = $this->db->where_in('section_id', explode(',',$subsectionids))->get('section'); 

            
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <li>
                <a href="#<?php echo $row['section_id'];?>" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-user"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('class');?> <?php echo $row['name'];?> </span>
                </a>
            </li>
        <?php endforeach;?>
        <?php endif;?>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                           
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>				
							<th><div><?php echo get_phrase('class');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                               // $students   =   $this->db->get_where('enroll' , array(
                                 //   'class_id' => $class_id , 'year' => $running_year
                               // ))->result_array();


                                $students   = $this->db->query('SELECT e.* FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.class_id = "'.$class_id.'" AND e.year = "'.$running_year.'"')->result_array();
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
                                    echo $this->db->get_where('section' , array(
                                        'section_id' => $row['section_id']
                                    ))->row()->name;
                                ?>
                            </td>                            
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        View <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                       

                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="<?php echo site_url('teacher/health_occurence/'.$row['student_id']);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('add_health_occurence');?>
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
        <?php
            $user_id = $this->session->userdata('login_user_id');   
						
			$subsectionids = $this->db->select("GROUP_CONCAT(section_id) as sections")->where('class_id', $class_id)->where('teacher_id', $user_id)->get('subject')->row()->sections;

			$query = $this->db->where_in('section_id', explode(',',$subsectionids))->get('section'); 
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row):
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>                
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                //$students   =   $this->db->get_where('enroll' , array(
                                   // 'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                               // ))->result_array();
                                $students   = $this->db->query('SELECT e.* FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.section_id = "'.$row['section_id'].'" AND e.class_id = "'.$class_id.'" AND e.year = "'.$running_year.'"')->result_array();

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

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        View <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
  
                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="<?php echo site_url('teacher/health_occurence/'.$row['student_id']);?>">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('add_health_occurence');?>
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