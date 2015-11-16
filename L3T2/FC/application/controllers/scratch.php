//3. CHECK TEAM DISTRIBUTION
				$user_id = $_SESSION['user_id'];
					$ft=0;
					$ft=$this->user_model->get_remaining_transfers($_SESSION['user_id']);
		
					//$used_transfer=0;
					$used_transfer=$this->user_model->get_used_transfers($user_id,$user_team);
					
					//Condition 0: No Transfer (Same Team Selected Again) -> only captain can be changed
					if($used_transfer==0)
					{
						$user_id=$_SESSION['user_id'];
					
						$match=$this->match_model->get_upcoming_match()->row_array();
						$match_id=$match['match_id'];
					
						$new_captain_id=$tableData[11]['captain_id'];
						
						$this->user_model->change_captain($user_id,$match_id,$new_captain_id);
						echo 'Your Team has been changed successfully!';
					}
					else
					{
						if($ft!='UNLIMITED' and $used_transfer>$ft)
						{
							//ERROR :: TRANSFER LIMIT EXCEDED. DISALLOW USER
							echo 'Transfer Limit Exceded';
						}
						
						$data['transfer_outs']=$this->user_model->get_transfer_outs($user_id,$user_team_players);
						$data['transfer_ins']=$this->user_model->get_transfer_ins($user_id,$user_team_players);
						
						$_SESSION['transfer_outs']=$data['transfer_outs'];
						$_SESSION['transfer_ins']=$data['transfer_ins'];
						
						print_r($_SESSION['transfer_outs']);
						echo '<br>';
						print_r($_SESSION['transfer_ins']);
						//DO SOME DB operations
						//LOAD SUCCESS MESSAGE
						echo 'Your Team has been changed successfully!';
					}
					
				}