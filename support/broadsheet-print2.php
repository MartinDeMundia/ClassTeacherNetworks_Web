<?php
session_start();

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


		
include_once("dbconn.php");

function task() {
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
        If (strtoupper($exm) == "ENDTERM") {
            grading();
        }

        
            $s = 0;

            $strQryt1 = "SELECT  concat(Abbreviation) as subjecta , Abbreviation,code FROM subjects order by code asc";
            $result = $con->query($strQryt1);
            while($row = $result->fetch_assoc()) {
        
                $subject = $row['subjecta']. "(".$row['code'].")";
                $ss = $row['Abbreviation'];
                $s += 1;
                $p = 0;
                
                    $sql1 = "UPDATE subscores SET S". $s." = '$subject' where id=1";

                    if ($con->query($sql1) === TRUE) {
						//echo "New record created successfully";
					} else { 
								
								//echo "New record  1 $sql1";
								}

                
                    $sql2 = "SELECT  adm,CONCAT((TotalScore)) AS TotalScore  ,gradingscale.grade FROM ".$exm." LEFT JOIN gradingscale ON (TotalPercent>=MIN AND TotalPercent<=MAX)   WHERE ".$exm.".subject='$ss' ORDER BY CODE asc";
                    $result1 = $con->query($sql2);
					
            while($row1 =mysqli_fetch_assoc($result1)) {

                        $ts = ($row1['TotalScore']. " ".$row1['grade']);
                        $adm = $row1['adm'];

                        $count = 0;
                        $p += 1;


                        
                            $sql3 = "SELECT  count(*) as c  FROM ".$exm." where term='$term'  and subject='$ss'";
                             $result2 = $con->query($sql3);
            while($row2 = $result2->fetch_assoc()) {
                                $count2 = $row2['c'];
			}




                        $sql4 = "SELECT  count(*) as c  FROM subscores where adm='$adm' and term='$term' and exam='$exm'";
                            $result2a = $con->query($sql4);
            while($row2a = $result2a->fetch_assoc()) {
                                $count = $row2a['c'];
			}
                               
                        If ($count >= 1) {

                                $sql5 = "UPDATE subscores SET S".$s." = '$ts', adm=$adm where term='$term' and exam='$exm' and adm='$adm'";

                                if ($con->query($sql5) === TRUE) {
						//echo "New record created successfully 2";
								} else { 
								
								//echo "New record  2 ";
								}
                        }    
                        else {

                          
                                $sql6 = "insert into subscores(S".$s.",adm,term,exam,year) values('$ts','$adm','$term','$exm','$year')";

                                if ($con->query($sql6) === TRUE) {
						//echo "New record created successfully 3";
								} else { 
								
								//echo "New record  3 ";
								}
                        }

			}
                    
                $p += 1;
                

}
            
       
            $sql7 = "UPDATE c SET  rpt='True'";

            if ($con->query($sql7) === TRUE) {
						//echo "New record created successfully 4";
								}
}

function grading() {
	
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
	   $count3 = 0;
        $strQryg1 = "SELECT  count(*) as c  FROM subscores2 where  term='$term' and year='$year'";
            $rg1=mysqli_query($con,$strQryg1);
		while($rs1=mysqli_fetch_assoc($rg1)){
                $count3 = $rs1['c'];
		}
//echo $count3;
        If ($count3 <= 0) {


            $sg1  = "INSERT INTO subscores2(adm,s1,s2,s3,s4,s5,s6,s7,s8,s9,s10,s11,s12,s13,s14,s15,s16,s17,s18,term,year) SELECT  adm,SUM(s1) AS s1,SUM(s2) AS s2,SUM(s3) AS s3 ,SUM(s4) AS s4 ,SUM(s5) AS s5,SUM(s6) AS s6,SUM(s7) AS s7,SUM(s8) AS s8,SUM(s9) AS s9,SUM(s10) AS s10,SUM(s11) AS s11,SUM(s12) AS s12,SUM(s13) AS s13,SUM(s14) AS s14,SUM(s15) AS s15,SUM(s16) AS s16,SUM(s17) AS s7,SUM(s18) AS s18,term,year FROM subscores WHERE Term='$term' AND YEAR='$year' GROUP BY adm";


               
                   if (mysqli_query($con,$sg1))
                                 {
                                    //echo "Rank $strQry4";

                                } else { 
								
								/////echo "failed";
								}
                


           




					}
		}

