<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Cricket</title>
	
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />
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
			background-color: teal;
		}
	</style>
</head>
<body>
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
		<?php switch($id): 
		case 1: ?>
			<li class = "active"><a href="<?php echo site_url('home'); ?>">HOME<span class="sr-only">(current)</span></a></li>
			<li><a href="<?php echo site_url('home/schedules'); ?>">Schedules</a></li>
			<li><a href="<?php echo site_url('home/results'); ?>">Results</a></li>
			<li><a href="<?php echo site_url('home/pointTable'); ?>">Points Table</a></li>
		<?php break; ?>
		<?php case 2: ?>
			<li><a href="<?php echo site_url('home'); ?>">HOME<span class="sr-only">(current)</span></a></li>
			<li class="active"><a href="<?php echo site_url('home/schedules'); ?>">Schedules</a></li>
			<li><a href="<?php echo site_url('home/results'); ?>">Results</a></li>
			<li><a href="<?php echo site_url('home/pointTable'); ?>">Points Table</a></li>
		<?php break; ?>
		<?php case 3: ?>
			<li><a href="<?php echo site_url('home'); ?>">HOME<span class="sr-only">(current)</span></a></li>
			<li><a href="<?php echo site_url('home/schedules'); ?>">Schedules</a></li>
			<li class = "active"><a href="<?php echo site_url('home/results'); ?>">Results</a></li>
			<li><a href="<?php echo site_url('home/pointTable'); ?>">Points Table</a></li>
		<?php break; ?>
		<?php case 4: ?>
			<li><a href="<?php echo site_url('home'); ?>">HOME<span class="sr-only">(current)</span></a></li>
			<li><a href="<?php echo site_url('home/schedules'); ?>">Schedules</a></li>
			<li><a href="<?php echo site_url('home/results'); ?>">Results</a></li>
			<li  class = "active"><a href="<?php echo site_url('home/pointTable'); ?>">Points Table</a></li>
		<?php break; ?>
		<?php default:?>
			<li><a href="<?php echo site_url('home'); ?>">HOME<span class="sr-only">(current)</span></a></li>
			<li><a href="<?php echo site_url('home/schedules'); ?>">Schedules</a></li>
			<li><a href="<?php echo site_url('home/results'); ?>">Results</a></li>
			<li><a href="<?php echo site_url('home/pointTable'); ?>">Points Table</a></li>
		<?php endswitch; ?>
		<?php if ($HOWTOPLAY) { ?>
			<li class="active"><a href="<?php echo site_url('home/howToPlay'); ?>">Rules & Scoring</a>
		<?php } else { ?>
			<li><a href="<?php echo site_url('home/howToPlay'); ?>">Rules & Scoring</a></li>
		<?php } ?>
		
      </ul>
      <form name = "loginForm" method = "post" action="<?php echo site_url('home/login'); ?>" class="navbar-form navbar-left" role="search">
        <div class="form-group">
		
          <input type="email" name ="email" class="form-control" placeholder="E-mail" required>
        </div>
        <div class="form-group">
          <input type="password" name ="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-default">Sign-In</button>
      </form>

      <ul class="nav navbar-nav navbar-right">
        <?php if($SIGNUP){?>
			<li class="active"><a href="<?php echo site_url('home/register'); ?>">Sign-Up</a></li>
		<?php }else{ ?>
			<li><a href="<?php echo site_url('home/register'); ?>">Sign-Up</a></li>
		<?php } ?>
	  </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</body>