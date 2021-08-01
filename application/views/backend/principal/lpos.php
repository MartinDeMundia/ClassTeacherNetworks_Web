<hr />  

<div class="row">
    <div class="col-md-12">	
				
				
				<form role="form" id="form" />			
				
						
						<div class="hr-line-dashed"></div>
							<div class="form-group" style="margin-bottom: 35px;" >
							
							<input class="form-control" disabled type="text" placeholder="Name" value="<?php echo $student_name; ?>" class="form-control" id="name" >
							
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group" style="margin-bottom: 35px;" >
						<input class="form-control" disabled type="text" placeholder="Adm No" value="<?php echo $adm; ?>" class="form-control" id="adm" >
						</div>
						<div class="form-group" style="margin-bottom: 35px;" >
                                   
                                    <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option>
                                </select>
                                </div>
								 <div class="form-group" style="margin-bottom: 35px;">
                                    
                                   <select data-placeholder="Choose a Term..." class="form-control select2" tabindex="1" id="year">
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option  value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select> </div>
                                
                                  <div class="form-group" style="margin-bottom: 35px;">
                                    <select data-placeholder="Choose exam..." class="form-control select2" tabindex="1" id="examtype"><option selected value="t">Select Exam...</option>
                                  <?php
								  
								  include_once("dbconn.php");
								  $q="SELECT term1 from exams WHERE school_id = '".$this->session->userdata('school_id')."'";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
								 
								  
									  <option   value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
									  <?php
									  
								  }
								  
								  ?>
                                   </option>
									   
                                </select> </div>
						<div class="form-group" style="margin-bottom: 35px;">
                                   <select placeholder="Select Subject..." class="form-control"  id="sub" onchange=""><option value="t">Select Subject...</option>
                                  <?php
								  
								 
								  $q=" SELECT  subject  FROM  class_subjects WHERE  school_id = '".$this->session->userdata('school_id')."'   AND  is_elective <> 2";

								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>									  
									  <option value="<?php echo $row['subject'];?>"><?php echo $row['subject'];?></option>
									  <?php
								  }
								  
								  ?>
                                   
                                </select> </div>
                        <div class="table-responsive">
                    <table class="table" style="border: 0px; font-size:13px;">
                    <thead >
                    <tr style="background-color:#68869b; color:#fff;">
                        <th>Item</th>
                        <th>Description</th>
                       
                       
                    </tr>
                    </thead>
                    <tbody id="items_holder">
                    <tr>
                        <td><div class="form-group" style="margin-bottom: 35px;" ><input  type="text" placeholder="Item Name" class="form-control des" name="item" style="width:200px;"></div></td>
                        <td> <div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="description" class="form-control quantity" name="quantity" style="width:500px;"></textarea></div></td>
                        </tr>
                    </tbody>
                </table>
				<div class="hr-line-dashed"></div>
				<button class="btn btn-info" id="add"><span class="pe pe-7s-plus"></span> Add Item </button>
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
			var adm = $("#adm").val();
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
			
			var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
			var sub=$("#sub").val();
			
			
			if (2==4){
				
				swal("ERROR!",	"Please fill all details and try again","error");
				
			} else{
				
				$("#wait").removeClass("hidden");
				var p = 'items=' + items + '&des=' + q + '&adm=' + adm + '&subject=' + sub + '&year=' + year + '&term=' + term + '&exam=' + exam;
				
				
				$.ajax({
					
					type: 'POST',
					url: '<?php echo base_url(); ?>index.php/admin/s_report/create',
					data: p ,
					cache: false,
					success: function(result){
						
						if(result =1){
							$("#wait").addClass("hidden");
							swal("Success","Report saved","success");
						}
						
						
					}
					
					
				});
			
			}
			
			return false;
		});
		
		
		
		
		
		$("#add").click(function () {
			
			var item = ' <tr><td><div class="form-group" style="margin-bottom: 35px;" ><input  type="text" placeholder="Item Name" class="form-control des" name="item" style="width:200px;"></div></td> <td> <div class="form-group" style="margin-bottom: 35px;" ><textarea  type="text" placeholder="description" class="form-control quantity" name="quantity" style="width:500px;"></textarea></div></td>                        </tr>';
			
			$("#items_holder").append(item);
			
			
			return false;
			
		});
		
		
		
		

    });

</script>