function rank() {
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
      $posf  = False;
        $poss  = False;
        $code  = 0;
        $pos2  = 0;
        $adm  = 0;
        $score  = 0;
        $id  = 0;
        $count  = 0;
        $subq  = "";
        $subject  = "";
       
        $pvv  = 0;
 
       
            If ($Stream =="all") {

                $subq = "Select count(*) as c from  $exm where Year='$year' and Term='$term' and form='$form' order by TotalPercent desc";


            } else {

                $subq = "Select count(*) as c  from  $exm where Year='$year' and Term='$term' and stream='$Stream' and form='$form' order by TotalPercent desc";
            }

              $c=mysqli_query($con,$subq);
		while($results_found=mysqli_fetch_assoc($c)){
			$count=$results_found['c'];
			
		}

          //END OF COUNT






       
            $strQry1 = "SELECT DISTINCT Stream from  $exm Where Year='$year' ";
            $r1=mysqli_query($con,$strQry1);
		while($results1=mysqli_fetch_assoc($r1)){
                $pos = 0;
                $pos2 = 0;

                $strQry2 = "SELECT DISTINCT SUBJECT from  $exm Where Year='$year' ";
               $r2=mysqli_query($con,$strQry2);
		while($results2=mysqli_fetch_assoc($r2)){
                    $pos = 0;
                    $pos2 = 0;
                    $subject = $results2['SUBJECT'];
					$tie3=0;
                    $query = "Select Adm,subject,Code,TotalScore as Score,ROUND(TotalPercent,1) as ' Score(%)',grade,posclass,posstream  from  $exm where Year='$year' and Term='$term'and form='$form'  and subject='$subject' order by TotalPercent desc";
                    $r3=mysqli_query($con,$query);
		while($results3=mysqli_fetch_assoc($r3)){
                       
                            $adm = $results3['Adm'];
                            $code = $results3['Code'];
                            //$id = $results3['Id'];
							
                            If ($tie3 == $results3['Score'] ) {

                            } else {
                                If ($pos < $pos2 ) {
                                    $pos = $pos2;
                                }
                                $pos += 1;
                                $tie3 == $results3['Score'];
                            }
                            $pos2 += 1;
                            $pvv += 1;

                         


                                $strQry4 = "UPDATE  $exm SET posclass=$pos  WHERE Year='$year' and Term='$term' and form='$form' and adm='$adm' and code='$code'  ";

                               if (mysqli_query($con,$strQry4))
                                 {
                                    //echo "Rank $strQry4";

                                } 
                                


                           




					}
					/*
					PROGRESS VALUE
                        Dr.Close()
                        //dbconn.Close()
                        ProgressBarAdv1.Value = (pvv / count) * 100
                        ProgressBarAdv1.Text = "Processing Class Rank$subject $Math.Round((pvv / count) * 100, 0)%"
                        If (ProgressBarAdv1.Value = 100 ) {
                            ProgressBarAdv1.Text = "Processing completed successifuly"
                        }
*/




			}
                

 }
            

        //=============END FORM $pos===================
        $pv  = 0;
        $tie = 0;
        $stream  = "";
  
            $strQry1a = "SELECT DISTINCT Stream from  $exm Where Year='$year'";
             $r1a=mysqli_query($con,$strQry1a);
		while($results1a=mysqli_fetch_assoc($r1a)){
                $pos = 0;
                $pos2 = 0;
                $stream = $results1a['Stream'];

                $strQry2a = "SELECT DISTINCT SUBJECT from  $exm Where Year='$year'";
                $r2a=mysqli_query($con,$strQry2a);
			while($results2a=mysqli_fetch_assoc($r2a)){
                    $pos = 0;
                    $pos2 = 0;
                    $subject = $results2a['SUBJECT'];
					$tie2 =0;
                    $querya = "Select Adm,subject,Code,ROUND(TotalScore,0) as Score,ROUND(TotalPercent,1) as ' Score(%)',grade,posclass,posstream  from  $exm where Year='$year' and Term='$term' and stream='$stream' and form='$form'  and subject='$subject' order by TotalPercent desc";

						$r3a=mysqli_query($con,$querya);
				while($results3a=mysqli_fetch_assoc($r3a)){
                       
                            $adm = $results3a['Adm'];
                            $code = $results3a['Code'];
                            $pv += 1;
							
                            If ($tie2 == $results3a['Score']) {
                            } else {
                                If ($pos < $pos2 ) {
                                    $pos = $pos2;
                                }
                                $pos += 1;
                                $tie2 = $results3a['Score'];
                            }
                            $pos2 += 1;
                          


                                $strQry4a = "UPDATE  $exm SET posstream='$pos'  WHERE Year='$year' and  Term='$term' and form='$form' and adm='$adm' and code='$code' ";

                                  

                               if (mysqli_query($con,$strQry4a))
                                 {
                                    //echo "Pos  $strQry4a";

                                }else{
                                    //echo "Pos e  $strQry4a";

                                }
				}
			}
		
		}
           
		
 }

function process_data(){
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
       


          
            $strQry1cc = "SELECT limits FROM examresults WHERE  ExamDate='$year' and   Term='$term' and  form='$form' and  Examtype='$en' limit 1";
          
            $r1cc=mysqli_query($con,$strQry1cc);
		while($results1cc=mysqli_fetch_assoc($r1cc)){


                $lmt = $results1cc['limits'];
		}
      

             $s = "INSERT INTO $exm(Year,Form,Stream,Grade,TotalScore,TotalPercent,Adm,CODE,term,SUBJECT)  SELECT Year,$f2.Form,$f2.Stream,Grade,($f2.$exm ),((($f2.$exm )/$f2.Limit1))*100 AS percentage,$f2.Adm,$f2.Code,$f2.term,subjects.abbreviation FROM $f2 RIGHT JOIN subjects ON subjects.code=$f2.code  LEFT JOIN gradingscale ON (((($f2.$exm )/$f2.Limit1))*100>= gradingscale.Min AND (((($f2.$exm )/$f2.Limit1))*100) <= gradingscale.Max) WHERE $f2.Year='$year' and $f2.term='$term' AND etype='$en'  ORDER BY $exm DESC";

           
            if (mysqli_query($con,$s))
                                 {
                                    echo "Processing $en <html><br><br></html>";
								rank();
                                }
								else{
									echo $s;
									echo "processing". strtoupper($en) ."Failed <html><br><br></html>";
								}

            
       
}

