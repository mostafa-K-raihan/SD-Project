<!--
Show Team Status 
<Needs to be modified>
-->

<pre> Number Of Players : 11 </pre>
<pre>Batsman: 3    Bowlers: 4    Allrounders: 3    Wicket Keeper: 1 </pre>
<pre>Team Value : 10,000 </pre>
	
 <table>
    <tr>
      <td width="300"></td>
      <td>
          <h3>YOUR TEAM</h3>
      </td>
      <td width="350"></td>
      <td><strong>Sort By (Category): </strong></td>
      <td>
		<form method="post" action="createTeam">
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
			<option value="">---</option>
            <option value=1> Bangladesh </option>
			<option value=2> Australia </option>
			<option value=3> South-Africa </option>
		</select>
      </td>
	  
      <td width="10"></td>
      <td>
        <input type="submit" name="submit" id="submit" value="GO!" class="btn btn-info pull-right">
      </td>
      </form>
    </tr>
  </table>

  <div >
    <div class="col-md-6">
      <table class="table table-bordered" class="table table-striped" class="table table-hover" >
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
			  $c=1;
			  $d="";
			
			for($i=0;$i<11;$i++)
			{
				if($c%5==0)$d=$c1;
				else if($c%5==1)$d=$c2;
				else if($c%5==2)$d=$c3;
				else if($c%5==3)$d=$c4;
				else if($c%5==4)$d=$c5;
				echo '<tr class='.$d.'>'.'
				
			<form method="post" action="remove_user_team_player">

            
            <input type="hidden" name="name" value=" Shakib Al Hasan "><td width="12%" > Shakib Al Hasan </td></input>
            <input type="hidden" name="cat" value="All Rounder"><td width="8%">All Rounder</td></input>
            <input type="hidden" name="price" value="1200"><td width="10%">$1200</td></input>
			<input type="hidden" name="player_id" value="1"></input>
            <input type="hidden" name="points" value="120"><td width="10%">120</td></input>
			<td width="5%"><input type="submit" name="submit" id="submit" value="REMOVE" class="btn btn-danger "></td>
            
          </form>
			  
			  </tr>';
			  $c++;
			}
			?>
		  
		  
		<tbody>
        
	  </table>
	  
	  <table>
    
	  <form method="post" action="createTeam_proc">
	  <tr>
	  <td width="200"><strong><h4>Team Name: </h4></strong></td>
	  <td></td>
	  <td>
		<input type="text" name="team_name" required></input>
	  </td>
      </tr>
	  
	  <tr height="20"></tr>
      <tr>
      <td><strong><h4>Select Captain: </h4></strong></td>
      <td ></td>
      <td>
        <select name="captain" required>
			<option value="1">Shakib Al Hasan</option>
			<option value="2">Tamim Iqbal</option>
			<option value="3">Glen Maxwell</option>			
		</select>
	  </td>
	  </tr>
	
	<tr height="10">
		<td> <br> </td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="submit" id="submit" value="CREATE TEAM" class="btn btn-danger "></td>
		</td>
    </tr>
	
	<tr height="50"></tr>
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
        for($index=0;$index<11;$index++) {
          echo'
          <tr >
          <form method="post" action="add_user_team_player">

            <td width="5%"><input type="submit" name="submit" id="submit" value="ADD" class="btn btn-primary "></td>
            <input type="hidden" name="name" value="Tamim Iqbal"><td width="12%" >Tamim Iqbal</td></input>
            <input type="hidden" name="cat" value="BAT"><td width="8%">Batsman</td></input>
            <input type="hidden" name="price" value="900"><td width="10%">$900</td></input>
			<input type="hidden" name="player_id" value="2"></input>
            <input type="hidden" name="points" value="387"><td width="10%">387</td></input>
            
          </form>
          </tr>';
          $index++;
        }
		?>		
        </tbody>
    </table>
    </div>
  </div>
