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
	
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
	<script type="text/javascript" src="https://jquery-json.googlecode.com/files/jquery.json-2.4.min.js" ></script>
	<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-theme.min.css"); ?>" />
	<style>
		#topTable td{
			text-align: center;
			font-family:sans-serif;
			font-size:25px;
			background-color: lightBlue;
		}
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
		#topTable0 th, #topTable0 td{
		
			table-layout:fixed;
			text-align: center;
			font-size:25px;
			font-family:sans-serif;
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
		
        <li class="active"><a href="<?php echo site_url('user/changeTeam'); ?>">Change Team </a></li>
        <li><a href="<?php echo site_url('user/topplayers'); ?>">Top Scorers </a></li>
        <li><a href="#">Prizes </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['user_name'];?><span class="caret"></span></a>
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

<div>
	<table class="table table-bordered"	 class="table table-striped" id = "topTable0">
		<thead>
			<th colspan="3">Next Match</th>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $matchData['home_team_name'].'<br>'; ?></td>
				<td>VS</td>
				<td><?php echo $matchData['away_team_name'].'<br>'; ?></td>
				
			</tr>
			<tr>
				<td colspan="3">Time: <?php echo $matchData['Time'];?></td>	
			</tr>
		</tbody>
	</table>

	
</div>

<table class="table table-bordered" class="table table-striped" id = "topTable" style="table-layout:fixed">
		<thead>
			<th colspan="5" style="text-align:right">Remaining Transfers</th><th colspan="5" style="text-align:left">	<?php echo $free_transfers; ?></th>
		</thead>
		<tbody>
			
			<tr>
				<td>Balance</td>
				<td id="priceTag" style="background-color: Blue; color:white; font-size:20px;"><?php echo '$'.((10000)-$team_status['value']);?></td>
				<td>Batsman</td>
				<td><?php echo $team_status['bat'];?></td>
				<td>Bowler</td>
				<td><?php echo $team_status['bowl'];?></td>
				<td>WK</td>
				<td><?php echo $team_status['wk'];?></td>
				<td>AllRounder</td>
				<td><?php echo $team_status['all'];?></td>
			</tr>
		</tbody>
	</table>


<table style="table-layout:fixed;width:100%;text-align:center">
    <tr>
		<td colspan="5" ><h3><?php echo $team_name;?></h3></td>
		<td colspan="3"></td>
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
			<td><button type="button" name="submit" id="catSelectSubmit" value="GO!" class="btn btn-info block-center">GO</button></td>
		</form>
    </tr>
</table>

<div>
	<div class="col-md-6">
	<div style="overflow:scroll;height:500px;width:100%;overflow:auto;">
	<table class="table table-bordered" class="table table-striped"id = "Table">
		<thead>
			<th>Player Name</th>
			<th>Category</th>
			<th>Price</th>
			<th>Team</th>
			<th>Earned Points</th>		
			
			<th colspan="3">Choose</th>
		</thead>
		<tbody>
		<?php
			
			  $c1="active";
			  $c3="success";
			  $c2="info";
			  $c4="warning";
			  $c5="danger";
			  $c=1;
			  $d="";
			
			
			foreach($user_team as $u)
			{
				echo '<tr >'.'
				
				<form method="post" action="#">

				
					<input type="hidden" id="pName" name="name" value="'.$u['player_name'].'"><td width="12%" >'.$u['player_name'].'</td></input>
					<input type="hidden" id="cat" name="cat" value="'.$u['player_cat'].'"><td width="8%">'.$u['player_cat'].'</td></input>
					<input type="hidden" id="price" name="price" value="$'.$u['price'].'"><td width="10%">$'.$u['price'].'</td></input>
					<input type="hidden" id="pid" name="player_id" value="'.$u['player_id'].'"></input>
					<input type="hidden" id="players_team" name="team_name" value="'.$u['team_name'].'"><td width="10%">'.$u['team_name'].'</td></input>
					<input type="hidden" id="points" name="points" value="'.$u['total_points'].'"><td width="10%">'.$u['total_points'].'</td></input>
					<td width="5%"><button type="button" id="finalBtn" class="btn btn-danger">Remove</button></td>
					
				</form>
			  
				</tr>';
				$c++;
			}
			
		?>  
		</tbody>
	</table>
	</div>
	
	<table style="width:100%;table-layout:fixed">

	  <form method="post" action="createTeam_proc">
	  
	  <tr>
		  <td><strong><h4>Select Captain: </h4></strong></td>
		  <td>
			<select style="width: 50%; margin-left:25%" id="captainSelection" name="captain" required>
						
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
		<td colspan="2">
		<button style="margin-left:35%"type="button" name="submit" id="TeamSubmit" class="btn btn-info btn-lg" >Create Team</button>
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
	
    <div class="col-md-6">
	<div style="overflow:scroll;height:500px;width:100%;overflow:auto;">
      <table id = "myTable"class="table table-bordered">
      <thead>
          
            <th>Choose</th>
            <th>Player Name</th>
            <th>Category</th>
            <th>Price</th>
			<th>Team</th>
			<th>Earned Points</th>
	     
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
		
		$tempStr="";
		if($p['Button_status']=='true')
		{
			$tempStr='<td width="5%"><button type="button" id="addButtonID" class="btn btn-success">Add</button> </td>';
		}
		else
		{
			$tempStr='<td width="5%"><button type="button" id="addButtonID" class="btn btn-default">Add</button> </td>';
		}
        echo'
          <tr>
          <form method="post" action="#" id ="myForm">

            
            '.$tempStr.'
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
    </div>
  </div>
