
 
<script>


function showUserr(str) {
	
	
    if (str == "") {
        document.getElementById("lim").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("lim").innerHTML = xmlhttp.responseText;
            }
        }
       xmlhttp.open("GET","lim it.php?s="+str,true);
        xmlhttp.send();
    }
}

function showUser3() {
	
    var list = document.getElementsByClassName('marks');
var n;
for (n = 0; n < list.length; ++n) {
    list[n].value='';
}
}


function showUsera(v) {
	
   document.getElementById("limit").value=v;
}
</script>

       

   
				
				
		

				
            <div class="panel-body" >
                    
                    
                            <strong class="card-title">Details</strong>
							<form method="POST" enctype="multipart/form-data" class="form-inline" role="form">
							
							 <div class="form-group" style="margin-bottom: 15px;">
                                    <select placeholder="Select Term..." class=" form-control"  id="term">
                                  <option value="t">Select Term...</option>
                                    <option value="Term 1">Term 1</option>
                                    <option value="Term 2">Term 2</option>
                                    <option value="Term 3">Term 3</option>
                                </select> </div>
								
								 <div class="form-group hidden" style="margin-bottom: 15px;">
                                   <select placeholder="Select Subject..." class="form-control"  id="subject" ><option value="t">Select Subject...</option>
                                  <?php
								  
								  include_once("dbconn.php");
								  $q="SELECT Abbreviation from subjects";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
									  
									  <option value="<?php echo $row['Abbreviation'];?>"><?php echo $row['Abbreviation'];?></option>
									  <?php
								  }
								  
								  ?>
                                   
                                </select> </div>
								
								
								 <div class="form-group" style="margin-bottom: 15px;">
                                    <select placeholder="Select exam..." class="form-control"  id="examtype" ><option value="t">Select Exam...</option>
                                  <?php
								  
								  include_once("dbconn.php");
								  $q="SELECT term1 from exams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
									  
									  <option id="<?php echo $row['term1']; ?>" value="<?php echo $row['term1']; ?>"><?php echo $row['term1']; ?>
									  <?php
								  }
								  
								  ?>
                                   </option>
									  
                                </select> </div>
								 <div class="form-group" style="margin-bottom: 15px;">
                                   
								<select placeholder="Select Form..." class="form-control"  id="fr" ><option value="1">Select class...</option>
								<?php
                                   $q="SELECT * from form";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?><option value="ALL">ALL</option>
                                </select> </div>
								
								 <div class="form-group hidden" style="margin-bottom: 15px;">
                                    
								<select placeholder="Select Stream..." class="form-control"  id="st" ><option value="Select Stream...">Select Stream...</option>
								<?php
                                   $q="SELECT * from streams";
								  $r=mysqli_query($con,$q);
								  while($row=mysqli_fetch_assoc($r)){
									 ?>
                                    <option value="<?php echo $row['Name']; ?>"><?php echo $row['Name']; ?></option>
                                   <?php
								  }
								  ?>
                                </select>
								 </div>
								 <div class="form-group" style="margin-bottom: 15px;">
                                    
								<select placeholder="Select Year..." class="form-control"  id="year" ><option value="t">Select Year...</option>
                                  <?php
								  for ($i=0; $i<=3;$i++){
									  ?>
									  <option value="<?php echo (date("Y")-3)+$i; ?>"><?php echo (date("Y")-3)+$i; ?></option>
									  <?php
								  }
								  ?>
                                    
                                </select>
								 </div> <div class="form-group" style="margin-bottom: 15px;">
                                   
								<div id="lim">
								
								</div>
								 </div>
								 
								 <div class="form-group hidden" style="margin-bottom: 15px;">
                                   
                            <div class="col "><input placeholder="enter limit..." class="form-control" type="text" id="limit" /></div>
                          </div>
						  
						  
						   <div class="form-group hidden" style="margin-bottom: 15px;">
                                   
                            <div class="col "><input placeholder="enter minimum subjects..." class="form-control" type="text" id="msub" /></div>
                          </div>
								 <div class="form-group" style="margin-bottom: 15px;">
                                   
								<div class="form-group hidden">
                            <input placeholder="enter out of..." class="form-control" type="text" id="outof"/>
                          </div>
								 </div>
								 
								 <div class="form-group" style="margin-bottom: 15px;">
                                   
								
								 </div>
								 
								 
								
								 <div class="form-group hidden" style="margin-bottom: 15px;">
                                    <label for="exampleInputEmail2" class="col-lg-2 control-label">
								<div class="checkbox" id="sp">
                                  <label for="checkbox1" class="form-check-label ">
                                    <input id="checkbox1" name="checkbox1" value="option1" class="form-check-input" type="checkbox" id="single" checked="true"/>Single Subject
                                  </label>
                                </div>
								 </div>
								<div class="row form-group">
                            <div class="col col-sm-7"><input placeholder="enter paper eg 1" class="form-control" type="text" id="paper" style="display:none;">
							<p id="error" style="color:red;display:none;"> Invalid Paper </p>
							</div>
                          </div>
								
								 <div class="form-group" style="margin-bottom: 15px;">
                                    
								<button type="button" class="btn btn-primary btn-sm btn-block" id="activate" value="SEARCH" style="display:;">ACTIVATE</button>
								 </div>
								
								
								</form>
								<div class="alert  alert-danger alert-dismissible fade show" role="alert" id="error_div" style="display:none;">
                  <span class="badge badge-pill badge-danger"></span> <p id="errorv"></p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                       
                         </div>

                <div class="hpanel hblue">
            <div class="panel-heading ">
                <div class="panel-tools">
                    
                </div>
               Active Exams
            </div>
            <div class="panel-body" >
						<!-- FILTER DATA -->
						<div class="table-responsive">
						<table  class="table table-striped table-bordered table-hover dataTables-example">
						<thead>
                    <tr>
                        <th>Exam name</th>
                        <th>Class</th>
                        <th>Stream</th>
                        <th>Term</th>
                        <th>Year</th>
						<th>Option</th>
                    </tr>
                    </thead>
                    <tbody>
					

					<?php 
						
						$q="SELECT * FROM openexam where status='Active' AND school_id ='" .$this->session->userdata('school_id'). "'";
						$result=$con->query($q);
						$num= $result->num_rows;
						if($num>0){
						while($row=$result->fetch_assoc()){
						?>
					
					<tr class="">
                        <td><?php echo $row['exam'];  ?></td>
                        <td><?php echo $row['form'];  ?>  </td>
                        <td><?php echo $row['stream'];  ?></td>
                        <td ><?php echo $row['term'];  ?></td>
                        <td ><?php echo $row['year'];  ?></td>
						<td >
						<a class="btn btn-warning" href="#" onclick="deactivita('<?php echo base_url();?>index.php/principal/dataentry/diactivate/<?php echo $row['id'];?>');">
                                                <i class="entypo-trash"></i>
                                                    <?php echo get_phrase('deactivate');?>
                                                </a></td>
						
                    </tr>
					<?php
						}
						}
					?>
					
					 </tbody>
							</table>
						</div>
						 </div>
    </div>
