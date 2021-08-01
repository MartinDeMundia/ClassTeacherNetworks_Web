<?php

$subject=$subject1;
$form=$form1;
$school_id=$this->session->userdata('school_id');
$stream=strtolower($stream1);
$year=$year1;
$examdate=$year1;
$en=$exam1;
$term=$term1;      
$exm=strtolower(str_replace("-","",str_replace(" ","",$exam1)));

$f="";
$qs="SELECT Id  FROM form where Name='$form'";
$results=$this->db->query($qs)->result_array();
foreach($results as $rs):
	
	$f=$rs['Id'];
endforeach;


$limit=0;
$divv='';
if($en=="END OF TERM")
{
	
	
	
	$exm="ve";
}else{
	
	$equery = "SELECT limit1 FROM scores WHERE  form='".$form."' and term='$term' and year='$year' and Etype='$en' limit 1";

	$r=$this->db->query($equery)->row()->limit1;
	$limit=$r;
	$divv=' / '.$r;
	
	
}
			  
						  ?>

<div class="table-responsive">
		<span width="100%" height="100%"></span>
						  <table class="table table-bordered dataTables-example" style="font-size:12px; color:; border-collapse=collapse" id="mr">
						  <thead>
						  <tr>
							  <?php 
							  $name=$this->db->get_where("school", array('school_id'=>$this->session->userdata('school_id')))->row()->school_name;
							  $address=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->address;
							  $telephone=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->phone;
							  $location=$this->db->get_where("principal", array('school_id'=>$this->session->userdata('school_id')))->row()->county;							
							  $school_image = $this->crud_model->get_image_url('school',$school_id);

							  ?>
							   <th colspan="10" > 
							   <center>
							<!--    <img src="<?php echo base_url();?>uploads/logo.png" width=70 height=70> -->
							  <img class="health_logo" src="<?php echo ($school_image !='')?$school_image:base_url('/uploads/logo.png');?>" width="100%" >
							   <br>
							   <?php echo $name; ?>
							   <br>
							   <?php echo $address; ?>
							   <br>
							   <?php echo $location; ?>
							   <br>
							   <?php echo $telephone; ?>
							   </center>
							   </th>
							  </tr>
						  <tr>
						  <th>#</th>
								 <th>ST</th> 
                                 <th>ADM</th>   
								 <th>NAME </th>
								 <th>RANK </th>
								 <th>POSITION </th>
								  <th>SCORE <?php echo $divv; ?></th>
								     <th>%</th>
								    <th>GRADE</th>
						  </tr></thead>
<?php
						 if(strtolower($stream)=="all"){
							 $query= $this->db->get_where("sudtls",array("Form"=>$f,"school_id"=>$school_id))->result_array();
						 }else{
							 $query= $this->db->get_where("sudtls",array("Form"=>$f,"Stream"=>$stream,"school_id"=>$school_id))->result_array();
						 }
						 
						  $NUM=0;
						 foreach($query as $row):
							  $NUM+=1;
							  $qs="SELECT Code  FROM subjects where Abbreviation='$subject' and school_id='$school_id'";
								  $code=$this->db->query($qs)->row()->Code;
								  ?>
								  <tbody>
								  <tr>
								 <td><?php echo $NUM ; ?></td>
								  <td> <?php echo substr($row['Stream'],0,1) ; ?></td> 
                                  <td> <?php echo $row['Adm'] ; ?></td>   
								  <td><?php echo $row['Name'] ; ?></td>
								  
								  <?php
					if($en=="END OF TERM"){
						 
						
					}else {
			 $qs1="SELECT TotalScore AS count,PosStream,PosClass,Grade   FROM $exm where Adm='".$row['Adm']."' and code='$code' and  term='$term' and year='$year'  and school_id='$school_id' order by adm desc";
					}
		$subs1=$this->db->query($qs1)->result_array();
		$res=0;
		$lmt=0;
		$p=0;
		$div='';
		$mult=1;
		foreach($subs1 as $sr2):
			
						  $res=$sr2['count'];
						  if($en=="END OF TERM"){
							  $lmt=1;
						  }else{
						  $lmt=$limit;
						  $div='/'.$lmt.'';
						  $mult=100;
						  }
						 
						 endforeach;
						  if($res>=1){
							  $p=($res/$lmt)*$mult;
							  ?>
							  <td><?php echo $sr2['PosClass'] ; ?></td>
								  <td><?php echo $sr2['PosStream'] ; ?></td>
						  <td><?php echo round($res,0) ; ?></td>
						   <td><?php echo round($p,0)  ; ?></td>
						   <?php
						  
		?>
						  <td><?php echo $sr2['Grade']  ; ?></td>
						  <?php
						  }else{
							  ?>
							  <td><?php echo ''  ; ?></td>
							   <td><?php echo '-' ; ?></td>
							  <td><?php echo '-'  ; ?></td>
							  <td><?php echo '-'  ; ?></td>
							  
							  <?php
						  }
						  
						?>
						</tr> <?php
						 endforeach;
					
	?>
	</tbody>
	</table>
	</div>
	</div>
	