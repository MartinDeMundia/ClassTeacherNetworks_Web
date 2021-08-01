<hr />  

<div class="row">
    <div class="col-md-12">
				 <table class="table table-striped">
				 <tr>
				 <th>Survey Name</th>
				 <th>Status</th>
				 
				 </tr>
				
				<?php
				
				$questions = $this->db->get_where("survey",array('school_id'=>$this->session->userdata('school_id')))->result_array();
				$i=0;
				foreach($questions as $quiz):
				$i+=1;
				
				
				?>
								  
								  
				
								 
								 <tr>
								<td><a href="<?php echo base_url(); ?>index.php/teacher/survey/take/<?php echo $quiz['id']; ?>"><?php echo $quiz['title']; ?></a>
								 </td>
								 <td><?php echo $quiz['status']; ?>
								 </td>
								 </tr>
				
				<?php
				
				endforeach;
				
				?>
				
				 </table> 
                                </div>
								
					
				
				
				
				
			
				
				
				
				</div>
                </div>
           
            
















<script>


    $(document).ready(function () {
		
		
		$("#submit").click(function(){
			var items = "";
			var q = "";
			var r = "";
			var tt = "";
			var title = $("#title").val();
			var qq = $(".des");
			var qt = $(".quantity");
			for(var i =0; i < qq.length; i++){
				if (items.length == 0){
					items = items + $(qq[i]).val();
				}else{
					if($(qq[i]).val()==''){
						
					}else{
				items = items + "," + $(qq[i]).val();
					}
				}
			}
			
			
			for(var i =0; i < qt.length; i++){
				if (q.length == 0){
					q = q + $(qt[i]).val();
				}else{
					if($(qt[i]).val()==''){
						
					}else{
				q = q + "," + $(qt[i]).val();
					}
				}
			}
			
			var qz=$("#no").val();
			
			
			if (items=='' || q=='' || title=='' || qz==''){
				
				swal("ERROR!",	"Please fill all details and try again","error");
				
			} else{
				
				$("#wait").removeClass("hidden");
				var p = 'quiz=' + items + '&ans=' + q + '&title=' + title + '&quizs=' + qz ;
				
				
				$.ajax({
					
					type: 'POST',
					url: '<?php echo base_url(); ?>index.php/teacher/survey/create',
					data: p ,
					cache: false,
					success: function(result){
						
						if(result =1){
							$("#wait").addClass("hidden");
							swal("Success","Survey saved","success");
						}
						
						
					}
					
					
				});
			
			}
			
			return false;
		});
		
		
		
		
		
		$("#add").click(function () {
			
			var item = ' <tr><td><div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="Question" class="form-control des" name="item" style="width:500px;"></textarea></div></td><td> <div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="Answers" class="form-control quantity" name="quantity" style="width:480px;"></textarea></div></td></tr>';
			
			$("#items_holder").append(item);
			
			
			return false;
			
		});
		
		
		
		

    });

</script>