</div></div></div></div>
                   

   
   
	


 <script>
        $(document).ready(function(){
			
	$("#activate").click(function() {
		var param="activate";
		var form=$("#fr").val(); 
		var limit=$("#limit").val(); 
	//	var msb=$("#msb").val(); 
		var stream=$("#st").val();
		var year=$("#year").val();
		var term=$("#term").val();
		var exam=$("#examtype").val();
		var dataString = 'form=' + form + '&stream=' + stream + '&year=' + year + '&term=' + term + '&exam=' + exam + '&param=' + param + '&limit=' + limit ;
	if(limit<=0){
		 swal({
                title: "FAILED",
                text: "Limit required",
                type: "warning"
            });	
		
	}
	else{
	$.ajax({
				type:'POST',
				url:"<?php echo site_url('principal/activate_exam/activate'); ?>",
				data:dataString,
				cache:false,
				success:function(result){
					//$("#paper").val('');
					if (result==1){
						  swal({
                title: "SUCCESS",
                text: "",
                type: "success"
            });
					}
					else if (result==12){
						  swal({
                title: "EXAM IS ACTIVE",
                text: "",
                type: "warning"
            });
					}
					
					else{
					  swal({
                title: "FAILED",
                text: "",
                type: "warning"
            });	
					}
					
				}
				
			});
	}
});
			
			
			
			
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'active_exams'},
                    {extend: 'pdf', title: 'active_exams'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>
