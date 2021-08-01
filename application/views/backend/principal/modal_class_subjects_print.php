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


        <div class="tab-content">
        <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('subject_id');?></div></th>                   			
                    		<th><div><?php echo get_phrase('subject_name');?></div></th> 
						</tr>
					</thead>
                    <tbody>
                    	<?php
						$school_id = $this->session->userdata('school_id');
						$class_subjects  = $this->db->get_where('class_subjects', array('school_id' => $school_id))->result_array();
						$count = 1;foreach($class_subjects as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['id'];?></td>														
							<td><?php echo $row['subject'];?></td>														
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
