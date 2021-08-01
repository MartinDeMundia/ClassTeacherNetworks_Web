<?php
session_start();
require("dbconn.php");
if (isset($_SESSION['form'])){
$subjectno=0;
$lmt = 0; 
$form=$_SESSION['ff'];
$f2=str_replace(" ","",$_SESSION['ff']);
$Stream=strtolower($_SESSION['Stream']);
$year=$_SESSION['year'];
$adm=" and Adm='".$_SESSION['adm']."'";
$examdate=$_SESSION['examdate'];
$en=$_SESSION['en'];
$term=$_SESSION['term'];
$adm2=$_SESSION['adm'];
}
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
 $data1f="";
	$data1="";
	$datab="";
 
	$data1b="";		

$data2="";
 
	$data12="";	

	$data2a="";
 
	$data12a="";	
	
$name="";

$series="";
 $m2=0; 
 if(strtolower($Stream)=="all"){
$str=""; 
						 }else{
						  $str=" and Stream ='".$Stream."' ";
						 }

?>

<?php

$i=0;
$m2=0;
$g=0;

							
				
				
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

			
						 
	 $q13d = "SELECT (TotalPercent) as m FROM ".$f2a."$exma WHERE Year='$yeara' $str $adm and  term='".$terma."' ";
	////echo $q13d;
 $qq3d=mysqli_query($con,$q13d);
 while($rs3d=mysqli_fetch_assoc($qq3d)){

	if($rs3d['m']>0){
	$m2=round($rs3d['m'],2);
	
	
	}else{
		
	}
	
	//VALUES/DATA

		//
 } 
 $datab=''.$forma.' '.$ex.' '.$terma.'-'.$yeara.'';
$data1b.='{ label: "'. $datab.'", y: '.$m2.' },';
 
 } 
				
	//echo $data1b;			
				
			$mn=0;	
				
		 $qs = "SELECT (TotalPercent) as m FROM ".$f2."$exm WHERE Year='$year' $str $adm and  term='".$term."' AND form='".$form."' ";
	//echo $qs;
 $res=mysqli_query($con,$qs);
 while($red=mysqli_fetch_assoc($res)){

	if($red['m']>0){
	$mn=$red['m'];
	}
	
	//VALUES/DATA
	
		//
 } 
  $q134 = "SELECT Grade FROM gradingscale WHERE ".$mn."<= MAX AND ".$mn.">=Min ";
  //echo $q1;
 $qq34=mysqli_query($con,$q134);
 while($rs34=mysqli_fetch_assoc($qq34)){

	
	$g=$rs34['Grade'];
	
	
	//VALUES/DATA
	
		//
 }		
			
 ?>

 


            
           
               
				<?php 
			 if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='ve';
$fm="";

}else{	

$exm=$_SESSION['exm'];

}
		$q12222 = "SELECT DISTINCT(Subject) as sub1 from $exm WHERE Year='$year' $adm order by code asc ";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	  if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='ve';
$fm="";
$q13 = "SELECT (TotalScore) as m FROM $exm WHERE Year='$year' $str $adm and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
}else{	

$exm=$_SESSION['exm'];
$q13 = "SELECT (TotalPercent) as m FROM $exm WHERE Year='$year' $str $adm  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
}
	 
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	if($rs3['m']>0){
		
	$m=$rs3['m'];
	 
	}
	
  $data.='"'.$rs22['sub1'].'",';

$data1.='{ label: "'.$rs22['sub1'].'", y: '.$m.' },';


 }

 } 
//echo $data1;
	if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='ve';
$fm="";

}else{	

$exm=$_SESSION['exm'];

}
		$q12222 = "SELECT DISTINCT(Subject) as sub1 from $exm WHERE Year='$year' $adm order by code asc ";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	  if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='ve';
$fm="";
$q13 = "SELECT avg(TotalScore) as m FROM $exm WHERE Year='$year'  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
}else{	

$exm=$_SESSION['exm'];
$q13 = "SELECT avg(TotalPercent) as m FROM $exm WHERE Year='$year'  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
}
	 
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	if($rs3['m']>0){
		
	$m=$rs3['m'];
	 
	}
	
  $data.='"'.$rs22['sub1'].'",';

