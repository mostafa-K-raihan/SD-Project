<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />
    
	<script type="text/javascript" src="<?php echo base_url("assets/js/canvasjs.min.js"); ?>"> </script>
  	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>

	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</head>

<body>
  
<div class="container-fluid"style="text-align:center">
<div>
	<div id="chartContainer" style="height: 300px; width: 50%; margin-top: 10%; float:left "></div>
	<div id="chartContainer1" style="height: 300px; width: 50%; margin-top: 10%; float: right"></div>
</div>
</div>
<script type="text/javascript">
	var jArray = <?php 
					echo json_encode($catData);
				?>;
	var jArray1 = <?php 
					echo json_encode($teamData);
				?>;	
	window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer",
	{
	  title:{
		text: "points gained per category"
	  },
	  data: [

	  {
		dataPoints: [
		{ x: 10, y: jArray[0]['catPoint'], label: jArray[0]['cat']},
		{ x: 20, y: jArray[1]['catPoint'], label: jArray[1]['cat'] },
		{ x: 30, y: jArray[2]['catPoint'], label: jArray[2]['cat']},
		{ x: 40, y: jArray[3]['catPoint'], label: jArray[3]['cat']}
		]
	  }
	  ]
	});

	chart.render();
	var chart1 = new CanvasJS.Chart("chartContainer1",
	{
	  title:{
		text: "points gained per team"
	  },
	  data: [

	  {
		dataPoints: [
			
		]
	  }
	  ]
	});
	
	var offset = 10;
	var init = 0;
	for(var i=0;i<jArray1.length;i++){
		chart1.options.data[0].dataPoints.push({x:init+=offset, y: jArray1[i]['teamPoint'], label: jArray1[i]['team_name']}); // Add a new dataPoint to dataPoints array
	}
	chart1.render();
	
}
  

</script>

   
 </body>
</html>