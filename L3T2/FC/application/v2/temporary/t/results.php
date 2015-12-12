
<div class="col-xs-12" style="text-align:center !important;float:left;">
    <h3> <span class="label label-success" > Results </span> </h3>
</div>


<div>
      <div class="col-md-2"></div>
      <div class="col-md-8"> 
        <table class="table table-hover table-bordered">
          <thead>
            <th>Time</th>
            <th>Team 1</th>
            <th>Runs</th>
            <th>Overs</th>
			<th>Team 2</th>
			<th>Runs</th>
            <th>Overs</th>
          </thead>
          <tbody>
		  <?php
          $c2="active";
          $c3="success";
          $c4="info";
          $c1="warning";
          $c=1;$d="";
          for($i=0;$i<5;$i++) {
            if($c%4==0)$d=$c1;
            else if($c%4==1)$d=$c2;
            else if($c%4==2)$d=$c3;
            else if($c%4==3)$d=$c4;
          echo'  <tr class='.$d.'>
              <td>29-05-2016</td>
              <td>Bangladesh</td>
              <td>271/6</td>
              <td>50.0</td>
			  <td>Pakistan</td>
			   <td>233/10</td>
              <td>44.5</td>
            </tr>';
            $c++;
          }
		  ?>
          </tbody>
        </table>
      </div>
      <div class="col-md-2"></div>
  </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>