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
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://jquery-json.googlecode.com/files/jquery.json-2.4.min.js" ></script>	

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
	  
        <li class="active"><a href="<?php echo site_url('user'); ?>">HOME <span class="sr-only">(current)</span></a></li>
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

 

<?php
	//Show Team Status //Needs to be modified
	if(isset($_SESSION['user_team']))
	{
		$user_team=$_SESSION['user_team'];
		
		$team_value=0;
		$bat=0;
		$bowl=0;
		$all=0;
		$wk=0;
		$number_of_players=0;
		
		foreach($user_team as $u)
		{
			$team_value+=$u['price'];
			if($u['player_cat']==='BAT') $bat++;
			else if($u['player_cat']==='BOWL') $bowl++;
			else if($u['player_cat']==='ALL') $all++;
			else if($u['player_cat']==='WK') $wk++;
			
			$number_of_players++;
		}
		echo '<pre>Number Of Players : '.$number_of_players.'</pre>';
		echo'<pre>Batsman: '.$bat.'    Bowlers: '.$bowl.'    Allrounders: '.$all.'    Wicket Keeper: '.$wk.'</pre>';
		echo '<pre>Team Value : '.$team_value.'</pre>';
	}
?>

<table>
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

<div>
	<div class="col-md-6">
	<table class="table table-bordered" class="table table-striped" class="table table-hover" id = "Table">
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
			
			//comment out the for loop later
			foreach($user_team as $u)
			{
				if($c%5==0)$d=$c1;
				else if($c%5==1)$d=$c2;
				else if($c%5==2)$d=$c3;
				else if($c%5==3)$d=$c4;
				else if($c%5==4)$d=$c5;
				echo '<tr class='.$d.'>'.'
				
				<form method="post" action="#">

				
					<input type="hidden" name="name" value="'.$u['player_name'].'"><td width="12%" >'.$u['player_name'].'</td></input>
					<input type="hidden" name="cat" value="'.$u['player_cat'].'"><td width="8%">'.$u['player_cat'].'</td></input>
					<input type="hidden" name="price" value="'.$u['price'].'"><td width="10%">$'.$u['price'].'</td></input>
					<input type="hidden" name="player_id" value="'.$u['player_id'].'"></input>
					<input type="hidden" name="points" value="'.$u['total_points'].'"><td width="10%">'.$u['total_points'].'</td></input>
					<td width="5%"><button type="button" id="finalBtn" class="btn btn-danger">Remove</button></td>
					
				</form>
			  
				</tr>';
				$c++;
			}
		?>  
		</tbody>
	</table>
	
	<table>

	  <form method="post" action="#">
	  <tr>
	  <td width="200"><strong><h4>Team Name: </h4></strong></td>
	  <td></td>
	  <td>
		<input id="team_name_input" style="width:100%" type="text" name="team_name" required></input>
	  </td>
      </tr>
	  
	  <tr height="20"></tr>
      <tr>
      <td><strong><h4>Select Captain: </h4></strong></td>
      <td ></td>
      <td>
        <select style="width:100%" id="captainSelection" name="captain" required>
					
		</select>
	  </td>
	  </tr>
	
	<tr height="10">
		<td> <br> </td>
	</tr>
	<tr>
		<td></td>
		<td><button type="button" name="submit" id="TeamSubmit" class="btn btn-danger ">Create Team</button></td>
		</td>
    </tr>
	
	<tr height="50"></tr>
  </table>
  
    </div>
	
    <div class="col-md-6">
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
            <input type="hidden" id="price" name="price" value="'.$p['Price'].'"><td width="10%">$'.$p['Price'].'</td></input>
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



<script type="text/javascript">
	
