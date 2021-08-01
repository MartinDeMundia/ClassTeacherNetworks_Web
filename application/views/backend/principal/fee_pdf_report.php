<div class="table-responsive">	 
    <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10">	
	  <tr width="100%">
		<!--<td width="25%" style='background-color:#073350 !important'><img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100px"/></td>	-->
		<td width="25%" style='background:none !important;'><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" width="100px"/></td>				                				                
		<td align="right"><img class="health_logo_1" src="<?php echo base_url('/assets/images/pdf_logo/fees.png');?>" />
	  </tr>
	  </table>
	  <br>
	 <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
     
    <div style="float:left;width:48%;padding-right:10px;">
     <table width="100%" class="table table-hover tablesorter" cellspacing="2" cellpadding="5">	
	 <tr width="100%">
		<td width="100%">
		    <table class="name_details_health" width="100%" border="1" cellpadding="2" cellspacing="5" style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Name</td> <td width="100%"><?php echo $student_name;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="" align="left" class="left_side">Class</td> <td width="100%"><?php echo $class_name;?></td>
			   </tr>
			   <tr  width="100%">
			      <td width="" align="left" class="left_side">class Teacher </td> <td width="100%"><?php echo $class_teacher;?>	</td>
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
		    <table class="name_details_health" width="100%" border="1" cellpadding="0" cellspacing="0"  style="border-collapse:collapse;">
			   <tr  width="100%">
			      <td width="100%" align="left" class="left_side">Fees Status</td> <td width="100%"><?php echo $fee_status;?></td>
			   </tr>
			   <tr   width="100%">
			      <td width="100%" align="left" class="left_side">Last Incident</td> <td width="100%"><?php echo $incident_date;?></td>
			   </tr>
			   <tr  width="100%">
			   <td></td>
			       <td width="100%" align="" style="color:red;">Balance: KES <?php echo $balance;?></td>
			   </tr>
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  <br>
	   <div style="float:left;width:100%;border-top:1px solid #14a79d;height:20px;"></div>
	   
	  	  
	  <div style="float:left;width:100%;clear:both;"></div>
	 
		<?php 
		$i=1;
		foreach($report as $v) {
			
			$invoice = $v['term_id'];	
			
		?>
	  	 
	   <div style="float:left;width:100%;">
	    <table>
		<tr  width="100%">
			      <td width="100%" align="left" class="left_side"><strong>FEE STRUCTURES</strong></td>
				  
			   </tr>
		</table>	   
     <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="5">	

	 <tr width="100%">
		<td width="100%">
		    <table class="known_all" width="100%" border="0" cellspacing="0" cellpadding="0" >
			   
			   <tr  width="100%">
			      <td width="100%" align="left" class=""><strong>Term <?php echo $i;?></strong></td> 
				  <td width="100%" align="left" class=""><strong>Payment For</strong></td> 
				  <td width="100%" align="center" class=""><strong>&nbsp;&nbsp;</strong></td> 
				  <td width="100%" align="right" class=""><strong>Amount (KES)</strong></td> 
			   </tr>
			   
			   <?php 
			
				$fees = $this->db->get_where('invoice_content' , array('invoice' => $invoice))->result_array();
				$total=0;
				foreach($fees as $fee) {	

					$title = $fee['name'];
					$amount = $fee['amount'];
					$total+=$amount;
				?>
			   
			   <tr  width="100%">
			     <td width="100%" align="left" class=""><strong></strong></td> 
				  <td width="100%" align="left" class=""><?php echo $title;?></td> 
				  <td width="100%" align="left" class=""><strong></strong></td> 
				  <td width="100%" align="right" class=""><?php echo $amount;?></td> 
			   </tr>
			   
				<?php } ?>
			   	   
			    <tr  width="100%" style="background:#f8e5dc;" cellpadding="0" cellpadding="0">
			      <td width="100%" align="left" class="" cellpadding="0" cellpadding="0"><strong></strong></td> 
				  <td width="100%" align="left" class="" cellpadding="0" cellpadding="0"></td> 
				  <td width="100%" align="center" class="" cellpadding="0" cellpadding="0">Total</td> 
				  <td width="100%" align="right" class="" cellpadding="0" cellpadding="0"><strong><?php echo $total;?><strong></td> 
				  
			   </tr>
			   
			</table>
		</td>				                				                
		</tr>
	 </table>
	  </div>
	  
	  <?php } ?>
	     
</div>

 <footer>
 
 
 <table width="100%" class="table table-hover tablesorter" cellspacing="1" cellpadding="10" style="border-top:1px solid #14a79d;">	

	  <tr width="100%">

		<td><br><img class="health_logo" src="<?php echo base_url('/assets/images/pdf_logo/logo.png');?>" /></td>				                				                
		<td align="right"><span> <?php echo date('d M Y');?></span>
	  </tr>
	  </table>
</footer>


<style type="text/css">

</style>