<?php
/**
	Provides Database Level Operations for `tournament` entity and related functions
*/
class Tournament_model extends CI_Model 
{

    public function __construct()	//done
	{
        $this->load->database();
	}
	
	/**
		Get information about currently running tournament.
	*/
	public function get_active_tournament()		
	{
		$sql = 'SELECT * FROM `tournament` where `is_active`=1';				
		$query=$this->db->query($sql); 
		return $query;
	}
	
	/**
		Get `tournament_id` of current tournament
	*/
	public function get_active_tournament_id()		
	{
		$sql = 'SELECT `tournament_id` FROM `tournament` where `is_active`=1';				
		$result=$this->db->query($sql)->row_array(); 
		return $result['tournament_id'];
	}
	
	/**
		\brief Get information of next phase (not started, admin will start) of current tournament
		
		This function is only used to show upcoming phase in admin homepage
	*/
	public function get_upcoming_phase($tournament_id)		
	{
		$sql = 'SELECT * FROM `phase` 
				WHERE `tournament_id`='.$tournament_id.' AND `is_started`=0 AND (`start_time`-CURRENT_TIMESTAMP) = 
				(	
					SELECT MIN(`start_time`-CURRENT_TIMESTAMP)
					FROM `phase` 
					WHERE (`start_time` > CURRENT_TIMESTAMP AND `is_started`=0 AND `tournament_id`='.$tournament_id.')
				)';				
		
		$query=$this->db->query($sql); 
		
		
		return $query;
	}
	
	/**
		Return match schedule
	*/
	public function get_fixture($tournament_id=0)		
	{
		if($tournament_id==0)
		{
			$tournament_id=$this->get_active_tournament_id();
		}
		
		
		$sql = 'SELECT M.`match_id` as match_id,M.`start_time` as Time,M.`team1_id` as home_team_id,
				T1.`team_name` as home_team_name,M.`team2_id` as away_team_id,T2.`team_name` as away_team_name 
				from `match` M, `team` T1, `team` T2 
				WHERE T1.`team_id`=M.`team1_id` AND T2.`team_id`=M.`team2_id` AND M.`tournament_id`=?
				ORDER BY M.`start_time`';
				
		$query=$this->db->query($sql, array($tournament_id)); 
		return $query;
	}
	
	/**
		Return completed match results
	*/
	public function get_result($tournament_id=0)	
	{
		if($tournament_id==0)
		{
			$tournament_id=$this->get_active_tournament_id();
		}
		
		$sql = 'SELECT M.`start_time` as Time, T1.`team_name` as `Home Team`,
				M.`team1_total_runs` AS RUNS,M.`team1_wickets` AS Wickets,
				Floor((M.`team1_balls`)/6) AS Overs, MOD(M.`team1_balls`,6) AS Balls,
				T2.`team_name` as `Away Team`,
				M.`team2_total_runs` AS RUNS2,M.`team2_wickets` AS Wickets2,
				Floor((M.`team2_balls`)/6) AS Overs2, MOD(M.`team2_balls`,6) AS Balls2
				from `match` M, `team` T1, `team` T2 
				WHERE T1.`team_id`=M.`team1_id` AND T2.`team_id`=M.`team2_id` AND M.`tournament_id`=? AND M.`start_time`<CURRENT_TIMESTAMP
				ORDER BY M.`start_time` DESC';
				
		$query=$this->db->query($sql,array($tournament_id)); 
		
		return $query;
	}
	
	/**
		Get information of all teams participating in the current tournament
	*/
	public function get_active_tournament_teams()	
	{
	
		$result = $this->get_active_tournament()->row_array();
		$tournament_id = $result['tournament_id'];
		
		$sql = 	'SELECT * from `team` where `team_id` IN
					(
					SELECT `team_id` FROM `team_tournament` where `tournament_id`=?
					)';
				
		$query=$this->db->query($sql,$tournament_id); 
		
		return $query;
	}
	
	/**
	*	RETURN TRUE IF PLAYER EXISTS IN CURRENT TOURNAMENT
	*	FALSE OTHERWISE
	*/
	public function player_exists($player_id)	
	{
		$result = $this->get_active_tournament()->row_array();
		$cur_tournament_id = $result['tournament_id'];
		
		$sql = 	'SELECT COUNT(*) FROM `player_tournament` where `player_id` = ? AND `tournament_id` = ?';
				
		$query=$this->db->query($sql,array($player_id,$cur_tournament_id)); 
		
		$rs = $query->row_array();
		
		if($rs['COUNT(*)']==0) return 0;
		else return 1;
	}
	
	/**
		insert a player into `player_tournament` table to indicate that the player is participating in the current tournament
	*/
	public function add_tournament_player($player_id)	
	{
		if($this->player_exists($player_id)==0)
		{
			$result = $this->get_active_tournament()->row_array();
			$cur_tournament_id = $result['tournament_id'];
			
			$data=array(
				'player_tournament_id'=>'',
				'player_id'=> $player_id,
				'tournament_id'=> $cur_tournament_id
			);
			$sql = 	'INSERT INTO `player_tournament` VALUES (?,?,?)';		
			$query=$this->db->query($sql,$data);
		}		
	}
	
	/**
		Delete a player from player_tournament table to indicate that the player is no longer participating in the current tournament
	*/
	public function delete_tournament_player($player_id)	
	{
		if($this->player_exists($player_id)==1)
		{
			$result = $this->get_active_tournament()->row_array();
			$cur_tournament_id = $result['tournament_id'];
			
			$sql = 	'DELETE FROM `player_tournament` WHERE `player_id`=? AND `tournament_id`=?';		
			$query=$this->db->query($sql,array($player_id,$cur_tournament_id));
		}
	}
	
