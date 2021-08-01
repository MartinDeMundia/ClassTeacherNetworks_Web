<hr />  

<div class="row">
    <div class="col-md-12">
				
				<table class="table table-striped" style="font-size:12px;">
				<?php
				
				$questions = $this->db->get_where("survey_questions",array("survey"=>$survey_id))->result_array();
				$i=0;
				foreach($questions as $quiz):
				$i+=1;
				$id = $quiz['id'];
				$q = $quiz['question'];
				$answer = $this->db->get_where("survey_answers",array("question_id"=>$id))->result_array();
				
				?><tr><td><div id="<?php echo $id; ?>">
                                   <p> <?php echo $i.'.  '.$q ; ?></p>
								   <table class="table borderless" style="border:0px;" id="a_<?php echo $id; ?>">
								   <?php
				foreach($answer as $ans):
				
				$found = $this->db->get_where("survey_data",array("question_id"=>$id,"answer_id"=>$ans['id'],"user_id"=>$user_id))->result_array();
				
				if(count($found) > 0){
				?>
				<font color="green"><i class="fa fa-check fa-3x primary"></i></font>
				<?php echo $ans['answer'];
				
				$count = $this->db->get_where("survey_answers",array("question_id"=>$id,"id"=>$ans['id']))->row()->votes;
				
				$this->db->select('AVG(votes) avg_votes');
$total=$this->db->get('survey_answers')->row()->avg_votes;

?>
			<i >  - [Votes - <?php echo $count . ' ('. round((($count/$total)*100),0) .' %)]'; ?></i>
<?php

				}	else{

					$found2 = $this->db->get_where("survey_data",array("question_id"=>$id,"user_id"=>$user_id))->result_array();

					if(count($found2) > 0){		
					
					}else{
				?>
								 
								 <tr >
								<td><input value="<?php echo ' '.$ans['answer']; ?>" class ="answer" name="<?php echo $id; ?>" type="radio" id="<?php echo $ans['id']; ?>"><?php echo ' '.$ans['answer']; ?>
								 </td>
								 </tr>
				
				<?php
				}
				}
				endforeach;
				
				?>
				
				 </table> 
                    </div></td>
				</tr>           
								
								<?php
				endforeach;
				?>
				
				 </table>
				
				
				
				
			
				
				
				
				</div>
                </div>
           
            
















<script>


    $(document).ready(function () {
		
		
		$(".answer").click(function(){
				var t = $(this).val() ;
				var user_id = <?php echo $user_id; ?>;
				var answer_id = $(this).attr('id') ;
				var div = $(this).attr('name') ;
				var p = 'id=' + answer_id + '&qid=' + div + '&user_id=' + user_id;
				$.ajax({
					
					type: 'POST',
					url: '<?php echo base_url(); ?>index.php/admin/survey/answer',
					data: p ,
					cache: false,
					success: function(result){
						
						if(result =1){
							$(this). prop("checked", true);
							$('#'+div). append('<font color="green"><i class="fa fa-check fa-3x primary"></i></font>');
							$("#"+div).off('click');
							$("#a_"+div).addClass('hidden');
							$('#'+div). append(t);
							//swal("Success","Survey saved","success");
						}
						
						
					}
					
					
				});
			
			
			return false;
		});
		
		
		
		
		
		
		$("#add").click(function () {
			
			var item = ' <tr><td><div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="Question" class="form-control des" name="item" style="width:500px;"></textarea></div></td><td> <div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="Answers" class="form-control quantity" name="quantity" style="width:480px;"></textarea></div></td></tr>';
			
			$("#items_holder").append(item);
			
			
			return false;
			
		});
		
		
		
		

    });

</script>