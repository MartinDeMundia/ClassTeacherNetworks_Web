<hr />
<br><br><br>

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
                    <?php echo get_phrase('class');?> - <?php echo $this->db->get_where('class' , array('class_id' => $class_id))->row()->name;?> : 
                    <?php echo get_phrase('stream');?> - <?php echo $this->db->get_where('section' , array('section_id' => $row['section_id']))->row()->name;?>
					
                   
                </div>
            </div>
            <div class="panel-body">
                
                <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered" id="add_student_tbl">
                   
					<?php 
				
				
				$layout_id = (int) $this->db->get_where('class_layouts' , array('class_id' => $class_id, 'section_id' => $row['section_id']))->row()->id;
		 
				
				$this->db->order_by("position", "asc");
				$this->db->where('layout_id', $layout_id );
				$this->db->where('layout_id !=', 0);
			    $student_name = $this->db->get('class_layout_places')->result_array();
				
				?>
				
				<div class="col-md-12 text-right" style="padding-bottom:20px;"><a href="<?php echo site_url('teacher/class_layout_edit/'.$row['class_id'].'/'.$row['section_id']);?>"> <button type="button" class="btn btn-default add_td">Change Layout</button><br/></a></div><br>
				
				<?php 
				 $jj = count($student_name);
					
					  
				?>
				
				
					<form action="<?php echo site_url('/teacher/class_layout/');?>" method="POST" name="class_layout">
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
				
				
				
  
             
    
            </div>
        </div>

    </div>

</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Student's Name</h4>
        </div>
        <div class="modal-body">
          <!--<p>Some text in the modal.</p>-->
		  <select id="sname_list"> 
		  <option value="Hari" name="sname1">Hari1</option> 
		  <option value="Arun" name="sname2">Arun2</option>
		  <option value="Bala" name="sname3">Bala3</option> 
		  <option value="Surya" name="sname4">Surya4</option> 
		  <option value="Ravi" name="sname5">Ravi5</option> 
		  <option value="sekar" name="sname6">sekar6</option> 
		  </select>


        </div>
       <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
      
    </div>
  </div>
<?php endforeach;?>
<?php  endif; ?> 

<script type="text/javascript">

jQuery(document).ready(function($)
{
	 // $('.add_student_name').hide();
	   
       $('.add_student_body .add_student_cover').click(function(){
		//   alert(231);
		// $("#myModal").modal();
		   //$(this).addClass("intro");
          //$(this).find(".add_student_name").delay(500).show(0);
		  
		 
		  /*$('#sname_list').on('change', function() {
             var jj = $('#sname_list').val();
            //alert(jj);
          $('.intro .add_student_name input').val(jj);
		  $('.add_student_cover').removeClass("intro");
   
          })*/
		 
		  
		 
          
     });
	 
	 


	 
	  
	  
	  $('.add_td').click(function(){ 
	  /* $("#add_student_tbl tbody td:last").after("<td><div class='add_student_cover'><span class='add_student_name'><input type='text' name='sname[]' value='131' /></span><span class='add_student_img'></span></div></td>");*/
	  });
	  
	 
	  $("#add_student_tbl").on("click", ".add_student_cover", function(){
  /* $("#myModal").modal();
		   $(this).addClass("intro");
          $(this).find(".add_student_name").delay(500).show(0);
		  
		 
		  $('#sname_list').on('change', function() {
             var jj = $('#sname_list').val();
            //alert(jj);
          $('.intro .add_student_name input').val(jj);
		  $('.add_student_cover').removeClass("intro");
   
          });*/
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
</style>