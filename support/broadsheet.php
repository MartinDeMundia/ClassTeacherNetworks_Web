<?php
session_start();
ini_set('max_execution_time', 10000);
if (isset($_SESSION['form'])){
require("dbconn.php");
$title='';
$address='';
$tel='';
$q1s="select description from settings where type='system_title'";
$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$title=$row2s['description'];
	
}

$q1s="select description from settings where type='address'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$address=$row2s['description'];
	
}

$q1s="select description from settings where type='phone'";

$rs=mysqli_query($con,$q1s);
while($row2s=mysqli_fetch_assoc($rs)){
	
	$tel=$row2s['description'];
	
}

?>

	

	


		<?php
include_once("dbconn.php");
//$subjectno=mysqli_real_escape_string($con,$_POST['sn']);
//$f2.Limit1 = 0; 

/*
$form="FORM ".mysqli_real_escape_string($con,$_POST['form']);
$f2="form".mysqli_real_escape_string($con,$_POST['form']);
$Stream=mysqli_real_escape_string($con,$_POST['stream']);
$year=mysqli_real_escape_string($con,$_POST['year']);
$examdate=mysqli_real_escape_string($con,$_POST['year']);
$en=mysqli_real_escape_string($con,$_POST['exam']);
$term=mysqli_real_escape_string($con,$_POST['term']);
$exm=strtolower(str_replace("-","",str_replace(" ","",mysqli_real_escape_string($con,$_POST['exam'])))); */

function process_thread() {
global $subjectno, $con,$cat1,$cat2,$cat3;
global $lmt; 
global $form;
global $f2;
global $Stream;
global $year;
global $examdate;
global $en;
global $term;
global $exm;	

        $processed =0;
        
            If ($Stream =="all") {

                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQryPT = "SELECT  count(*) as c FROM `".$f2."term` WHERE  Year='$year' and Term='$term'";
                        $c13=mysqli_query($con,$strQryPT);
		while($results_found13=mysqli_fetch_assoc($c13)){
			$processed=$results_found13['c'];
			
		}


				}         
                else {
                    If (2==8) {
						
					}
                        
                    else {
                        


                            $strQrytp1 = "SELECT  count(*) as c FROM `".$f2."$exm` WHERE Year='$year' and Term='$term'";
                            $c13aa=mysqli_query($con,$strQrytp1);
		while($results_found13aa=mysqli_fetch_assoc($c13aa)){
			$processed=$results_found13aa['c'];
			
		}

					}


                }
			}
            else {
                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQry20 = "SELECT  count(*) as c FROM `".$f2."term` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
                        $c20=mysqli_query($con,$strQry20);
		while($results_found20=mysqli_fetch_assoc($c20)){
			$processed=$results_found20['c'];
			
		}
                       
			}
                else{
                    If (2==8) {
                       $processed = 0;
                        
                      
					}
						else{
                       $Qry = "SELECT  count(*) as c FROM `".$f2."$exm` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
					   
                            $qr=mysqli_query($con,$Qry);
		while($qqr=mysqli_fetch_assoc($qr)){
			$processed=$qqr['c'];
			
		}
					}


				}
            }




          


            If ($processed > 0) {
				
				
			}
            else
			{

                process_data();

                process_exam();
				task();

			}

            If ($Stream =="all") {
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`  , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `".$f2."term`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' ";





			} else{
                    If (2==8) {
                     
			} else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` , `".$f2."$exm`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."$exm.form='$form' and subno>='$subjectno' ;";
			}
			}


            } else{
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`  , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `".$f2."term`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' and ".$f2."term.Stream='$Stream' ";
			} else {


                    If (2==8) {
                       
			}else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` , `".$f2."$exm`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."$exm.stream='$Stream' and ".$f2."$exm.form='$form' and subno>='$subjectno' ;";
			}
			}

            }
			
		?>
		<div class="spiner-example hidden" id="loader">
                                <div class="sk-spinner sk-spinner-cube-grid">
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                </div>
                            </div>
<div class="row" id="">
	 <div class="col-lg-12">
