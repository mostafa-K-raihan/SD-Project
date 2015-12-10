<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends CI_Controller {

	/**
		\brief load all necessary libraries and helpers

		if session is set then load neccessary models else redirects to homepage
		
	*/
	 
	 public function __construct()		
     {
        parent::__construct();
		
		$this->load->library('session');
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('form_validation');
		
		if(isset($_SESSION["user_id"]))
		{
			$this->load->model('stat_model');
			$this->load->model('tournament_model');
			$this->load->model('user_model');
			$this->load->model('team_model');
			$this->load->model('player_model');
		}
		else
		{
			redirect('/home', 'refresh');
		}  
     }
	 
	/**
		Default: Show Bargraphs
	*/	
	public function index()
	{
		$this->per_category_per_team_stat();
	}
	

	/**
		Show statistics of point contribution of individual players for the user
	*/
	public function player_overall_stat()
	{
		/// 1. Find all player's id
		$players = $this->tournament_model->get_all_players();
		
		$playerData=array();
		/// 2. For Each Player
		
		foreach($players as $p)
		{
			/// 2(a). Find all 'match_id' & 'point' s where the player played for the user
			$temp = $this->stat_model->get_user_team_match_id($_SESSION['user_id'],$p['player_id']);
			
			if($temp->num_rows()==0)
			{
				continue;
			}
			else
			{
				$temp = $temp->result_array();
			}
			
			
			$p['points']=0;
			
			/// 2(a).1. For Each match_id, calculate point and add them
			foreach($temp as $t)
			{
				if($t['captain_id']==$p['player_id'])
				{
					$p['points']+=($this->player_model->get_player_point_by_match($p['player_id'],$t['match_id']))*2;
				}
				else
				{
					$p['points']+=$this->player_model->get_player_point_by_match($p['player_id'],$t['match_id']);
				}
			}
		
			array_push($playerData,$p);
			
		}
		
		$multiSort = array();
		foreach ($playerData as $key => $row)
		{
			$multiSort[$key] = $row['points'];
		}
		array_multisort($multiSort, SORT_DESC, $playerData);
			
		$data['playerData']=$playerData;
		$this->load->view('playerByplayerStat',$data);
	}
	
	/**
		Show statistics of point contribution of each team for the user
	*/
	public function team_overall_stat()
	{
		$teamData = array();
		
		///1. Find All 'team_id's of the tournament
		$teams = $this->tournament_model->get_active_tournament_teams()->result_array();
		
		foreach($teams as $team)
		{
			/// 1.1. Find all player's id of that team only
			$players = $this->team_model-> get_team_players($team['team_id'])->result_array();
			
			$playerData=array();
			$teamPoint=0;
			/// 1.2. For Each Player
			foreach($players as $player)
			{
				/// 1.2(a). Find all 'match_id' & 'point' s where the player played for the user
				$temp = $this->stat_model->get_user_team_match_id($_SESSION['user_id'],$player['player_id']);
				
				if($temp->num_rows()==0)
				{
					continue;
				}
				else
				{
					$temp = $temp->result_array();
				}
				
				
				$player['points']=0;
				
				/// 1.2(a).1. For Each match_id, calculate point and add them
				foreach($temp as $t)
				{
					if($t['captain_id']==$player['player_id'])
					{
						$player['points']+=($this->player_model->get_player_point_by_match($player['player_id'],$t['match_id']))*2;
					}
					else
					{
						$player['points']+=$this->player_model->get_player_point_by_match($player['player_id'],$t['match_id']);
					}
				}
			
				$teamPoint+=$player['points'];
			}
			
			$team['teamPoint']=$teamPoint;
			
			array_push($teamData,$team);
			
		}
		
		$multiSort = array();
		foreach ($teamData as $key => $row)
		{
			$multiSort[$key] = $row['teamPoint'];
		}
		array_multisort($multiSort, SORT_DESC, $teamData);
		
		return $teamData;
	}
	
	/**
		Show statistics of point contribution of each category for the user
	*/
	public function per_category_per_team_stat()
	{
		$catData = array();
		
		///1. Find All 'team_id's of the tournament
		$categories = array('BAT','BOWL','ALL','WK');
		$catData=array();
			
		foreach($categories as $cat)
		{
			
			/// 1.1. Find all player's id of that team only
			$players = $this->tournament_model-> get_tournament_players_by_category($cat)->result_array();
			//print_r($players);
			//echo '<br><br>';
			
			$catPoint=0;
			/// 1.2. For Each Player
			foreach($players as $player)
			{
				/// 1.2(a). Find all 'match_id' & 'point' s where the player played for the user
				$temp = $this->stat_model->get_user_team_match_id($_SESSION['user_id'],$player['player_id']);
				
				if($temp->num_rows()==0)
				{
					continue;
				}
				else
				{
					$temp = $temp->result_array();
				}
				
				
				$player['points']=0;
				
				/// 1.2(a).1. For Each match_id, calculate point and add them
				foreach($temp as $t)
				{
					if($t['captain_id']==$player['player_id'])
					{
						$player['points']+=($this->player_model->get_player_point_by_match($player['player_id'],$t['match_id']))*2;
					}
					else
					{
						$player['points']+=$this->player_model->get_player_point_by_match($player['player_id'],$t['match_id']);
					}
				}
			
				$catPoint+=$player['points'];
			}
			
			if($cat=="BAT")
			{
				$category['cat']="Batsman";
			}else if($cat == "BOWL"){
				$category['cat']="Bowler";
			}else if($cat == "WK"){
				$category['cat'] = "WicketKeeper";
			}else if($cat=="ALL"){
				$category['cat']="All-Rounder";
			}
			
			
			$category['catPoint']=$catPoint;
			
			array_push($catData,$category);
			
		}
		
		//print_r($catData);
		
		$multiSort = array();
		foreach ($catData as $key => $row)
		{
			$multiSort[$key] = $row['catPoint'];
		}
		array_multisort($multiSort, SORT_DESC, $catData);
		
		$data['catData']=$catData;
		$data['teamData']=$this->team_overall_stat();
		$this->load->view('BargraphView',$data);
	}
	
	/**
		Show match by match user points - also show detailed information on click
	*/
	public function stat_per_match()
	{
		/**
			Get All Match Data (Before Current Match)
			Required : match_id, time, home_team , away_team
		*/
		$query = $this->tournament_model->get_result();
		if($query->num_rows()==0)
		{
			
			$data=array(
				'success'=>false,
				'fail_message'=>"No Previous Match"
			);
			$this->load->view('templates/header2');
			$this->load->view('status_message_Before_login',$data);
		}
		else
		{
			$result=$query->result_array();
			$temp=array();
			foreach($result as $r)
			{
				$r['points'] = $this->user_model->get_user_match_point_v2($_SESSION['user_id'],$r['match_id']);
				$r['detail'] = $this->detail_match_point($r['match_id']); 
				array_push($temp,$r);
			}
			
			$data['result'] = $temp;
			
			$this->load->view('matchByMatchStat',$data);
		}
	}
	
	/**
		Get detailed information (point contribution of each player) for that match
	*/
	public function detail_match_point($match_id)
	{
		$user_id = $_SESSION['user_id'];
			
		/**
			1. Find Captain's Id (For showing double point) & user_match_team_id (To Find Other Team Players)
		*/
			
		$temp = $this->stat_model->get_ids_by_match($user_id,$match_id);
		
		$captain_id = $temp['captain_id'];
		$user_match_team_id = $temp['user_match_team_id'];
		
		$match_data = array();
			
		if($captain_id!=-1 and $user_match_team_id!=-1)
		{
			/**
				2. FIND ALL PLAYERS OF THE USER TEAM
			*/
			
			// required data : player_name, team , category , player_id
			$temp = $this->stat_model->get_user_player_by_match($user_match_team_id);
			$total_point = 0;
					
			foreach($temp as $t)
			{
				$t['is_captain']=0;
				$t['match_point'] = $this->player_model->get_player_point_by_match($t['player_id'],$match_id); 
					
				if($t['player_id'] === $captain_id)
				{
					$t['is_captain']=1;
					$t['match_point']*=2;
				}
					
				$total_point += $t['match_point'];
					
				array_push($match_data,$t);
			}
		}
		return $match_data;
	}
	
	/**
		FOR TEST MAINLY
	*/
	public function match_stat_action()
	{
		if(isset($_POST['match_id']) && !empty($_POST['match_id']))
		{
			$match_id=$_POST['match_id'];
			$user_id = $_SESSION['user_id'];
			
			/**
				1. Find Captain's Id (For showing double point) & user_match_team_id (To Find Other Team Players)
			*/
			
			$temp = $this->stat_model->get_ids_by_match($user_id,$match_id);
			$captain_id = $temp['captain_id'];
			echo $user_match_team_id = $temp['user_match_team_id'];
			
			/**
				2. FIND ALL PLAYERS OF THE USER TEAM
			*/
			$temp = $this->stat_model->get_user_player_by_match($user_match_team_id);
			$total_point = 0;
			
			$match_data = array();
			
			foreach($temp as $t)
			{
				$t['is_captain']=0;
				$t['match_point'] = $this->player_model->get_player_point_by_match($t['player_id'],$match_id); 
				
				if($t['player_id'] === $captain_id)
				{
					$t['is_captain']=1;
					$t['match_point']*=2;
				}
				
				$total_point += $t['match_point'];
				
				
				array_push($match_data,$t);
			}
			
			print_r($match_data);
			
		}
		else
		{
			echo 'Invalid Input';
		}
	}
	
	/**
		for debug
	
	*/
	public function test()
	{
		$cur=$this->tournament_model->get_previous_match()->row_array();
		print_r($cur);
		$cur=$this->tournament_model->get_current_phase();
		print_r($cur);
	}
		
}