<?php 
	//$behaviours = $this->db->get_where('behaviours' , array('school_id' => $school_id))->result_array();
	//$behaviours = $this->db->get_where('behaviours')->result_array();

      $behaviours   = $this->db->query('SELECT * FROM behaviours WHERE behaviour_title <> "NURSERY REPORTS" AND behaviour_title= BINARY UPPER(behaviour_title) AND school_id = 13 ORDER BY sort_id ASC')->result_array();

	/*$this->db->select('b.*,s.*'); 
    $this->db->from('school s');
    $this->db->join('behaviours b', 'b.school_id = s.school_id', 'left'); 
	$this->db->where('s.school_id', $school_id);
    $query = $this->db->get();
    $behaviours = $query->result_array();*/
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary" data-collapsed="0">
        	<!--div class="panel-heading">
            	<div class="panel-title" >
            		
					<?php echo get_phrase('behaviours');?>
            	</div>
            </div-->
			<div class="panel-body">
				
				
				<div class="col-md-12">
  
<div class="col-md-12">
	<div class="row">
        <div class="col-lg-11 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
			  <?php $query_primary = $this->db->query("SELECT * FROM school WHERE school_id =$school_id"); 
			    $data = $query_primary->result_array();
			    $school_type = ($data[0]['school_type']); 
				
				?>
			   <?php $i=1; foreach ($behaviours as $behaviour){ ?>
			    
			    <?php
  
				$pid = $behaviour['id'];
				$pst = $school_type;
				?>
			   <?php if( $pid == 29 && $pst == 2) { ?>
               
			   <?php }else  {?>
			   <a href="#" class="list-group-item <?php echo ($i == 1)?'active':'';?> text-center" style="padding:20px 0px;">
                  <!--<h4 class=""></h4><br/>--><?php echo $behaviour['behaviour_title'];?>
                </a>
				<?php }  ?>
			   <?php $i++; } ?>                 
                
              </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
				
				<?php 
				
					$i=1;
					foreach ($behaviours as $behaviour){ $behaviour_id = $behaviour['id'];	?>
				
				   <div class="bhoechie-tab-content <?php echo ($i == 1)?'active':'';?>" style="margin-bottom:20px;">
					<?php echo form_open(site_url('admin/behaviour_update/'. $student_id) , array('class' => 'form-horizontal form-groups-bordered validate'));?>
                    <center>

					<?php
									
					$contents = $this->db->get_where('behaviour_content' , array('behaviour' => $behaviour_id))->result_array();
					if(count($contents) >0){
					foreach ($contents as $content){ 
					
				
					$content_id = $content['id'];
					$content_name = $content['content_name'];					
					$actions = explode(',',$content['actions']);
					
					$student_behaviour = $this->db->get_where('behaviour_reports' , array('student_id' => $student_id,'behaviour' => $content_id))->row();	
					//print_r($student_behaviour);
					
					$student_report = $student_behaviour->report;
					$student_action = $student_behaviour->action;					
					$student_behaviour1 = $student_behaviour->behaviour;					
					
					
					?>
					
					<div class="row">
							   <div class="col-md-8 title_heading_behav">
							   
							  <h4><?php echo $content_name;?></h4>					 
							  					 
							  <input type="hidden" name="behaviour[]" value="<?php echo $content_id;?>"/>					  
							  </div>
							   <div class="col-md-4">
									<div class="dropdown col-md-3" style="padding-left:0;">
									<?php if ($behaviour_id != '25' && $behaviour_id != '27' && $behaviour_id != '28') { ?>	
									

									 	<?php 
											$deviant = array("21","22","25","26","27","28","24");
											if (in_array($behaviour_id, $deviant)) {
										?>
										 <select name="report[]" class="dropdown yes_no_option btn btn-primary" data-style="btn-primary" style="margin-top:10px;" onchange="showactdeviant(this.value,'<?php echo $content_id;?>');">
											<option value='no' <?php echo (trim(strtolower($student_report)) =='no')?'selected':'';?> >No</option>
										    <option value='yes' <?php if(trim(strtolower($student_report)) == 'yes') { echo 'selected'; }else { echo (trim(strtolower($student_report)) =='yes')?'selected':''; } ?> >Yes</option>
									    </select>

	                                     <?php 
											}else{
										  ?>
										   <select name="report[]" class="dropdown yes_no_option btn btn-primary" data-style="btn-primary" style="margin-top:10px;" onchange="showact(this.value,'<?php echo $content_id;?>');">
											  <option value='yes' <?php echo ($student_report =='yes')?'selected':'';?> >Yes</option>
										      <option value='no' <?php if($behaviour_id == 20 && $student_report != 'yes') { echo 'selected'; }else { echo ($student_report =='no')?'selected':''; } ?> >No</option>
									      </select>

										<?php
											}
									 	 ?>

									

									
									 <?php } else { ?>
									 <select name="report[]" class="dropdown yes_no_option btn btn-primary" data-style="btn-primary" style="margin-top:10px;" onchange="showact1(this.value,'<?php echo $content_id;?>');">
									  <option value='no' <?php echo ($student_report =='no')?'selected':'';?> >No</option>
									  <option value='yes' <?php echo ($student_report =='yes')?'selected':'';?> >Yes</option>
									</select>
									<?php } ?>
									
								   			
								  </div>
				   
							   </div>	







									 	<?php 
											$deviant = array("21","22","25","26","27","28","24");
											if (in_array($behaviour_id, $deviant)) {
										?>


							  <div class="alert alert-danger yes_no_show col-md-10" style="<?php echo (trim(strtolower($student_report)) == 'no' || $student_report == '' )?'display:none !important;':'';?>margin-top:10px;padding:10px 0 10px 0;border-color:#dadada;background:#dadada;" id="select_no_option<?php echo $content_id;?>">	
									<div class="no_details_option col-md-12">
									   <p class="col-md-4" style="margin-top:10px;font-size:15px;"><strong>Action Taken </strong></p>
									  <select name="action[]" class="dropdown pull-right btn btn-primary col-md-4" data-style="btn-primary" onchange="getval(this);">
										  <?php foreach ($actions as $action){ ?>	
											<option <?php echo ( trim(strtolower($student_action)) == trim(strtolower($action)) )?'selected':'';?> value="<?php echo $action;?>"><?php echo $action;?></option>
										  <?php }?>	
					  
										</select>
										
											<script>
												function getval(sel) {
												$selected = sel.value;
												if($selected == ' Any other (explain)'){
													 $(".others").show();
													}else{
														$(".others").hide();
													}
												}
											</script>

									</div>
										<div class="col-md-12">
										<p class="col-md-4" style="color:#000000; font-size:10px; font-weight:bold;">Any Others Explain here</p>
											<div class="col-md-8">
												<input type="text" class ="others" name="others_<?php echo $content_id;?>" value="<?php echo $student_behaviour->others;?>" /> 
											</div>
										</div>
							</div>








									
	                                     <?php 
											}else{

										  ?>


								<div class="alert alert-danger yes_no_show col-md-10" style="<?php echo (trim(strtolower($student_report)) == 'yes' || $student_report == '')?'display:none;':'';?>margin-top:10px;padding:10px 0 10px 0;border-color:#dadada;background:#dadada;" id="select_no_option<?php echo $content_id;?>">	
								<div class="no_details_option col-md-12">
								   <p class="col-md-4" style="margin-top:10px;font-size:15px;"><strong>Action Taken </strong></p>
								  <select name="action[]" class="dropdown pull-right btn btn-primary col-md-4" data-style="btn-primary" onchange="getval(this);">
									  <?php foreach ($actions as $action){ ?>	
										<option <?php echo ($student_action ==$action)?'selected':'';?> value="<?php echo $action;?>"><?php echo $action;?></option>
									  <?php }?>	
				  
									</select>
									
										<script>
											function getval(sel) {
											$selected = sel.value;
											if($selected == ' Any other (explain)'){
												 $(".others").show();
												}else{
													$(".others").hide();
												}
											}
										</script>

								</div>
									<div class="col-md-12">
									<p class="col-md-4" style="color:#000000; font-size:10px; font-weight:bold;">Any Others Explain here</p>
										<div class="col-md-8">
											<input type="text" class ="others" name="others_<?php echo $content_id;?>" value="<?php echo $student_behaviour->action;?>" /> 
										</div>
									</div>
						</div>


									
										<?php
											}
									 	 ?>









				   
							  











					</div>		 					
					<?php } ?>
					
			 
					</center>
		
					<div class="col-md-12 text-center"><input type="submit" class="btn btn-success" style="margin-bottom:20px;width: 200px;margin-top:20px;" value="Update" /></div>
					
					 <?php echo form_close();?>
					 
					</div>
					<?php }else{ ?>	
					
						<div class="row">
							<div class="col-md-8 title_heading_behav">
							 Yet to be added in Behaviour content  
						   </div>

						</div>	
					
					<?php $i++; }} ?>
	 
            </div>
        </div>
  </div>
</div>  
  
  
</div>
				
				
				
				
            </div>
        </div>
    </div>
</div>

<style>


/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5A55A3;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}

.special {
  font-weight: bold !important;
  color: #fff !important;
  background: #bc0000 !important;
  text-transform: uppercase;
}


.title_heading_behav h4 {
	margin-top:30px;
}
input[type="text"]{
	width:100%;
}

</style>
<script type="text/javascript">
function showact(opt,act){		
		 
		if(opt == 'no') {
			$('#select_no_option'+act).css("display","");
		}
		else{
			
			$('#select_no_option'+act).css("display","none");
		}
}

function showactdeviant(opt,act){		
		 
		if(opt == 'yes') {
			$('#select_no_option'+act).css("display","");
		}
		else{
			
			$('#select_no_option'+act).css("display","none");
		}
}

function showact1(opt,act){		
		 
		if(opt == 'yes') {
			$('#select_no_option'+act).css("display","");
		}
		else{
			
			$('#select_no_option'+act).css("display","none");
		}
}


$(document).ready(function() {
	
   $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });	
 
});
</script>