function process_exam() {
        $adm  = 0;
        $suc  = 0;
        $id  = 0;
        $pv  = 0;
        $count  = 0;
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
       

       
            $strQry1c = "select COUNT(DISTINCT adm) as c  from $exm  where Year='$year' ";
            $r1c=mysqli_query($con,$strQry1c);
		while($results1c=mysqli_fetch_assoc($r1c)){



                $count = $results1c['c'];

		}
          



        
            $strQry2c = "SELECT DISTINCT adm from  $exm where Year='$year'";
            $r2c=mysqli_query($con,$strQry2c);
		while($results2c=mysqli_fetch_assoc($r2c)){
                $adm = $results2c['adm'];
                $pv += 1;




                $queryc = "SELECT adm, COUNT(DISTINCT SUBJECT) AS COUNT FROM $exm where adm='$adm' and Year='$year'";



                


                    $r3c=mysqli_query($con,$queryc);
		while($results3c=mysqli_fetch_assoc($r3c)){

                        $suc = $results3c['COUNT'];
                        $id = $results3c['adm'];
                        
                        


                            $strQry4c = "UPDATE  $exm SET subno=$suc  WHERE  adm='$id' and Year='$year'";
                            if (mysqli_query($con,$strQry4c))
                                 {
                                    //echo "Subject sorting <html><br><br></html>";

                                }else{ //echo "Subject sorting failed<html><br><br></html>";
								}
                        
                        

		}
                   







            }
            






            $s2  = "INSERT INTO $f2$exm (Year,subno,TotalMarks,Adm,Term,Stream,TotalScore,TotalPercent,Form)  SELECT Year,subno,ROUND(SUM(TotalPercent)),adm,Term,Stream,ROUND(AVG(TotalScore)),ROUND(AVG(TotalPercent)) ,Form from $exm WHERE term='$term' and Year='$year' and form='$form' GROUP BY adm ";
            if (mysqli_query($con,$s2))
                                 {
                                    echo "Processing exam completed succesifully<html><br><br></html>";

                                }else{echo "Processing exam failed<html><br><br></html>";}

            rankexam();
        } 
 
function rankexam()	{
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
        $posf = False;
        $poss = False;
        $code = 0;
        $pos2 = 0;
        $adm = 0;
        $score = 0;
        $id = 0;
        $count = 0;
        $count2 = 0;
        $subq = "";
        $subject = "";
        $marks  = 0;
        $grade = "";
        $pvv = 0;
        $points = 0;
       
            $subq3a = "Select count(*) as c from $f2$exm  where Year='$year' and Term='$term' and form='$form' ";
				 $c3=mysqli_query($con,$subq3a);
		while($results_found3=mysqli_fetch_assoc($c3)){
			
                $count = $results_found3['c'];

		}
           

            $subq3 = "Select count(*) as c  from $f2$exm  where Year='$year' and Term='$term' and stream='$Stream' and form='$form' ";


          

           $c3a=mysqli_query($con,$subq3);
		while($results_found3a=mysqli_fetch_assoc($c3a)){
			
                $count2 = $results_found3a['c'];

		}
           



       




        $query3 = "Select Adm,TotalScore as Score,TotalPercent   from $f2$exm  where Year='$year' and  Term='$term'and form='$form'  ";
      

            
            $r3cc=mysqli_query($con,$query3);
		while($results3cc=mysqli_fetch_assoc($r3cc)){
                $pvv += 1;
                $adm = $results3cc['Adm'];
               
                $marks =  $results3cc['TotalPercent'];
				
               
                    $strQry4cc = "SELECT grade,points  from gradingscale where $marks<= Max AND $marks>= Min ";
                   $r3cc1=mysqli_query($con,$strQry4cc);
			while($results3cc1=mysqli_fetch_assoc($r3cc1)){


                        $points = $results3cc1['points'];
                        $grade = $results3cc1['grade'];

			}
		


              


                    $strQry5cc = "UPDATE $f2$exm  SET grade='$grade',points=$points  WHERE  Year='$year' and  Term='$term' and form='$form' and adm='$adm'  ";

                   if (mysqli_query($con,$strQry5cc))
                                 {
                                   // echo "Updating grades completed successifuly <html><br><br></html>";

                                }else{
                                    echo "Updating grades failed<html><br><br></html>";

                                }


               

               


		}
            








        //=============END GRADING===================

        //============START STREAM RANKING================

        $pv = 0;
        $tie = 0;
        $stream = "";
       
            $strQry12 = "SELECT DISTINCT Stream from  $f2$exm  where Year='$year' ";
            $r12=mysqli_query($con,$strQry12);
		while($results13=mysqli_fetch_assoc($r12)){
                $subject = $results13['Stream'];

                $pos = 0;
                $pos2 = 0;

$tie =0;
                $query12 = "Select Adm,TotalMarks,TotalScore as Score,TotalPercent   from $f2$exm  where  Year='$year' and  subno>='$subjectno' and stream='$subject' and Term='$term'and form='$form'  order by TotalPercent desc";



               
						$r12a=mysqli_query($con,$query12);
					while($results13a=mysqli_fetch_assoc($r12a)){
                        $adm = $results13a['Adm'];
                        $marks = $results13a['TotalMarks'];
                       
                        $pv += 1;
                        If ($tie == $results13a['TotalMarks']) {
							
							//echo $results13a['TotalMarks'];
						}

                        else{
                            If ($pos < $pos2){
                                $pos = $pos2;
					}
                            $pos += 1;
                            $tie = $results13a['TotalMarks'];
					}
                        $pos2 += 1;
                       

                            $strQry_U = "UPDATE  $f2$exm  SET posstream=$pos  WHERE  Year='$year' and  subno>='$subjectno' and Term='$term' and form='$form' and adm='$adm'and Stream='$subject'";

                           if (mysqli_query($con,$strQry_U))
                                 {
                                  //  echo "Stream sorting completed <html><br><br></html>";

                                }
                       

					}
                   







			}
           

        //============END STREAM RANKING==================

        //=========START FORM RANKING==============
        $pos2 = 0;
        $pos = 0;
        
            

$tie =0;

            $queryf = "Select Adm,TotalMarks,TotalScore as Score,TotalPercent   from $f2$exm  where  Year='$year' and  subno>='$subjectno' and  Term='$term'and form='$form'  order by TotalPercent desc";


					$r12af=mysqli_query($con,$queryf);
					while($results13af=mysqli_fetch_assoc($r12af)){
                    $adm = $results13af['Adm'];
                        $marks = $results13af['TotalMarks'];
                       
                        $pv += 1;
                        If ($tie == $results13af['TotalMarks']) {}

                        else{
                            If ($pos < $pos2){
                                $pos = $pos2;
					}
                            $pos += 1;
                            $tie = $results13af['TotalMarks'];
					}
                        $pos2 += 1;
                   


                        $strQry_FU = "UPDATE  $f2$exm  SET POSCLASS=$pos  WHERE   Year='$year' and  subno>=$subjectno and Term='$term' and form='$form' and adm='$adm'";

                        if (mysqli_query($con,$strQry_FU))
                                 {
                                   // echo "Form sorting completed<html><br><br></html>" ;

                                }



					}



           
      
        //=========END FORM RANKING==================
	}
  
