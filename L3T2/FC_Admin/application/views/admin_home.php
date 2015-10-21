    <div style="height:140px">
      <div class="col-xs-3"></div>
      <!--
	  <div class="col-xs-3">
        <h1><span class="label label-danger">Current Tournament </span></h1>
      </div>
	  -->
      <div class="col-xs-3">
        <h1><span class="label label-success"><?php echo $tournament_name;?> </span></h1>
      </div>
      <div class="col-xs-3"></div>
    </div>

    <!--- You have to edit from here  -->
    <hr>
    <div style="height:60px"> 
      <div class="col-xs-3" style="text-align:center !important;float:left;">
        <h2><span class="label label-default" > Upcoming Match </span></h2>
      </div>
      <div class="col-xs-3" style="text-align:center;">
        <h2><span class="label label-primary" > <?php echo $home_team; ?> </span><span class="label label-warning">Vs </span><span class="label label-primary"> <?php echo $away_team; ?> </span></h2>
      </div>
	  
      <?php
	  echo '<form method="POST" action="admin/start_match_action/'.$match_id.'">
	  <div class="col-xs-3" style="text-align:center !important; float:right; vertical-align:top; padding:left">
        <br><input type="submit" value="Initialize Match Data" class="btn btn-info">  </input><br>
      </div>
	  </form>';
	  ?>
	  
    </div>
	
    <hr>
    <div style="height:60px"> 
      <div class="col-xs-3" style="text-align:center !important;float:left;">
        <h2><span class="label label-default" > Upcoming Phase </span></h2>
      </div>
	  <div class="col-xs-3" style="text-align:center;">
		<h2><span class="label label-primary"> <?php echo $upcoming_phase ;?> </span></h2>
      </div>
	  
	  <?php
	  echo '<form method="POST" action="admin/start_phase_action/'.$phase_id.'">
		<div class="col-xs-3" style="text-align:center !important; float:right; vertical-align:top; padding:left">
			<br><input type="submit" value="Initialize Phase Data" class="btn btn-info">  </input><br>
		</div>
	  </form>';
	  ?>
    </div>

	<hr>

  </body>

</html>