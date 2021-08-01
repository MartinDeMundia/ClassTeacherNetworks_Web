
<script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "SCHOOL PERFORMANCE"
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
		name: "KCSE <?php echo date("Y")-1; ?>",
		showInLegend: true,
		dataPoints: [
			 <?php echo $data12a; ?>
			{ label: "", y: 0 }
		]
	},
	{
		type: "area",
		name: "CURRENT CLASS",
		markerBorderColor: "white",
		markerBorderThickness: 2,
		showInLegend: true,
		dataPoints: [
			<?php echo $data12; ?>
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

}
</script>