function rankterm() {
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
        $pos2 = 0;
        $posf = False;
        $poss = False;
        $code = 0;
        $adm = 0;
        $score = 0;
        $id = 0;
        $count = 0;
        $count2 = 0;
        $subq = "";
        $subject = "";
        $marks  = 0;
        $grade = "";
        $pvv = 0;
        $points = 0;
        

            $subqt = "Select count(*) as c from ".$f2."term where  Year='$year' and  Term='$term' ";




try {
            $c3t=mysqli_query($con,$subqt);
		while($results_found3t=mysqli_fetch_assoc($c3t)){
			
                $count = $results_found3t['c'];

		}
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}

        ///////////////////


       //echo $subqt;







            $subqt2 = "Select count(*) as c from ".$f2."term where  Year='$year' and  Term='$term' and stream='$Stream'  ";

$c3at=mysqli_query($con,$subqt2);
		while($results_found3at=mysqli_fetch_assoc($c3at)){
			
                $count2 = $results_found3at['c'];

		}


        //=============END GRADING===================

        //============START STREAM RANKING================

        $pv = 0;
        $tie = 0;
        $stream = "";
           $strQryt = "SELECT DISTINCT Stream from ".$f2."term  where  Year='$year' ";
            $r12t=mysqli_query($con,$strQryt);
		while($results13t=mysqli_fetch_assoc($r12t)){
                $subject = $results13t['Stream'];

                $pos = 0;
                $pos2 = 0;
$tie =0;

                $queryt = "Select Adm,TotalPercent   from ".$f2."term where  Year='$year' and  subno>='$subjectno' and stream='$subject' and Term='$term'  order by TotalPercent desc";



                $r12at=mysqli_query($con,$queryt);
					while($results13at=mysqli_fetch_assoc($r12at)){
                        $adm = $results13at['Adm'];
                        $marks = $results13at['TotalPercent'];
                       
                        $pv += 1;
                        If ($tie == $results13at['TotalPercent']) {}

                        else{
                            If ($pos < $pos2){
                                $pos = $pos2;
					}
                            $pos += 1;
                            $tie = $results13at['TotalPercent'];
					}
                        $pos2 += 1;


                            $strQrytt = "UPDATE  ".$f2."term SET posstream=$pos  WHERE  Year='$year' and  subno>='$subjectno' and Term='$term' and adm='$adm'  and TotalPercent='$marks' and Stream='$subject'";

                           if (mysqli_query($con,$strQrytt))
                                 {
                                  // echo "Stream sorting completed <html><br><br></html>";

                                }
                       

					}
                   







			}
        //============END STREAM RANKING==================

        //=========START FORM RANKING==============

        $pos2 = 0;
        $pos = 0;
          
            $suj= 0;

            $queryt2 = "Select subno,Adm,TotalScore as Score,TotalPercent   from ".$f2."term where  Year='$year' and  subno>='$subjectno' and  Term='$term'  order by TotalPercent desc";

$tie =0;

          $r12aft=mysqli_query($con,$queryt2);
					while($results13aft=mysqli_fetch_assoc($r12aft)){
                    $adm = $results13aft['Adm'];
                        $marks = $results13aft['TotalPercent'];
                       $suj = $results13aft['subno'];
                        $pv += 1;
                        If ($tie == $results13aft['TotalPercent']) {}

                        else{
                            If ($pos < $pos2){
                                $pos = $pos2;
					}
                            $pos += 1;
                            $tie = $results13aft['TotalPercent'];
					}
                        $pos2 += 1;


                        $strQryta = "UPDATE  ".$f2."term SET POSCLASS=$pos,TotalMarks=".$marks * $suj."  WHERE  Year='$year' and  subno>='$subjectno' and Term='$term' and adm='$adm' ";

                        if (mysqli_query($con,$strQryta))
                                 {
                                   //echo "Form sorting completed $strQryta<html><br><br></html>";

                                }else{
                                   //echo "Form sorting  $strQryta<html><br><br></html>";

                                }



					}



           
      
        //=========END FORM RANKING==================
	}

