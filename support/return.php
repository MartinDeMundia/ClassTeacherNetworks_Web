<?php 
//session_start(); 
 include_once("dbconn.php"); 
 $subject="";
$subject=mysqli_real_escape_string($con,$_GET['st']);
$form=mysqli_real_escape_string($con,$_GET['f']);
$class=str_replace("","",(mysqli_real_escape_string($con,$_GET['f'])));
$f="";

$qs="SELECT Id  FROM form where Name='$class'";
$results=mysqli_query($con,$qs);
while($rs=mysqli_fetch_assoc($results)){
	
	$f=$rs['Id'];
}



$Stream=mysqli_real_escape_string($con,$_GET['s']);
$year=mysqli_real_escape_string($con,$_GET['y']);
$term=mysqli_real_escape_string($con,$_GET['t']);
$exam=mysqli_real_escape_string($con,$_GET['exam']);
// $form=mysqli_real_escape_string($con,$_GET['form']);
$code=0;
 $qs="SELECT code  FROM subjects where Abbreviation='$subject'";
$results=mysqli_query($con,$qs);
while($rs=mysqli_fetch_assoc($results)){
	
	$code=$rs['code'];
}
$update=0;
$tb="scores";
$exm=strtoupper(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_GET['exam']))));
$query_data_update="SELECT COUNT(*) AS found FROM $tb WHERE Year='$year'  and   Etype='$exam'  and Term='$term' AND code='$code' ";
//echo $query_data_update;
$dataRetrive=mysqli_query($con,$query_data_update);
		while($results_found=mysqli_fetch_assoc($dataRetrive)){
			$update=$results_found['found'];
			
		}
		
		$m="'0'";

?>

<div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
								  <th scope="col">Adm No.</th> 
                                  <th scope="col">Name</th>    <th scope="col">Score</th>
								  <th scope="col">Saved</th>
                              </tr>
                          </thead>
                          <tbody>
						  
						  <?php
						  $score="";
						  if($update > 0){
							  
							   $query="SELECT sudtls.Adm,sudtls.Name,concat(((".$exm."*100)/Limit1),' ',rgrade(((".$exm."*100)/Limit1))) AS Score,Limit1 FROM $tb LEFT JOIN subjectoptionsa ON (subjectoptionsa.Adm=$tb.Adm) LEFT JOIN sudtls ON( sudtls.Adm=$tb.Adm) where $tb.Form='$form' and $tb.Stream='$Stream' and $tb.Year='$year'  and   Etype='$exam'  and $tb.Term='$term' AND subjectoptionsa.code='$code'  
AND $tb.code='$code'
AND subjectoptionsa.Stream='$Stream'
							   ";
							  
						  }else{
						  $query="SELECT sudtls.Adm,sudtls.Name FROM sudtls  WHERE Form='$f' and sudtls.Stream='$Stream' ";
						  }
						  //echo $query;
						  $results=mysqli_query($con,$query);
						  $count=0;
						  while($row=mysqli_fetch_assoc($results)){
							  
							 $count=$count+1  ;
						  if($update > 0){
							  
							  $score=$row['Score'];
							  
						  }
						  $m.=",'".$row['Adm']."'";
						  
						  ?>
						  
						  
                            <tr>
                              <th scope="row"><?php echo $count; ?></th>
							  <td><?php echo $row['Adm']; ?></td>
                              <td><?php echo $row['Name']; ?></td>
                              <td><div class="row form-group">
                            <div class=""><input placeholder="<?php echo ($score); ?>" class="form-control marks" type="text" id="<?php echo $row['Adm']; ?>"></div>
                          </div></td>
                              <td><span style="color:green;" class="ti-cancel" id="save<?php echo $row['Adm']; ?>" ></span></td>
                          </tr>
                          
                          <?php
						  
						  }
						 
                          $query="SELECT Adm,Name from sudtls where Form='$f' and Stream='$Stream' and Adm NOT IN($m)";
						
						 $score=0;
						  $results=mysqli_query($con,$query);
						  $count=0;
						  while($row=mysqli_fetch_assoc($results)){
							  
							 $count=$count+1  ;
						  
						  ?>
						  
						  
                            <tr>
                              <th scope="row"><?php echo $count; ?></th>
							  <td><?php echo $row['Adm']; ?></td>
                              <td><?php echo $row['Name']; ?></td>
                              <td><div class="row form-group">
                            <div class=""><input placeholder="<?php echo $score; ?>" class="form-control marks" type="text" id="<?php echo $row['Adm']; ?>"></div>
                          </div></td>
                              <td><span style="color:green;" class="ti-cancel" id="save<?php echo $row['Adm']; ?>" ></span></td>
                          </tr>
                          
                          <?php
						  
						  }
						  ?>
                      </tbody>
                  </table>
                        </div>