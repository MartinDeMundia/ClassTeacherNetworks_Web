<center>
    <a onClick="PrintElem('#notice_print')" class="btn btn-default btn-icon icon-left hidden-print pull-right">
        Print
        <i class="entypo-print"></i>
    </a>
    
</center>
  <div class="row" id="notice_print">
    <div class="col-md-12">
        <div class="tab-content">
            <div class="tab-pane active" id="home">
				
				
				
				
               <table class="table table-bordered datatable" id="table_export">
                    <thead>
                        <tr>
                            <th width="80"><div><?php echo get_phrase('photo');?></div></th>
                            <th><div><?php echo get_phrase('ID');?></div></th>
                            <th><div><?php echo get_phrase('name');?></div></th>
							<th><div><?php echo get_phrase('role');?></div></th>
							<th><div><?php echo get_phrase('phone');?></div></th>
                            <th><div><?php echo get_phrase('email');?></div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $school_id = $this->session->userdata('school_id');
							$teachers = $this->db->get_where('teacher' , array('school_id' => $school_id))->result_array();
                            foreach($teachers as $row):?>
							
							
                        <tr>
                            <td><img src="<?php echo $this->crud_model->get_image_url('teacher',$row['teacher_id']);?>" class="img-circle" width="30" /></td>
                            <td><?php echo $row['teacher_id'];?></td>
                            <td><?php echo $row['name'];?></td>
							<td><?php echo $row['designation'];?></td>
							<td><?php echo $row['phone'];?></td>
                            <td><?php echo $row['email'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>

			</div>
		</div>
	</div>
</div>

<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		$(".dataTables_wrapper select").select2({
			minimumResultsForSearch: -1
		});
	});
		
</script>

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