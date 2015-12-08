<?php

/**
	Provides database support for the controllers to manipulate user related information
*/

class User_model extends CI_Model 
{

	/**
	*	Connect to database
	*/
    public function __construct()
	{
        $this->load->database();
	}
	
	/**
	*	\brief Get the number of free transfer remaining for a user (in current phase)
	*
	*	\brief param : $user_id --- just user_id (int)
	*
	*	return value : number of remaining transfers (int)
	*/
	public function get_remaining_transfers($user_id)
	{
		/**
			No current phase means - during two phases or before the first phase of the tournament. So, user has unlimited transfer access
		*/
		if($this->tournament_model->get_current_phase() === NULL)
		{
			return 'UNLIMITED';
		}
		
		/**
			Otherwise, get number of available free transfers from database
		*/
		$sql='SELECT P.free_transfers-IFNULL(UPT.transfers_made,0) as FT
			FROM phase P, user_phase_transfer UPT
			WHERE P.phase_id=current_phase()
			AND P.phase_id=UPT.phase_id AND UPT.user_id=?';
		$query=$this->db->query($sql,$user_id);
		
		$result=$query->row_array();
		return $result['FT'];
		
	}	
	
	/**
		\brief #TASK : To find out which players are transferred out from user's team
		
		\brief #PARAMS :
		
			\brief $user_id  --- int
			
			\brief $user_team_players --- array of int (array of player_id's of players selected by user after submitting request for transfers)
			
		\brief #RETURN VALUE : array('player_id'=>id of the player transferred out , 'name'=> name of the player)
	*/
	public function get_transfer_outs($user_id,$user_team_players)		
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
	
	/**
		\brief #TASK : To find out which players are transferred in from user's team
		
		\brief #PARAMS :
		
			\brief $user_id  --- int
			
			\brief $user_team_players --- array of int (array of player_id's of players selected by user after submitting request for transfers)
			
		\brief #RETURN VALUE : array('player_id'=>id of the player transferred in , 'name'=> name of the player)
	*/
	public function get_transfer_ins($user_id,$user_team_players)		
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
	
	/**
		\brief #TASK : To find out number of transfers used by a user
		
		\brief #PARAMS :
		
			\brief $user_id  --- int
			
			\brief $user_team_players --- array of int (array of player_id's of players selected by user after submitting request for transfers)
			
		\brief #RETURN VALUE : int (number of transfers used)
	*/
	public function get_used_transfers($user_id,$user_team_players)		
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
	
	/**
		\brief #TASK : To get required login info from userinfo table
		
		\brief #PARAMS :
		
			\brief $data  --- array('email'=> e-mail address of user, 'password'=>password submitted by user)
		
		\brief #RETURN VALUE : the query result. indices follows the column names of database table. i.e. user_id, email, password etc
	*/
	public function get_loginInfo($data)
	{
		$query = $this->db->get_where('userInfo', array('email' => $data['email'],'password' => $data['password']));
		return $query;
	}
	
	/**
		\brief CHECK WHETHER AN EMAIL IS ALREADY REGISTERED 
		
		RETURN 1 IF YES, OTHERWISE RETURN 0
	*/
	public function exist_user($email)
	{
		$query = $this->db->get_where('userInfo', array('email' => $email));
		if($query->num_rows()>0) return 1;
		else return 0;
	}
	
	/**
		\brief COMPLETE REGISTRATION inside database
		
		return type : void
	*/
	public function register($data)				
	{
		$query = $this->db->insert('userInfo',$data);
	}
	
	/**
		\brief CHECK WHETHER A USER HAS A TEAM FOR THE CURRENT TOURNAMENT

		return - 1 FOR YES, 0 FOR NO
	*/
	public function exist_tournament_user($user_id)		
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

