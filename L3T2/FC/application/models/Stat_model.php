<?php
class Stat_model extends CI_Model 
{
    public function __construct()
	{
        $this->load->database();
	}
	
	/**
		Returns the array of user team players' id [ array("player_id"=>value) ] for the given match id
	*/
	/// required data : player_name, team , category , player_id
	public function get_user_player_by_match($user_match_team_id)
	{
		$sql='SELECT u.player_id , p.player_cat , p.name , t.team_name  FROM `user_match_team_player` u ,
			player p , team t WHERE u.user_match_team_id = ?
			and p.player_id = u.player_id and p.team_id = t.team_id';
		
		$temp = $this->db->query($sql,array($user_match_team_id));
		$result=$temp->result_array();
		
		return $result;
	}
	
	/**
		Returns the user_match_team_id & captain_id of user team for the given match id
	*/
	public function get_ids_by_match($user_id,$match_id)
	{
		$sql='SELECT user_match_team_id , captain_id FROM `user_match_team` WHERE user_id = ? and match_id = ?';
		$temp = $this->db->query($sql,array($user_id,$match_id));
		
		if($temp->num_rows()==0)
		{
			$result['user_match_team_id']=-1;
			$result['captain_id']=-1;
			return $result;
		}
		
		$result=$temp->row_array();
		
		return $result;
	}
	
	/**
		Return 'match_id' and corresponding 'captain_id' s in which the given player was in the user's team.
		If No such entry, return -1
	*/
	public function get_user_team_match_id($user_id,$player_id)
	{
		$sql='SELECT umt.match_id, umt.captain_id FROM `user_match_team_player` umtp, user_match_team umt
		WHERE umt.user_id=? and
		umt.user_match_team_id = umtp.user_match_team_id and
		umtp.player_id=?';
		$temp=$this->db->query($sql,array($user_id,$player_id));
		
		return $temp;
	}
}
?>