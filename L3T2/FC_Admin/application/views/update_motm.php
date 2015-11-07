<head>

<style>
	body{
		background-color: teal;
	}
</style>

</head>

<body>
<?php
/*
	//print_r($team_array);	
	foreach($team_array as $team_data)
	{
		echo 'Team Name: '.$team_data['team_name'];
		echo '<br>';
		foreach($team_data['team_players'] as $player_data)
		{
			echo $player_data['PLAYER_NAME'];
			echo '<br>';
		}
		echo '<pre>';
		
	}
	*/
?>
	
	<form method="POST" action="updateMatchStat_proc/2">
	<table>
		<tr height="10"></tr>
		<tr>
			<td style="width:50"></td>
			<td><h4> <strong style="font-family:verdana; font-size:1.25em"> Select Man of the match</strong> </h4></td>
			<td width="50"></td>
			<td>
				<div class="dropdown" >
				<div class = "t1" style="float:left">
				<?php
				
				echo '<h3 style="color:white">'.$team_array[1]['team_name'].'</h3>';
				echo '<table>';
				foreach($team_array[1]['team_players'] as $player_data)
				{
					echo '
						<tr>
						<td width="250"> 
							<h4>
								<input type="radio" name="player_id" required value='.$player_data["PLAYER_ID"].'>'.$player_data["PLAYER_NAME"].'
							</h4>
						</td>
						</tr>';
				}
				echo '</table>';
				echo '<br>';
				?>
				</div>
				<div class="t2" style="float:right">
				<?php
				
				echo '<h3 style="color:white">'.$team_array[2]['team_name'].'</h3>';
				echo '<table>';
				foreach($team_array[2]['team_players'] as $player_data)
				{
					echo '
						<tr>
						<td width="250"> 
							<h4>
								<input type="radio" name="player_id" required value='.$player_data["PLAYER_ID"].'>'.$player_data["PLAYER_NAME"].'
							</h4>
						</td>
						</tr>';
				}
				echo '</table>';
				echo '<br>';
				?>
				</div>
				</div>
			</td>
		</tr>
		
		<tr>
			<td width="50"></td>
			<td></td>
			<td></td>
			<td>
				<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info center-block">
			</td>

		</tr>
	</table>
</form>


</body>