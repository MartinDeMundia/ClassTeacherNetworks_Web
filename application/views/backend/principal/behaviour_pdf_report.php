<div class="table-responsive">	 
    <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10">
	  <tr width="100%">
		<!--<td width="25%" style='background-color:#073350 !important'><img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100px"/></td>	-->
		<td width="25%" style='background:none !important;'><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" width="100px"/></td>				                				                
		<td align="right"><img class="health_logo_1" src="<?php echo base_url('/assets/images/pdf_logo/Behaviour.png');?>" />
	  </tr>
	  </table>
	  <br>
	 <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
     
    <div style="float:left;width:48%;padding-right:10px;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="0" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="name_details_health" width="100%" border="1" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Name</td> <td width="180"><?php echo $student_name;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="" align="left" class="left_side">Class</td> <td width="50%"><?php echo $class_name;?></td>
			   </tr>
			   <tr  width="100%">
			      <td width="" align="left" class="left_side">class Teacher </td> <td width="50%"><?php echo $class_teacher;?>	</td>
			   </tr>
			    
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  
	<div style="float:left;width:50%;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="0" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="name_details_health" width="98%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Overall Behaviour</td> <td width="180"><?php echo $overall_behaviour;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="100%" align="left" class="left_side">Last Incident</td> <td width="50%"><?php echo $incident_date;?></td>
			   </tr>
			   <tr  width="100%">
			   <td></td>
			       <td width="50%" align="" style="color:red;"><?php echo $incident_action;?></td>
			   </tr>
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  <br>
	   <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
	   
	  
	  
	  <div style="float:left;width:100%;clear:both;"></div>
	 
	 <br>
	   <div style="float:left;width:65%;">
	    <table>
		<tr  width="100%">
			      <td width="100%" align="left" class="left_side"><strong>BEHAVIORAL OCCURENCES</strong></td>
				  
			   </tr>
		</table>	   
     <table width="75%" class="table table-hover tablesorter" cellspacing="1" cellpadding="5">

	 <tr width="50%">
		<td width="100%">
		    <table class="known_all"  border="0">
			   
			   <tr  width="100%">
			      <td width="20%" align="left" class=""><strong>Date</strong></td>
				  <td width="80%" align="left" class=""><strong>Occurence</strong></td>
			   </tr>
			   
			   <?php 			    
				foreach($report as $v){		

					$title = $this->db->get_where('behaviour_content' , array('id' => $v['behaviour']))->row()->content_name;					
				?>   
				
			   <tr  width="100%">
			      <td width="20%" align="left" class=""><?php echo date('d.m.Y',strtotime($v['updated_on']));?></td>
				   <td width="80%" align="left" class=""><?php echo $title;?>: <strong><?php echo $v['report'];?></strong></td>
			   </tr>
				<?php } ?>  
							    		   
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  
	  <div style="float:left;width:35%;">
	  <br>
     <table width="50%" class="table table-hover tablesorter" cellspacing="1" cellpadding="5" style="background:#f8e5dc;">
	 <tr width="100%">
		<td width="80%" align="right">
		    <table class="known_all action_section"  border="0" >
			   
			   <tr  width="100%">
			      <td width="100%" align="left" class="" align="right"><strong>Action Taken</strong></td> 
				  
			   </tr>
			   
			   <?php			    
				foreach($report as $v){							 				
				?>   
				
					<tr  width="100%">
					  <td width="50%" align="left" class=""> <?php echo $v['action'];?> </td>
					  <td width="50%" align="left" class=""> <?php echo $v['others'];?> </td>
				   </tr>
				<?php } ?>  
			   
			   
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  
	 

  
</div>

 <footer>
 
 
 <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10" style="border-top:1px solid #14a79d;">	

	  <tr width="100%">

		<td><br><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" /></td>				                				                
		<td align="right"><span><span>Genrated <?php echo date('d M Y');?></span>
	  </tr>
	  </table>
</footer>


<style type="text/css">

</style>