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
			//$this->load->model('team_model');
			$this->load->model('player_model');
		}
		else
		{
			redirect('/home', 'refresh');
		}  
     }
	 
	public function index()
	{
		$this->load->view('stat');
	}
	
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
			
			/**
			TEST BLOCK
			*/
			//$r['points'] = $this->user_model->get_user_match_point_v2($_SESSION['user_id'],101);
			//$r['detail'] = $this->detail_match_point(101); 
			//array_push($temp,$r);
			
			/**
			END OF TEST BLOCK
			*/
			
			$data['result'] = $temp;
			
			$this->load->view('matchByMatchStat',$data);
		}
	}
	
	public function detail_match_point($match_id)
	{
		$user_id = $_SESSION['user_id'];
			
		/**
			1. Find Captain's Id (For showing double point) & user_match_team_id (To Find Other Team Players)
		*/
			
		$temp = $this->stat_model->get_ids_by_match($user_id,$match_id);
		
		$captain_id = $temp['captain_id'];
		$user_match_team_id = $temp['user_match_team_id'];
		
		if($captain_id==-1 or $user_match_team_id==-1)
		{
			return -1;
		}
		else
		{
			/**
				2. FIND ALL PLAYERS OF THE USER TEAM
			*/
			
			/// required data : player_name, team , category , player_id
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
				
			return $match_data;
		}
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
			/// required data : player_name, team , category , player_id
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
				
				//echo '<pre>';
				//print_r($t);
				//echo '</pre>';
				
				array_push($match_data,$t);
			}
			
			print_r($match_data);
			
			//echo $total_point;
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