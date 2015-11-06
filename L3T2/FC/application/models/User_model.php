<?php

/*
	THE REMAINING LOGICAL TASK
	
	(1) WHEN A USER CREATES A NEW TEAM,
		----- INSERT INTO USER_PHASE_TRANSFER
		----- HANDLE THE TRANSFER COUNT OF HIS/HER FIRST MATCH CAREFULLY
		
	(2) CHECK BEFORE GIVING ACCESS TO CHANGE TEAM,
		----- THE USER HAS A TEAM IN THE CURRENT TOURNAMENT
*/

class User_model extends CI_Model 
{

    public function __construct()
	{
        $this->load->database();
	}
	
	
	public function get_remaining_transfers($user_id)
	{
		if($this->tournament_model->get_current_phase() === NULL)
		{
			return 'UNLIMITED';
		}
		
		$sql='SELECT P.free_transfers-UPT.transfers_made as FT
			FROM phase P, user_phase_transfer UPT
			WHERE P.phase_id=current_phase()
			AND P.phase_id=UPT.phase_id AND UPT.user_id=?';
		$query=$this->db->query($sql,$user_id);
		
		$result=$query->row_array();
		return $result['FT'];
	}	
	
	public function get_transfer_outs($user_id,$user_team_players)		//RUNNING
	{
		$temp=$this->match_model->get_upcoming_match();
		$result=$temp->row_array();
		$match_id=$result['match_id'];
		
		$sql='SELECT P.player_id 
				FROM user_match_team T,user_match_team_player	P
				where T.user_match_team_id=P.user_match_team_id
				and	T.user_id=? and T.match_id=?
				and P.player_id NOT IN ?';
				
		$query=$this->db->query($sql,array($user_id,$match_id,$user_team_players));
		$result=$query->result_array();
		
		$outs=array();
		foreach($result as $r)
		{
			$inf=$this->player_model->get_player_info($r['player_id']);
			$new_player=array('player_id'=>$inf['player_id'],'name'=>$inf['name']);
			array_push($outs,$new_player);
		}
		return $outs;
	}
	
	public function get_transfer_ins($user_id,$user_team_players)		//RUNNING
	{
		$temp=$this->match_model->get_upcoming_match();
		$result=$temp->row_array();
		$match_id=$result['match_id'];
		
		$ins = array();
		
		foreach($user_team_players as $p)
		{
			$sql='SELECT count(P.player_id) as cnt
				FROM user_match_team T,user_match_team_player P
				where T.user_match_team_id=P.user_match_team_id
				and	T.user_id=? and T.match_id=?
				and P.player_id=?';
				
			$query=$this->db->query($sql,array($user_id,$match_id,$p));
			$result=$query->row_array();
			if($result['cnt']==0)
			{
				$inf=$this->player_model->get_player_info($p);
				$new_player=array('player_id'=>$inf['player_id'],'name'=>$inf['name']);
				array_push($ins,$new_player);
			}
		}
		
		return $ins;
	}
	
	public function get_used_transfers($user_id,$user_team_players)		//RUNNING
	{
		$temp=$this->match_model->get_upcoming_match();
		$result=$temp->row_array();
		$match_id=$result['match_id'];
		
		$sql='SELECT count(P.player_id) as count
				FROM user_match_team T,user_match_team_player	P
				where T.user_match_team_id=P.user_match_team_id
				and	T.user_id=? and T.match_id=?
				and P.player_id NOT IN ?';
				
		$query=$this->db->query($sql,array($user_id,$match_id,$user_team_players));
		$result=$query->row_array();
		
		return $result['count'];
	}
	
	public function get_loginInfo($data)		//USED FOR LOG-IN
	{
		$query = $this->db->get_where('userInfo', array('email' => $data['email'],'password' => $data['password']));
		return $query;
	}
	
	public function exist_user($email)			//CHECK WHETHER AN EMAIL IS ALREADY REGISTERED - RETURN 1 IF YES, OTHERWISE RETURN 0
	{
		$query = $this->db->get_where('userInfo', array('email' => $email));
		if($query->num_rows()>0) return 1;
		else return 0;
	}
	
	public function register($data)				//COMPLETE REGISTRATION
	{
		$query = $this->db->insert('userInfo',$data);
	}
	
