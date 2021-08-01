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

        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="home">

                <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr> 
							<th style="width: 32px !important;">#</th>       
							<th width="80"><div><?php echo get_phrase('admission_no.');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
							<th><div><?php echo get_phrase('parent');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$count = 1;
								$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;					
								$class_id = $this->uri->segment(4);
                                $students   =   $this->db->get_where('enroll' , array(
                                    'class_id' => $class_id , 'year' => $running_year
                                ))->result_array();
                                foreach($students as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>  
                            
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
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

            </div>
       
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
            }, 2500);
        }
        else {
            mywindow.print();
            mywindow.close();

            return true;
        }

        return true;
    }
	
</script>
