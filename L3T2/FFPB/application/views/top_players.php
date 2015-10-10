<div class="col-xs-12" style="text-align:center !important;float:left;">
    <h3> <span class="label label-success" > Top Scoring Players </span> </h3>
</div>


<div>
      <div class="col-md-2"></div>
      <div class="col-md-8"> 
        <table class="table table-hover table-bordered">
          <thead>
            <th>Player Name</th>
            <th>Team Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Point</th>
          </thead>
          <tbody>
		  
		  <?php
          $c1="active";
          $c3="success";
          $c2="info";
          $c4="warning";
          $c=1;$d="";
          for($i=0;$i<5;$i++) {
            if($c%4==0)$d=$c1;
            else if($c%4==1)$d=$c2;
            else if($c%4==2)$d=$c3;
            else if($c%4==3)$d=$c4;
          echo'<tr class='.$d.'>
              <td>Player'.$i.'</td>
              <td>Team'.$i.'</td>
              <td>Batsman</td>
              <td>$500</td>
              <td>54</td>
            </tr>';
            $c++;
          }?>
          </tbody>
        </table>
      </div>
      <div class="col-md-2"></div>
  </div>
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>