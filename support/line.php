<?php
$data2="";
 
	$data12="";
	
	$data2a="";
 
	$data12a="";
	
if(date("m") >= 01 && date("m") <= 04){
	$yr=date("Y")-1;
	
	$term="Term 3";
	$yr2=date("Y")-1;
	$term2="Term 2";
}elseif(date("m") >= 05 && date("m") <= 07){
	$yr=date("Y");
		$term="Term 1";
	$term2="Term 3";
	$yr2=date("Y")-1;
}elseif(date("m") >= 08 && date("m") <= 11){
	$yr=date("Y");
		$term="Term 2";
		$term2="Term 1";
	$yr2=date("Y");
}else{
	
	$yr=date("Y");
		$term="Term 3";
		$term2="Term 2";
		$yr2=date("Y");
}
require("dbconn.php");
$i=0;
 $q12222 = "SELECT DISTINCT(Abbreviation) as sub1,Code from subjects order by code asc";
 $qq22=mysqli_query($con,$q12222);
 while($rs22=mysqli_fetch_assoc($qq22)){
	 
	 
	  $q13s = "SELECT score as m FROM kcse WHERE Year='".(date("Y")-1)."' and code='".$rs22['Code']."'";
	//echo $q13;
	$m2=0;
 $qq3s=mysqli_query($con,$q13s);
 while($rs3s=mysqli_fetch_assoc($qq3s)){

	
	if($rs3s['m']>0){
		
		   
			

	$m2=round($rs3s['m'],0);
	
	}
	
	 
 }
	 
	 
	 
	 $i+=1;
	 $q13 = "SELECT AVG(TotalScore) as m FROM ve WHERE Year='$yr'  and  term='$term' AND form='form 4' and code='".$rs22['Code']."'";
	//echo $q13;
	$m=0;
 $qq3=mysqli_query($con,$q13);
 while($rs3=mysqli_fetch_assoc($qq3)){

	
	if($rs3['m']>0){
		
		   
			

	$m+=round($rs3['m'],0);
	
	}
	
	 
 }
 $data2.='"'.$rs22['sub1'].'",';
$data12.='{ label: "'.$rs22['sub1'].'", y: '.$m.' },';

$data12a.='{ label: "'.$rs22['sub1'].'", y: '.$m2.' },';

 }

?>
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "SCHOOL PERFORMANCE"
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
	name: "ENG", 
	showInLegend: true, 
	dataPoints: [ 
	{ label: "A", y: 14 },
	{ label: "A-", y: 4 },
	{ label: "B+", y: 4 },
	{ label: "B", y: 8 },
	{ label: "B-", y: 5 },
	{ label: "C+", y: 5 },
	{ label: "C", y: 2 },
	{ label: "C-", y: 7 },
	{ label: "D+", y: 2 },
	{ label: "D", y: 28},
	{ label: "D-", y: 0 },
	{ label: "E", y: 1 }, 
	{ } ] }, 
	
	{ type: "line", name: "KISW", showInLegend: true, dataPoints: [ { label: "A", y: 14 },{ label: "A-", y: 4 },{ label: "B+", y: 4 },{ label: "B", y: 8 },{ label: "B-", y: 5 },{ label: "C+", y: 5 },{ label: "C", y: 2 },{ label: "C-", y: 7 },{ label: "D+", y: 2 },{ label: "D", y: 0 },{ label: "D-", y: 0 },{ label: "E", y: 1 }, { } ] }, 
	
	{ type: "line", name: "MATH", showInLegend: true, dataPoints: [ { label: "A", y: 14 },{ label: "A-", y: 4 },{ label: "B+", y: 4 },{ label: "B", y: 8 },{ label: "B-", y: 5 },{ label: "C+", y: 5 },{ label: "C", y: 2 },{ label: "C-", y: 7 },{ label: "D+", y: 2 },{ label: "D", y: 0 },{ label: "D-", y: 0 },{ label: "E", y: 1 }, { } ] }, 
	
	{ type: "line", name: "BIO", showInLegend: true, dataPoints: [ { label: "A", y: 14 },{ label: "A-", y: 4 },{ label: "B+", y: 4 },{ label: "B", y: 8 },{ label: "B-", y: 5 },{ label: "C+", y: 5 },{ label: "C", y: 2 },{ label: "C-", y: 7 },{ label: "D+", y: 2 },{ label: "D", y: 0 },{ label: "D-", y: 0 },{ label: "E", y: 1 }, { } ] },  { } ] 
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

}
</script>

<div id="chartContainer" style="height: 400px; width: 100%;"></div>
<script src="charts/js/canvas.js"></script>
