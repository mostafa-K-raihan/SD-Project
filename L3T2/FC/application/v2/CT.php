<!--
Show Team Status 
<Needs to be modified>
-->

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Cricket</title>
	
	<!--<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	-->
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.json-2.4.min.js"); ?>" ></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />


	<style>
	#topTable0 td{
		text-align: center;
		font-size: 25px;
		font-family: sans-serif;
		
	}
	#topTable td{
		text-align: center;
		background-color: lightBlue;
		font-size: 20px;
		font-family:verdana;
	}
		body{
			background-color: #f9f9f9;
		}
		.scrollit{
			overflow:scroll;
			height:100px;
		}
		
		#myTable th, td, #Table th,td{
			table-layout:fixed;
			text-align: center;
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
	  
        <li class="active"><a href="<?php echo site_url('user'); ?>">HOME <span class="sr-only">(current)</span></a></li>
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

 
<!-- Home away teams and match starting time id:topTable0-->

<div>
	<table class="table table-bordered"	 class="table table-striped" id = "topTable0" style="table-layout:fixed">
		<tbody>
			<tr>
				<td><?php echo $matchData['home_team_name'].'<br>'; ?></td>
				<td>VS</td>
				<td><?php echo $matchData['away_team_name'].'<br>'; ?></td>
				
			</tr>
			<tr>
				<td colspan="3"><?php echo $matchData['Time']; ?></td>	
			</tr>
		</tbody>
	</table>
</div>

