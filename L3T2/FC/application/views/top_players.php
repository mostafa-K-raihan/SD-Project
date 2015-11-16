<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Cricket</title>

	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />
    <link href="<?php echo base_url("assets/css/bootstrap.css"); ?>" rel="stylesheet">
	<link href="<?php echo base_url("assets/css/bootstrap-responsive.css"); ?>" rel="stylesheet" media="screen">
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
		#mainTabs li a{
			color: black;
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
		body{
			background-color: #f9f9f9;
		}
		#topUsers th, #topUsers tbody, #FCPB_leaderboard th, #FCPB_leaderboard tbody{
			table-layout:fixed;
			text-align:center;
		}
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
        <li><a href="<?php echo site_url('user/howToPlay'); ?>">Rules and Scoring</a></li>
        
        <li><a href="<?php echo site_url('user/changeTeam'); ?>">Change Team </a></li>
        <li  class="active"><a href="<?php echo site_url('user/topplayers'); ?>">Top Scorers </a></li>
        <li><a href="#">Prizes </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['user_name'];?> <span class="caret"></span></a>
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
<!--
  <div class="col-xs-12" style="text-align:center !important;float:left;">
    <h3> <span class="label label-success" > Top Scoring Players </span> </h3>
  </div>
-->

<div class="container-fluid">
	<div class="tabbable">      
		<ul id="mainTabs" class="nav nav-tabs">
			<li class="active"><a href="#topUsers" data-toggle="tab">Top Scoring Players</a></li>
			<li><a href="#FCPB_leaderboard" data-toggle="tab">FCPB LeaderBoard</a></li>
		</ul>
		<div class = "tab-content">
			<div class="tab-pane active" id="topUsers"> 
				<div style="overflow:scroll;height:595px;width:100%;overflow:auto;">
					<table class="table table-hover table-bordered">
						  <thead>
								<th>Player Name</th>
								<th>Team Name</th>
								<th>Category</th>
								<th>Price</th>
								<th>Point</th>
						  </thead>
						  <tbody>
							  <?php
							  $c1="active";
							  $c3="success";
							  $c2="info";
							  $c4="warning";
							  $c=1;$d="";
							  
							  $COUNT=min(sizeof($top,0),50);
							  $index=0;
							  for($index=0;$index<$COUNT;$index++)
							  {
								if($index%4==0)$d=$c1;
								else if($index%4==1)$d=$c2;
								else if($index%4==2)$d=$c3;
								else if($index%4==3)$d=$c4;
								echo'  <tr class='.$d.'>
								  <td>'.$top[$index]['name'].'</td>
								  <td>'.$top[$index]['team_name'].'</td>
								  <td>'.$top[$index]['cat'].'</td>
								  <td>$'.$top[$index]['price'].'</td>
								  <td>'.$top[$index]['point'].'</td>
								</tr>';
								
							  }
							  ?>
						  </tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane" id="FCPB_leaderboard">
				<div style="overflow:scroll;height:595px;width:100%;overflow:auto;">
					<table class="table table-hover table-bordered">
						<thead>
							<th>User Name</th>
							<th>Team Name</th>
							<th>Country</th>
							<th>Total Points</th>
						</thead>
						<tbody>
							  <?php
							  $c1="active";
							  $c3="success";
							  $c2="info";
							  $c4="warning";
							  $c=1;$d="";
							  
							  $index=0;
							  $COUNT=min(sizeof($topUsers,0),50);
							  for($index=0;$index<$COUNT;$index++)
							  {
								if($index%4==0)$d=$c1;
								else if($index%4==1)$d=$c2;
								else if($index%4==2)$d=$c3;
								else if($index%4==3)$d=$c4;
								echo'  <tr class='.$d.'>
								  <td>'.$topUsers[$index]['user_name'].'</td>
								  <td>'.$topUsers[$index]['user_team_name'].'</td>
								  <td>'.$topUsers[$index]['country'].'</td>
								  <td>'.$topUsers[$index]['point'].'</td>
								</tr>';
								
							  }
							  ?>
						</tbody>
					</table>
				</div>
			</div>
		</div> <!-- tab content finished -->
	</div> <!-- tabbale finished-->
</div> <!-- container fluid finished-->
<script>
	$(document).on('click', '#refresh', function () {
		var $link = $('li.active a[data-toggle="tab"]');
		$link.parent().removeClass('active');
		var tabLink = $link.attr('href');
		$('#mainTabs a[href="' + tabLink + '"]').tab('show');
	});
</script>