	/**
		\brief COMPLETES DB OPERATIONS FOR CREATE TEAM ACTION
	
		\brief parameters : 
		
			\brief $user_id --- int
			
			\brief $match_id --- int (id of upcoming match)
			
			\brief $captain_id --- int (id of captain of user's team)

			\brief $user_team --- array of int (id of players of user's team)

			\brief $user_team_name --- string (team name submitted by user)
	*/
	public function create_user_match_team($user_id, $match_id,$captain_id,$user_team,$team_name)
	{
		//! GET CURRENT TOURNAMENT
		$tournament_id=$this->tournament_model->get_active_tournament_id();
		$sql='INSERT into user_tournament VALUES(\'\',?,?,?)';
		$query=$this->db->query($sql,array($user_id,$tournament_id,$team_name));
		
		//! SET NEW CAPTAIN		
		$new_captain=$captain_id;
		
		//! CREATE USER_MATCH_TEAM ENTRY
		$sql='INSERT into user_match_team VALUES(\'\',?,?,?,0)';
		$query=$this->db->query($sql,array($user_id,$match_id,$new_captain));
		
		
		//! GET NEW MATCH TEAM ID
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$match_id));
		$result=$query->row_array();
		$new_match_team_id=$result['user_match_team_id'];
		
		//! SET ALL PLAYERS ID INTO user_match_team_player TABLE
		foreach($user_team as $r)
		{
			$sql='INSERT into user_match_team_player VALUES(\'\',?,?)';
			$query=$this->db->query($sql,array($new_match_team_id,$r));
		}
	}

	/**
		\brief Find the list of players currently in user's team.
		
		\brief input : $user_id --- int
		
		output : array('captain'=> int [captain's id] , 'team_players'=>array('player_id' => int [id of each player]))
	*/
	public function get_current_user_match_team($user_id)	
	{
		//! GET UPCOMING MATCH ID
		$query = $this->match_model->get_upcoming_match();
		$result=$query->row_array();
		$prev_match_id = $result['match_id'];
		
		//! GET  USER MATCH TEAM
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$prev_match_id));
		
		if($query->num_rows()==0) return NULL;
		
		$result=$query->row_array();
		
		//! GET CAPTAIN ID
		$data['captain']=$result['captain_id'];
		
		//! GET  MATCH TEAM ID
		$prev_match_team_id=$result['user_match_team_id'];
		
		//! GET ALL USER_MATCH_TEAM_PLAYERS
		$sql='SELECT player_id FROM user_match_team_player WHERE user_match_team_id=?';
		$query=$this->db->query($sql,array($prev_match_team_id));
		$data['team_players']=$query->result_array();
		return $data;
	}
	
	/**
		\brief Find the list of players who were in user's team in the last(previous) match.
		
		\brief input : $user_id --- int
		
		output : array('captain'=> int [captain's id] , 'team_players'=>array('player_id' => int [id of each player]))
	*/
	public function get_user_match_team($user_id)	//RUNNING
	{
		//! GET PREVIOUS MATCH ID
		$query = $this->tournament_model->get_previous_match();
		$result=$query->row_array();
		$prev_match_id = $result['match_id'];
		
		//! GET PREVIOUS USER MATCH TEAM
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$prev_match_id));
		
		if($query->num_rows()==0) return NULL;
		
		$result=$query->row_array();
		
		//! GET PREVIOUS CAPTAIN ID
		$data['captain']=$result['captain_id'];
		
		//! GET PREVIOUS MATCH TEAM ID
		$prev_match_team_id=$result['user_match_team_id'];
		
		//! GET ALL PREVIOUS USER_MATCH_TEAM_PLAYERS
		$sql='SELECT player_id FROM user_match_team_player WHERE user_match_team_id=?';
		$query=$this->db->query($sql,array($prev_match_team_id));
		$data['team_players']=$query->result_array();
		return $data;
	}
	
	/**
		\brief returns the user_match_team_id for a specific user and match
		
		\brief input:
		
			\brief $user_id --- int
			
			\brief $match_id --- int
			
		\brief output: int [user_match_team_id]
	*/
	public function get_user_match_team_id($user_id,$match_id)
	{
		$sql='SELECT * FROM user_match_team WHERE user_id=? AND match_id=?';
		$query=$this->db->query($sql,array($user_id,$match_id));
		$result=$query->row_array();
		return $result['user_match_team_id'];
	}
	
	/**
		Get matchday points of a user (for current match). Uses get_user_match_point_v2($user_id,$m_id) for calculation
	*/
	public function get_user_match_point($user_id)	
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
	
	/**
		\brief returns matchday points of a user for any given match.
		
		\brief inputs: $u_id => user_id , $m_id => match_id for the given match
	*/
	public function get_user_match_point_v2($u_id,$m_id)	
	{
		$total=0;
		$cur_tournament=$this->tournament_model->get_active_tournament_id();

		$sql='SELECT `user_match_team_id`,`captain_id`
		FROM `user_match_team` WHERE `user_id`='.$u_id.' AND `match_id` ='.$m_id.'';
		
		$query=$this->db->query($sql);
		
		if($query->num_rows()==0)
		{
			return 0;
		}
		
		$result=$query->row_array();
		
		$u_team_id=$result['user_match_team_id'];
		$cap=$result['captain_id'];

		//! ADD CAPTAIN'S POINT
		$sql='SELECT UPDATE_PLAYER_POINT(?, ?, ?) AS pl_point';
		$query=$this->db->query($sql,array($cap, $m_id,$cur_tournament));
		
		$result=$query->row_array();
		if($result['pl_point']!=NULL)
		{
			$total+=$result['pl_point'];
		}
		
		
		//! ADD TEAM PLAYERS POINT
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
	
	
	/**
		\brief returns phase points of a user for any given phase.
		
		\brief inputs: $u_id => user_id , $ph_id => phase_id for the given phase
	*/
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
	
	
	/**
		\brief returns overall points of a user for the current tournament
		
		\brief inputs: $u_id => user_id
		
		\brief output: int [overall_point]
	*/
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
	
	/**
		\brief Used to complete user transfer.
		
		\brief input:
		
			\brief $user_match_team_id : id of the user_match_team entry , $ins : array of int (player_id of transferred in players) , $outs : array of int (player_id of transferred out players)
	*/
	public function replace_team_players($user_match_team_id,$ins,$outs)
	{
		$i=0;
		foreach($outs as $old)
		{
			$old_id=$old['player_id'];
			$new_id=$ins[$i]['player_id'];
			
			$sql='UPDATE user_match_team_player 
			SET player_id=? 
			WHERE user_match_team_id=? AND player_id=?';
			
			$query=$this->db->query($sql,array($new_id,$user_match_team_id,$old_id));
			
			$i++;
		}
		
		//! UPDATE TRANSFER COUNT IF APPLICABLE
		
		$sql='SELECT transfers_made
				FROM user_phase_transfer
				WHERE user_id=? AND phase_id=current_phase()';
		$result=$this->db->query($sql,array($_SESSION['user_id']))->row_array();
		
		if($result['transfers_made']===NULL)
		{
			//! DO NOTHING---THERE IS NO ENTRY FOR CURRENT PHASE I.E. USER HAVE UNLIMITED FREE TRANSFERS
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
	
	/*
		THERE ARE TWO VERSIONS OF CREATE_USER_PHASE_TRANSFER.
		YOU ARE SUGGESTED TO UNDERSTAND THIS AND USE IT PROPERLY
		
		These are used to differentiate between first phase of (new)user
	*/
	
	//used for admin module
	public function create_user_phase_transfer($user_id, $phase_id)
	{
		$sql='INSERT into user_phase_transfer VALUES(\'\',?,?,0)';
		$query=$this->db->query($sql,array($user_id,$phase_id));
	}
	//used for user module
	public function create_user_phase_transfer_from_user($user_id, $phase_id)
	{
		$sql='INSERT into user_phase_transfer VALUES(\'\',?,?,NULL)';
		$query=$this->db->query($sql,array($user_id,$phase_id));
	}
	
	/**
		Find top users based on overall points. Returns the array in a sorted order (descending) of points
	*/
	public function top_users()
	{
		$current_t=$this->tournament_model->get_active_tournament_id();
		if($current_t==NULL)
		{
			echo 'No Player Record Found';
		}
		else
		{
			$sql = 'SELECT u.user_id as user_id from user_tournament u
				where u.tournament_id=?';

			$result = $this->db->query($sql,$current_t)->result_array();
			
			$info = array();
			$i = 0;
			foreach ($result as $r) {
				$temp = $this->get_user_info($r['user_id']);
				
				$inf['user_name']=$temp['user_name'];
				$inf['user_team_name']=$temp['user_team_name'];
				$inf['country']=$temp['country'];
				
				
				$inf['point']=$this->get_user_overall_point($r['user_id']);
				$info[$i]=$inf;
				
				$i++;
			}
				
			$sort = array();
			foreach ($info as $key => $row)
			{
				$sort[$key] = $row['point'];
			}
			array_multisort($sort, SORT_DESC, $info);
			
			return $info;
		}
	}
	
	public function get_user_info($user_id)
	{
		$sql='SELECT ui.user_name,ui.country,ut.user_team_name from user_tournament ut, userinfo ui WHERE ut.user_id=ui.user_id and ui.user_id=?';
		$result=$this->db->query($sql,$user_id)->row_array();
		return $result;
	}
	
	public function update_password($user_id,$password)
	{
		$sql='UPDATE userinfo SET password=? WHERE user_id=?';
		$query=$this->db->query($sql,array($password,$user_id));
	}
	
}

?>