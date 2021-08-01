  <a onClick="PrintElem('#notice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print
        <i class="entypo-print"></i>
    </a>
	<div class="row" id="notice_print">
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th>#</th>                             
                            <th><div><?php echo get_phrase('name');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                            <th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('profession');?></div></th>							
							<th><div><?php echo get_phrase('stream');?></div></th>
                            <th><div><?php echo get_phrase('admiss_no');?></div></th>
                            <th><div><?php echo get_phrase('student_name');?></div></th>
							 
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $count = 1;							
							
							$school_id = $this->session->userdata('school_id');      
							
							$parentsids = $this->db->select("GROUP_CONCAT(parent_id) as parents")->where_in('school_id',$school_id)->get('student')->row()->parents;
							
							if($parentsids!='')
							$parents = $this->db->where_in('parent_id', explode(',',$parentsids))->get('parent')->result_array();
							 							
							
                            foreach($parents as $row):?>
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
								$row1 = $query->result_array();
								echo $row1[0]['name'];
							?>
							</td>
	                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
	</div>
				
<script type="text/javascript">

    // print invoice function
    function PrintElem(elem)
    {
		//alert('123456');
        Popup($(elem).html());
    }

    function Popup(data)
    {
		//alert(data);
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
	
	/*function myFunction() {
    window.print();
}*/

</script>