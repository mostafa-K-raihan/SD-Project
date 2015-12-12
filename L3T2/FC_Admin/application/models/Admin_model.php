<?php
/**
	Database support for admin
*/
class Admin_model extends CI_Model 
{
	/**
		Connect to database; load other required models
	*/
    public function __construct()	
	{
        $this->load->database();
		$this->load->model('match_model');
		$this->load->model('tournament_model');
	}
		
	/**
		Find information required for login
	*/	
	public function get_loginInfo($data)	
	{
		$query = $this->db->get_where('admin', array('admin_id' => $data['admin_id'],'password' => $data['password']));
		return $query;
	}
	
	
	/**
		Update database to start a phase; returns true if successful
	*/
	public function start_phase($phase_id)
	{
		/// 1. set `is_started` flag
		
		$sql='UPDATE `phase` SET `is_started`=1 WHERE `phase_id`=?';
		$query=$this->db->query($sql,$phase_id);
		
		/// 2. GET ALL TOURNAMENT USERS
		$sql='SELECT `user_id` FROM `user_tournament` WHERE `tournament_id`=current_tournament()';
		$users=$this->db->query($sql)->result_array();
		
		/// 3. FOR EACH USER create phase transfer entry to keep track of remaining free transfers
		foreach($users as $u)
		{
			$this->create_user_phase_transfer($u['user_id'], $phase_id);
		}
		
		return true;
	}
	
	/**
		create phase transfer entry to keep track of remaining free transfers
	*/
	public function create_user_phase_transfer($user_id, $phase_id)
	{
		$sql='INSERT into user_phase_transfer VALUES(\'\',?,?,0)';
		$query=$this->db->query($sql,array($user_id,$phase_id));
	}
	
	/**
		Do database operations to start a match
	*/
	public function start_match($match_id)		
	{
		/// 1. Get current tournament tournament id
		$cur_tour= $this->tournament_model->get_active_tournament_id();
		
		///	2. Set is_started flag
		$sql='UPDATE `match` SET `is_started`=1 WHERE `match_id`=?';
		$query=$this->db->query($sql,$match_id);
		
		/// 3. Create player_match_point_entries for all players (of current tournament)
		$sql='SELECT `player_id` FROM `player_tournament` WHERE `tournament_id`=?';
		$result=$this->db->query($sql,$cur_tour)->result_array();
		
		foreach($result as $r)
		{
			$val=$this->match_model->create_player_match_points($r['player_id'], $match_id);
		}
		
		
		/// 4. GET ALL TOURNAMENT USERS
		$sql='SELECT `user_id` FROM `user_tournament` WHERE `tournament_id`=?';
		$users=$this->db->query($sql,$cur_tour)->result_array();
		
		foreach($users as $u)
		{
			/// 4(a). Update NULL entries in user phase transfer table
			$sql = 'UPDATE `user_phase_transfer` SET transfers_made = 0 WHERE user_id = ? and IFNULL(transfers_made,0) = 0';
			$this->db->query($sql,array($u['user_id']));
			/// 4(b). FOR EACH USER , create a default match team
			$val = $this->match_model->create_user_match_team($u['user_id'], $match_id);
		}
		return true;
	}
}

?>