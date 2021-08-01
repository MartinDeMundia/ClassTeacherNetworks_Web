<hr />
<br><br><br>

<?php
$sec_id= $this->uri->segment(4);
echo $url;
	$query = $this->db->get_where('section' ,array('class_id' => $class_id, 'section_id' => $sec_id ));
	if($query->num_rows() > 0):
		$sections = $query->result_array();
		 $layout_id = (int) $this->db->get_where('class_layouts' , array('class_id' => $class_id, 'section_id' => $sec_id))->row()->id;
		 
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
                
				
				<div id="#result"></div>
				
                <table cellpadding="0" cellspacing="0" border="0"  class="table table-bordered" id="add_student_tbl">
                   
					<?php 
				
				
				$layout_id = (int) $this->db->get_where('class_layouts' , array('class_id' => $class_id, 'section_id' => $row['section_id']))->row()->id;	        
				
				$this->db->order_by("position", "asc");
				$this->db->where('layout_id', $layout_id );
				$this->db->where('layout_id !=', 0);
				//$this->db->where('student_id !=', 0);
			    $student_name = $this->db->get('class_layout_places')->result_array();	
				//echo '<pre>';
				//print_r($student_name);
				//echo '</pre>';
			    $jj = count($student_name);
				?>
					<form action="<?php echo site_url('/principal/class_layout/');?>" method="POST" name="class_layout">
					    <?php if ($jj > 0) { ?>
					<tbody class="add_student_body">
					  <tr>
					  <?php 
					   
					   $i = 0;
					  
					  foreach($student_name as $row2): 
					
					   $i++;
					  if ($row2['student_id'] != 0 ) {
						
						 $student_id = $row2['student_id'];
						 //echo $student_id;
						 $student_name1 = $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->name;
	
					  ?>
					      <td>
						  <div stuid="<?php echo $student_id;?>" class="add_student_cover filled_places_edit" id="id_<?php echo $i;?>">
						  <span class="add_student_name"><input type="text" name="sname" value="<?php echo $student_name1;
						  ?>"/></span><?php //echo $row2['id']; ?>
						  <span class="add_student_img"></span>
						  <span class="sheet_no_places">sheet <?php echo $i;?></span>						  
						  <input type="hidden" name="sposition" value="<?php echo $i;?>" class="sposition"/>
						  </div>
						  </td>
					  <?php 
			} else { ?>
					     <td>
						  <div stuid="" class="add_student_cover" id="id_<?php echo $i;?>">
						  <span class="add_student_name"><input type="text" name="sname" value=""/></span>
						  <span class="add_student_img"></span>
						  <span class="sheet_no_places">sheet <?php echo $i;?></span>
						  <input type="hidden"  name="sposition" value="<?php echo $i;?>" class="sposition"/>
						  </div>
						  </td> 
					  <?php } ?>
						  <?php endforeach; ?>
					  </tr>
					
					</tbody>
					
					<?php }  else { 
					
									
					$query = $this->db->get_where('section' , array('class_id' => $class_id,'section_id' => $section_id))->row()->total_seat;
					
					?>
					
					<tbody class="add_student_body">
					  <tr>
					  <?php for($i =1; $i<=$query; $i++):?>
					   <td>
						  <div class="add_student_cover">
						  <span class="add_student_name"><input type="text" name="sname" value=""/></span>
						 
						  <span class="add_student_img"></span>
						   <span class="sheet_no_places">sheet <?php echo $i;?></span>
						   <input type="hidden"  name="sposition" value="<?php echo $i;?>" class="sposition"/>
						  </div>
						  
						  </td> 
						   <?php endfor;?>
					  
					  </tr>
					
					</tbody>
					
					<?php } ?>
                </table>
				</form>
            </div>
        </div>

    </div>

</div>

<?php endforeach;?>
<?php  endif; ?> 

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Student's List</h4>
        </div>
        <div class="modal-body">
		<form action="#" method="POST" name="student_list" id="student_list">
		<!--<form action="<?php echo site_url('principal/class_layout_change/');?>" method="POST" name="student_list" id="student_list">-->
		
	
		<select id="sname_list" required> 
		<option value=''>select</option>
		<?php
		
		 
		 $students =  $this->db->get_where('enroll' , array('class_id' => $class_id, 'section_id' => $sec_id))->result_array();
		
		foreach($students as $row2) {
		    
		    $student_id = $row2['student_id'];
			$student_name1 = $this->db->get_where('student' , array('student_id' => $row2['student_id']))->row()->name;
	
			echo $student_name1;
		
		?>
		
		  <option value="<?php echo $student_id;?>" name="sname1" class=""><?php echo $student_name1;?></option> 
	<?php	} ?>
		  </select>
		 
		  <input type="hidden" name="stu_name" value="" class="stu_position_name"/>
		  <input type="hidden" name="stu_pos" value="" class="stu_place"/>		  
		  <input type="submit" name="stu_frm" class="btn btn-primary stud_submit" value="Rearrange"/>

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
		
	    var stuid = $(this).attr('stuid'); 
var sposition_id = $('#'+$(this).attr('id')+' .sposition').val();
//alert(sposition_id);
	    $("#sname_list").val(stuid);
		 
		$("#myModal").modal();
		  $(this).addClass("intro");
          $(this).find(".add_student_name").delay(500).show(0);
		  
		  
		   var cur_sname = $(".intro .add_student_name input").val();
		
	
		  $('#sname_list').on('change', function() {
			  
			  
			  
             var get_name = $('#sname_list').val();
			 var get_place = sposition_id; //$('.sposition').val();	
           
          //$('.intro .add_student_name input').val(get_name);
		   $('.stu_position_name').val(get_name);
		   $('.stu_place').val(get_place);
		  $('.add_student_cover').removeClass("intro");
   
          })
		 
		  
		 
          
     });
	 
	 


	 
	  
	  
	  
	  
	 
	  $("#add_student_tbl").on("click", ".add_student_cover", function(){
   $("#myModal").modal();
		   $(this).addClass("intro");
          $(this).find(".add_student_name").delay(500).show(0);
		  
		 
		  $('#sname_list').on('change', function() {
             var jj = $('#sname_list').val();
            //alert(jj);
          $('.intro .add_student_name input').val(jj);
          $('.stu_name').val(jj);
		  $('.add_student_cover').removeClass("intro");
   
          });
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
tbody.add_student_body tr td
{
	height:122px !important;
}
</style>
<script type="text/javascript">
jQuery(document).ready(function($)
{
	
	 $('.stud_submit').click(function(){ 
	 
	    var stuid = $('.stu_position_name').val();
	    var place = $('.stu_place').val();
	    var lid = "<?php echo  $layout_id;?>"; 
	    
	    if(stuid !='')	{
	       
            $.ajax({
                url: '<?php echo site_url('principal/class_layout_change/'); ?>' + lid + '/' + stuid + '/'+ place,
                success: function (response)
                {
					//console.log('<?php echo site_url('principal/class_layout_change/'); ?>' + lid + '/' + stuid + '/'+ place);
                    location.reload(); 
                }
            });
            
           return false;
	    }
		
	 });
	
});
</script>