$data1f.='{ label: "'.$rs22['sub1'].'", y: '.$m.' },';
//echo $data1;

 }

 } 
//echo $data1f;
	 
	$data1="";
 if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='ve';
$fm="";

}else{	

$exm=$_SESSION['exm'];
}
	 
$q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc ";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	$data2a="";
 
	$data12a="";
	 $i+=1;
	  if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='ve';
$fm="";
$q13 = "SELECT (TotalScore) as m FROM $exm WHERE Year='$year' $str $adm  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
}else{	

$exm=$_SESSION['exm'];
$q13 = "SELECT (TotalPercent) as m FROM $exm WHERE Year='$year' $str $adm  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
}
	 
	//echo $q13;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){
$m=0;
	
	if($rs3['m']>0){
		
	$m=$rs3['m'];
	 
	}
	
  $data.='"'.$rs22['sub1'].'",';

$data1.='{ label: "'.$rs22['sub1'].'", y: '.$m.' },';
$q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$exm='ve';
$fm="";
}else{	

$exm=$_SESSION['exm'];
}
	
	 $q1g1 = "SELECT COUNT(Grade) as grade2 FROM ".$fm."$exm WHERE Year='$year' $str and  term='".$term."' AND form='".$form."' $adm  and  SUBJECT='".$rs22['sub1']."' AND grade='".$rgs['Grade']."'";
	 //echo $q1;
 $qq=mysqli_query($con,$q1g1);
 while($rs=mysqli_fetch_assoc($qq)){
$data2a.='"'.$rgs['Grade'].'",';
	//$data12a.=$rs['grade2'].',';
	
	//$data12.='{ label: "'.$rs22['sub1'].'", y: '.$m.' },';

$data12a.='{ label: "'.$rgs['Grade'].'", y: '.$rs['grade2'].' },';
	
 }
		
	
		}
		
 //echo $data2a;
	


	
 }
 
 	  $query = "SELECT value FROM colors WHERE id='$i'";
	$color="";
 $result=mysqli_query($con,$query);
 while($raw=mysqli_fetch_assoc($result)){

	$color=['value'];
	
 }
 //echo $data12a;
 $series.='

		{
		type: "line",
		name: "'.$rs22['sub1'].'",
		showInLegend: true,
		dataPoints: [
			'.$data12a.'
			{  }
		]
	},	
';
	
	
		}
		 //print_r $series;
		//print($series);
  $q12222 = "SELECT DISTINCT(Abbreviation) as sub1 from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
