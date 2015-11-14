<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Cricket</title>
  
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />
    <link href="css/bootstrap-responsive.css" rel="stylesheet" media="screen">
    <link href="css/hosting.css" rel="stylesheet" media="all">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/image.css"); ?>"/>
    <link href="<?php echo base_url("assets/css/bootstrap.css"); ?>" rel="stylesheet">
	<link href="<?php echo base_url("assets/css/bootstrap-responsive.css"); ?>" rel="stylesheet" media="screen">
	<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url("assets/css/hosting.css"); ?>" rel="stylesheet" media="all">
	
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>

	<style>
		.navbar-inverse{
			background : #c4c4c4;
		}
		.navbar-inverse .navbar-brand{
			color : Navy; 
		}
		.navbar-inverse .navbar-nav > li > a {
			color: #000;
		}
		body{
			background-color: #f9f9f9;
		}
		body{
			background-color:teal;
		}
		#mainTabs li a{
			color: white;
		}
		.nav-tabs > li.active > a,
        .nav-tabs > li.active > a:hover,
        .nav-tabs > li.active > a:focus{
            color: #555555;
            background-color: DarkGray;  
        } 
		
		.nav-tabs > li > a:hover{
			background-color: Tomato;
		}
		#comboTable td,th{
			color: black;
			text-align:center;
		}
		#pointTable{
			color: black;
			text-align:center;
		}
		#pointTable td{
			width:50%;
		}
		#pointTable th{
			text-align:center;
		}
		
		.table-striped>thead{
			background-color: #fcb;
			
		}
		.table-striped>tbody>tr:nth-child(odd)>td, 
			.table-striped>tbody>tr:nth-child(odd)>th {
				background-color: #9ff;
		}
		
		.table-striped>tbody>tr:nth-child(even)>td, 
			.table-striped>tbody>tr:nth-child(even)>th {
				background-color: #c0c0c0;
		}
		
</style>	

	</style>
	
