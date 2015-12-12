<?php
/**
	Database operations for `match` entity
*/

class Match_model extends CI_Model 
{

    public function __construct()	
	{
        $this->load->database();
	}
	
	/**
		Get next match information (not started , will be shown in admin homepage to start)
	*/
	public function get_upcoming_match($tournament_id)		
	{
		$sql = 'SELECT * FROM `match` 
				WHERE `tournament_id`='.$tournament_id.' AND `is_started`=0 AND (`start_time`-CURRENT_TIMESTAMP) = 
				(	
					SELECT MIN(`start_time`-CURRENT_TIMESTAMP)
					FROM `match` 
					WHERE (`start_time` > CURRENT_TIMESTAMP AND `is_started`=0 AND `tournament_id`='.$tournament_id.')
				)';				
		
		$query=$this->db->query($sql); 
		
		return $query;
	}
	
	/**
		Update man of the match id for a particular match
	*/
	public function update_motm_id($match_id,$player_id)
	{
		$sql='UPDATE `match` SET `motm_id`= ? WHERE match_id= ?';
		$query=$this->db->query($sql,array($player_id,$match_id));
	}
	
	/**
		INSERT operation in `match` table
	*/
	public function create_match($data)	
	{
		$sql = 'INSERT INTO `match` VALUES(\'\',STR_TO_DATE(?,\'%Y-%m-%d %H:%i:%s\'),?,?,\'\',?,\'\',\'\',\'\',\'\',\'\',\'\',0,0)';		
		return $this->db->query($sql,$data); 
	}
	
	/**
		Get information of a match (by match_id)
	*/
	public function get_match_info($match_id)	
	{
		$sql = 'SELECT M.`start_time` as Time,M.`team1_id` as home_team_id,
				T1.`team_name` as home_team_name,M.`team2_id` as away_team_id,T2.`team_name` as away_team_name 
				from `match` M, `team` T1, `team` T2 
				WHERE T1.`team_id`=M.`team1_id` AND T2.`team_id`=M.`team2_id` AND M.`match_id`=?
				ORDER BY M.`start_time`';
				
		return $this->db->query($sql,$match_id);
	}
	
	/**
		\brief Update information of a particular match.
		
		Input: $data : array('match_id'=>?,'start_time'=>?)
	*/
	public function update_match($data)	
	{
		$sql = 'UPDATE `match` SET `start_time` = STR_TO_DATE(?,\'%Y-%m-%d %H:%i:%s\')
				WHERE `match_id`='.$data["match_id"].'';		
		return $this->db->query($sql,$data["start_time"]); 
	}
	
	/**
		\brief Update match statistics and so, point calculations of a particular match.
		
		Input: $data : array('runs_scored'=>?,'balls_played'=>? , 'fours'=>? , 'sixes'=>? , etc)
	*/
	public function update_match_points($data)		
	{	
		$sql='UPDATE `player_match_point` SET `runs_scored`=? , `balls_played`=? ,`fours`=? , `sixes`=? 
					,`wickets_taken`=?, `balls_bowled`=?, `runs_conceded`=?,`maiden_overs`=?
					,`catches`=?,`stumpings`=?,`run_outs`=?  WHERE `player_id`=? AND `match_id`=?';
		$this->db->query($sql,$data);
		
		
		$sql='select UPDATE_PLAYER_POINT(?,?,CURRENT_TOURNAMENT()) as PT';
		$tmp=$this->db->query($sql,array($data['player_id'],$data['match_id']))->row_array();
		$points=$tmp['PT'];
		
		$sql='UPDATE player_match_point SET total_points=?  WHERE player_id=? AND match_id=?';
		$this->db->query($sql,array($points,$data['player_id'],$data['match_id']));
		
	}
	
	/**
		\brief Update match summary (total runs, wickets, overs for both home & away teams) of a particular match.
	*/
	public function update_match_summary($match_id)	//done
	{
		$cur_tour=$this->tournament_model->get_active_tournament_id();
		
		/// 1. GET HOME TEAM ID, AWAY TEAM ID
		$sql='SELECT * from `match` WHERE `tournament_id`=? AND `match_id`=?';
		$query=$this->db->query($sql,array($cur_tour,$match_id));
		$match=$query->row_array();
		
		$home_team_id=$match['team1_id'];
		$away_team_id=$match['team2_id'];
		
		/// 1(a). GET ALL HOME AND AWAY TEAM PLAYERS IN THE TOURNAMENT
		$sql='SELECT P.`player_id` FROM `player` P, `player_tournament` T
									WHERE P.`team_id`=? 
									AND P.`player_id`=T.`player_id` 
									AND T.`tournament_id`=?';
		$query=$this->db->query($sql,array($home_team_id,$cur_tour));
		$home_players=$query->result_array();
		
		$sql='SELECT P.`player_id` FROM `player` P, `player_tournament` T
									WHERE P.`team_id`=? 
									AND P.`player_id`=T.`player_id` 
									AND T.`tournament_id`=?';
		$query=$this->db->query($sql,array($away_team_id,$cur_tour));
		$away_players=$query->result_array();
		
									
		/// 2. SAVE HOME TEAM SUMMARY
		$home_runs=0;
		$home_balls=0;
		$home_wickets=0;
		
		foreach($away_players as $p)
		{
			$sql='SELECT * from `player_match_point` where `player_id`=? and `match_id`=?';
			$query=$this->db->query($sql,array($p['player_id'],$match_id));
			$temp=$query->row_array();
			$home_runs+=$temp['runs_conceded'];
			$home_balls+=$temp['balls_bowled'];
			$home_wickets+=$temp['wickets_taken']+$temp['stumpings']+$temp['run_outs'];
			
		}
		
		/// 3. SAVE AWAY TEAM SUMMARY
		$away_runs=0;
		$away_balls=0;
		$away_wickets=0;
		
		foreach($home_players as $p)
		{
			$sql='SELECT * from `player_match_point` where `player_id`=? and `match_id`=?';
			$query=$this->db->query($sql,array($p['player_id'],$match_id));
			$temp2=$query->row_array();
			$away_runs+=$temp2['runs_conceded'];
			$away_balls+=$temp2['balls_bowled'];
			$away_wickets+=$temp2['wickets_taken']+$temp2['stumpings']+$temp2['run_outs'];
		}

		/// 4. UPDATE RECORDS
		$sql='UPDATE `match` SET `team1_total_runs`=?,
			 `team1_balls`=?, `team1_wickets`=?, `team2_total_runs`=?,
			 `team2_balls`=?,`team2_wickets`=? WHERE `match_id`=?';
		$query=$this->db->query($sql,array($home_runs,$home_balls,$home_wickets,$away_runs,$away_balls,$away_wickets,$match_id));
	}
	
