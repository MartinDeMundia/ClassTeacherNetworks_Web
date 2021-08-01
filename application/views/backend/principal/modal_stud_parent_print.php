<hr />
<br>
<center>
    <a onClick="PrintElem('#notice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print
        <i class="entypo-print"></i>
    </a>
    
   
</center>
<br><br>
<br><br>
<!--Print Option code-->


<div class="row" id="notice_print">
    <div class="col-md-12">

        <ul class="nav nav-tabs bordered">
            <li class="active">
                <a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="entypo-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('all_students');?></span>
                </a>
            </li>
        <?php
		$class_id = $this->uri->segment(4);
            $query = $this->db->get_where('section' , array('class_id' => $class_id));
            if ($query->num_rows() > 0):
                $sections = $query->result_array();
                foreach ($sections as $row): 
        ?>
        <?php endforeach;?>
        <?php endif;?>
        </ul>
        <div class="tab-content">

                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                           
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
							<th><div><?php echo get_phrase('class');?></div></th>							
                            <th><div><?php echo get_phrase('Parent');?></div></th>				
							
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						
						$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;	
						
						$class_id = $this->uri->segment(4);
                                $students   =   $this->db->get_where('enroll' , array(
                                    'class_id' => $class_id , 'year' => $running_year
                                ))->result_array();
                                foreach($students as $row2):?>
                        <tr>
                            
                            <td><img src="<?php echo $this->crud_model->get_image_url('student',$row2['student_id']);?>" class="img-circle" width="30" /></td>
                            
							<td><?php echo $this->db->get_where('student' , array(
                                    'student_id' => $row2['student_id']
                                ))->row()->student_code;?></td>
							<td>
                                <?php
                                    echo $this->db->get_where('student' , array(
                                        'student_id' => $row2['student_id']
                                    ))->row()->name;
                                ?>
                            </td>
							 <td>
                                <?php
                                    echo $this->db->get_where('section' , array(
                                        'section_id' => $row2['section_id']
                                    ))->row()->name;
                                ?>
                            </td> 
							<td>
							<?php
								$query = $this->db->query("SELECT p.name FROM student s LEFT JOIN parent p ON s.parent_id = p.parent_id WHERE s.student_id =".$row2['student_id']);
								$row3 = $query->result_array();
								echo $row3[0]['name'];
                            ?>
							</td>							
                            
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

       
			
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
        mywindow.document.write('<html><head><title>Student Information</title>');
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
	
</script>
