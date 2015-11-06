<head>
	<style>
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

<div class="col-xs-12" style="text-align:center !important;float:left;">
    <h3> <span class="label label-primary" style="background-color:#abc">Tournament Fixture </span> </h3>
  </div>
<div>
      <div class="col-md-3"></div>
      <div class="col-md-6">
		<table class="table table-striped">
          <thead>
            <th>Time</th>
            <th>Team 1</th>
            <th>Team 2</th>
          </thead>
          <tbody>
			<?php
			foreach($fixture as $f)
			{
				echo '
				<tr>
				<td>'.$f['Time'].'</td>
				<td>'.$f['home_team_name'].'</td>
				<td>'.$f['away_team_name'].'</td>
				</tr>';
			}
			?>
		</tbody>
        </table>
      </div>
      <div class="col-md-3"></div>
  </div>
	<script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>