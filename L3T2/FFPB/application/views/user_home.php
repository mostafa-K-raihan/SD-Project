<div class="container" class="row-fluid PageHead"> <!-- Description Start -->
    <div class="span12">
      <h1 style="color:#180000">Incredible XI</h1>
    </div>
</div> <!-- Description End -->

<div class="row" >
	<div class="col-md-8" style="float:right">
	<table>
	<tr>
		<!--
		<td>
			<div class="col-md-4">
				<a href="#" class="btn btn-primary btn-lg active" role="button" style="float:right">Captain </a>
			</div>
		</td>
		-->
		<form action="#" method="POST">
		
		<td>
			Captain:
		</td>
		
		<td width="10"> </td>
		
		<td>
			<div class="dropdown">
			  <select name="captain" id="captain_select" role="menu" aria-labelledby="dLabel">
				<option value="#" selected>Shakib Al Hasan</option>
				<option value="#" >Player1</option>
				<option value="#" >Player2</option>
			  </select>
			</div>
		</td>
		
		<td width="50"> </td>
		
		<td>
			  <input type="submit" class="btn btn-primary btn-lg active" value="Change Captain" action="#" style="float:right">
		</td>
		
		</form>
		
		<td width="200"></td>
		
		<td>
			<td>Overall Points: 567 </td>
		</td>
		
		<td></td>
	</tr>
	
	</table>
  </div>
	
</div>


<div class="col-xs-12" class="container-fluid">
   
</div>

<div class="container-fluid class="row-fluid">
<!-- Row2 start -->
  
<?php
	for($i=0;$i<11;$i++)
	{
    echo '<div class="span3 PlanPricing template4" style="width:180px">  <!-- Price template4 Starts -->
      <div class="planName"> <span class="price">546</span>
        <h4>Taskin Ahmed</h4>
        <p>Bangladesh</p>
      </div>
      <div class="planFeatures">
        <ul>
          <li><img src="'.base_url('images/e1.png/').'" height="80" width="80" class="img-circle" alt="Circular Image"></li>
        </ul>
      </div>
      <p> <a href="#" role="button" data-toggle="modal" class="btn btn-success btn-large" height="50" width="50">Bowler</a> </p>
    </div>';
	}
?>

    
  </div>  <!-- Row3 ends -->
  
  <br><br> <br><br> <br><br>
  
</div> <!-- Container ends -->


<!-- footer -->
<hr>
<footer>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <p class="navbar-brand">   This website is under construction. Any type of feedback from you will be appriciated.</p>  
      <a class="navbar-brand" class="col-lg-12" href="#"><p>Copyright &copy; Your Website 2015</p></a>
    </div>
  </div>
</nav>
</footer>
<hr>

<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-1.11.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>

</body>
</html>