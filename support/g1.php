<?php
session_start();
require("dbconn.php");

$subjectno=0;
$lmt = 0; 
$form="Form 2";
$f2="form2";
$Stream="all";
$year=date("Y");
$examdate=date("Y");
$en="all";
$term="term 1";

$fm="";
if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='term';
$fm=$f2;
}else{	

$exm=$_SESSION['exm'];
}
$i=0;
$m=0;
$g=0;

$data="";
 
	$data1="";
	$datab="";
 
	$data1b="";		

$data2="";
 
	$data12="";	

	$data2a="";
 
	$data12a="";	
	
$name="";
$adm=0;
$series="";
 $m2=0;


?>

<?php

$i=0;
$m2=0;
$g=0;
 if(strtolower($Stream)=="all"){
							$str=""; 
						 }else{
						  $str=" and Stream ='".$Stream."' ";
						 }
				
				
				$ex="";
				$f2a="";
						$exma="";
						$yeara="";
						$terma="";
 $equery = "SELECT term,exam,form,year FROM openexam WHERE  form='".$form."' $str order by id asc";
	
 $datac=mysqli_query($con,$equery);
 while($return=mysqli_fetch_assoc($datac)){
	 $m2=0;
$forma=$return['form'];
	$f2a=strtolower(str_replace(" ","",str_replace("-","",$return['form'])));
						$exma=strtolower(str_replace(" ","",str_replace("-","",$return['exam'])));
						$yeara=$return['year'];
						$terma=$return['term'];
$ex=$return['exam'];

			
						 
	 $q13d = "SELECT AVG(TotalPercent) as m FROM ".$f2a."$exma WHERE Year='$yeara' $str and  term='".$terma."' ";
	// echo $q13d;
 $qq3d=mysqli_query($con,$q13d);
 while($rs3d=mysqli_fetch_assoc($qq3d)){

	if($rs3d['m']>0){
	$m2=$rs3d['m'];
	
	
	}else{
		
	}
	
	//VALUES/DATA

		//
 } 
 $datab.='"'.$forma.' '.$ex.' '.$terma.'-'.$yeara.'",';
$data1b.=$m2.',';
 
 } 
				
	//echo $data1b;			
				
			$mn=0;	
				
		 $qs = "SELECT AVG(TotalPercent) as m FROM ".$f2."$exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' ";
	// echo $qs;
 $res=mysqli_query($con,$qs);
 while($red=mysqli_fetch_assoc($res)){

	if($red['m']>0){
	$mn=$red['m'];
	}
	
	//VALUES/DATA
	
		//
 } 
  $q134 = "SELECT Grade FROM gradingscale WHERE ".round($mn,0)."<= MAX AND ".round($mn,0).">=Min ";
  //echo $q1;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	
	$g=$rs34['Grade'];
	
	
	//VALUES/DATA
	
		//
 }		
			
 ?>

 <div class="row">
					 <div class="col-lg-9">
					<div class="ibox">


				
                       
						<?php
						 $tp = "SELECT count(*) as x from sudtls where form=2";
  //echo $q1;
  $all=0;
 $scv=mysqli_query($con,$tp);
 while($b=mysqli_fetch_assoc($scv)){

	
	$all=$b['x'];
	
	
	//VALUES/DATA
	
		//
 }	
 ?>
                       
                                <div class="ibox-content">
                      
                           <div class="">
						     <h3><?php echo strtoupper($form); ?></h3>
							
                                <h3><strong><?php echo 'MEAN SCORE-'.round($mn,2).'      GRADE-'.$g.'        '.'                TOTAL STUDENTS-'.round($all,2);  ?></strong> </h3> 
								
                            </div><hr>
                            <div class="pull-right text-right">
                                <h2>    CLASSES PERFORMANCE TREND</h2>
                            </div>
                            
                                 <div>
                                <canvas id="lineChart1" ></canvas>
                           
                            </div>
							
							<hr>
							
							 <div class="hidden">
                                <canvas id="lineChart2" ></canvas>
                           
                            </div>
							
							
							<div class="hidden" id="linegraph">
                            <div>
                                <canvas id="lineChart" ></canvas>
                            </div>
							  </div>
							  <div class=" hidden" id="bargraph">
                            <div>
                                <canvas id="barChart" ></canvas>
                            </div>
                        </div>
                    </div></div></div>


            
           
                <div class="col-lg-12 hidden">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Bar Chart</h5>
							 <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                           
                            
                        </div>
                        </div>
						
                        <div class="ibox-content">
                            <div>
                                <canvas id="barChart" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
				
				<!--
				SUBJECT GRADES
				-->
				
				 <div class="col-lg-12 hidden
