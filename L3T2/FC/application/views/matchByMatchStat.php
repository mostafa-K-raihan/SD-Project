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
	<!--<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">-->
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
		mark.red{
			color: red;
		}
		mark.green{
			color: green;
		}
		mark.vs{
			color: #399;
		}
		table th{
			text-align:center;
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
<?php
echo'

  <div class="col-xs-12" style="text-align:center !important;float:left;">
    <h3> <span class="label label-success" > Match Statistics </span> </h3>
  </div>


<div>
      <div class="col-md-2"></div>
      <div class="col-md-8"> 
        <table class="table table-hover table-bordered" id="table0" style ="table-layout:fixed; text-align:center">
          <thead>
            <th style="text-align:center">Time</th>
            <th style="text-align:center"><mark class="blue">Home Team
            <mark class="vs"> vs <mark class="blue">Away Team</mark> </th>
			<th style="text-align:center">Earned Points</th>
          </thead>
          <tbody>';
          $c2="active";
          $c3="success";
          $c4="info";
          $c1="warning";
          $c=1;$d="";
          foreach ($result as $r) {
            if($c%4==0)$d=$c1;
            else if($c%4==1)$d=$c2;
            else if($c%4==2)$d=$c3;
            else if($c%4==3)$d=$c4;
			
			//print_r($result[0]['detail']);
          echo'  <tr class='.$d.'>
              <td>'.$r['Time'].'</td>
              <td><font color="blue">'.$r['Home Team'].'</font> <font color="#399">vs</font> <font color="blue">'.$r['Away Team'].'</font></td>
			  <td>'.$r['points'].'</td>
            </tr>
			<tr class="prevRow"><div class="slidethis"><td colspan="3"><p>Detailed Stat</p>';
					if(count($r['detail'])==0)
					{
						echo '<font color="red">No Data Available</font>';
					}
					else
					{
						if($r['is_captain']==1)
						{
							$r['name']=$r['name']." (Captain) ";
						}
						
						echo '<table class="table table-hover" id="table1">
						<thead>
							<th>Player Name</th>
							<th>Category</th>
							<th>Player Team</th>
							<th>Point</th>
						</thead>
						<tbody>
							<tr>
								<td>'.$r['name'].'</td>
								<td>'.$r['player_cat'].'</td>
								<td>'.$r['team_name'].'</td>
								<td>'.$r['match_point'].'</td>
							</tr>
						</tbody>
					</table>';
					
					}
					
				echo'</td></div></tr>';
			
			/*
			//ON CLICK EXPAND
			if($r['detail']==-1)
			{
				echo 'No Data Available';
			}
			else
			{
				foreach($r['detail'] as $t)
				{
					print_r($t);
					echo '<br><br>';
				}
			}
			echo '<pre>END</pre><br><br>';
			*/
            $c++;
          }
          echo'</tbody>
        </table>
      </div>
      <div class="col-md-2"></div>
  </div>';
?>
<script type="text/javascript">
$(function() {
    $(".prevRow").find("td[colspan=3]").hide();
    $("#table0").click(function(event) {
        event.stopPropagation();
        var $target = $(event.target);
        if ( $target.closest("td").attr("colspan") > 1 ) {
            $target.slideUp();
        } else {
			//$("td[colspan=3]").hide();
            $target.closest("tr").next().find("td[colspan=3]").slideToggle();
        }                    
    });
});

</script>
</body>