<div class="ibox" id="ibox2">
                    <div class="ibox-title">
                        <h2>BROAD SHEET -   <?php echo strtoupper($form." ". $Stream." ".$_SESSION['exxm']. " ($term - ". $year. ")"); ?></h2>
                        <div class="ibox-tools">
                            <a href="../PDFS/broadsheet.pdf" id="p rt" download="BROADSHEET - <?php echo strtoupper($form." ". $Stream." ".$_SESSION['exxm']. " ($term - ". $year. ")"); ?>">
                                <i class="fa fa-2x fa-print" ></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">

					<div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
		
		<div class="table-responsive">
                            <table class="table table-bordered dataTables-example"  style="font-size:11px; color:;">
                              <thead>
                                <tr>
                                  <th scope="col">RNK</th>
								  <th scope="col">ADM</th> 
                                  <th scope="col">NAME</th>   
								  <th scope="col">FORM</th>
								  <th scope="col">STREAM</th>
								   <th scope="col">POS</th>
								   <th scope="col">TOTAL</th>
								  <th scope="col">MS</th> 
                                  <th scope="col">(%)</th>   
								  <th scope="col">MG</th>
								  <th scope="col">V/A</th>
								  <?php
								  $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  ?><th scope="col"><?php echo $sr['subs']; ?></th>
						   <?php
						  
						  }
						  ?>
                              </tr>
                          </thead>
                          <tbody>
						  
						  <?php
					  
 $qq=mysqli_query($con,$q1);
 $score="";
 $pv =0;
 
		while($rs=mysqli_fetch_assoc($qq)){	
		 $pm="";
			$_SESSION['progress_text']='Loading';
			$_SESSION['out']=0;	
$pv+=1;			
$_SESSION['progress']=$pv;
$va=0;
		if(($rs['POINTS']-$rs['kcpe'])<0) { $pm= "+"; $va= ($rs['POINTS']-$rs['kcpe'])*-1;} else{$pm= "-";$va= ($rs['POINTS']-$rs['kcpe']);} 
						  ?>
						    <tr>
                              <th scope="row"><?php echo $rs['PosClass']; ?></th>
							  <td><?php echo $rs['adm']; ?></td>
                              <td><?php echo $rs['Name']; ?></td>
							  <td><?php echo $rs['Form']; ?></td>
                              <td><?php echo $rs['Stream']; ?></td>
							  <td><?php echo $rs['PosStream']; ?></td>
							  
                              <td><?php echo round($rs['TotalMarks'],2); ?></td>
							  <td><?php echo round($rs['TotalScore'],2); ?></td>
                              <td><?php echo round($rs['TotalPercent'],2); ?></td>
							  <td><?php echo $rs['Grade']; ?></td>
                              <td><?php echo $pm.' '.$va; ?></td><?php
                              $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			$qsc="SELECT CONCAT((TotalScore),' ',gradingscale.grade) as TotalScore,PosStream  FROM $exm left join gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX) WHERE adm='".$rs['adm']."' AND SUBJECT='".$sr['subs']."' AND $exm.term='$term' AND year='$year' ";
			$score="";
			$pos="";
			
								  $sc=mysqli_query($con,$qsc);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=$ss['TotalScore'];
						$pos=$ss['PosStream'] ; 
		}
		?>
			<td scope="col"><?php echo round($score,2); ?><sub><?php if($pos !=="") echo " (".$pos.")" ;?></sub></td><?php
						  }
						  ?>
                          </tr>
                          
                          <?php
						  
						  }
						  ?>
                          
                      </tbody>
                  </table>
                        </div>
						</div></div></div>
						<!-- Footer -->

    	</div>
						</div>
    
    
    


						
						<?php
		
			

         
 } 

