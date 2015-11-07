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
        <br>';
		if($match_id==null)
		{
			echo '<input type="button" style="display: none;" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit1" class="btn btn-default" />';	
		}
		else
		{
			echo '<input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit1" class="btn btn-default" />';
		}
		?>
		<br>
      </div>
	  </form>
	  
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
		<div class="col-xs-3" style="text-align:center !important; float:right; vertical-align:top; padding:left">';
		
		if($phase_id==null)
		{
			echo '<input type="button" style="display: none;" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit2" class="btn btn-default" />';	
		}
		else
		{
			echo '<input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit2" class="btn btn-default" />';
		}
	?>
		
			
		</div>
	  </form>
    </div>

	<hr>

	
<div class="modal fade" id="confirm-submit1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Initialize Match Data?
            </div>
            <div class="modal-body">
                This action involves some crucial operations on the system and required to enable transfer for the mentioned match. Please proceed if you are sure
                
            </div>
            <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="<?php echo site_url('admin/start_match_action').'/'.$match_id; ?>" id="submit" class="btn btn-success success">Submit</a>
            </div>
        </div>
    </div>
</div>
	
<div class="modal fade" id="confirm-submit2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Initialize Phase Data?
            </div>
            <div class="modal-body">
                This action involves some crucial operations on the system and required to enable transfer for the mentioned phase. Please proceed if you are sure
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="<?php echo site_url('admin/start_phase_action').'/'.$phase_id; ?>" id="submit" class="btn btn-success success">Submit</a>
            </div>
        </div>
    </div>
</div>
  </body>

</html>
<!--
<br><input type="submit" value="Initialize Phase Data" class="btn btn-info">  </input><br>
	-->		