
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
		.table td,th {
				color: black;
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
		<li class="active"><a href="<?php echo site_url('user/view_points'); ?>">Latest Points </a></li>
        <li><a href="<?php echo site_url('user/schedules'); ?>">Schedules </a></li>
        <li><a href="<?php echo site_url('user/results'); ?>">Results </a></li>
        <li><a href="<?php echo site_url('user/howToPlay'); ?>">Rules and Scoring</a></li>
		
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

<div class="container" class="row-fluid PageHead"> <!-- Description Start -->
    <div class="span12">
      <h1 style="color:#180000">Incredible XI</h1>
    </div>
</div> <!-- Description End -->

<div class="row" >
	<div class="col-md-8" style="float:right">
	<table>
		<tr>
			<td>Last Match : Bangladesh Vs Australia</td>
			<td width="50"> </td>
			<td>Time: 29-01-2016 05:00 PM </td>
		</tr>
		
		<tr>
			<td> <br> </td>
		</tr>
		
		<tr>
			<td>Overall Points: 567</td>
			<td width="30"> </td>
		
			<td>Matchday Points: 567</td>
			<td width="30"> </td>
		
			<td>Matchday Rank: 567</td>
			<td width="30"> </td>
		</tr>
	
	</table>
  </div>
	
</div>


<div class="col-xs-12" class="container-fluid">
   
</div>

<div class="container-fluid class="row-fluid">
<!-- Row2 start -->

<table class = "table table-striped">
<thead>
	<th>Player Name</th><th>Category</th><th>Team</th><th>Points</th>
</thead>
<tbody>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
	<tr><td>Tamim Iqbal</td><td>Batsman</td><td>Dhaka Gladiators</td><td>105</td></tr>
</tbody>
</table>

<?php
/*
	for($i=0;$i<11;$i++)
	{
    echo '<div class="span3 PlanPricing template4" style="width:180px">  <!-- Price template4 Starts -->
      <div class="planName"> <span class="price">546</span>
        <h4>Taskin Ahmed</h4>
        <p>Bangladesh</p>
      </div>
      <div class="planFeatures">
        <ul>
          <li><img src="'.base_url('images/e1.png/').'" height="80" width="80" class="img-circle" alt="Circular Image"></li>
        </ul>
      </div>
      <p> <a href="#" role="button" data-toggle="modal" class="btn btn-success btn-large" height="50" width="50">Bowler</a> </p>
    </div>';
	}
	*/
	?>

    
  </div>  <!-- Row3 ends -->
  
  <br><br> <br><br> <br><br>
  
</div> <!-- Container ends -->


<!-- footer -->
<hr>
<footer>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header"> 
      <a class="navbar-brand" class="col-md-12" href="#" style=""><p>Copyright &copy; FantasyCricket.com 2015</p></a>
    </div>
  </div>
</nav>
</footer>
<hr>
<!--
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
-->
</body>


</html>