	public function exist_tournament_user($user_id)		//CHECK WHETHER A USER HAS A TEAM FOR THE CURRENT TOURNAMENT - 1 FOR YES, 0 FOR NO
	{
		$tournament_id=$this->tournament_model->get_active_tournament_id();
		$sql='SELECT * FROM `user_tournament` WHERE `tournament_id`=? and `user_id`=?';
		$query=$this->db->query($sql,array($tournament_id,$user_id));
		if($query->num_rows()===0)
		{
			return 0;
		}
		else
		{
			return 1;
		}
	}

	public function create_user_match_team($user_id, $match_id,$captain_id,$user_team,$team_name)	//RUNNING #CAN BE A SOURCE OF ERROR
	{
		//GET CURRENT TOURNAMENT
		$tournament_id=$this->tournament_model->get_active_tournament_id();
		$sql='INSERT into user_tournament VALUES(\'\',?,?,?)';
		$query=$this->db->query($sql,array($user_id,$tournament_id,$team_name));
		
		//GET PREVIOUS MATCH ID
		$query = $this->tournament_model->get_previous_match();
		$result=$query->row_array();
		$prev_match_id = $result['match_id'];
		
		//SET NEW CAPTAIN := OLD CAPTAIN		
		$new_captain=$captain_id;
		
		//CREATE USER_MATCH_TEAM
		$sql='INSERT into user_match_team VALUES(\'\',?,?,?,0)';
		$query=$this->db->query($sql,array($user_id,$match_id,$new_captain));
		
		
		//GET NEW MATCH TEAM ID
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$match_id));
		$result=$query->row_array();
		$new_match_team_id=$result['user_match_team_id'];
		
		//SET ALL PLAYERS DATA
		//SET NEW MATCH_TEAM_PLAYERS := ALL PREVIOUS USER_MATCH_TEAM_PLAYERS	
		foreach($user_team as $r)
		{
			$sql='INSERT into user_match_team_player VALUES(\'\',?,?)';
			$query=$this->db->query($sql,array($new_match_team_id,$r['player_id']));
		}
	}

	public function get_current_user_match_team($user_id)	//RUNNING
	{
		//GET UPCOMING MATCH ID
		$query = $this->match_model->get_upcoming_match();
		$result=$query->row_array();
		$prev_match_id = $result['match_id'];
		
		//GET  USER MATCH TEAM
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$prev_match_id));
		
		if($query->num_rows()==0) return NULL;
		
		$result=$query->row_array();
		
		//GET CAPTAIN ID
		$data['captain']=$result['captain_id'];
		
		//GET  MATCH TEAM ID
		$prev_match_team_id=$result['user_match_team_id'];
		
		//GET ALL USER_MATCH_TEAM_PLAYERS
		$sql='SELECT player_id FROM user_match_team_player WHERE user_match_team_id=?';
		$query=$this->db->query($sql,array($prev_match_team_id));
		$data['team_players']=$query->result_array();
		return $data;
	}
	
	public function get_user_match_team($user_id)	//RUNNING
	{
		//GET PREVIOUS MATCH ID
		$query = $this->tournament_model->get_previous_match();
		$result=$query->row_array();
		$prev_match_id = $result['match_id'];
		
		//GET PREVIOUS USER MATCH TEAM
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$prev_match_id));
		
		if($query->num_rows()==0) return NULL;
		
		$result=$query->row_array();
		
		//GET PREVIOUS CAPTAIN ID
		$data['captain']=$result['captain_id'];
		
		//GET PREVIOUS MATCH TEAM ID
		$prev_match_team_id=$result['user_match_team_id'];
		
		//GET ALL PREVIOUS USER_MATCH_TEAM_PLAYERS
		$sql='SELECT player_id FROM user_match_team_player WHERE user_match_team_id=?';
		$query=$this->db->query($sql,array($prev_match_team_id));
		$data['team_players']=$query->result_array();
		return $data;
	}
	
	public function get_user_match_team_id($user_id,$match_id)
	{
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$match_id));
		$result=$query->row_array();
		return $result['user_match_team_id'];
	}
	
	public function get_user_match_point($user_id)	//RUNNING
	{
		$m=$this->tournament_model->get_previous_match()->row_array();
		$match_id=$m['match_id'];
		
		if($match_id===NULL) $total=0;
		else 
		{
			$total=$this->get_user_match_point_v2($user_id,$match_id);
			if($total===NULL) $total=0;
		}
		return $total;
	}
	
	
	public function get_user_match_point_v2($u_id,$m_id)	//RUNNING
	{
		$total=0;
		$cur_tournament=$this->tournament_model->get_active_tournament_id();

		$sql='SELECT `user_match_team_id`,`captain_id`
		FROM `user_match_team` WHERE `user_id`='.$u_id.' AND `match_id` ='.$m_id.'';
		$result=$this->db->query($sql)->row_array();
		
		$u_team_id=$result['user_match_team_id'];
		$cap=$result['captain_id'];

		//ADD CAPTAIN'S POINT
		$sql='SELECT UPDATE_PLAYER_POINT(?, ?, ?) AS pl_point';
		$query=$this->db->query($sql,array($cap, $m_id,$cur_tournament));
		
		$result=$query->row_array();
		if($result['pl_point']!=NULL)
		{
			$total+=$result['pl_point'];
		}
		
		
		//ADD TEAM PLAYERS POINT
		$sql='SELECT player_id
					FROM user_match_team_player
					WHERE user_match_team_id=?';
		$query=$this->db->query($sql,array($u_team_id));
		$result=$query->result_array();

		foreach($result as $r)
		{
			$pl_id=$r['player_id'];
			
			$sql='SELECT UPDATE_PLAYER_POINT(?, ?, ?) AS pl_point';
			$query=$this->db->query($sql,array($pl_id, $m_id,$cur_tournament));
			$result=$query->row_array();
			if($result['pl_point']!=NULL)
			{
				$total+=$result['pl_point'];
			}
		}
		
		return $total;
	}
	
	
	
	public function get_user_phase_point_v2($u_id,$ph_id)
	{
		$total=0;
		$sql='SELECT M.match_id as mid FROM `match` M, phase P
						WHERE M.tournament_id= current_tournament()
						AND  P.phase_id = '.$ph_id.'
						AND(M.start_time BETWEEN P.start_time AND P.finish_time )';
		
		$result=$this->db->query($sql)->result_array();

		foreach($result as $r)
		{
			$m_id=$r['mid'];
			$total+=$this->get_user_match_point_v2($u_id,$m_id);
		}
		return $total;
	}
	
	
	
	public function get_user_overall_point($u_id)
	{
		$total=0;
		$sql='SELECT phase_id FROM phase  WHERE tournament_id = current_tournament()';
		$result=$this->db->query($sql)->result_array();

		foreach($result as $r)
		{
			$p_id=$r['phase_id'];
			$temp=$this->get_user_phase_point_v2($u_id,$p_id);
			if($temp!='')
			{
				$total+=$temp;
			}
		}
		return $total;
	}
	
	public function user_team_name($user_id)
	{
		$tournament_id=$this->tournament_model->get_active_tournament_id();
		$sql='SELECT * FROM user_tournament WHERE tournament_id=? and user_id=?';
		$query=$this->db->query($sql,array($tournament_id,$user_id))->row_array();
		return $query['user_team_name'];
	}
	
	public function change_captain($user_id,$match_id,$new_captain_id)
	{
		$sql='UPDATE user_match_team 
			SET captain_id=? 
			WHERE user_id=? AND match_id=?';
			
		$query=$this->db->query($sql,array($new_captain_id,$user_id,$match_id));
		return;
	}
	
	public function replace_team_players($user_match_team_id,$ins,$outs)
	{
		$i=0;
		foreach($outs as $old)
		{
			echo $old_id=$old['player_id'];
			echo $new_id=$ins[$i]['player_id'];
			
			echo '<hr>';
			
			$sql='UPDATE user_match_team_player 
			SET player_id=? 
			WHERE user_match_team_id=? AND player_id=?';
			
			$query=$this->db->query($sql,array($new_id,$user_match_team_id,$old_id));
			
			$i++;
		}
		
		//UPDATE TRANSFER COUNT IF APPLICABLE
		
		$sql='SELECT transfers_made
				FROM user_phase_transfer
				WHERE user_id=? AND phase_id=current_phase()';
		$result=$this->db->query($sql,array($_SESSION['user_id']))->row_array();
		
		if($result==NULL)
		{
			//DO NOTHING---THERE IS NO ENTRY FOR CURRENT PHASE I.E. USER HAVE UNLIMITED FREE TRANSFERS
		}
		else
		{
			$count=$result['transfers_made'];
			$count+=$i;
			$sql='UPDATE user_phase_transfer
					SET transfers_made=?
					WHERE user_id=? AND phase_id=current_phase()';
			$query=$this->db->query($sql,array($count,$_SESSION['user_id']));
		}	
		return;
		
	}
	
	public function create_user_phase_transfer($user_id, $phase_id)
	{
		$sql='INSERT into user_phase_transfer VALUES(\'\',?,?,0)';
		$query=$this->db->query($sql,array($user_id,$phase_id));
	}
	
}

?>