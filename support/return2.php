<?php 
  $lmt=0;
 include_once("dbconn.php");
$subject=mysqli_real_escape_string($con,$_GET['st']);
$form='Form '.mysqli_real_escape_string($con,$_GET['f']);
$f=mysqli_real_escape_string($con,$_GET['f']);
$Stream=mysqli_real_escape_string($con,$_GET['s']);
$year=mysqli_real_escape_string($con,$_GET['y']);
$term=mysqli_real_escape_string($con,$_GET['t']);
$exam=mysqli_real_escape_string($con,$_GET['exam']);
// $form=mysqli_real_escape_string($con,$_GET['form']);
 $qs="SELECT code  FROM subjects where Abbreviation='$subject'";
$results=mysqli_query($con,$qs);
while($rs=mysqli_fetch_assoc($results)){
	
	$code=$rs['code'];
}
$update=0;
$tb=strtolower(str_replace(" ","",$form));
$exm=strtoupper(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_GET['exam']))));
$query_data_update="SELECT COUNT(*) AS found FROM $tb WHERE Year='$year'  and   Etype='$exam'  and Term='$term' AND code='$code' ";

$dataRetrive=mysqli_query($con,$query_data_update);
		while($results_found=mysqli_fetch_assoc($dataRetrive)){
			$update=$results_found['found'];
			
		}
		
		$m="'0'";

?>


						  
						  <?php
						
						  if($update > 0){
							  
							   $query="SELECT Limit1,sudtls.Adm,Name,concat(((".$exm."*100)/Limit1),' ',rgrade(((".$exm."*100)/Limit1))) AS Score,Limit1 FROM sudtls LEFT JOIN $tb ON( $tb.Adm=sudtls.Adm) where $tb.Form='$form' and $tb.Stream='$Stream' and $tb.Year='$year'  and   Etype='$exam'  and $tb.Term='$term' AND code='$code' limit 1";
							  
						  }else{
						  $query="SELECT Adm,Name from sudtls where Form='$f' and Stream='$Stream' limit 1";
						  }
						 
						  $results=mysqli_query($con,$query);
						  $count=0;
						  while($row=mysqli_fetch_assoc($results)){
							  
							 $count=$count+1  ;
						  if($update > 0){
							  
							  $lmt=$row['Limit1'];
							  
						  }
						  $m.=",'".$row['Adm']."'";
						   //echo $m  .'  '.$update;
						  ?>
						  
						  
                            
                          
                          <?php
						  
						  }
						 
                          $query="SELECT Adm,Name from sudtls where Form='$f' and Stream='$Stream' and Adm NOT IN($m) limit 1";
						
						 $score=0;
						  $results=mysqli_query($con,$query);
						  $count=0;
						  while($row=mysqli_fetch_assoc($results)){
							  
							 $count=$count+1  ;
						  
						  ?>
						  
						  <div class="col "><input placeholder="30" value="<?php echo $lmt; ?>" class="form-control" type="text" id="limit"/></div>
                          
                          <?php
						  
						  }
						  ?>
                     