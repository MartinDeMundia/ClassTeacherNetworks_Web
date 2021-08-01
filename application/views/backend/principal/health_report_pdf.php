<div class="table-responsive">	 
    <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10">	
	  <tr width="100%">
		<!--<td width="25%" style='background-color:#073350 !important'><img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100px"/></td>--><td width="25%" style='background:none !important;'><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" width="100px"/></td>					                				                
		<td align="right"><img class="health_logo_1" src="<?php echo base_url('/assets/images/pdf_logo/health1.png');?>" />
	  </tr>
	  </table>
	  <br>
	 <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
     
    <div style="float:left;width:50%;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="0" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="name_details_health" width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
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
		    <table class="name_details_health" border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Overall Health</td> <td width="180"><?php echo $overall_health;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="100%" align="left" class="left_side">Last Incident</td> <td width="50%"><?php echo $incident_date;?></td>
			   </tr>
			   <tr  width="100%">
			   <td></td>
			       <td width="50%" align=""><?php echo $incident_action;?></td>
			   </tr>
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  <br>
	   <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
	   
	   <div style="float:left;width:50%;clear:both;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="known_all" width="100%" border="0">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side"><strong>KNOWN ALLERGIES</strong></td>
				  
			   </tr>
			   <?php
				foreach($report as $v){  
				?>   
				
			   <tr  width="100%">
			      <td width="100%" align="left" class=""><?php echo $v['title'];?></td> 
				  
			   </tr>
				<?php } ?>
			   
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  
	  <div style="float:left;width:100%;clear:both;"></div>
	 
	 <br>
	   <div style="float:left;width:60%;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="known_all" width="100%" border="0">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side"><strong>HEALTH OCCURENCES</strong></td>
				  
			   </tr>
			   <tr  width="100%">
			      <td width="100%" align="left" class=""><strong>Date</strong></td> 
				  <td width="100%" align="left" class=""><strong>OCCURENCES</strong></td> 
			   </tr>
			   
			   <?php
			    $i = 1;
				foreach($report as $v){
					if($i>2) continue;
				?>   
				
			   <tr  width="100%">
			      <td width="100%" align="left" class=""><?php echo date('d.m.Y',strtotime($v['updated_date']));?></td> 
				   <td width="100%" align="left" class=""><?php echo $v['title'];?></td> 				  
			   </tr>
				<?php $i++; } ?>   
			   
			   
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  
	  <div style="float:left;width:40%;">
	  <br>
     <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="5" style="background:#f8e5dc;">	
	 <tr width="100%">
		<td width="100%" align="right">
		    <table class="known_all action_section" width="100%" border="0" >
			   
			   <tr  width="100%">
			      <td width="100%" align="left" class=""><strong>Action Taken</strong></td> 
				  
			   </tr>
			   
			   <?php
				$i=1;
				foreach($report as $v){
					if($i>2) continue;
				?>   
				
			   <tr  width="100%">
			      <td width="100%" align="left" class=""><?php echo $v['action'];?></td> 			  			  
			   </tr>
				<?php $i++; } ?>  		   
			   
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
		<td align="right"><span>Genrated <?php echo date('d M Y');?></span>
	  </tr>
	  </table>
</footer>


<style type="text/css">

</style>