	<?php
		if($success==true)
		{
			echo '<div class="alert alert-success">
				<strong><span class="glyphicon glyphicon-ok"></span> '.$success_message.' </strong>
			 </div>';
		}
		else
		{
			echo '<div class="alert alert-danger">
				<strong><span class="glyphicon glyphicon-remove"></span> '.$fail_message.'</strong>
			 </div>';
		}

	?>

	</body>
</html>