<?php
/**
	LAST UPDATED: 30-06-2015
	STATUS: REPLICATION COMPLETE
*/
class Team_model extends CI_Model 
{
	
    public function __construct()	//DONE
	{
        $this->load->database();
	}
	
	public function update_motm_id($match_id,$player_id)	//NOT TESTED
	{
		$sql='UPDATE `match` SET `motm_id`=? WHERE `match_id`=?';
		$query=$this->db->query($sql,$team_id); 
		return;
	}
	
	public function get_team_name($team_id)	//DONE
	{
		$sql = 'SELECT `team_name` FROM `team` where `team_id`=?';				
		$query=$this->db->query($sql,$team_id); 
		$result=$query->row_array();
		
		return $result['team_name'];
	}
	
	public function get_team_id($team_name)	//DONE
	{
		$sql = 'SELECT `team_id` FROM `team` where `team_name`=?';				
		$query=$this->db->query($sql,$team_name);

		$result=$query->row_array();
		
		return $result['team_id'];
	}
	
	public function create_team($data)		//DONE
	{
		$sql = 'INSERT INTO `team` VALUES(?,?,?)';		
		return $this->db->query($sql,$data); 
	}
	
	public function get_all_teams()	//DONE
	{
		$sql = 	'SELECT * from `team` ORDER BY `team_name`';
				
		$query=$this->db->query($sql); 
		
		return $query;
	}
	
	/*
	//SELECT PLAYER_ID'S FOR A GIVEN TEAM
	//PLAYER MAY OR MAYNOT BE IN THE TEAM SHEET FOR THE CURRENT/ACTIVE TOURNAMENT
	*/
	public function get_team_players($team_id)	//DONE
	{
		$sql = 	'SELECT * from `player` where `team_id`=? ORDER BY `player_cat` ASC, `name` ASC';			
		$query=$this->db->query($sql,$team_id); 
		return $query;
	}

	/*
	//SELECT PLAYER_ID'S FOR A GIVEN TEAM
	//PLAYER MUST BE IN THE TEAM SHEET FOR THE CURRENT/ACTIVE TOURNAMENT
	*/
	public function get_tournament_team_players($team)	//done
	{
		$sql = 'select P.`name` as PLAYER_NAME, P.`player_id` as PLAYER_ID
				from `player` P, `player_tournament` PT
				where P.`player_id` = PT.`player_id` and P.`team_id`=? and PT.`tournament_id`=?';
		$query = $this->db->query($sql,$team);
		return $query;
	}
	
}
?>