function tcheckeData() {
global $subjectno, $con,$cat1,$cat2,$cat3;
global $lmt; 
global $form;
global $f2;
global $Stream;
global $year;
global $examdate;
global $en;
global $term;
global $exm;	

        $processed =0;
        
            If ($Stream =="all") {

                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQryPT = "SELECT  count(*) as c FROM `".$f2."term` WHERE  Year='$year' and Term='$term'";
                        $c13=mysqli_query($con,$strQryPT);
		while($results_found13=mysqli_fetch_assoc($c13)){
			$processed=$results_found13['c'];
			
		}


				}         
                else {
                    If (2==8) {
						
					}
                        
                    else {
                        


                            $strQrytp1 = "SELECT  count(*) as c FROM `".$f2."$exm` WHERE Year='$year' and Term='$term'";
                            $c13aa=mysqli_query($con,$strQrytp1);
		while($results_found13aa=mysqli_fetch_assoc($c13aa)){
			$processed=$results_found13aa['c'];
			
		}

					}


                }
			}
            else {
                If ($exm =="all") {
                    $processed = 0;
                   


                        $strQry20 = "SELECT  count(*) as c FROM `".$f2."term` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
                        $c20=mysqli_query($con,$strQry20);
		while($results_found20=mysqli_fetch_assoc($c20)){
			$processed=$results_found20['c'];
			
		}
                       
			}
                else{
                    If (2==8) {
                       $processed = 0;
                        
                      
					}
						else{
                       $Qry = "SELECT  count(*) as c FROM `".$f2."$exm` where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";
					   
                            $qr=mysqli_query($con,$Qry);
		while($qqr=mysqli_fetch_assoc($qr)){
			$processed=$qqr['c'];
			
		}
					}


				}
            }




          


            If ($processed > 0) {
			}
            else
			{

                term();
                rankterm();
				

			}

              If ($Stream =="all") {
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent` , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, (`sudtls`.`kcpe` -`".$f2."term`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' ";





			} else{
                    If (2==8) {
                     
			} else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,(`sudtls`.`kcpe`- `".$f2."$exm`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."$exm.form='$form' and subno>='$subjectno' ;";
			}
			}


            } else{
                If ($exm =="all") {
                    $q1 = "SELECT kcpe,`".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`, `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`,(`sudtls`.`kcpe` -`".$f2."term`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' and ".$f2."term.Stream='$Stream' ";
			} else {


                    If (2==8) {
                       
			}else{
                        $q1 = "SELECT kcpe,`".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,(`sudtls`.`kcpe` -`".$f2."$exm`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."$exm.stream='$Stream' and ".$f2."$exm.form='$form' and subno>='$subjectno' ;";
			}
			}

            }
		//echo $q1;
			?>
			<div class="spiner-example hidden" id="loader">
                                <div class="sk-spinner sk-spinner-cube-grid">
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                </div>
                            </div>
<div class="row" id="mr">
	 <div class="col-lg-12">
<div class="ibox">

<div class="ibox-title">
                         <h2>BROAD SHEET -   <?php echo strtoupper($form." ". $Stream." ".$_SESSION['exxm']. " ($term - ". $year. ")"); ?></h2>
                        <div class="ibox-tools">
                            <a href="../PDFS/broadsheet.pdf" id="p rt" download="BROADSHEET -  <?php echo strtoupper($form." ". $Stream. " ".$_SESSION['exxm']." ($term - ". $year. ")"); ?>">
                                <i class="fa fa-2x fa-print" ></i>
                            </a>
                            
                        </div>
                    </div>

                  
                    <div class="ibox-content">
		<div class="table-responsive">
                            <table class="table table-bordered dataTables-example" style="font-size:12px; color:;">
                              <thead>
                                <tr>
                                  <th scope="col">RNK</th>
								  <th scope="col">ADM</th> 
                                  <th scope="col">NAME</th>   
								  <th scope="col">FORM</th>
								  <th scope="col">STREAM</th>
								   <th scope="col">POS</th>
								   <?php if ($_SESSION['c1']=="True"){?>
								   <th scope="col">CAT 1</th>   <?php }?>
								 <?php if ($_SESSION['c2']=="True"){?>
								   <th scope="col">CAT 2</th>   <?php }?>
								   <?php if ($_SESSION['c3']=="True"){?>
								   <th scope="col">CAT 3</th>   <?php }?>
								  <th scope="col">END TERM</th>
								   <th scope="col">TOTAL</th>
								  <th scope="col">MS%</th>    
								  <th scope="col">MG</th>
								  <th scope="col">V/A</th>
								  <?php
								  
								  $qs="SELECT concat(UPPER(Abbreviation),' (',code,')') AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  ?><th scope="col"><?php echo $sr['subs']; ?></th>
						   <?php
						  
						  }
						  ?>
                              </tr>
                          </thead>
                          <tbody>
						  
						  <?php
		
 $qq=mysqli_query($con,$q1);
 $score="";
 $tt=0;
 $pv=0;
 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
		while($srcv=mysqli_fetch_assoc($subsc1)){
			 $tt=$srcv['sc'];
		}
		while($rs=mysqli_fetch_assoc($qq)){
			 $pm="";
							  $va=0;
							  
					$_SESSION['progress_text']='Loading';
			$_SESSION['out']=0;	
$pv+=1;			
$_SESSION['progress']=$pv;		  
							  
		if(($rs['POINTS']-$rs['kcpe'])<0) { $pm= "+"; $va= ($rs['POINTS']-$rs['kcpe'])*-1;} else{$pm= "-";$va= ($rs['POINTS']-$rs['kcpe']);} 
			  ?>
						    <tr>
                               <th scope="row"><?php echo $rs['PosClass']; ?></th>
							  <td><?php echo $rs['adm']; ?></td>
                              <td><?php echo $rs['Name']; ?></td>
							  <td><?php echo $_SESSION['form']; ?></td>
                              <td><?php echo $rs['Stream']; ?></td>
							  <td><?php echo $rs['PosStream']; ?></td>	
<?php if ($_SESSION['c1']=="True"){?>
								    <td><?php echo round($rs['CAT1'],2); ?></td>   <?php }?>
								 <?php if ($_SESSION['c2']=="True"){?>
								   <td><?php echo round($rs['CAT2'],2); ?></td>   <?php }?>
								   <?php if ($_SESSION['c3']=="True"){?>
								   <td><?php echo round($rs['CAT3'],2); ?></td>   <?php }?>							  
							 
                              
							  
							  <td><?php echo round($rs['ENDTERM'],2); ?></td>
                              <td><?php echo round($rs['TotalMarks'],2); ?></td>
							  <td><?php echo round($rs['TotalPercent'],2); ?></td>
							  <td><?php echo $rs['Grade']; ?></td>
                              <td><?php echo $pm.' '.$va;  ?></td><?php
							   
							  
                             for($i=1;$i<=$tt;$i++){
			$qsc1="SELECT CONCAT(SUM(S".$i."),' ' ,rgrade(SUM(S".$i."))) AS TotalScore FROM subscores  WHERE adm='".$rs['adm']."' AND subscores.term='$term' AND year='$year' ";
			$score="";
			$pos="";
			//echo $qsc1;
								  $sc=mysqli_query($con,$qsc1);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=$ss['TotalScore'];
		}
		?>
			<td scope="col"><?php echo round($score,2); ?><sub><?php if($pos !=="") echo " (".$pos.")" ;?></sub></td><?php
						  }
						  ?>
                          </tr>
                          
                          <?php
						  
						  }
						  ?>
                          
                      </tbody>
                  </table>
                        </div>
						</div></div></div>
						<!-- Footer -->

    	</div>
						
    
    
    


						
						<?php
		
			
			
         
 } 

