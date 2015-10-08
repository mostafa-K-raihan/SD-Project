<?php
	echo '<table>
			<tr>
				<td>
					<tr>Transfer Outs: </tr>
					<hr>
					<tr> </tr>';
			foreach($transfer_outs as $p)
			{
				echo'<tr><pre>'.$p['name'].'</pre></tr>';	
			}
					
	echo'			</td>
				
				<td>
					
				</td>
				
				<td>
					<tr>Transfer Ins: </tr>
					<hr>
					<tr> </tr>';
			foreach($transfer_ins as $p)
			{
				echo'<tr><pre>'.$p['name'].'</pre></tr>';	
			}
	echo'			</td>
			</tr>
			
			<tr> </tr>
			<tr>';
				echo'Deducted Transfers: '.$used_transfers.'
			</tr>
		</table>';
?>

<form action="changeTeam" method="POST" >

	<input type="submit" name="reject_transfer" value="BACK">
	
</form>

<form action="changeTeam_proc" method="POST" >

	<input type="submit" name="confirm_transfer" value="CONFIRM">
	
</form>

