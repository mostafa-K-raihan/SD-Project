<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />
    
	<script type="text/javascript" src="<?php echo base_url("assets/js/canvasjs.min.js"); ?>"> </script>
  	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>

	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
</head>
<body style="height=800;">
  <!-- navigation bar -->
    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Fantasy Cricket</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
	  
        <li><a href="<?php echo site_url('user'); ?>">HOME <span class="sr-only">(current)</span></a></li>
		<li><a href="<?php echo site_url('user/view_points'); ?>">Latest Points </a></li>
        <li><a href="<?php echo site_url('user/schedules'); ?>">Schedules </a></li>
        <li><a href="<?php echo site_url('user/results'); ?>">Results </a></li>
        <li><a href="<?php echo site_url('user/howToPlay'); ?>">Rules and Scoring</a></li>
        
        <li><a href="<?php echo site_url('user/changeTeam'); ?>">Change Team </a></li>
        <li><a href="<?php echo site_url('user/topplayers'); ?>">Top Scorers </a></li>
        <li class="active" class="dropdown">
				<a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" href="<?php echo site_url('stat/per_category_per_team_stat'); ?>">Statistics<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo site_url('stat/per_category_per_team_stat'); ?>">Per Category Per Team</a></li>
					<li><a href="<?php echo site_url('stat/stat_per_match'); ?>">Match by Match</a></li>
					<li><a href="<?php echo site_url('stat/player_overall_stat'); ?>">Player by Player</a></li>
					
				</ul>
		</li>
		<li><a href="#">Prizes </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['user_name'];?> <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo site_url('user/changePassword'); ?>">Change Password</a></li>
					<li><a href="<?php echo site_url('user/logout'); ?>">Sign Out</a></li>
				</ul>
			</li>
       </ul>
	   
	   
	   
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  
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
	
	var offset = 50/jArray1.length;
	var init = 0;
	for(var i=0;i<jArray1.length;i++){
		chart1.options.data[0].dataPoints.push({x:init+=offset, y: jArray1[i]['teamPoint'], label: jArray1[i]['team_name']}); // Add a new dataPoint to dataPoints array
	}
	chart1.render();
	
}
  

</script>

   
 </body>
</html>