">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>SUBJECT GRADES(<?php echo strtoupper($form.'  '.$Stream.'  '.$en.'    -   '.$term.'  '.$year); ?>)
                            </h5>
							
                        </div>
						 
                        <div class="ibox-content">
                            <div>
                                <canvas id="lineChartg" ></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php 
			
			


 If ($Stream !="all") {
	 
	

	 
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM ".$fm."$exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	if($rs3['m']>0){
		
	$m=$rs3['m'];
	 
	}
	
  $data.='"'.$rs22['sub1'].'",';
$data1.=$m.',';


$q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $q1g1 = "SELECT COUNT(Grade) as grade2 FROM ".$fm."$exm WHERE Year='$year' and Stream='$Stream' and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1g1);
 while($rs=mysqli_fetch_assoc($qq)){
$data2a.='"'.$rgs['Grade'].'",';
	$data12a.=$rs['grade2'].',';
	//VALUES/DATA
	
		//
 }
		
	
		}
		
 //echo $data2a;
	//echo $data12a;


	
 }
 
 	  $query = "SELECT value FROM colors WHERE id='$i'";
	$color="";
 $result=mysqli_query($con,$query);
 while($raw=mysqli_fetch_assoc($result)){

	$color=['value'];
	
 }
 $series.='

		,{
			label: "'.strtoupper($rs22['sub1']).'",
                 borderColor: "#'.rand(10,1068).'",
			    backgroundColor: "rgba(0,0,0,0.0)",
                pointBorderColor: "#fff",
                data: ['.$data12a.',0]
            }	
';
	
	
		}
		 //print_r $series;
		//print($series);
  $q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM ".$fm."$exm WHERE Year='$year' and term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	if($rs3['m']>0){
		
		   
			

	$m=$rs3['m'];
	
	}
	
	 $data2.='"'.$rs22['sub1'].'",';
$data12.=$m.',';
 }
 }
	 $countgrade="";
$countnum="";
	 
	 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $count = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year'  and  term='".$term."' AND grade='".$rgs['Grade']."' $str";
	 //echo $count;
 $countr=mysqli_query($con,$count);
 while($resc=mysqli_fetch_assoc($countr)){
$countgrade.='"'.$rgs['Grade'].'",';
$countnum.=$resc['grade2'].',';
	//VALUES/DATA
	
		//
 }
		
	
		}
	 
	 
	 
 } else{
	 
	 $countgrade="";
$countnum="";

	 


 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $count = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year'  and  term='".$term."' AND grade='".$rgs['Grade']."' $str";
	 //echo $count;
 $countr=mysqli_query($con,$count);
 while($resc=mysqli_fetch_assoc($countr)){
$countgrade.='"'.$rgs['Grade'].'",';
$countnum.=$resc['grade2'].',';
	//VALUES/DATA
	
		//
 }
		
	
		}
		
 //echo $data2a;
	//echo $data12a;


	
 


	
	
		
	 
	 
	 
	 
	 
	 
	 
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM ".$fm."$exm WHERE Year='$year'  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	// echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	if($rs3['m']>0){
		
	$m=$rs3['m'];
	 
	}
	
  $data.='"'.$rs22['sub1'].'",';
$data1.=$m.',';


$q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	
	
	 $q1g1 = "SELECT COUNT(Grade) as grade2 FROM ".$fm."$exm WHERE Year='$year'  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1g1);
 while($rs=mysqli_fetch_assoc($qq)){
$data2a.='"'.$rgs['Grade'].'",';
	$data12a.=$rs['grade2'].',';
	//VALUES/DATA
	
		//
 }
		
	
		}
		
 //echo $data2a;
	//echo $data12a;


	
 }
 
 	  $query = "SELECT value FROM colors WHERE id='$i'";
	$color="";
 $result=mysqli_query($con,$query);
 while($raw=mysqli_fetch_assoc($result)){

	$color=['value'];
	
 }
 $series.='

		,{
			label: "'.strtoupper($rs22['sub1']).'",
                 borderColor: "#'.rand(10,1068).'",
			    backgroundColor: "rgba(0,0,0,0.0)",
                pointBorderColor: "#fff",
                data: ['.$data12a.',0]
            }	