function main() {
$zero = 0;
global $subjectno, $con,$cat1,$cat2,$cat3;
global $lmt; 
global $form;
global $f2;
global $Stream;
global $year;
global $examdate;
global $en;
global $term;
global $exm;


    
 If ($exm =="all") {
				  If ($Stream =="all") {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."term` where Year='$year' and Term='$term'and form='$form'";
				 } else {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."term` where Year='$year' and stream ='$Stream' and  Term='$term' and form='$form'";
 }
				}
                else {
					  If ($Stream =="all") {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."$exm` where Year='$year' and Term='$term'and form='$form'";
				 } else {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."$exm` where Year='$year' and stream ='$Stream' and  Term='$term' and form='$form'";
 }

                }

          
            $r1cc=mysqli_query($con,$strQry);
		while($results1cc=mysqli_fetch_assoc($r1cc)){


                $zero = $results1cc['results'];
		}

            If ($zero <= 0) {
               ?>
				<script>
				$(document).ready(function() {
					swal({
						title: 'INFORMATION',
						text: 'No results found for <?php echo $form.' '. $en; ?>',
						type: 'warning'
					});
				});
				</script>
				<img class="hidden" src="uploads/preloader.gif" ><span class="hidden" width="100%" height="100%">Please wait.. ready in a few</span>
				
				<div class="spiner-example hidden" id="loader">
                                <div class="sk-spinner sk-spinner-cube-grid">
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                </div>
                            </div>
				
				<?php
            } else {

                If ($exm =="all") {
					grading();
                      tcheckeData();
				}
                else {
					task();
                    process_thread();

                }
			}
    }
if (isset($_SESSION['en'])){
$subjectno=0;
$lmt = 0; 
$form=$_SESSION['form'];
$f2=$_SESSION['f2'];
$Stream=$_SESSION['Stream'];
$year=$_SESSION['year'];
$examdate=$_SESSION['examdate'];
$en=$_SESSION['en'];
$term=$_SESSION['term'];
$exm=$_SESSION['exm'];
$cat1 = $_SESSION['c1'];
$cat2 = $_SESSION['c2'];
$cat3 = $_SESSION['c3'];
main();
}
else{ echo "No results found";
	?>
	<div class="spiner-example hidden" id="loader">
                                <div class="sk-spinner sk-spinner-cube-grid">
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                    <div class="sk-cube"></div>
                                </div>
                            </div>	
<?php
}}
?>

<script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: false,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'broadsheet'},
                    {extend: 'pdf', title: 'broadsheet',pageSize: 'A4',orientation: 'landscape'},

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