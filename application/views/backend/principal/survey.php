<hr />  

<div class="row">
    <div class="col-md-12">
				
				
				
				<button class="btn btn-success" onclick="showAjaxModal('<?php echo base_url(); ?>index.php/modal/popup/survey_modal/');">Survey List</button>
				
				<form role="form" id="form" />
				
				
						
						<div class="hr-line-dashed"></div>
							
						<div class="form-group" style="margin-bottom: 35px;" >
                                   <label for="title"><font color="red"> * </font> Survey Title </label>
                                   <input class="form-control" type="text" placeholder="enter survey title"  class="form-control" id="title" >
                                </div>
								
								
								<div class="form-group" style="margin-bottom: 35px;" >
                                   <label for="title"><font color="red"> * </font> No of Questions </label>
                                   <input class="form-control" type="text" placeholder="enter survey title"  class="form-control" id="no" >
                                </div>
								
								<div class="form-group" style="margin-bottom: 35px;" >
                                   <label for="title"><font color="red"> * </font> Target </label>
                                    <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="target">
                                  <option value="t">Select Target...</option>
                                    <option value="1">Teachers</option>
                                    <option value="2">Parents</option>
                                    <option value="3">All</option>
                                </select>
                                </div>
								 
                        <div class="table-responsive">
                <table class="table" style="border: 0px; font-size:13px;">
                    <thead >
                    <tr style="background-color:; color:#fff;">
                        <th><font color="red"> * </font> Question</th>
                        <th><font color="red"> * </font> Answers - (Use <font color="red"> # </font> to seperate answers) </th>
                       
                       
                    </tr>
                    </thead>
                    <tbody id="items_holder">
                    <tr>
                        <td><div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="Question" class="form-control des" name="item" style="width:500px;"></textarea></div></td>
                        <td> <div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="Answers" class="form-control quantity" name="quantity" style="width:480px;"></textarea></div></td>
                        </tr>
                    </tbody>
                </table>
				<div class="hr-line-dashed"></div>
				<button class="btn btn-info" id="add"><span class="pe pe-7s-plus"></span> Add Question </button>
</div>	<div class="hr-line-dashed"></div>
						<hr>
                        <div>
                            <button class="btn btn-sm btn-primary m-t-n-xs" id="submit"><strong>Submit</strong></button>
							<i id="wait" class="hidden">please wait...</i>
                        </div>
                    </form>
				
				
			
				
				
				
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
			var target=$("#target").val();
			
			if (items=='' || q=='' || title=='' || qz==''){
				
				swal("ERROR!",	"Please fill all details and try again","error");
				
			} else{
				
				$("#wait").removeClass("hidden");
				var p = 'quiz=' + items + '&ans=' + q + '&title=' + title + '&quizs=' + qz + '&target=' + target ;
				
				
				$.ajax({
					
					type: 'POST',
					url: '<?php echo base_url(); ?>index.php/admin/survey/create',
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