$(document).ready(function() {
	var jArray = <?php 
					echo json_encode($players);
				?>;
	var jArray2 = <?php echo json_encode ($points);?>;
				
	$("#myTable tbody").on("click", ".btn-success", function(event) {
		/*var formElements=document.getElementById("myForm").elements;    
		var postData={};
		for (var i=1; i<formElements.length; i++)
			if (formElements[i].type!="submit")//we dont want to include the submit-buttom
				//alert(formElements[i].value);	
		
		var tr = $(this).closest('tr');	
	
		var cell2 = tr.find('td').eq(1).text();
		var cell3 = tr.find('td').eq(2).text();
		var cell4 = tr.find('td').eq(3).text();
		var cell5 = tr.find('td').eq(4).text();
		var cell6 = tr.find('td').eq(5).text();
		var btn = tr.find('td').eq(0).text();
		*/
		var tr=$(this).closest('tr');
		//tr.find("#addButtonID").prop("disabled",true);
		//tr.find("#addButtonID").toggleClass("clicked");
		tr.find("#addButtonID").removeClass("btn-success");
		tr.find("#addButtonID").addClass("btn-default");
		
		
	//var pName = tr.find('#pName').val();
		
		var pName = tr.find('#pName').val();
		var category = tr.find('#cat').val();
		var price = tr.find('#price').val();
		var pid = tr.find('#pid').val();
		var points = tr.find('#points').val();
		var teamName = tr.find('#players_team').val();
		
		for(var i=0; i < jArray.length; i++){
			if($.trim(pid) == jArray[i]['Player_id'])
			{
				jArray[i]['Button_status']='false';
				//alert('done'+jArray[i]['Button_status']);
			}
			
		}
		
		
		
		//alert(pName);
		var largeStr = '<form method="post" action="#">';
		largeStr+='<button type="button" class="btn btn-danger">Remove</button>';
		largeStr+='<input type="hidden" id="pName" name="name" value="'+pName+'"</input>';
        largeStr+='<input type="hidden" id="cat" name="cat" value="'+category+'"</input>';
		largeStr+='<input type="hidden" id="price" name="price" value="'+price+'"</input>';
		largeStr+='<input type="hidden" id="pid" name="player_id" value="'+pid+'"></input>';
		largeStr+='<input type="hidden" id="players_team" name="team_name" value="'+teamName+'"></input>';
		
		largeStr+='<input type="hidden" id="points" name="points" value="'+points+'"</input></form>';
		var str = '<tr class="child"><td>' + pName + '</td><td>' + category + '</td><td>' + price + '</td><td>' + teamName + '</td><td>' + points + '</td><td>'+ largeStr + '</td></tr>';
		//alert(str);
		var captain = '<option value="' + pid + '">' + pName +  '</option>';
		$('#captainSelection').append(captain);
	   $('#Table').append(str);
    });
	
		
		$('#TeamSubmit').click(function() {
		
			//TODO
			/*
				#REMOVE ALL ALERT MESSAGES
				#COUNT NUMBER OF PLAYERS - IF NOT 11, DONOT ALLOW
				#A TEAM NAME MUST BE SUBMITTED , ELSE SHOW ALERT MESSAGE
				#A CAPTAIN MUST BE SELECTED, ELSE SHOW ALERT MESSAGE
				#ELSE PROCEDE
			*/
			var TableData;
			TableData = $.toJSON(storeTblValues());
			
			$.ajax({
				type: "POST",
				url: "createTeam_check",
				data: "pTableData=" + TableData,
				success: function(msg){
			
			// return value stored in msg variable
				alert(msg);
			}
			});
			
			function storeTblValues()
			{
				//TODO
				/*
					#SEND USER_TEAM_NAME
					#SEND USER_CAPTAIN_ID
				*/
				var TableData = new Array();

				$('#Table tr').each(function(row, tr){
					TableData[row]={
						"player_name" : $(tr).find('td:eq(0)').text()
						, "player_cat" :$(tr).find('td:eq(1)').text()
						, "price" : $(tr).find('td:eq(2)').text()
						, "team_name" : $(tr).find('td:eq(3)').text()
						, "points" : $(tr).find('td:eq(4)').text()
						, "player_id": $('#pid').val()
						
					}
				
				});
				TableData.shift();  // first row will be empty - so remove
				return TableData;
			}
		});
		
		
		
		$("#Table tbody").on("click", ".btn-danger", function(event){
			//var pid = $('#pid').val();
			
			//alert(pid);
			var closest = $(this).closest('tr');
			var playerID = closest.find('#pid').val();
			
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
					//$(tr).find("#addButtonID").prop("disabled",false);
					//$(tr).find("#addButtonID").toggleClass("clicked");
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
					str+='<input type="hidden" id="price" name="price" value="'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
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
					str+='<input type="hidden" id="price" name="price" value="'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
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
					str+='<input type="hidden" id="price" name="price" value="'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
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
					str+='<input type="hidden" id="price" name="price" value="'+jArray[i]['Price']+'"><td width="10%">$'+jArray[i]['Price']+'</td></input>';
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