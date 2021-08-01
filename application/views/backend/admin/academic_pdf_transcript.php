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
                    <span class="hidden-xs"><?php echo get_phrase('stream');?> <?php echo $row['name'];?> </span>
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
							<th><div><?php echo get_phrase('stream');?></div></th>
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $students   =   $this->db->get_where('enroll' , array(
                                    'class_id' => $class_id , 'year' => $running_year
                                ))->result_array();
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
                                        <!-- STUDENT EDITING LINK -->
										<li>
                                            <a target="_blank" href="<?php $report =5; echo site_url('admin/academic_report/'.$row['student_id'].'/'.$report);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('summery');?>
                                                </a>
                                        </li>
										
										<li>
                                            <a target="_blank" href="<?php $report =5; echo site_url('admin/academic_report/'.$row['student_id'].'/'.$report);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('details');?>
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
							<th><div><?php echo get_phrase('stream');?></div></th>							
                            <th><div><?php echo get_phrase('options');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $students   =   $this->db->get_where('enroll' , array(
                                    'class_id'=>$class_id , 'section_id' => $row['section_id'] , 'year' => $running_year
                                ))->result_array();
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
                                        <!-- STUDENT EDITING LINK -->
										<li>
                                            <a target="_blank" href="<?php $report =5; echo site_url('admin/academic_report/'.$row['student_id'].'/'.$report);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('summery');?>
                                                </a>
                                        </li>
										
										<li>
                                            <a target="_blank" href="<?php $report =5; echo site_url('admin/academic_report/'.$row['student_id'].'/'.$report);?>">
                                                <i class="entypo-user"></i>
                                                    <?php echo get_phrase('details');?>
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