</div>

<script type="text/javascript">
	
$(document).ready(function() {
	var jArray = <?php 
					echo json_encode($players);
				?>;
	
	
	var jArray2 = <?php echo json_encode ($points);?>;
				
	var players = <?php echo json_encode($user_team)?>;
	
	var pp;
	var bats,bowl,wk,all;
	bats = <?php echo $team_status['bat'];?>;
	bowl = <?php echo $team_status['bowl'];?>;
	wk = <?php echo $team_status['wk'];?>;
	all = <?php echo $team_status['all'];?>;
	
	var captainID=<?php echo $captain_id; ?>;
	
	for(var j=0;j<players.length;j++){
		if(players[j]['player_id']==captainID)
		{
			pp = '<option value="' + players[j]['player_id'] + '">' + players[j]['player_name'] +  '</option>';
			$('#captainSelection').append(pp);
		}
	}
	for(var j=0;j<players.length;j++){
		if(players[j]['player_id']!=captainID)
		{
			pp = '<option value="' + players[j]['player_id'] + '">' + players[j]['player_name'] +  '</option>';
			$('#captainSelection').append(pp);
		}
	}
	
	$("#myTable tbody").on("click", ".btn-success", function(event) {
		
		var tr=$(this).closest('tr');
		tr.find("#addButtonID").removeClass("btn-success");
		tr.find("#addButtonID").addClass("btn-default");
		
		var pName = tr.find('#pName').val();
		var category = tr.find('#cat').val();
		var price = tr.find('#price').val();
		//alert(price); // dollar ase
		var pid = tr.find('#pid').val();
		var points = tr.find('#points').val();
		var teamName = tr.find('#players_team').val();
		
		for(var i=0; i < jArray.length; i++){
			if($.trim(pid) == jArray[i]['Player_id'])
			{
				jArray[i]['Button_status']='false';
			}	
		}
		
		var stringCurrentPrice = $("#topTable").find('#priceTag').html();
		alert(stringCurrentPrice);
		var newStringCurrentPrice = stringCurrentPrice.substr(1);
		var intCurrentPrice = parseInt(newStringCurrentPrice, 10);
		var clickedPlayerPrice = parseInt(price.substr(1), 10); // dollar removed from price or right table 
		var changedPrice = (intCurrentPrice-clickedPlayerPrice);
		if(changedPrice<0){
			$('#topTable td').eq(1).css('background-color','red');
			$('#topTable td').eq(1).html("$" + changedPrice.toString());
		
		}else{
			$('#topTable td').eq(1).css('background-color','blue');
			$('#topTable td').eq(1).html("$" + changedPrice.toString());
		}
		if(category == 'BAT'){
			bats++;
		
			$('#topTable td').eq(3).html(bats.toString());
		}else if(category == 'BOWL'){
			bowl ++;
			$('#topTable td').eq(5).html(bowl.toString());
		}else if(category == 'WK'){
			wk++;
			$('#topTable td').eq(7).html(wk.toString());
		}else if(category == 'ALL'){
			all++;
			$('#topTable td').eq(9).html(all.toString());
		}
		
		var largeStr = '<form method="post" action="#">';
		largeStr+='<button type="button" class="btn btn-danger">Remove</button>';
		largeStr+='<input type="hidden" id="pName" name="name" value="'+pName+'"></input>';
        largeStr+='<input type="hidden" id="cat" name="cat" value="'+category+'"></input>';
		largeStr+='<input type="hidden" id="price" name="price" value="'+price+'"></input>';
		largeStr+='<input type="hidden" id="pid" name="player_id" value="'+pid+'"></input>';
		largeStr+='<input type="hidden" id="players_team" name="team_name" value="'+teamName+'"></input>';
		
		largeStr+='<input type="hidden" id="points" name="points" value="'+points+'"</input></form>';
		var str = '<tr class="child"><td>' + pName + '</td><td>' + category + '</td><td>' + price + '</td><td>' + teamName + '</td><td>' + points + '</td><td>'+ largeStr + '</td></tr>';
		var captain = '<option value="' + pid + '">' + pName +  '</option>';
		$('#captainSelection').append(captain);
		$('#Table').append(str);
    });
	
		
		$('#TeamSubmit').click(function() {
			var teamName;
			var captainID;
			var totalRows = document.getElementById("Table").rows.length - 1;
			if(totalRows != 11){
				$('#elevenPlayerModal').modal('show');  
			}
			else
			{
				captainID= $.trim($('#captainSelection option:selected').val());	
				
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
				
				var TableData;
				TableData = $.toJSON(storeTblValues());
					
				$.ajax({
					type: "POST",
					url: "changeTeam_check",
					data: "pTableData=" + TableData,
					success: function(msg){
				
						// return value stored in msg variable
						//alert(msg);
								
						if(msg=='Your Team has been changed successfully!')
						{
							window.location.href = "<?php echo site_url('user/view_team'); ?>";
						}
						else if(msg=='CONFIRM TRANSFER')
						{
							window.location.href = "<?php echo site_url('user/changeTeam_confirm'); ?>";
						}
						else
						{
							alert(msg);
						}
								
					}
				});
				
			}
		});
		$("#Table tbody").on("click", ".btn-danger", function(event){
			var closest = $(this).closest('tr');
			var playerID = closest.find('#pid').val();
			//alert(closest.find('#price').val());
			var playerPrice = parseInt(closest.find('#price').val().substr(1),10);
			
			var currentBalance = parseInt($("#topTable").find('#priceTag').html().substr(1),10);
			
			var updatedBalance = playerPrice+currentBalance;
			//alert(playerPrice + ' ' + currentBalance +'='+ updatedBalance);
			var category = closest.find('#cat').val();
			if(category == 'ALL'){
				all--;
				$('#topTable td').eq(9).html(all.toString());
			}else if(category == 'BOWL'){
				bowl--;
				$('#topTable td').eq(5).html(bowl.toString());
			}else if(category == 'BAT'){
				bats--;
				$('#topTable td').eq(3).html(bats.toString());
			}else if(category == 'WK'){
				wk--;
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
					//alert(jArray[i]['Player_name']+'?'+true+'?');
				}
			}
			
			$(this).closest('tr').remove();
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
			for(var i=0;i<jArray.length;i++){
				var str = "";
				if(cat == '---' && team == '---'){
					str+='<tr>';
					str+='<form method="post" action="#" id ="myForm">';
					if(jArray[i]['Button_status']=='false')
					{
						//alert('got it');
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-default">Add</button> </td>';
						
					}
					else
					{
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
				else if((jArray[i]['Team_name'] == team) && (cat == '---')){
					str+='<tr>';
					str+='<form method="post" action="#" id ="myForm">';
					if(jArray[i]['Button_status']=='false')
					{
						//alert('got it');
						str+='<td width="5%"><button type="button" id="addButtonID" class="btn btn-default">Add</button> </td>';
						
					}
					else
					{
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
  