<!-- top row indicating any change made in selecting players ie balance, # of players id: topTable -->

	<table class="table table-bordered" class="table table-striped" id = "topTable" style="table-layout:fixed">
		<tbody>
			
			<tr>
				<td>Balance</td>
				<td id="priceTag" style="background-color: Blue; color:white; font-size:20px;">$10000</td>
				<td>Batsman</td>
				<td>0</td>
				<td>Bowler</td>
				<td>0</td>
				<td>WK</td>
				<td>0</td>
				<td>AllRounder</td>
				<td>0</td>
			</tr>
		</tbody>
	</table>

	<!-- sorting category and team and select id: dataTable-->
	
	<table id="dataTable">
		<tr>
			<td width="300"></td>
			<td><h3>YOUR TEAM</h3></td>
			<td width="350"></td>
			<td><strong>Sort By (Category): </strong></td>
			<form method="post" action="#">
				<td>
					
						<select name="cat" id="categories">
							<option value="">---</option>
							<option value="BAT">BAT</option>
							<option value="BOWL">BOWL</option>
							<option value="ALL">ALL</option>
							<option value="WK">WK</option>
						</select>
				</td>
				<td width="100"></td>
				<td><strong>Sort By (Team): </strong></td>
				<td>
					<select name="team_id" id="team_ID" >
							<option value="">---</option>
							<?php
							foreach ($teams as $t) {
								echo'<option value='.$t['team_id'].'> '.$t['team_name'].' </option>';
							}
							?>
					</select>
				</td>
				<td width="10"></td>
				<td><button type="button" name="submit" id="catSelectSubmit" value="GO!" class="btn btn-info pull-right">GO</button></td>
			</form>
		</tr>
	</table>
		<!-- Own team players area , selected players are inserted one by one in this area id: Table-->
		<div class="col-md-6">
			<div style="overflow:scroll;height:500px;width:100%;overflow:auto;">
				<table class="table table-bordered" class="table table-striped" id = "Table" >
					<thead>
						<th>Name</th>
						<th>Category</th>
						<th>Price</th>
						<th>Team</th>
						<th>Points</th>		
						
						<th colspan="3">Choose</th>
					</thead>
					<tbody>
					</tbody>
				</table>
				
			</div>
			<table>
			  <!--<form method="post" action="createTeam_proc">-->
				<tr>
					<td width="200"><strong><h4>Team Name: </h4></strong></td>
					<td></td>
					<td>
						<input type="text" name="team_name" id="teamNameID" style="width:100%">
						<div id="emptyTeamNameModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">

							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<!--<h4 class="modal-title">Modal Header</h4>-->
									</div>
									<div class="modal-body">
										<p>Please choose a name for your team</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
					</td>
				</tr>
				
				<tr height="20"></tr>
				<tr>
					  <td><strong><h4>Select Captain: </h4></strong></td>
					  <td ></td>
					  <td>
						<select style="width:100%" id="captainSelection" name="captain" required>
									
						</select>
						<div id="captainConfirmation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">

							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<!--<h4 class="modal-title">Modal Header</h4>-->
									</div>
									<div class="modal-body">
										<p></p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
					  </td>
				</tr>
				<tr height="10">
					<td> <br> </td>
				</tr>
			  
				<tr>
					<td></td>
					<td>
						<button type="button" name="submit" id="TeamSubmit" class="btn btn-info btn-lg">Create Team</button>
						<div id="elevenPlayerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">

							<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<!--<h4 class="modal-title">Modal Header</h4>-->
									</div>
									<div class="modal-body">
										<p>Please select eleven players</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
						<!--<button type="button" name="submit" id="TeamSubmit" class="btn btn-danger ">Create Team</button></td>-->
					
					</td>
				</tr>
			
				<tr height="50"></tr>
			</table>
		</div>
		<!-- All team players area id: myTable-->
		<div class="col-md-6" style="overflow:scroll;height:500px;width:50%;overflow:auto">
		<table id = "myTable"class="table table-bordered">
			<thead>
			  
				<th>Choose</th>
				<th>Name</th>
				<th>Category</th>
				<th>Price</th>
				<th>Team</th>
				<th>Points</th>
			 
			</thead>
			<tbody>
			
				<?php 
				$index=0;
				//SHOW THE RIGHT COLUMN FOR DISPLAYING ALL PLAYERS
				
				foreach ($players as $p) {
				/*
					INDEXES:
						Player_name : name of the player
						Team_name : name of the team w.r.t. the player
						Button_status : For enable/disable button
						Price
						Category
						Player_id
						points[index] : Overall points w.r.t. the player
				*/
				  echo'
				  <tr>
				  <form method="post" action="#" id ="myForm">
					<td width="5%"><button type="button" id="addButtonID" class="btn btn-success">Add</button> </td>
					<input type="hidden" id="pName" name="name" value="'.$p['Player_name'].'"><td width="12%" >'.$p['Player_name'].'</td></input>
					<input type="hidden" id="cat" name="cat" value="'.$p['Category'].'"><td width="8%">'.$p['Category'].'</td></input>
					<input type="hidden" id="price" name="price" value="$'.$p['Price'].'"><td width="10%">$'.$p['Price'].'</td></input>
					<input type="hidden" id="pid" name="player_id" value="'.$p['Player_id'].'"></input>
					<input type="hidden" id="players_team" name="team_name" value="'.$p['Team_name'].'"><td width="10%">'.$p['Team_name'].'</td></input>
					<input type="hidden" id="points" name="points" value="'.$points[$index].'"><td width="10%">'.$points[$index].'</td></input>
					
				  </form>
				  </tr>';
				  $index++;
				}
				
				?>				
			</tbody>
		</table>
	</div>



	<!-- javascript needed to dynamically change a lot of things in this page-->
<script type="text/javascript">
	