function term() {
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
        $s  = "";
      If ($cat1 == "True" And $cat2 == "True" And $cat3 == "True"){

            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,cat1,cat2,cat3,endterm,TotalPercent,Points,Grade,subno)SELECT `".$f2."endterm`.`Year`, `".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`, `".$f2."cat1`.`TotalScore`, `".$f2."cat2`.`TotalScore`, `".$f2."cat3`.`TotalScore`, `".$f2."endterm`.`TotalScore`, `".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`+`".$f2."cat1`.`TotalScore` +`".$f2."cat1`.`TotalScore` 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`  LEFT JOIN `school_5`.`".$f2."cat1`  ON (`".$f2."endterm`.`Adm` = `".$f2."cat1`.`Adm`) LEFT JOIN `school_5`.`".$f2."cat3` ON (`".$f2."cat3`.`Adm` = `".$f2."endterm`.`Adm`) LEFT JOIN `school_5`.`".$f2."cat2`  ON (`".$f2."cat2`.`Adm` = `".$f2."cat3`.`Adm`) LEFT JOIN `school_5`.`gradingscale` ON ((`".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`+`".$f2."cat1`.`TotalScore`)<=gradingscale.Max AND  (`".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`+`".$f2."cat1`.`TotalScore`)>=gradingscale.Min)  WHERE ".$f2."endterm.term='$term' ";

        } elseIf ($cat1 == "True" And $cat2 == "True" And $cat3 == "False"){
            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,cat1,cat2,endterm,TotalPercent,Points,Grade,subno)SELECT `".$f2."endterm`.`Year`,`".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`, `".$f2."cat1`.`TotalScore`, `".$f2."cat2`.`TotalScore`,  `".$f2."endterm`.`TotalScore`, `".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`+`".$f2."cat1`.`TotalScore` 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`  LEFT JOIN `school_5`.`".$f2."cat1`  ON (`".$f2."endterm`.`Adm` = `".$f2."cat1`.`Adm`) LEFT JOIN  `school_5`.`".$f2."cat2`  ON (`".$f2."cat2`.`Adm` = `".$f2."cat1`.`Adm`) LEFT JOIN `school_5`.`gradingscale` ON ((`".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`+`".$f2."cat1`.`TotalScore`)<=gradingscale.Max AND  (`".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`+`".$f2."cat1`.`TotalScore`)>=gradingscale.Min)  WHERE ".$f2."endterm.term='$term' ";
        } elseIf ($cat1 == "True" And $cat2 == "False" And $cat3 == "False"){
            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,cat1,endterm,TotalPercent,Points,Grade,subno)SELECT  `".$f2."endterm`.`Year`,`".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`, `".$f2."cat1`.`TotalScore`,`".$f2."endterm`.`TotalScore`, `".$f2."endterm`.`TotalScore`+`".$f2."cat1`.`TotalScore` 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`  LEFT JOIN `school_5`.`".$f2."cat1`  ON (`".$f2."endterm`.`Adm` = `".$f2."cat1`.`Adm`)  LEFT JOIN `school_5`.`gradingscale` ON ((`".$f2."endterm`.`TotalScore`+`".$f2."cat1`.`TotalScore`)<=gradingscale.Max AND  (`".$f2."endterm`.`TotalScore`+`".$f2."cat1`.`TotalScore`)>=gradingscale.Min)  WHERE ".$f2."endterm.`term`='$term' ";
        } elseIf ($cat1 == "True" And $cat2 == "False" And $cat3 == "True"){
            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,cat1,cat3,endterm,TotalPercent,Points,Grade,subno)SELECT  `".$f2."endterm`.`Year`,`".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`, `".$f2."cat1`.`TotalScore`, `".$f2."cat3`.`TotalScore`, `".$f2."endterm`.`TotalScore`, `".$f2."endterm`.`TotalScore`+`".$f2."cat1`.`TotalScore` +`".$f2."cat3`.`TotalScore` 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`  LEFT JOIN `school_5`.`".$f2."cat1`  ON (`".$f2."endterm`.`Adm` = `".$f2."cat1`.`Adm`) LEFT JOIN `school_5`.`".$f2."cat3` ON (`".$f2."cat3`.`Adm` = `".$f2."endterm`.`Adm`) LEFT JOIN `school_5`.`gradingscale` ON ((`".$f2."endterm`.`TotalScore`+`".$f2."cat3`.`TotalScore`+`".$f2."cat1`.`TotalScore`)<=gradingscale.Max AND  (`".$f2."endterm`.`TotalScore`+`".$f2."cat1`.`TotalScore`+`".$f2."cat3`.`TotalScore`)>=gradingscale.Min)  WHERE ".$f2."endterm.term='$term' ";
        } elseIf ($cat1 == "False" And $cat2 == "False" And $cat3 == "True"){
            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,cat3,endterm,TotalPercent,Points,Grade,subno)SELECT  `".$f2."endterm`.`Year`,`".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`, `".$f2."cat3`.`TotalScore`, `".$f2."endterm`.`TotalScore`, `".$f2."endterm`.`TotalScore`+`".$f2."cat3`.`TotalScore` 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`  LEFT JOIN `school_5`.`".$f2."cat3`  ON (`".$f2."endterm`.`Adm` = `".$f2."cat3`.`Adm`) LEFT JOIN `school_5`.`gradingscale` ON ((`".$f2."endterm`.`TotalScore`+`".$f2."cat3`.`TotalScore``)<=gradingscale.Max AND  (`".$f2."endterm`.`TotalScore`+`".$f2."cat3`.`TotalScore`)>=gradingscale.Min)  WHERE ".$f2."endterm.term='$term' ";
        } elseIf ($cat1 == "False" And $cat2 == "True" And $cat3 == "False"){
            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,cat2,endterm,TotalPercent,Points,Grade,subno)SELECT `".$f2."endterm`.`Year`, `".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`, `".$f2."cat2`.`TotalScore`,`".$f2."endterm`.`TotalScore`, `".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore` 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`  LEFT JOIN `school_5`.`".$f2."cat2`  ON (`".$f2."endterm`.`Adm` = `".$f2."cat2`.`Adm`)  LEFT JOIN `school_5`.`gradingscale` ON ((`".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`)<=gradingscale.Max AND  (`".$f2."endterm`.`TotalScore`+".$f2."cat2`.`TotalScore`)>=gradingscale.Min)  WHERE ".$f2."endterm.term='$term' ";


        } elseIf ($cat1 == "False" And $cat2 == "True" And $cat3 == "True"){
            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,cat2,cat3,endterm,TotalPercent,Points,Grade,subno)SELECT  `".$f2."endterm`.`Year`,`".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`,  `".$f2."cat2`.`TotalScore`, `".$f2."cat3`.`TotalScore`, `".$f2."endterm`.`TotalScore`, `".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore` +`".$f2."cat3`.`TotalScore` 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`  LEFT JOIN `school_5`.`".$f2."cat2`  ON (`".$f2."endterm`.`Adm` = `".$f2."cat2`.`Adm`) LEFT JOIN `school_5`.`".$f2."cat3` ON (`".$f2."cat3`.`Adm` = `".$f2."cat2`.`Adm`) LEFT JOIN `school_5`.`gradingscale` ON ((`".$f2."endterm`.`TotalScore`+`".$f2."cat2`.`TotalScore`+`".$f2."cat3`.`TotalScore`)<=gradingscale.Max AND  (`".$f2."endterm`.`TotalScore`+".$f2."cat2`.`TotalScore`+`".$f2."cat3`.`TotalScore`)>=gradingscale.Min)  WHERE ".$f2."endterm.term='$term' ";


        } else {
            $s = "INSERT INTO ".$f2."term(Year,adm,Stream,Term,endterm,TotalPercent,Points,Grade,subno)SELECT  `".$f2."endterm`.`Year`, `".$f2."endterm`.`Adm`,`".$f2."endterm`.`Stream`,`".$f2."endterm`.`Term`,`".$f2."endterm`.`TotalScore`,ROUND (((".$f2."endterm.`TotalScore`)/" .$lmt .")*100) 'TOTALPOINTS',gradingscale.Points,gradingscale.Grade,`".$f2."endterm`.`subno` FROM `school_5`.`".$f2."endterm`   LEFT JOIN `school_5`.`gradingscale` ON ((((`".$f2."endterm`.`TotalScore`)/" .$lmt .")*100)<=gradingscale.Max) AND  ((((`".$f2."endterm`.`TotalScore`)/" .$lmt .")*100)>=gradingscale.Min)  WHERE ".$f2."endterm.term='$term' ";
		}
       
       


           if (mysqli_query($con,$s))
                                 {
                                    echo " Termly report ready $cat1<html><br><br></html>";

                                }
 }

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
                    $q1 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`  , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `".$f2."term`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' ";





			} else{
                    If (2==8) {
                     
			} else{
                        $q1 = "SELECT `".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` , `".$f2."$exm`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."$exm.form='$form' and subno>='$subjectno';";
			}
			}


            } else{
                If ($exm =="all") {
                    $q1 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`  , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `".$f2."term`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' and ".$f2."term.Stream='$Stream'";
			} else {


                    If (2==8) {
                       
			}else{
                        $q1 = "SELECT `".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` , `".$f2."$exm`.`VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."$exm.stream='$Stream' and ".$f2."$exm.form='$form' and subno>='$subjectno';";
			}
			}

            }
			
		
	  
						$cc1='<center>
						<h3 class="card-title ">BROAD SHEET FOR  '.strtoupper($form." ". $Stream. " ($term - ". $year. ")").'</center></h3>';
		
                           $cc1.=' <table border="1" cellspacing="0" cellpadding="3">
                              <thead>
                                <tr>
                                  <th>RNK</th>
								  <th>ADM</th> 
                                  <th>NAME</th>   
								  <th>FORM</th>
								  <th>STREAM</th>
								   <th>POS</th>
								   <th>TOTAL</th>
								  <th>MS</th> 
                                  <th>(%)</th>   
								  <th>MG</th>
								  <th>V/A</th>';
								  
								  $qs="SELECT UPPER(Abbreviation) AS subs FROM subjects ";
								  $subs=mysqli_query($con,$qs);
									while($sr=mysqli_fetch_assoc($subs)){
			
						 $cc1.=' <th>'.$sr['subs'].'</th>';
						   
						  
						  }
						  
                              $cc1.='</tr>
                          </thead>
                          <tbody>';
						  
						  	
					$qq=mysqli_query($con,$q1);
					$score="";
					while($rs=mysqli_fetch_assoc($qq)){	
						  
						    $cc1.='<tr>
                              <th>'.$rs['PosClass'].'</th>
							  <td>'.$rs['adm'].'</td>
                              <td>'.$rs['Name'].'</td>
							  <td>'.$rs['Form'].'</td>
                              <td>'.$rs['Stream'].'</td>
							  <td>'.$rs['PosStream'].'</td>
							  
                              <td>'.$rs['TotalMarks'].'</td>
							  <td>'.$rs['TotalScore'].'</td>
                              <td>'.$rs['TotalPercent'].'</td>
							  <td>'.$rs['Grade'].'</td>
                              <td></td>';
									$qs="SELECT UPPER(Abbreviation) AS subs FROM subjects ";
									$subs=mysqli_query($con,$qs);
									while($sr=mysqli_fetch_assoc($subs)){
									$qsc="SELECT CONCAT(round(TotalScore),' ',gradingscale.grade) as TotalScore,PosStream  FROM $exm left join gradingscale ON (TotalScore>=MIN AND TotalScore<=MAX) WHERE adm='".$rs['adm']."' AND SUBJECT='".$sr['subs']."' AND $exm.term='$term' AND year='$year'";
									$score="";
									$pos="";
			
									$sc=mysqli_query($con,$qsc);
									while($ss=mysqli_fetch_assoc($sc)){
									$score=$ss['TotalScore'];
									$pos=$ss['PosStream'] ; 
																		}
		
			$cc1.='<td>'.$score.'<sub>';

			if($pos !==""){

			$cc1.=' " ("'.$pos.'")" </sub></td>';
			}
						  }
						  
                         $cc1.='</tr>';
                          
                          
						  
						  }
						  
                          
                     $cc1.='</tbody>
                  </table>';
                       
    


						
						
		
			

         
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
                    $q1 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent` , `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, (`sudtls`.`kcpe`- `".$f2."term`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno'";





			} else{
                    If (2==8) {
                     
			} else{
                        $q1 = "SELECT `".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,(`sudtls`.`kcpe`- `".$f2."$exm`.POINTS) as `VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term'  and ".$f2."$exm.form='$form' and subno>='$subjectno';";
			}
			}


            } else{
                If ($exm =="all") {
                    $q1 = "SELECT `".$f2."term`.`adm`, `sudtls`.`Name` ,`".$f2."term`.`Stream`, `".$f2."term`.`PosStream` , `".$f2."term`.`PosClass`,subno AS 'No. of Sub',CAT1, CAT2, CAT3, ENDTERM,`".$f2."term`.`TotalMarks`, `".$f2."term`.`TotalPercent`, `".$f2."term`.`POINTS` ,`".$f2."term`.`Grade`, `sudtls`.`kcpe`- `".$f2."term`.POINTS as `VALUE_ADDITION`  FROM `school_5`.`".$f2."term` INNER JOIN `school_5`.`sudtls` ON (`".$f2."term`.`Adm` = `sudtls`.`Adm`) WHERE Year='$year' and Term='$term'   AND subno>='$subjectno' and ".$f2."term.Stream='$Stream'";
			} else {


                    If (2==8) {
                       
			}else{
                        $q1 = "SELECT `".$f2."$exm`.`adm`, `sudtls`.`Name`, `".$f2."$exm`.`Form` ,`".$f2."$exm`.`Stream`, `".$f2."$exm`.`PosStream` , `".$f2."$exm`.`PosClass`,subno,`".$f2."$exm`.`TotalMarks`, `".$f2."$exm`.`TotalScore` , `".$f2."$exm`.`TotalPercent`  , `".$f2."$exm`.`Grade`, `".$f2."$exm`.`POINTS` ,`sudtls`.`kcpe`- `".$f2."$exm`.POINTS as `VALUE_ADDITION`  FROM `school_5`.`".$f2."$exm` INNER JOIN `school_5`.`sudtls` ON (`".$f2."$exm`.`Adm` = `sudtls`.`Adm`) where Year='$year' and Term='$term' and ".$f2."$exm.stream='$Stream' and ".$f2."$exm.form='$form' and subno>='$subjectno';";
			}
			}

            }
		
			
		$v = strtoupper($form." ". $Stream. " ($term - ". $year. ")");
						$cc1='<center>
						<h3 class="card-title ">BROAD SHEET FOR  '.$v.'</center></h3>
	
                            <table border="1" cellspacing="0" cellpadding="3">
                              <thead>
                                <tr>
                                  <th>RNK</th>
								  <th>ADM</th> 
                                  <th>NAME</th>   
								  <th>FORM</th>
								  <th>STREAM</th>
								   <th>POS</th>';
								    if ($_SESSION['cat1']=="True"){
								   $cc1.='<th>CAT 1</th> ';   }
								  if ($_SESSION['cat2']=="True"){
								   $cc1.='<th>CAT 2</th> ';   }
								    if ($_SESSION['cat3']=="True"){
								   $cc1.='<th>CAT 3</th>';    }
								  $cc1.='<th>END TERM</th>';
								   $cc1.='<th>TOTAL</th>
								  <th>MS%</th>    
								  <th>MG</th>
								  <th>V/A</th>';
								  
								  
								  $qs="SELECT concat(UPPER(Abbreviation),' (',code,')') AS subs FROM subjects order by code asc";
								  $subs=mysqli_query($con,$qs);
		while($sr=mysqli_fetch_assoc($subs)){
			
						  $cc1.='<th>'.$sr['subs'].'</th>';
						   
						  
						  }
						  
                              $cc1.='</tr>
                          </thead>
                          <tbody>';
						  
						  
			
								 $qq=mysqli_query($con,$q1);
								 $score="";
								 $tt=0;
								 $qscw1="SELECT count(Abbreviation) AS sc FROM subjects order by  subjects.code asc";
								  $subsc1=mysqli_query($con,$qscw1);
								while($srcv=mysqli_fetch_assoc($subsc1)){
									 $tt=$srcv['sc'];
								}
								while($rs=mysqli_fetch_assoc($qq)){
			  
						    $cc1.='<tr>
                               <th>'.$rs['PosStream'].'</th>
							  <td>'.$rs['adm'].'</td>
                              <td>'.$rs['Name'].'</td>
							  <td>'.$_SESSION['form'].'</td>
                              <td>'.$rs['Stream'].'</td>
							  <td>'.$rs['PosClass'].'</td>';	
									 if ($_SESSION['cat1']=="True"){
							  $cc1.='<td>'.$rs['CAT1'].'</td>';    }
								  if ($_SESSION['cat2']=="True"){
								$cc1.='<td>'.$rs['CAT2'].'</td>';    }
								    if ($_SESSION['cat3']=="True"){
								   $cc1.='<td>'.$rs['CAT3'].'</td>';    }							  
							 
                              
							  
							  $cc1.='<td>'.$rs['ENDTERM'].'</td>
                              <td>'.$rs['TotalMarks'].'</td>
							  <td>'.$rs['TotalPercent'].'</td>
							  <td>'.$rs['Grade'].'</td>
                              <td>';
							  if($rs['VALUE_ADDITION']<0) { $cc1.=' "+"';  $rs['VALUE_ADDITION']*-1;} else{$cc1.=' "-"';  $rs['VALUE_ADDITION'];}  $cc1.='</td>';
							  
							  
							   
							  
                             for($i=1;$i<=$tt;$i++){
			$qsc1="SELECT concat(round(S".$i."),' ' ,gradingscale.grade) as TotalScore  FROM subscores2 left join gradingscale ON (S".$i.">=MIN AND S".$i."<=MAX)  WHERE adm='".$rs['adm']."' AND subscores2.term='$term' AND year='$year'";
			$score="";
			$pos="";
			
								  $sc=mysqli_query($con,$qsc1);
		while($ss=mysqli_fetch_assoc($sc)){
			$score=$ss['TotalScore'];
		}
		
			$cc1.='<td>'.$score; $cc1.='<sub>'; if($pos !=="") $cc1.=' " ("'.$pos.'")" </sub></td>';
						  }
						  
                        $cc1.='  </tr>';
                          
                          
						  
						  }
						  
                          
                     $cc1.=' </tbody>
                  </table>';
                       

    
    
    


						
						
		
			
			
         
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
                    $strQry = "SELECT  count(*) as results FROM `".$f2."$exm` where Year='$year' and Term='$term'and form='$form'";
				 } else {
                    $strQry = "SELECT  count(*) as results FROM `".$f2."$exm` where Year='$year' and stream ='$Stream' and  Term='$term' and form='$form'";
 }
               
            $r1cc=mysqli_query($con,$strQry);
		while($results1cc=mysqli_fetch_assoc($r1cc)){


                $zero = $results1cc['results'];
		}

            If ($zero <= 0) {
               $cc1= "No results found $en";
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
$cc1="";
main();
}
else{}
	require_once('library/tcpdf/tcpdf.php'); 
	$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('BROAD SHEET - '.   strtoupper($form." ". $Stream. " ".$term . "- ". $year. "") ); 
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(false);  
    $pdf->setPrintFooter(false);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 8);  
    $pdf->AddPage();
	
	$pdf->writeHTML($cc1);  
	$pdf->Output('CashBook.pdf','I');

	
	?>	