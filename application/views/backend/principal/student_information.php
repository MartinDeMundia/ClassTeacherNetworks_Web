<hr />
<a href="<?php echo site_url('admin/student_add');?>"
    class="btn btn-primary pull-right">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('add_new_student');?>
    </a>
<br>

<div class="btn-group" style="float:right; margin:30px -115px 20px 0px; "  >
                                   <!-- <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Print Option <span class="caret"></span>
                                    </button>-->
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">
										<?php 
										  $school_id = $this->session->userdata('school_id');
										 
											$classes = $this->db->get_where('class' , array('school_id' => $school_id))->result_array();
											$class_idp = ($classes[0]['class_id']);											
											?>
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_stud_info_print/'.$class_idp);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('print student');?>
                                                </a>
                                        </li>

                                        <li class="divider"></li>
                                        <li>
                                          <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_stud_parent_print/'.$class_id);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('print with parents');?>
                                                </a>
                                        </li>
										
                                    </ul>
 </div>

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
							<!--<th><div><?php //echo get_phrase('parent');?></div></th>-->
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                                /*$students   =   $this->db->get_where('enroll' , array(
                                    'class_id' => $class_id , 'year' => $running_year
                                ))->result_array();*/
								
								//var_dump('SELECT e.* FROM enroll e JOIN student s ON s.student_id = e.student_id  WHERE e.class_id = "'.$class_id.'" AND e.year = "'.$running_year.'"'); exit();
								
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
							<!--<td>
							<?php
								//$query = $this->db->query("SELECT p.name FROM student s LEFT JOIN parent p ON s.parent_id = p.parent_id WHERE s.student_id =".$row['student_id']);
								//$row1 = $query->result_array();
								//echo $row1[0]['name'];
                            ?>
							</td>-->							
                            <td>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Action <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                        <!-- STUDENT MARKSHEET LINK  -->
                                        <!--li>
                                            <a href="<?php echo site_url('admin/student_marksheet/'.$row['student_id']);?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li-->


                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="<?php echo site_url('admin/student_profile/'.$row['student_id']);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>

                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_student_edit/'.$row['student_id']);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
                                        <!--li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/student_id/'.$row['student_id']);?>');">
                                                <i class="entypo-vcard"></i>
                                                <?php echo get_phrase('generate_id');?>
                                            </a>
                                        </li-->

                                        <li class="divider"></li>
                                        <li>
                                          <a href="#" onclick="confirm_modal('<?php echo site_url('admin/delete_student/'.$row['student_id'].'/'.$class_id);?>');">
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
        <?php
           // $query = $this->db->get_where('section' , array('class_id' => $class_id));
		   $sections = $this->db->query("SELECT * FROM section WHERE class_id =". $class_id)->result_array();
          // var_dump($query );exit();
		   //if ($query->num_rows() > 0):
               // $sections = $query->result_array();
                foreach ($sections as $row):			
        ?>
            <div class="tab-pane" id="<?php echo $row['section_id'];?>">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>                
                            <th><div><?php echo get_phrase('parent');?></div></th>                
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>





  <div style="float:right;">
                    <div class="row">
<div class="col-6">
<button type="button" class="btn btn-default btn-sm dropdown-toggle" >
                                                Promote Class
                            </button>
</div>
<div class="col-6">
<!--<button type="button" class="btn btn-default btn-sm dropdown-toggle" >
                                                Demote Class
                            </button>-->
</div>
                    </div>
                    </div>


 


                        <?php
                                /*$students   =   $this->db->get_where('enroll' , array(
                                    'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                                ))->result_array();*/
							
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
							<?php 
								$query = $this->db->query("SELECT p.name FROM student s LEFT JOIN parent p ON s.parent_id = p.parent_id WHERE s.student_id =".$row['student_id']);
								$row1 = $query->result_array();
								echo $row1[0]['name'];
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
                                            <a href="<?php echo site_url('admin/student_marksheet/'.$row['student_id']);?>">
                                                <i class="entypo-chart-bar"></i>
                                                    <?php echo get_phrase('mark_sheet');?>
                                                </a>
                                        </li-->


                                        <li>
                                            <a href="<?php echo site_url('admin/promote-student/'.$row['student_id']);?>">
                                                <i class="entypo-right"></i>
                                                    Promote Student to next class
                                            </a>
                                        </li>


                                        <!-- STUDENT PROFILE LINK -->
                                        <li>
                                            <a href="<?php echo site_url('admin/student_profile/'.$row['student_id']);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('profile');?>
                                                </a>
                                        </li>
                                        <!--li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/student_id/'.$row['student_id']);?>');">
                                                <i class="entypo-vcard"></i>
                                                <?php echo get_phrase('generate_id');?>
                                            </a>
                                        </li-->

                                        <!-- STUDENT EDITING LINK -->
                                        <li>
                                            <a href="#" onclick="showAjaxModal('<?php echo site_url('modal/popup/modal_student_edit/'.$row['student_id']);?>');">
                                                <i class="entypo-pencil"></i>
                                                    <?php echo get_phrase('edit');?>
                                                </a>
                                        </li>
										
										 <li>
                                          <a href="#" onclick="confirm_modal('<?php echo site_url('admin/delete_student/'.$row['student_id'].'/'.$class_id);?>');">
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
        <?php endforeach;?>
        <?php //endif;
		?>

        </div>


    </div>
</div>
<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'notice', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Notice</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        var is_chrome = Boolean(mywindow.chrome);
        if (is_chrome) {
            setTimeout(function() {
                mywindow.print();
                mywindow.close();

                return true;
            }, 250);
        }
        else {
            mywindow.print();
            mywindow.close();

            return true;
        }

        return true;
    }
	
	function myFunction() {
    window.print();
}

</script>