$(document).ready(function() {
	var jArray = <?php 
					echo json_encode($players);
				?>;
	var jArray2 = <?php echo json_encode ($points);?>;
	var bats,bowl,wk,all;
	bats=bowl=wk=all=0;
	var MAXIMUM_BATSMAN = 5;
	var MINIMUM_BATSMAN = 4;
	var MAXIMUM_BOWLER = 5;
	var MINIMUM_BOWLER = 4;
	var MAXIMUM_WK = 1;
	var MINIMUM_WK = 1;
	var MAXIMUM_AR = 2;
	var MINIMUM_AR = 1;
	var map = new Map();
	var buttonDisable;
	var numberOfPlayer;
	// add button functionality
	//add button will be disabled
	//get all relevant data from the selected row
	//change topTable0 data dynamically
	//append selected row into Table
	
	$("#myTable tbody").on("click", ".btn-success", function(event) {
		buttonDisable = true; // default button disable action
		var tr=$(this).closest('tr');  // which row is clicked
		 
		var pName = tr.find('#pName').val(); // get the values of the row
		var category = tr.find('#cat').val();
		var price = tr.find('#price').val();
		var pid = tr.find('#pid').val();
		var points = tr.find('#points').val();
		var teamName = tr.find('#players_team').val();
		
		//check the player if he is categorically consistent
		if(category == 'BAT'){
			bats++;
			if(bats > MAXIMUM_BATSMAN){
				alert('Sorry you can only take maximum ' + MAXIMUM_BATSMAN + ' batsman');
				// button change hobe na, player add hobe na, topTable o change hobe na
				bats--;
				buttonDisable = false;
			}else if(bats == MAXIMUM_BATSMAN){
				if(bowl == MAXIMUM_BOWLER || all == MAXIMUM_AR){
					alert('Team combination failed view the rules and scoring section');
					// button change hobe na, player add hobe na, topTable o change hobe na
					bats--;
					buttonDisable = false;
				}
			}
		}
		
		else if(category == 'BOWL'){
			bowl ++;
			if(bowl > MAXIMUM_BOWLER){
				alert('Sorry you can only take maximum ' + MAXIMUM_BOWLER + ' bowler');
				// button change hobe na, player add hobe na, topTable o change hobe na
				bowl--;
				buttonDisable = false;
				
			}else if(bowl == MAXIMUM_BOWLER){
				if(bats == MAXIMUM_BATSMAN || all == MAXIMUM_AR){
					alert('Team combination failed view the rules and scoring section');
					// button change hobe na, player add hobe na, topTable o change hobe na
					bowl--;
					buttonDisable = false;
					
				}
			}
		}
		
		else if(category == 'WK'){
			wk++;
			if(wk > MAXIMUM_WK){
				alert('Sorry you can only take maximum ' + MAXIMUM_WK + ' wicketkeeper');
				// button change hobe na, player add hobe na
				wk--;
				buttonDisable = false;
			}
		}
		
		else if(category == 'ALL'){
			all++;
			if(all > MAXIMUM_AR){
				alert('Sorry you can only take maximum ' + MAXIMUM_AR + ' all-rounder');
				// button change hobe na, player add hobe na
				all--;
				buttonDisable = false;
			}else if(all == MAXIMUM_AR){
				if(bats == MAXIMUM_BATSMAN || bowl == MAXIMUM_BOWLER){
					alert('Team combination failed view the rules and scoring section');
					all--;
					buttonDisable = false;		
				}
			}
		}
		
		//check the player is teamwise consistent
		if(!map.has(teamName)){
			if(buttonDisable == true)map.set(teamName, 1);
			
		}else {
			var k = map.get(teamName);
			k++;
			if(k>3){
				alert('Sorry you can only take 3 players from each team');
			
				//category er count komate hobe
				
				if(buttonDisable==true)
				{
					//Remove Button e variable gula revert korte hobe
					if(category == 'BAT')bats--;
					else if(category == 'BOWL')bowl--;
					else if(category == 'ALL')all--;
					else if(category == 'WK')wk--;
					
				}
				
				//button change hobe na, table e add hobe na ar top table 0 teo change hobe na
				buttonDisable = false;
				
				k--;
			}else {
				if(buttonDisable == true) map.set(teamName,k);
			}
			
		}
		
		//check the player is too costly
		var stringCurrentPrice = $("#topTable").find('#priceTag').html();
		var newStringCurrentPrice = stringCurrentPrice.substr(1);
		var intCurrentPrice = parseInt(newStringCurrentPrice, 10);
		var clickedPlayerPrice = parseInt(price.substr(1), 10);
		var changedPrice = (intCurrentPrice-clickedPlayerPrice);
		if(changedPrice<0){
			alert('You are out of balance');
			//player add hobe na balance o change hobe na button disable hobe na
			buttonDisable = false;
		}
	   
	   if(buttonDisable == true){
			numberOfPlayer++;
			if(numberOfPlayer>11){
				alert('You have selected 11 players already');
				numberOfPlayer--;
				if(category == 'BAT')bats--;
				else if(category == 'BOWL')bowl--;
				else if(category == 'ALL')all--;
				else if(category == 'WK')wk--;
				if(map.has(teamName)){
					var k = map.get(teamName);
					k--;
					map.set(teamName, k);
				}
			}else {
			// disable the button
				tr.find("#addButtonID").removeClass("btn-success");
				tr.find("#addButtonID").addClass("btn-default");
				
				//append in the Table
				var largeStr = '<form method="post" action="#">';
				largeStr+='<button type="button" class="btn btn-danger">Remove</button>';
				largeStr+='<input type="hidden" id="pName" name="name" value="'+pName+'"></input>';
				largeStr+='<input type="hidden" id="cat" name="cat" value="'+category+'"></input>';
				largeStr+='<input type="hidden" id="price" name="price" value="'+price+'"></input>';
				largeStr+='<input type="hidden" id="pid" name="player_id" value="'+pid+'"></input>';
				largeStr+='<input type="hidden" id="players_team" name="team_name" value="'+teamName+'"></input>';
				
				largeStr+='<input type="hidden" id="points" name="points" value="'+points+'"</input></form>';
				var str = '<tr class="child"><td>' + pName + '</td><td>' + category + '</td><td>' + price + '</td><td>' + teamName + '</td><td>' + points + '</td><td>'+ largeStr + '</td></tr>';
				
				//append the player into captain position
				var captain = '<option value="' + pid + '">' + pName +  '</option>';
				$('#captainSelection').append(captain);
				$('#Table').append(str);
				
				//change topTable0 heading
				$('#topTable td').eq(1).css('background-color','blue');
				//price change
				$('#topTable td').eq(1).html("$" + changedPrice.toString());
				//categorywise number change
				if(category == 'BAT')$('#topTable td').eq(3).html(bats.toString());
				else if(category == 'BOWL')$('#topTable td').eq(5).html(bowl.toString());
				else if(category == 'WK')$('#topTable td').eq(7).html(wk.toString());
				else if(category == 'ALL')$('#topTable td').eq(9).html(all.toString());
				//button status saved
				for(var i=0; i < jArray.length; i++){
				if($.trim(pid) == jArray[i]['Player_id'])
				{
					jArray[i]['Button_status']='false';
				}
			}
		}
	   }else {
			//nothing should be happened here 
			//some error msg
			//system will net let the user to add this row to the user player table
	   }
    });
	
		
		$('#TeamSubmit').click(function() {
			var teamName;
			var captainID;
			var totalRows = document.getElementById("Table").rows.length - 1;
			//change this to 11 later
			if(totalRows != 11){
				$('#elevenPlayerModal').modal('show');  
			}else {
				teamName= $.trim($('#teamNameID').val());
				if(teamName == ''){
					
					$('#emptyTeamNameModal').modal('show');
				}else {
					captainID= $.trim($('#captainSelection option:selected').val());
					// player select korlei default captain selected hobe
					/*
					for(var i=0;i<jArray.length;i++){
						if(jArray[i]['Player_id'] == captainID){
							$("#captainConfirmation .modal-body p").html("Your captain is " +  jArray[i]['Player_name']);
							$('#captainConfirmation').modal('show');
							break;
						}
					}
					*/
					
					
					var TableData;
					
					function storeTblValues()
					{
						var TableData = new Array();

						$('#Table tr').each(function(row, tr){
							TableData[row]={
								"player_name" : $(tr).find('td:eq(0)').text()
								, "player_cat" :$(tr).find('td:eq(1)').text()
								, "price" : $(tr).find('td:eq(2)').text()
								, "team_name" : $(tr).find('td:eq(3)').text()
								, "points" : $(tr).find('td:eq(4)').text()
								, "player_id": $(tr).find('#pid').val()
								
							}
						
						});
						
						//change to 11+1=12
						
						TableData[12]={
							"team_name" : teamName
							,"captain_id" : captainID
						}
						
						TableData.shift();  // first row will be empty - so remove
						return TableData;
					}
					TableData = $.toJSON(storeTblValues());
					
					$.ajax({
						type: "POST",
						url: "createTeam_check",
						data: "pTableData=" + TableData,
						success: function(msg){
							if(msg=='Your Team has been created successfully!')
							{
								window.location.href = "<?php echo site_url('user/createTeam_proc'); ?>";
							}
							else
							{
								alert(msg);
							}
							
						}
					});
				
				}
				
			}
		});
		
		
		
		$("#Table tbody").on("click", ".btn-danger", function(event){
			var closest = $(this).closest('tr');
			var playerID = closest.find('#pid').val();
			//alert(closest.find('#price').val());
			var playerPrice = parseInt(closest.find('#price').val().substr(1),10);
			var currentBalance = parseInt($("#topTable").find('#priceTag').html().substr(1),10);
			var updatedBalance = playerPrice+currentBalance;
			var category = closest.find('#cat').val();
			var teamName = closest.find('#players_team').val();
			if(category == 'ALL'){
				all--;
				if(map.has(teamName)){
					var k = map.get(teamName);
					k--;
					map.set(teamName,k);
				}
				$('#topTable td').eq(9).html(all.toString());
			}else if(category == 'BOWL'){
				bowl--;
				if(map.has(teamName)){
					var k = map.get(teamName);
					k--;
					map.set(teamName,k);
				}
				$('#topTable td').eq(5).html(bowl.toString());
			}else if(category == 'BAT'){
				bats--;
				
				if(map.has(teamName)){
					var k = map.get(teamName);
					k--;
					map.set(teamName,k);
				}
				$('#topTable td').eq(3).html(bats.toString());
			}else if(category == 'WK'){
				wk--;
				
				if(map.has(teamName)){
					var k = map.get(teamName);
					k--;
					map.set(teamName,k);
				}
				$('#topTable td').eq(7).html(wk.toString());
			}
			if(updatedBalance>=0){
				$('#topTable td').eq(1).css('background-color','blue');
				$('#topTable td').eq(1).html("$" + updatedBalance.toString());
			}else {
				$('#topTable td').eq(1).css('background-color','red');
				$('#topTable td').eq(1).html("$" + updatedBalance.toString());
			}
			for(var i=0; i < jArray.length; i++){
				if($.trim(playerID) == jArray[i]['Player_id'])
				{
					jArray[i]['Button_status']='true';
					//alert('done'+jArray[i]['Button_status']);
				}
				
			}
			
			$(this).closest('tr').remove();
			//alert(playerID + " is removed ");
			var dropdownElement = $("#captainSelection");
			dropdownElement.find('option[value='+playerID+']').remove();
			
			$('#myTable tr').each(function(row, tr){
				if(playerID==$(tr).find("#pid").val()){
					$(tr).find("#addButtonID").addClass("btn-success");
				}
			});
		});
		
		$('#catSelectSubmit').click(function(){
				var cat = $("#categories option:selected").text();
				var team = $("#team_ID option:selected").text();
				team = $.trim(team);
				cat = $.trim(cat);
					
			$('#myTable tr').not(":first").each(function(row, tr){
				$(tr).remove();
			});
			
			//alert(cat +" "+ team);
			for(var i=0;i<jArray.length;i++){
				var str = "";
				//alert(jArray[i]['Team_name'] +" >> "+ team);
				if(cat == '---' && team == '---'){
					str+='<tr>';
					str+='<form method="post" action="#" id ="myForm">';
					
					//alert(jArray[i]['Button_status']);
					//str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-danger">Add</button> </td>';
					if(jArray[i]['Button_status']=='false')
					{
						//alert('got it');
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-default">Add</button> </td>';
						
					}
					else
					{
						//$("#addButtonID").prop("disabled",false);
						//$("#addButtonID").toggleClass("clicked");
						//$("#addButtonID").addClass("btn-success");
						
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-success">Add</button> </td>';
					}
					
					str+='<input type="hidden" id="pName" name="name" value="'+jArray[i]['Player_name']+'"><td width="12%" >'+jArray[i]['Player_name']+'</td></input>';
					str+='<input type="hidden" id="cat" name="cat" value="'+jArray[i]['Category']+'"><td width="8%">'+jArray[i]['Category']+'</td></input>';
					str+='<input type="hidden" id="price" name="price" value="$'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
					str+='<input type="hidden" id="players_team" name="team_name" value="'+jArray[i]['Team_name']+'"><td width="10%">'+jArray[i]['Team_name']+'</td></input>';
					str+='<input type="hidden" id="pid" name="player_id" value="'+jArray[i]['Player_id']+'"></input>';
					str+='<input type="hidden" id="points" name="points" value="'+jArray2[i]+'"><td width="10%">'+jArray2[i]+'</td></input>';
					
					str+='</form>';
					str+='</tr>';
					$("#myTable").append(str);
					
					
				}
				else if(jArray[i]['Category'] == cat && team == '---'){			
					str+='<tr>';
					str+='<form method="post" action="#" id ="myForm">';
					if(jArray[i]['Button_status']=='false')
					{
						//alert('got it');
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-default">Add</button> </td>';
						
					}
					else
					{
						//$("#addButtonID").prop("disabled",false);
						//$("#addButtonID").toggleClass("clicked");
						//$("#addButtonID").addClass("btn-success");
						
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-success">Add</button> </td>';
					}
					str+='<input type="hidden" id="pName" name="name" value="'+jArray[i]['Player_name']+'"><td width="12%" >'+jArray[i]['Player_name']+'</td></input>';
					str+='<input type="hidden" id="cat" name="cat" value="'+jArray[i]['Category']+'"><td width="8%">'+jArray[i]['Category']+'</td></input>';
					str+='<input type="hidden" id="price" name="price" value="$'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
					str+='<input type="hidden" id="players_team" name="team_name" value="'+jArray[i]['Team_name']+'"><td width="10%">'+jArray[i]['Team_name']+'</td></input>';
					str+='<input type="hidden" id="pid" name="player_id" value="'+jArray[i]['Player_id']+'"></input>';
					str+='<input type="hidden" id="points" name="points" value="'+jArray2[i]+'"><td width="10%">'+jArray2[i]+'</td></input>';
					
					str+='</form>';
					str+='</tr>';
					$("#myTable").append(str);
					
				}
				
				//console.log(jArray[i]['Team_name']+">>>"+$.trim(team));
				
				else if((jArray[i]['Team_name'] == team) && (cat == '---')){
					//alert('got it');
					
					str+='<tr>';
					str+='<form method="post" action="#" id ="myForm">';
					if(jArray[i]['Button_status']=='false')
					{
						//alert('got it');
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-default">Add</button> </td>';
						
					}
					else
					{
						//$("#addButtonID").prop("disabled",false);
						//$("#addButtonID").toggleClass("clicked");
						//$("#addButtonID").addClass("btn-success");
						
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-success">Add</button> </td>';
					}
					str+='<input type="hidden" id="pName" name="name" value="'+jArray[i]['Player_name']+'"><td width="12%" >'+jArray[i]['Player_name']+'</td></input>';
					str+='<input type="hidden" id="cat" name="cat" value="'+jArray[i]['Category']+'"><td width="8%">'+jArray[i]['Category']+'</td></input>';
					str+='<input type="hidden" id="price" name="price" value="$'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
					str+='<input type="hidden" id="players_team" name="team_name" value="'+jArray[i]['Team_name']+'"><td width="10%">'+jArray[i]['Team_name']+'</td></input>';
					str+='<input type="hidden" id="pid" name="player_id" value="'+jArray[i]['Player_id']+'"></input>';
					str+='<input type="hidden" id="points" name="points" value="'+jArray2[i]+'"><td width="10%">'+jArray2[i]+'</td></input>';
					
					str+='</form>';
					str+='</tr>';
					$("#myTable").append(str);
					
				}
				else if(jArray[i]['Category'] == cat && jArray[i]['Team_name'] == team){			
					str+='<tr>';
					str+='<form method="post" action="#" id ="myForm">';
					if(jArray[i]['Button_status']=='false')
					{
						//alert('got it');
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-default">Add</button> </td>';
						
					}
					else
					{
						//$("#addButtonID").prop("disabled",false);
						//$("#addButtonID").toggleClass("clicked");
						//$("#addButtonID").addClass("btn-success");
						
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-success">Add</button> </td>';
					}
					str+='<input type="hidden" id="pName" name="name" value="'+jArray[i]['Player_name']+'"><td width="12%" >'+jArray[i]['Player_name']+'</td></input>';
					str+='<input type="hidden" id="cat" name="cat" value="'+jArray[i]['Category']+'"><td width="8%">'+jArray[i]['Category']+'</td></input>';
					str+='<input type="hidden" id="price" name="price" value="$'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
					str+='<input type="hidden" id="players_team" name="team_name" value="'+jArray[i]['Team_name']+'"><td width="10%">'+jArray[i]['Team_name']+'</td></input>';
					str+='<input type="hidden" id="pid" name="player_id" value="'+jArray[i]['Player_id']+'"></input>';
					str+='<input type="hidden" id="points" name="points" value="'+jArray2[i]+'"><td width="10%">'+jArray2[i]+'</td></input>';
					
					str+='</form>';
					str+='</tr>';
					$("#myTable").append(str);
					
				}
			}
		});
		
});
</script>
  
  
  
  <!--<td width="5%"><input type="submit" name="submit" id="submit" value="ADD" class="btn btn-primary "></td>
  -->