';
	
	
		}
		 //print_r $series;
		//print($series);
  $q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 
	 $i+=1;
	 $q13 = "SELECT AVG(TotalPercent) as m FROM ".$fm."$exm WHERE Year='$year' and term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	if($rs3['m']>0){
		
		   
			

	$m=$rs3['m'];
	
	}
	
	 $data2.='"'.$rs22['sub1'].'",';
$data12.=$m.',';
 }
 }
	 
 }
	 
	 
	 
	

 
 
 

 
 	


 
 
 ?>
			<script>
			
			$(document).ready(function() {
				
				$("#ds").click(function() {
					
					window.print();
					
				});
				
          
				
				
				$("#bar").click(function () {
				if($("#bar").prop('checked')==true){
					$("#linegraph").addClass("hidden");
					$("#bargraph").removeClass("hidden");
					//alert("");
				}else{
					//alert("");
					$("#linegraph").removeClass("hidden");
					$("#bargraph").addClass("hidden");
				}
			});
				
				$("#line").click(function () {
				if($("#line").prop('checked')==true){
					$("#linegraph").removeClass("hidden");
					$("#bargraph").addClass("hidden");
					
				}else{
					//alert("");
					$("#linegraph").addClass("hidden");
					$("#bargraph").removeClass("hidden");
				}
			});
				
			});
			
			
$(function() {
    var lineData = {
        labels: [<?php echo $data; ?>,""],
        datasets: [

            {
			label: "<?php if(strtolower($Stream=="all")) {echo strtoupper($form);} else{ echo strtoupper($Stream);} ?>",
               backgroundColor: 'rgba(0,0,0,0.0)',
                borderColor: "rgba(26,179,148,0.7)",
              //  pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $data1; ?>,0]
            },{
			label: "<?php echo strtoupper($form); ?>",
               backgroundColor: 'rgba(220, 220, 220, 0.5)',
			    backgroundColor: 'rgba(26,179,148,0.1)',
                pointBorderColor: "#fff",
                data: [<?php echo $data12; ?>,0]
            }
        ]
    };

    var lineOptions = {
        responsive: true
    };


    var ctx = document.getElementById("lineChart").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
 
     var lineData1 = {
        labels: [<?php echo $datab; ?>,""],
        datasets: [

            {
			label: "<?php if(strtolower($Stream=="all")) {echo strtoupper($form);} else{ echo strtoupper($Stream);} ?>",
               backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
              //  pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $data1b; ?>,0]
            }
        ]
    };
	
	
	////////////////
	
	
	

	
	

    var lineOptions1 = {
        responsive: true
    };


    var ctx = document.getElementById("lineChart1").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData1, options:lineOptions1});
	
	
	
	var lineData2 = {
        labels: [<?php echo $countgrade; ?>,""],
        datasets: [

            {
			label: "CLASS PERFORMANCE",
               backgroundColor: 'rgba(26,179,148,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
              //  pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $countnum; ?>,0]
            }
        ]
    };
	
	
	var lineOptions2 = {
        responsive: true
    };


    var ctx = document.getElementById("lineChart2").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData2, options:lineOptions2});
	
 var barData = {
        labels: [<?php echo $data; ?>,""],
        datasets: [
            {
               label: "<?php if(strtolower($Stream=="all")) {echo strtoupper($form);} else{ echo strtoupper($Stream);}?>",
              backgroundColor: '#810d21',
                pointBorderColor: "#fff",
                data: [<?php echo $data1; ?>,0]
            },
			 {
               label: "<?php echo strtoupper($form); ?>",
                backgroundColor: 'rgba(26,179,148,0.8)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: [<?php echo $data12; ?>,0]
            }
        ]
    };

    var barOptions = {
        responsive: true
    };


    var ctx2 = document.getElementById("barChart").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
  

  
  
  //GRADES 
   var lineData = {
        labels: [<?php echo $data2a; ?>,""],
        datasets: [

            {
			label: "",
              // backgroundColor: 'rgba(0,0,0,0.0)',
               // borderColor: "rgba(26,179,148,0.7)",
              //  pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: []
            }
			
			<?php print($series); ?>
        ]
    };

    var lineOptions = {
        responsive: true
    };


    var ctx = document.getElementById("lineChartg").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
 
  
  
  
  
  
  
  
  
  
  
  
});

</script>






<!--



-->