$q13 = "SELECT (TotalScore) as m FROM ve WHERE Year='$year' $adm  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
}else{	
$q13 = "SELECT (TotalPercent) as m FROM ".$fm."$exm WHERE Year='$year' $adm  and  term='".$term."' AND form='".$form."' AND SUBJECT='".$rs22['sub1']."' ";
$exm=$_SESSION['exm'];
}
	 $i+=1;
	 
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
	 	$countnum2=""; 
	 
	 $q1g = "SELECT Grade FROM gradingscale ORDER BY MAX desc";
	
	$qqg=mysqli_query($con,$q1g);
 while($rgs=mysqli_fetch_assoc($qqg)){
	
	if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
 $count = "SELECT COUNT(Grade) as grade2 FROM ve WHERE Year='$year'  $adm  and  term='".$term."' AND grade='".$rgs['Grade']."' $str";
}else{	
 $count = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year'  $adm  and  term='".$term."' AND grade='".$rgs['Grade']."' $str";
$exm=$_SESSION['exm'];
}
	

	 //echo $count;
 $countr=mysqli_query($con,$count);
 while($resc=mysqli_fetch_assoc($countr)){
$countgrade.='"'.$rgs['Grade'].'",';
//$countnum.=$resc['grade2'].',';
$countnum.='{ label: "'.$rgs['Grade'].'", y: '.$resc['grade2'].' },';
 }
			if(strtolower($en=="all")){
	$enb='form'.$form.'term'; 
 $count = "SELECT COUNT(Grade) as grade2 FROM ve WHERE Year='$year'  $adm  and  term='".$term."' AND grade='".$rgs['Grade']."' ";
}else{	
 $count = "SELECT COUNT(Grade) as grade2 FROM ".$f2."$exm WHERE Year='$year'  $adm  and  term='".$term."' AND grade='".$rgs['Grade']."' ";
$exm=$_SESSION['exm'];
}
 $countr=mysqli_query($con,$count);
 while($resc=mysqli_fetch_assoc($countr)){
$countgrade.='"'.$rgs['Grade'].'",';
//$countnum.=$resc['grade2'].',';
	$countnum2.='{ label: "'.$rgs['Grade'].'", y: '.$resc['grade2'].' },';
 }
	
		}
	 
	 //echo $countnum2;
	 

	 
	 
	

 
 
 

 
 	


 
 
 ?>
	<script>
	
	$(document).ready(function () {
		
	
	
	
	




function addSymbols(e) {
	var suffixes = ["", "K", "M", "B"];
	var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

	if(order > suffixes.length - 1)                	
		order = suffixes.length - 1;

	var suffix = suffixes[order];      
	return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}
/////TREND CLASS



var chart = new CanvasJS.Chart("chartContainer4", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: " SUBJECT MEAN SCORE(<?php echo strtoupper($form.'  '.$en.'    -   '.$term.'  '.$year); ?>)"
	},
      axisX:{
		  
        labelAngle: -45
      },
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [
	{
		type: "line",
		name: "CLASS MEAN SCORE",
		showInLegend: true,
		dataPoints: [
			<?php echo $data1f; ?>
			{ label: "", y: 0 }
		]
	} ,{
		type: "line",
		name: "<?php echo 'Your performance '.$adm2; ?>",
		showInLegend: true,
		dataPoints: [
			<?php echo $data1; ?>
	{ label: "", y: 0 } 
		]
	}]
});
chart.render();




var chart = new CanvasJS.Chart("chartContainer1", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: " PERFORMANCE TREND(<?php echo strtoupper($form.'  '.$en.'    -   '.$term.'  '.$year); ?>)"
	},
      axisX:{
		  
        labelAngle: -45
      },
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [
	{
		type: "area",
		name: "CLASS MEAN SCORE",
		showInLegend: true,
		dataPoints: [
			<?php echo $data1b; ?>
			{ label: "", y: 0 }
		]
	}]
});
chart.render();

function addSymbols(e) {
	var suffixes = ["", "K", "M", "B"];
	var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

	if(order > suffixes.length - 1)                	
		order = suffixes.length - 1;

	var suffix = suffixes[order];      
	return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}


/////


/////TREND CLASS




});
</script>

<div class="col-lg-12">
					<div class="ibox">


				<div class="ibox-title">
                        <h5><?php echo strtoupper($form.'  '.$Stream.'  '.$en.'    -   '.$term.'  '.$year.'  '); ?>  CLASS PERFORMANCE TREND<br><strong><?php echo 'Mean Scrore-'.round($mn,2);  ?><?php echo '  - Grade-'.$g;  ?></strong><br></h5>
						
                        <div class="ibox-tools">
                            
                            <a class="" id="ds">
                                <i class="fa fa-2x fa-print" ></i>
                            </a>
                        </div></div>
                                <div class="ibox-content">
                       
                           <div class="pull-left text-left text-primary">
                                <h2> </h2> 
                            </div>
                            <div class="pull-right text-right">
                                <h2>   </h2>
                            </div>
                            
                                 <div id="chartContainer1" style="height: 300px; width: 100%;"></div>
								 <hr>
							 <div id="chartContainer4" style="height: 300px; width: 100%;"></div>
							<hr>
							
							 
                                  
                    </div></div></div>



<script>
$(document).ready(function(){
	$("#ds").click(function(){
		$("#search").addClass("hidden");
		window.print();
		
	});
});

</script>


	
 <script src="charts/js/canvas.js"></script>