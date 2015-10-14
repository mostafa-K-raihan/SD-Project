	<!--Show Team Status //Needs to be modified -->
			
	<pre>Number Of Players : 10 </pre>
	<pre>Batsman: 3    Bowlers: 3    Allrounders: 4    Wicket Keeper: 1</pre>
	<pre>Team Value : 9780 </pre>
	<pre>Free Transfers : 36 </pre>
	
  
	<table>
    <tr>
      <td width="300"></td>
      <td>
          <h3>USER TEAM NAME</h3>
      </td>
      <td width="350"></td>
      <td><strong>Sort By (Category): </strong></td>
      <td>
		<form method="post" action="changeTeam">
        <select name="cat" >
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
        <select name="team_id" >
			<option value="">---</option>';
            <?php 
			for($i=0;$i<3;$i++) {
				echo '<option value=""> Team'.$i.' </option>';
			}
		  ?>
        </select>
      </td>
      <td width="10"></td>
      <td>
        <input type="submit" name="submit" id="submit" value="GO!" class="btn btn-info pull-right">
      </td>
      </form>
    </tr>
  </table>

  <div>
    <div class="col-md-6">
      <table class="table table-bordered" class="table table-striped" class="table table-hover">
      <thead>
		  
				<th>Player Name</th>
				<th>Category</th>
				<th>Price</th>
				<th>Earned Points</th>
				
				<th colspan="3"></th>
			  
			  </thead>
			  <tbody>
			  <?php
			  $c1="active";
			  $c3="success";
			  $c2="info";
			  $c4="warning";
			  $c5="danger";
			  $c=1;$d="";
			  
			for($i=0;$i<5;$i++)
			{
				if($c%5==0)$d=$c1;
				else if($c%5==1)$d=$c2;
				else if($c%5==2)$d=$c3;
				else if($c%5==3)$d=$c4;
				else if($c%5==4)$d=$c5;
				echo '<tr class='.$d.'>
				
				<form method="post" action="#">
					<input type="hidden" name="name" value="Shakib"><td width="12%" >Shakib Al Hasan</td></input>
					<input type="hidden" name="cat" value="ALL-Rounder"><td width="8%">All-Rounder</td></input>
					<input type="hidden" name="price" value="980"><td width="10%">$980</td></input>
					<input type="hidden" name="points" value="200"><td width="10%">200</td></input>
					<td width="5%"><input type="submit" name="submit" id="submit" value="REMOVE" class="btn btn-danger "></td>
					
				</form>
			  
			  </tr>';
			  $c++;
			}
			?>
	  <tbody>
    </table>
	
		<table>
		  <form method="post" action="changeTeam_check">
	  
		  <tr height="20"></tr>
		  <tr>
		  <td><strong><h4>Select Captain: </h4></strong></td>
		  <td ></td>
		  <td>
			<select name="captain" required>';
				<?php
				for($i=0;$i<5;$i++)
				{
					echo '<option value="#" selected>Player'.$i.'</option>';
				}
				?>
				
				
			</select>
		</tr>
			
		  
		<tr height="10">
			<td> <br> </td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" id="submit" value="COMPLETE TRANSFER" class="btn btn-danger "></td>
			</td>
		</tr>
		</table>
    </div>
	
    <div class="col-md-6">
      <table class="table table-bordered">
      <thead>
          <tr>
            <th ></th>
            <th>Player Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Earned Points</th>
            
          
          </tr>
        </thead>
        <tbody>
		<?php
        $index =0;
        for($i=0;$i<10;$i++) {
          echo'
          <tr >
          <form method="post" action="add_transfered_player">

            <td width="5%"><input type="submit" name="submit" id="submit" value="ADD" class="btn btn-primary "></td>
            <input type="hidden" name="name" value="#"><td width="12%" >AB De Villeiers</td></input>
            <input type="hidden" name="cat" value="#"><td width="8%">Batsman</td></input>
            <input type="hidden" name="price" value="#"><td width="10%">$1100</td></input>
			<input type="hidden" name="points" value="#"><td width="10%">278</td></input>
            
          </form>
          </tr>';
          $index++;
        }
		?>		
        </tbody>
    </table>
    </div>
  </div>