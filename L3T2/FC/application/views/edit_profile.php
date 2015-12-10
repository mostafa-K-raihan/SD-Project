<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Cricket</title>
	
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
	
	<style>
		body{
			background-color: #f9f9f9;
		}
	</style>
	
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
        <li class="dropdown">
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
			<li class="active" class="dropdown">
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
<div>
	<?php
		if($error==true)
		{
			echo '<div class="alert alert-danger">
				<strong><span class="glyphicon glyphicon-remove"></span> Password and Confirm Password didn\'t match </strong>
			 </div>';
		}
	?>
</div>
<div class="container" style="padding-top: 60px;">
	<h1 class="page-header">Change Password</h1>
	
	<div class="row">
		<!-- left column -->
		
		
		<!-- edit form column -->
		<div class="col-md-8 col-sm-6 col-xs-12 personal-info">
			
			
			<form class="form-horizontal" method = "post" action="<?php echo site_url('user/changePassword_proc'); ?>" role="form">
				
				<div class="form-group">
					<label class="col-md-3 control-label">New Password:</label>
					<div class="col-md-8">
						<input class="form-control" value="" name="password" type="password" required >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Confirm password:</label>
					<div class="col-md-8">
						<input class="form-control" value="" name="confirm_password" type="password" required >
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"></label>
					<div class="col-md-8">
						  <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info pull-right">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>