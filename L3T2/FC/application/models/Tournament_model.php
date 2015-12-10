<?php
/**
	Provides Database Level Operations for `tournament` entity and related functions
*/
class Tournament_model extends CI_Model 
{

    public function __construct()	
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
		Get current `phase_id` of current tournament
	*/
	public function get_current_phase()
	{
		$sql = 'SELECT current_phase() as phase_id';				
		$result=$this->db->query($sql)->row_array(); 
		return $result['phase_id'];
	}
	
	/**
		\brief Get next `phase_id` of current tournament
		
		This function is only used during "Change Team" when current phase_id is NULL (Currently , no phase)
	*/
	public function get_upcoming_phase()		
	{
		$tournament_id=$this->get_active_tournament_id();
		$sql = 'SELECT * FROM `phase` 
				WHERE `tournament_id`='.$tournament_id.' AND `is_started`=1 AND (`start_time`-CURRENT_TIMESTAMP) = 
				(	
					SELECT MIN(`start_time`-CURRENT_TIMESTAMP)
					FROM `phase` 
					WHERE (`start_time` > CURRENT_TIMESTAMP AND `is_started`=1 AND `tournament_id`='.$tournament_id.')
				)';				
		
		$query=$this->db->query($sql)->row_array(); 
		
		return $query['phase_id'];
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
		GENERATES player data (all players participating in given tournament) FOR CREATE_TEAM VIEW.
		
		input: $team: array('tournament_id' => ?)
	*/
	
	public function get_tournament_players($team)
	{
		$sql = 'select P.name as Player_name, P.player_id as Player_id, P.player_cat as Category, P.price as Price, T.team_name as Team_name, "true" as Button_status
					from player P, player_tournament PT, team T
					where P.player_id = PT.player_id and P.team_id=T.team_id and PT.tournament_id=?';
			
		$query = $this->db->query($sql,array($team['tournament_id']));
		return $query;
	}
	
	/**
		Get players information for a given category in current tournament
	*/
	public function get_tournament_players_by_category($cat)
	{
		$sql = 'select P.name as player_name, P.player_id as player_id, P.player_cat as category, P.price as price, T.team_name as team_name
					from player P, player_tournament PT, team T
					where P.player_id = PT.player_id and P.player_cat=? and P.team_id=T.team_id and PT.tournament_id=current_tournament()';
			
		$query = $this->db->query($sql,array($cat));
		return $query;
	}
	
	/**
		Return all players ( information ) participating in the current tournament 
	*/
	public function get_all_players()
	{
		$sql = 'select P.name as player_name, P.player_id as player_id, P.player_cat as category, P.price as price, T.team_name as team_name
					from player P, player_tournament PT, team T
					where P.player_id = PT.player_id and P.team_id=T.team_id and PT.tournament_id=current_tournament()';
			
		$query = $this->db->query($sql)->result_array();
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
		
		$sql = 'SELECT M.`match_id` as match_id , M.`start_time` as Time, T1.`team_name` as `Home Team`,
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
		Return all data from `tournament` table
	*/
	public function view_tournaments()	
	{
		$sql = 'SELECT * FROM `tournament`';		
		return $query=$this->db->query($sql);
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
	
	/*
	public function team_exists_tournament($tournament_id,$team_id)	//done
	{
		
		$sql = 	'SELECT COUNT(*) FROM `team_tournament` where `team_id` = ? AND `tournament_id` = ?';
				
		$query=$this->db->query($sql,array($team_id,$tournament_id)); 
		
		$rs = $query->row_array();
		
		if($rs['COUNT(*)']==0) return 0;
		else return 1;
	}
	*/
	/*
	public function get_tournament_info($tournament_id)	//done
	{
		$sql = 'SELECT * FROM `tournament` where `tournament_id`=?';				
		$query=$this->db->query($sql,$tournament_id); 
		return $result=$query->row_array();
	}
	*/
	/*
	public function get_phase_info($tournament_id)	//done
	{
		$sql = 'SELECT * FROM `phase` where `tournament_id`=?';				
		$query=$this->db->query($sql,$tournament_id); 
		return $result=$query->result_array();
	}
	*/
	/*
	public function get_active_tournament_name()	
	{
		$sql = 'SELECT `tournament_name` FROM `tournament` where `is_active`=1';				
		
		$query=$this->db->query($sql); 
		
		$result=$query->row_array();
		
		return $result['tournament_name'];
	}
	*/
	
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
	
	/**
		Get previous match id (started by admin)
	*/
	public function get_previous_match_id()
	{
		$sql = 'SELECT match_id FROM `match` 
				WHERE tournament_id=current_tournament() AND is_started=1 AND (CURRENT_TIMESTAMP-start_time) = 
				(	
					SELECT MIN(CURRENT_TIMESTAMP-start_time)
					FROM `match` 
					WHERE (start_time < CURRENT_TIMESTAMP AND is_started=1 AND tournament_id= current_tournament())
				)';				
		
		$query=$this->db->query($sql); 
			
		return $query->row_array();
	}
	
}