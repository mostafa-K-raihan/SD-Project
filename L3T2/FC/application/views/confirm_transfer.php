<html>
	<head>
	</head>
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
		
			#mainDiv{
				margin: 0 auto;
				text-align: left;
				width: 800px;
				height: 500px;
				
			}
			h2{
				margin-top: 5%;
			}
			#transferTable{
				table-layout:fixed;
				background-color:lightBlue;
			}
			#transferTable th,#transferTable td{
				text-align: center;
			}
		</style>
	<body>
		<div id="mainDiv">
			<h2>Transfers</h2>
			<?php
				echo '<table class="table table-hover table-bordered"  id="transferTable">
					<thead>
						<th>Player(s) out</th>
						<th>Player(s) in</th>
					</thead>
					<tbody>';
					 
					$len = count($transfer_outs);
					for($i=0;$i<$len;$i++){
						echo '<tr><td>';
						echo $transfer_outs[$i]['name'];
						echo '</td><td>';
						echo $transfer_ins[$i]['name'];
						echo '</td></tr>';
					}
					?>
				</tbody>
			</table>
			
			<h4>Deducted Transfers 
			<?php echo $used_transfer;?>
			</h4>
			<table style="table-layout:fixed;width:100%">
			<tbody>
			<tr><td><form action="changeTeam" method="POST" >
				
				<input type="submit" class="btn btn-primary pull-left" name="reject_transfer" value="BACK">
	
			</form>
			</td>
			<td>
			<form action="changeTeam_proc" method="POST" >
				
				<input type="submit" class="btn btn-success pull-right"  name="confirm_transfer" value="CONFIRM">
	
			</form>
			</td>
			</tr>
			</tbody>
			</table>
		</div>
	</body>
</html>