	/**
		Initialize point calculation data for a player (of a particular match) with default values
	*/
	public function create_player_match_points($player_id, $match_id)	
	{
		$sql= 'INSERT INTO `player_match_point` VALUES(\'\',?,?,0,0,0,0,0,0,0,0,0,0,0,0,0)';
		return $this->db->query($sql,array($player_id,$match_id));
	}
	
	/**
		Initialize user match team with the previous user team
	*/
	public function create_user_match_team($user_id, $match_id)	//DONE, HIGH PROBABILITY OF ERROR
	{
		/// 1. GET PREVIOUS MATCH ID
		$query = $this->tournament_model->get_previous_match();
		$result=$query->row_array();
		$prev_match_id = $result['match_id'];
		
		/// 2. GET PREVIOUS USER MATCH TEAM
		$sql='SELECT * FROM `user_match_team` WHERE `user_id`=? AND `match_id`=?';
		$query=$this->db->query($sql,array($user_id,$prev_match_id));
		$result=$query->row_array();
		
		/// 3. GET PREVIOUS CAPTAIN ID
		$prev_captain=$result['captain_id'];
		
		/// 3(a). SET NEW CAPTAIN := OLD CAPTAIN		
		$new_captain=$prev_captain;
		
		
		/// 4. GET PREVIOUS MATCH TEAM ID
		$prev_match_team_id=$result['user_match_team_id'];
		
		/// 4(a). GET ALL PREVIOUS USER_MATCH_TEAM_PLAYERS
		$sql='SELECT `player_id` FROM `user_match_team_player` WHERE `user_match_team_id`=?';
		$query=$this->db->query($sql,array($prev_match_team_id));
		$team_players=$query->result_array();
		
		/// 4(b). CREATE USER_MATCH_TEAM
		$sql='INSERT into `user_match_team` VALUES(\'\',?,?,?,0)';
		$query=$this->db->query($sql,array($user_id,$match_id,$new_captain));
		
		
		/// 5. GET NEW USER MATCH TEAM ID
		$sql='SELECT * FROM `user_match_team` WHERE `user_id`=? AND `match_id`=?';
		$query=$this->db->query($sql,array($user_id,$match_id));
		$result=$query->row_array();
		$new_match_team_id=$result['user_match_team_id'];
		
		/// 6. SET ALL PLAYERS DATA (SET NEW MATCH_TEAM_PLAYERS := ALL PREVIOUS USER_MATCH_TEAM_PLAYERS	)
		foreach($team_players as $r)
		{
			$sql='INSERT into `user_match_team_player` VALUES(\'\',?,?)';
			$query=$this->db->query($sql,array($new_match_team_id,$r['player_id']));
		}
	}
	
	/**
	*	THIS FUNCTION WILL ONLY BE CALLED FROM UPDATE_MATCH_POINT
	*	NO EXTERNAL USE
	*/
	public function update_motm_point($match_id)
	{
		/// 1. Reset previous man of the match point
		$sql='UPDATE player_match_point SET motm_bonus =0 WHERE match_id=?';
		$query=$this->db->query($sql,$match_id);
		
		/// 2. GET MOTM_ID FROM MATCH
		$sql='SELECT `motm_id` FROM `match` WHERE `match_id`=?';
		$query=$this->db->query($sql,$match_id)->row_array();
		$motm_id=$query['motm_id'];
		
		/// 3. GET MOTM_BONUS_PONT FROM CONSTANTS TABLE
		$sql='select MOTM_BONUS_POINT from `constants` WHERE TOURNAMENT_ID=CURRENT_TOURNAMENT()';
		$query=$this->db->query($sql)->row_array();
		$motm_bonus=$query['MOTM_BONUS_POINT'];
		
		/// 4. SET MOTM_BONUS_PONT FOR THE PLAYER IN PLAYER_MATCH_POINT TABLE
		$sql='UPDATE player_match_point SET motm_bonus=? WHERE player_id=? AND match_id=?';
		$query=$this->db->query($sql,array($motm_bonus,$motm_id,$match_id));
	}

}
?>