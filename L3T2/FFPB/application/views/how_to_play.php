<head>
	
	
<style>
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

<body>
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
				
				<table class = "table table-striped">
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
					You can also change your Captain & Vice-captain.
					Make sure you keep a tab on who is playing and who is not to keep your team updated at all timaes.
				</p>
				<p>You will be given 100$ to manage all your players. Each Player costs differently. Adjust wisely.</p>
				<p>If captain does not play, vice captain will receive points as captain.<br> But if both captain and vice captain does not play
				then there will be no captain and vice captain point allocation.<br> So choose wisely.</p>
				</div>
				<div class="tab-pane" id="Scoring" style="color:white">
				<p>Here is how your team earns Points in the Fantasy Cricket League.</p>
				<table class = "table table-striped">
					<thead>
						<th>Type of points</th><th>Points</th>
					</thead>
					<tbody>
						<tr><td>For being part of the starting XI</td><td>2</td></tr>
						<tr><td>For every run scored</td><td>1</td></tr>
						<tr><td>Wicket excluding run out</td><td>10</td></tr>
						<tr><td>Catch</td><td>5</td></tr>
						<tr><td>Caught & Bowled</td><td>15</td></tr>
						<tr><td>Stumping/Run out(direct)</td><td>12</td></tr>
						<tr><td>Run out(thrower/catcher)</td><td>8/6</td></tr>
						<tr><td>Dismissal for Duck</td><td>-5</td></tr>
					</tbody>
				</table>
				<table class = "table table-striped">
					<p>Bonus points</p>
					<thead>
						<th>Type of points</th><th>Points</th>
					</thead>
					<tbody>
						<tr><td>Every boundary hit</td><td>4</td></tr>
						<tr><td>Every Six</td><td>6</td></tr>
						<tr><td>Half Century</td><td>50</td></tr>
						<tr><td>Century</td><td>150</td></tr>
						<tr><td>Maiden Over</td><td>10</td></tr>
						<tr><td>Every 3rd wicket</td><td>30</td></tr>
						<tr><td>5 wicket haul</td><td>100</td></tr>
						<tr><td>Strike Rate(Applicable for players batting minimum 30 balls) above 80%</td><td>80</td></tr>
						<tr><td>Strike Rate(Applicable for players batting minimum 30 balls) above 100%</td><td>100</td></tr>
						<tr><td>Strike Rate(Applicable for players batting minimum 30 balls) bellow 40%</td><td>-80</td></tr>
						<tr><td>Economy Rate(Applicable for players bowling minimum 2 overs) above 8 run/over</td><td>-20</td></tr>
						<tr><td>Economy Rate(Applicable for players bowling minimum 2 overs) between 6-8 run/over</td><td>-10</td></tr>
						<tr><td>Economy Rate(Applicable for players bowling minimum 2 overs) between 4-6 run/over</td><td>20</td></tr>
						<tr><td>Economy Rate(Applicable for players bowling minimum 2 overs) between 2-4 run/over</td><td>60</td></tr>
						<tr><td>Economy Rate(Applicable for players bowling minimum 2 overs) bellow 2 run/over</td><td>100</td></tr>
					</tbody>
				</table>
				<p> * Cricketer you choose as Captain will receive double points.</p>
				<p> * Vice Captain will receive 1.5 times the points his achieve in the match.</p>
				</div>
      </div>
	</div>
</div>
	<script>
		<script>
	$(document).on('click', '#refresh', function () {
    var $link = $('li.active a[data-toggle="tab"]');
    $link.parent().removeClass('active');
    var tabLink = $link.attr('href');
    $('#mainTabs a[href="' + tabLink + '"]').tab('show');
});
</script>
		
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>

	
</body>
</html>