	/**
		Return all data from `tournament` table
	*/
	public function view_tournaments()	
	{
		$sql = 'SELECT * FROM `tournament`';		
		return $query=$this->db->query($sql);
	}
	
	/**
		Create a new tournament
	*/
	public function create_tournament($data)	
	{
		$sql = 'INSERT INTO `tournament` VALUES(?,?,DATE(?),DATE(?),?,?,?)';		
		return $query=$this->db->query($sql,$data); 
	}
	
	/**
		Return all data from `tournament` table, sorted by tournament name
	*/
	public function get_all_tournaments()	
	{
		$sql = 	'SELECT * from `tournament` ORDER BY `tournament_name`';
				
		$query=$this->db->query($sql); 
		
		return $query;
	}
	
	/**
		Return tournament_name for a given tournament_id
	*/
	public function get_tournament_name($tournament_id)	
	{
		$sql = 'SELECT `tournament_name` FROM `tournament` where `tournament_id`=?';				
		$query=$this->db->query($sql,$tournament_id); 
		$result=$query->row_array();
		
		return $result['tournament_name'];
	}
	
	/**
		returns 1 if a team is alredy in a tournament; returns 0 otherwise 
	*/
	public function team_exists_tournament($tournament_id,$team_id)	
	{
		
		$sql = 	'SELECT COUNT(*) FROM `team_tournament` where `team_id` = ? AND `tournament_id` = ?';
				
		$query=$this->db->query($sql,array($team_id,$tournament_id)); 
		
		$rs = $query->row_array();
		
		if($rs['COUNT(*)']==0) return 0;
		else return 1;
	}
	
	/**
		Insert a team into team_tournament table to indicate that the team is participating in that tournament
	*/
	public function add_tournament_team($tournament_id,$team_id)	
	{
		if($this->team_exists_tournament($tournament_id,$team_id)==0)
		{
			$data=array(
				'team_tournament_id'=>'',
				'team_id'=> $team_id,
				'tournament_id'=> $tournament_id
			);
			$sql = 	'INSERT INTO `team_tournament` VALUES (?,?,?)';		
			$query=$this->db->query($sql,$data);
		}		
	}
	
	/**
		Delete a team from team_tournament table to indicate that the team is no longer participating in that tournament
	*/
	public function delete_tournament_team($tournament_id,$team_id)	
	{
		if($this->team_exists_tournament($tournament_id,$team_id)==1)
		{
			$sql = 	'DELETE FROM `team_tournament` WHERE `team_id`=? AND `tournament_id`=?';		
			$query=$this->db->query($sql,array($team_id,$tournament_id));
		}
	}
	
	/**
		Update current tournament id
	*/
	public function update_active_tournament($tournament_id)	
	{
		$current_tournament=$this->get_active_tournament_id();
		$sql='UPDATE `tournament`
				SET `is_active` = 0
				where `tournament_id` = (?)';
		$query=$this->db->query($sql,array($current_tournament));

		$sql='UPDATE `tournament`
				SET `is_active` = 1
				where `tournament_id` = ?';
		$query=$this->db->query($sql, $tournament_id);

	}
	
	/**
		Insert a tournament phase
	*/
	public function add_tournament_phase($phase_data)	
	{
		$sql = 'INSERT INTO `phase` VALUES(?,?,STR_TO_DATE(?,\'%Y-%m-%d %H:%i:%s\'),STR_TO_DATE(?,\'%Y-%m-%d %H:%i:%s\'),?,?,?,?)';
		return $this->db->query($sql,$phase_data);
	}
	
	/**
		Get information of a particular tournament (given by tournament_id)
	*/
	public function get_tournament_info($tournament_id)	
	{
		$sql = 'SELECT * FROM `tournament` where `tournament_id`=?';				
		$query=$this->db->query($sql,$tournament_id); 
		return $result=$query->row_array();
	}
	
	/**
		Get information of all phases of a particular tournament (given by tournament_id)
	*/
	public function get_phase_info($tournament_id)	
	{
		$sql = 'SELECT * FROM `phase` where `tournament_id`=?';				
		$query=$this->db->query($sql,$tournament_id); 
		return $result=$query->result_array();
	}
	
	/**
		Update information of a phase
	*/
	public function update_tournament_phase($phase_data)	
	{
		$sql = 'UPDATE `phase` SET `phase_name` = ?,
		`start_time` = STR_TO_DATE(?,\'%Y-%m-%d %H:%i:%s\'),
		`finish_time` = STR_TO_DATE(?,\'%Y-%m-%d %H:%i:%s\'),
		`free_transfers` = ? 
		WHERE `phase_id` = ?';
		
		return $this->db->query($sql,array($phase_data['phase_name'],$phase_data['start_time'],$phase_data['finish_time'],$phase_data['free_transfers'],$phase_data['phase_id']));
	}
	
	/**
		Returns the name of currently active tournament
	*/
	public function get_active_tournament_name()	
	{
		$sql = 'SELECT `tournament_name` FROM `tournament` where `is_active`=1';				
		
		$query=$this->db->query($sql); 
		
		$result=$query->row_array();
		
		return $result['tournament_name'];
	}
	
	/**
		Get previous match information (started by admin)
	*/
	public function get_previous_match()		
	{
		$cur_tour=$this->get_active_tournament_id();
		
		$sql = 'SELECT * FROM `match` 
				WHERE `tournament_id`=? AND `is_started`=1 AND (CURRENT_TIMESTAMP-`start_time`) = 
				(	
					SELECT MIN(CURRENT_TIMESTAMP-`start_time`)
					FROM `match` 
					WHERE (`start_time` < CURRENT_TIMESTAMP AND `is_started`=1 AND `tournament_id`= ?)
				)';				
		
		$query=$this->db->query($sql,array($cur_tour,$cur_tour)); 
			
		return $query;
	}

}