</head>
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
        
		
		<li class="active"><a href="<?php echo site_url('user/howToPlay'); ?>">Rules and Scoring</a></li>
				
        
        <li><a href="<?php echo site_url('user/changeTeam'); ?>">Change Team </a></li>
        <li><a href="<?php echo site_url('user/topplayers'); ?>">Top Scorers </a></li>
        <li><a href="#">Prizes </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">User Name <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#">Edit Profile</a></li>
					<li><a href="#">Change Password</a></li>
					<li><a href="<?php echo site_url('user/logout'); ?>">Sign Out</a></li>
				</ul>
			</li>
       </ul>
	   
	   
	   
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">
       <!-- tabs link -->
	<div class="tabbable">      
		<ul id="mainTabs" class="nav nav-tabs">
       
			<li class="active"><a href="#howToPlay" data-toggle="tab">How to Play</a></li>
			<li><a href="#Scoring" data-toggle="tab">Scoring</a></li>
		
		
		
		
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="howToPlay" style="color: white">
				<h3>Creating Your Team</h3>
				<p>Create a team by selecting your cricketers with any of the 7 possible combinations available.</p>
				<table class = "table table-striped table table-bordered" id="comboTable">
					<thead>
						<th>Player Type</th><th>Combo 1</th><th>Combo 2</th><th>Combo 3</th><th>Combo 4</th><th>Combo 5</th><th>Combo 6</th><th>Combo 7</th>
					</thead>
					
					<tbody>
						<tr><td>Wicketkeeper</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td></tr>
						<tr><td>Batsmen</td><td>5</td><td>5</td><td>4</td><td>4</td><td>4</td><td>3</td><td>3</td></tr>
						<tr><td>Bowlers</td><td>3</td><td>4</td><td>5</td><td>4</td><td>3</td><td>5</td><td>4</td></tr>
						<tr><td>All-Rounders</td><td>2</td><td>1</td><td>1</td><td>2</td><td>3</td><td>2</td><td>3</td></tr>
						<tr><td>Total Cricketers</td><td>11</td><td>11</td><td>11</td><td>11</td><td>11</td><td>11</td><td>11</td></tr>
		
					</tbody>
				</table>
				<h3>Manage Your Team</h3>
				<p>You can edit your team any time before the deadline for the round.
					You can make unlimited changes to your team before the deadline.
					You can also change your Captain.
					Make sure you keep a tab on who is playing and who is not to keep your team updated at all timaes.
				</p>
				<p>You will be given 100$ to manage all your players. Each Player costs differently. Adjust wisely.</p>
				<p>Captain's point will be doubled after each match.</p>
				<p>If captain does not play there will be <strong style="font:monospace; font-size:20px"><i>no captain's double point allocation.</i></strong><br> So choose wisely.</p>
			</div>
			
			<div class="tab-pane" id="Scoring" style="color:white">
				
				<label style="font-size:30px">Batting Points</label>
				<table class = "table table-striped table table-bordered" id="pointTable">
					<thead>
						<th>Type of points</th><th>Points</th>
					</thead>
					<tbody>
						<tr><td>For every run scored</td><td>1</td></tr>
						<tr><td>Milestone Bonus(For each 25 runs)</td><td>25</td></tr>
						<tr><td>Every Boundary Hit</td><td>2</td></tr>
						<tr><td>Every Six Hit</td><td>6</td></tr>
						<tr><td>Dismissal for Duck</td><td>-5</td></tr>
						<tr><td style="background-color:#fcb"><strong>Strike Rate Bonus System</strong></td><td style="background-color:#fcb"><strong>Points</strong></td></tr>
						<tr><td>120-149.99</td><td>10</td></tr>
						<tr><td>150-179.99</td><td>20</td></tr>
						<tr><td>180-209.99</td><td>30</td></tr>
						<tr><td>210 and more</td><td>40</td></tr>
						<tr><td>less than 90</td><td>-5</td></tr>
						<tr><td>less than 75</td><td>-10</td></tr>
						
					</tbody>
				</table>
				<label style="font-size:30px">Bowling Points</label>
				<table class = "table table-striped table table-bordered" id="pointTable">
					<thead>
						<th>Type of points</th><th>Points</th>
					</thead>
					<tbody>
						<tr><td>1 Wicket</td><td>25</td></tr>
						<tr><td>For Each Subsequent Wicket</td><td>25</td></tr>
						<tr><td>Per Maiden Over</td><td>20</td></tr>
						<tr><td>Per Dot Ball</td><td>2</td></tr>
						<tr><td style="background-color:#fcb"><strong>Economy Rate Bonus System</strong></td><td style="background-color:#fcb"><strong>Points</strong></td></tr>
						<tr><td>12 and more </td><td>-10</td></tr>
						<tr><td>10 - 11.99</td><td>-5</td></tr>
						
						<tr><td>8-9.99</td><td>10</td></tr>
						<tr><td>6.5-7.99</td><td>20</td></tr>
						<tr><td>5-6.49</td><td>30</td></tr>
						<tr><td>4-5.99</td><td>40</td></tr>
					</tbody>
				</table>
				
				<label style="font-size:30px">Fielding Points</label>
				<table class = "table table-striped table table-bordered" id="pointTable">
					<thead>
						<th>Type of points</th><th>Points</th>
					</thead>
					<tbody>
						<tr><td>Per Catch, Run-Out, Stumping</td><td>20</td></tr>
					</tbody>
				</table>
				<p> * Man of the Match will receive extra 50 points.</p>
				<p> * Cricketer you choose as Captain will receive double points.</p>
			</div>
		</div>
	</div>
</div>
	<script>
	$(document).on('click', '#refresh', function () {
    var $link = $('li.active a[data-toggle="tab"]');
    $link.parent().removeClass('active');
    var tabLink = $link.attr('href');
    $('#mainTabs a[href="' + tabLink + '"]').tab('show');
});
</script>
		<!--
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
-->
	
</body>
</html>