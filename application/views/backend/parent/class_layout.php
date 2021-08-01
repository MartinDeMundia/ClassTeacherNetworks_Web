<hr />
<br><br><br>

<?php
 
?>
<div class="row">
	
    <div class="col-md-12">

        <div class="panel panel-default" data-collapsed="0">
            <div class="panel-heading" >
                <div class="panel-title" style="font-size: 16px; color: white; text-align: center;">
                    <?php echo get_phrase('class');?> - <?php echo $this->db->get_where('class' , array('class_id' => $class_ids))->row()->name;?> : 
                    <?php echo get_phrase('section');?> - <?php echo $this->db->get_where('section' , array('section_id' => $section_ids))->row()->name;?>
					
                   
                </div>
            </div>
            <div class="panel-body">
                
                <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered" id="add_student_tbl">
                   
					<?php 
				
				
				$layout_id = (int) $this->db->get_where('class_layouts' , array('class_id' => $class_ids, 'section_id' => $section_ids))->row()->id;
		 
				
				$this->db->order_by("position", "asc");
				$this->db->where('layout_id', $layout_id );
				$this->db->where('layout_id !=', 0);
			    $student_name = $this->db->get('class_layout_places')->result_array();
				
				 
				 $jj = count($student_name);
					
					  
				?>
				
				
					<form action="<?php echo site_url('/parents/class_layout/');?>" method="POST" name="class_layout">
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
					
					
					
					$query = $this->db->get_where('section' , array('class_id' => $class_ids,'section_id' => $section_ids))->row()->total_seat;
				
	
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