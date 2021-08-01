<hr />
<br><br><br>
<?php 
				   $school_id = $this->session->userdata('school_id');
				    $school_name = $this->db->get_where('school' , array('school_id' => $school_id))->row()->school_name;
				   $school_image = $this->crud_model->get_image_url('school',$school_id);
				   ?>
<?php


	$query = $this->db->get_where('section' , array('class_id' => $class_id));
	if($query->num_rows() > 0):
		$sections = $query->result_array();
	foreach($sections as $row):
	
		$section_id = $row['section_id'];
?>
<div class="row">
	
    <div class="col-md-12">

        <div class="panel panel-default" data-collapsed="0">
            <div class="panel-heading" >
                <div class="panel-title" style="font-size: 16px; color: white; text-align: center;">
                    <?php echo get_phrase('stream');?> - <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> : 
                    <?php echo get_phrase('class');?> - <?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;?>
					
					<!--<a class="btn btn-primary btn-xs pull-right event_print">
                            <i class="entypo-print"></i> Print                    </a>-->
					
                   
                </div>
            </div>
			<div id="print">
		
            <div class="panel-body">
                
                <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered" id="add_student_tbl">
                   
					<?php 
				
				
				$layout_id = (int) $this->db->get_where('class_layouts' , array('class_id' => $class_id, 'section_id' => $row['section_id']))->row()->id;
		 
				
				$this->db->order_by("position", "asc");
				$this->db->where('layout_id', $layout_id );
				$this->db->where('layout_id !=', 0);
			    $student_name = $this->db->get('class_layout_places')->result_array();
				
				?>
				
				<div class="col-md-12 text-right" style="padding-bottom:20px;">
				<!--<img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="50px" style="float:left;">-->
				<a href="<?php echo site_url('admin/class_layout_edit/'.$row['class_id'].'/'.$row['section_id']);?>"> <button type="button" class="btn btn-default add_td">Change Layout</button><br/></a></div><br>
				
				<?php 
				 $jj = count($student_name);
					
					  
				?>
				
				
					<form action="<?php echo site_url('/Principal/class_layout/');?>" method="POST" name="class_layout">
					    <?php if ($jj > 0) { ?>
					<tbody class="add_student_body">
					  <tr>
					  <?php 
					    $i = 0;
					  foreach($student_name as $row2): 
					  
					 $i++;
					  if ($row2['student_id'] != 0 ) {
						
						 
						 $student_name1 = $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->name;
	
	
					  ?>
					  
					  
					      <td>
						  
						 
						  <div class="add_student_cover fill_places">
						  <span class="add_student_name"><input type="text" name="sname[]" value="<?php echo $student_name1;
						  
						  
						  ?>"/></span>
						 
						  <span class="add_student_img"></span>
						   <span class="sheet_no_places">sheet <?php echo $i;?></span>
						  </div>
						  </td>
						  
						  
					  <?php 


			} else { ?>
					     <td>
						  <div class="add_student_cover free_places">
						  <span class="add_student_name"><input type="text" name="sname[]" value=""/></span>
						 
						  <span class="add_student_img"></span>
						   <span class="sheet_no_places">sheet <?php echo $i;?></span>
						  </div>
						  </td> 
					  <?php } ?>
						  <?php endforeach; 
						  
						  
						  ?>
						  
	  
					  </tr>
					
					</tbody>
					
					<?php } else {  
					
					
					
					$query = $this->db->get_where('section' , array('class_id' => $class_id,'section_id' => $section_id))->row()->total_seat;
				
	
					?>
					
					
					
					
					<tbody class="add_student_body">
					  <tr>
					  <?php 
					  $v = 0;
					  for($i =1; $i<=$query; $i++):
					  $v++;
					  ?>
					  
					  
					   <td> 
					      <div class="add_student_cover free_places">
						  <span class="add_student_name"><input type="text" name="sname[]" value=""/></span>
						 
						  <span class="add_student_img"></span>
						   <span class="sheet_no_places">sheet <?php echo $v;?></span>
						  </div>
					   </td>
					  <?php endfor;?>
					   
					  
					  </tr>
					</tbody>
					
					
					<?php  
					} ?>
                </table>
				
				
				
				
				</form>
				
				
				
				
				
				   <input id="btn-Preview-Image" type="button" value="Preview" class="btn btn-default add_td"/>
    
    <br />
   
	
	<!--<a id="btn-Convert-Html2Image">fdsf</a>-->
				     
  <!--<div id="sd" style="display:none;">
  
  <div class="col-md-12" id="print_section"> 
	
	<div style="float:left;width:100%;text-align: center;"><img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="50px"></div><br>
    <img id="imagedata">
	
    
	</div>
  
  </div>-->
             
    
            </div>
			</div>
        </div>

    </div>

</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Layout</h4>
		  <a class="btn btn-primary btn-xs pull-right event_print">
                            <i class="entypo-print"></i> Print                    </a>
        </div>
        <div class="modal-body">
          
		  
		  <div id="sd" style="display:block;">
  
  <div class="col-md-12" id="print_section"> 
	
	<div style="float:left;width:100%;text-align: center;"><img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="50px"></div><br>
    <div style="float: left;width: 100%;text-align: center;height: 100%;">
	<img id="imagedata" width="100%">
	</div>
	
    
	</div>
  
  </div>


        </div>
       <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
      
    </div>
  </div>
<?php endforeach;?>
<?php  endif; ?> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<script type="text/javascript">

$(document).ready(function()
{
	
	 $('.event_print').click(function(){
		 
		
		 
		 
	$('#btn-Convert-Html2Image').click();	 
	 var elem = $('#sd');
        PrintElem(elem);
        Popup(data);
	 // $('.add_student_name').hide();
	 });
	  function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title></title>');
        //mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        //mywindow.document.write('<style>.print{border : 1px;}</style>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
	   
       
	 

	
	 
});


$(document).ready(function(){


var element = $("#add_student_tbl"); // global variable
var getCanvas; // global variable

    
         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
             }
         });
  

	$("#btn-Preview-Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
	
  //  $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
   // $("#btn-Convert-Html2Image").html(newData);
	 $("#imagedata").attr("src", newData);
	 
	 $("#myModal").modal();
	});

});

</script>

<style>
.modal-open .modal 
{
background:rgba(0,0,0,.2);	
}
.modal-backdrop.in {
z-index:1;
}
.add_student_name input {
	border: none;
    background: transparent;
    text-align: center;
}
option:empty
{
  display:none;
}


.modal-body {
    background: #fff;
    float: left;
    margin-top: 1px;
}


#sd {
    display: block;
    background: #fff;
    width: 100%;
    float: left;
}
#print_section {
	padding:0;
	margin:0;
}
</style>