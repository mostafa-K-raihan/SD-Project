<table>
	<tr>
		<td>
			<tr>Transfer Outs: </tr>
			<hr>
			<tr> </tr>
			<?php
			for($i=0;$i<3;$i++)
			{
				echo'<tr><pre>Player'.$i.'</pre></tr>';	
			}?>
					
		</td>
				
		<td>
					
			<tr>Transfer Ins: </tr>
			<hr>
			<tr> </tr>
					
			<?php
			for($i=0;$i<3;$i++)
			{
				echo'<tr><pre>Player'.$i.'</pre></tr>';	
			}?>
			
		</td>
			
		<tr height="30"> <br> </tr>
		<tr height>
				Deducted Transfers: 3
		</tr>
	</tr>
</table>

<div>
	<table>
		<tr height="1"> </tr>
		<tr>
			<td>
			<form action="changeTeam" method="POST" >

				<input type="submit" name="reject_transfer" value="BACK">
				
			</form>
			</td>

			<td width="50"> </td>
			
			<td>
			<form action="changeTeam_proc" method="POST" >

				<input type="submit" name="confirm_transfer" value="CONFIRM">
				
			</form>
			</td>
		</tr>
	<table>
</div>