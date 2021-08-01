<hr />
 <div class="btn-group"  style="float: right;">
		<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
		Action <span class="caret"></span>
		</button>
		<ul class="dropdown-menu dropdown-default pull-right" role="menu">
		
		<li>
		<a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_class_elective_subject_add/'.$class_id);?>');">
		<i class="entypo-pencil"></i>
			<?php echo get_phrase('add_bulk_elective_subject');?>
		</a>
		</li>
		<!--<li>
		<a href="#" onclick="showAjaxModal('<?php //echo site_url('modal/popup/modal_class_elective_subject_edit/'.$class_id);?>');">
		<i class="entypo-pencil"></i>
			<?php //echo get_phrase('edit_bulk_elective_subject');?>
		</a>
		</li> -->
		</ul>
 </div>




<?php $school_id = $this->session->userdata('school_id');?>
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
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
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
                               /* $students   =   $this->db->get_where('enroll' , array(
                                    'class_id' => $class_id , 'year' => $running_year
                                ))->result_array();*/
                                $students   = $this->db->query('SELECT * FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.class_id = "'.$class_id.'" AND e.year = "'.$running_year.'"   ')->result_array();


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
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT PROFILE LINK 
                                        <li>
                                            <a href="<?php //echo site_url('admin/student_profile/'.$row['student_id']);?>">
                                                <i class="entypo-user"></i>
                                                    <?php //echo get_phrase('profile');?>
                                                </a>
                                        </li>-->

                                        <!-- STUDENT EDITING LINK -->
                                        <!--<li>
                                            <a href="#" onclick="showAjaxModal('<?php //echo site_url('modal/popup/modal_elective_subject_add/'.$row['student_id']);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php e//cho get_phrase('add_elective_subject');?>
                                                </a>
                                        </li> -->
										<li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_elective_subject_edit/'.$row['student_id']);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit_elective_subject');?>
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                        <!--<li>
                                          <a href="#" onclick="confirm_modal('<?php //echo site_url('admin/delete_student/'.$row['student_id'].'/'.$class_id);?>');">
                                            <i class="entypo-trash"></i>
                                              <?php //echo get_phrase('delete');?>
                                          </a>
                                        </li>-->
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
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>                
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                /*$students   =   $this->db->get_where('enroll' , array(
                                    'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                                ))->result_array();*/
                        $students   = $this->db->query('SELECT * FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.section_id ="'.$row['section_id'].'" AND e.class_id = "'.$class_id.'" AND e.year = "'.$running_year.'"   ')->result_array();

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
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT PROFILE LINK -->
                                         <!--<li>
                                            <a href="<?php echo site_url('admin/student_profile/'.$row['student_id']);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li> -->

                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_elective_subject_edit/'.$row['student_id']);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('update_elective_subject');?>                                              
                                                </a>
                                        </li>
                                        
                                        <li class="divider"></li>
                                       <!-- <li>
                                          <a href="#" onclick="confirm_modal('<?php echo site_url('admin/delete_student/'.$row['student_id'].'/'.$class_id);?>');">
                                            <i class="entypo-trash"></i>
                                              <?php echo get_phrase('delete');?>
                                          </a>
                                        </li> -->
										
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