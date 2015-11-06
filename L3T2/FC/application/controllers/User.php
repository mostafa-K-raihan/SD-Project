<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	 	 
	 public function __construct()		//DONE
     {
        parent::__construct();
		
		$this->load->library('session');
		$this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('form_validation');
		
		if(isset($_SESSION["user_id"]))
		{
			$this->load->model('user_model');
			$this->load->model('tournament_model');
			$this->load->model('match_model');
			$this->load->model('team_model');
			$this->load->model('player_model');
				
			$this->load->view('templates/header2');
		}
		else
		{
			redirect('/home', 'refresh');
		}  
     }
	 
	public function index()
	{
		$query=$this->tournament_model->get_active_tournament();
		if($query->num_rows()==0)
		{
			$data['success']=false;
			$data['fail_message']="No Tournament Running";
			$this->load->view('status_message',$data);
		}
		else
		{	
			$var=$this->user_model->exist_tournament_user($_SESSION['user_id']);
			
			if($var===0)
			{
				redirect('user/createTeam','refresh');
			}
			else
			{
				redirect('user/view_team','refresh');
			}
			
		}
	}
	
	
	public function logout()
	{
		//Stop Session
		$this->session->sess_destroy();
		
		//Redirect To Homepage
		redirect('/home', 'refresh');
	}
	
	public function changeTeam()		//UI
	{
		$this->load->view('changeTeam');
	}
	
	public function changeTeam_check()
	{
		$this->load->view('confirm_transfer');
	}
	
	public function changeTeam_proc()	//CONFIRMATION
	{
		echo 'Your Team Is Successfully Changed';
	}
	
	public function remove_transfered_player()
	{
		
	}
	
	public function createTeam()		//UI
	{
	 
		$this->load->view('createTeam');
	}
	
	public function createTeam_proc()	//CONFIRMATION
	{
		echo 'Team Successfully Created';
	}
	
	public function view_team()			//CHECK LATER
	{
		$data = array(
               'login_error' => false,
			   'registration_success' => false
			);
			
		$user_team=$this->user_model->get_current_user_match_team($_SESSION['user_id']);
		
		//if current match is not found, then transfer window is closed. 
		//Just Show the old team, because it will be replicated after the transfer window re-opens
		if($user_team==NULL)
		{
			$user_team=$this->user_model->get_user_match_team($_SESSION['user_id']);
		}
			
		$data['user_team']=array();
			
		$data['m_point']=$this->user_model->get_user_match_point($_SESSION['user_id']);		//Needs To Be Deleted From this and view
		$data['o_point']=$this->user_model->get_user_overall_point($_SESSION['user_id']);
			
		$data['team_name']=$this->user_model->user_team_name($_SESSION['user_id']);
		//echo '<br>';
			
			foreach($user_team['team_players'] as $u)
			{
				$info=array();
				$info['player_id']=$u['player_id'];
				//echo '<br>';
				$result=$this->player_model->get_player_info($info['player_id']);
				//print_r($result);
				$info['name']=$result['name'];
				$tmp=$this->team_model->get_team_name($result['team_id']);
				$info['team_name']=$tmp;
				$info['player_cat']=$result['player_cat'];
				$tmp=$this->player_model->player_overall_point($info['player_id']);
				$info['point']=$tmp;
				
				array_push($data['user_team'],$info);
			}
			$data['captain_id']=$user_team['captain'];
			$result=$this->player_model->get_player_info($data['captain_id']);
			$data['captain_name']=$result['name'];
			
			$this->load->view('user_home',$data);			//View Needs Modification
		
	}
	
	public function view_points()			//UI
	{
		$this->load->view('view_points');
	}
	
	public function topPlayers()				//done
	{
		$current_t=$this->tournament_model->get_active_tournament_id();
		if($current_t==NULL)
		{
			echo 'No Player Record Found';
		}
		else
		{
			$data['top']=$this->player_model->top_players();
			$this->load->view('top_players',$data);
		}

	}
	
	public function schedules()				//done
	{
		$query= $this->tournament_model->get_fixture();		
		
		if($query->num_rows()==0)
		{
			//echo "No Fixture Available for this tournament";	//Load No Fixture View
			$data=array(
				'success'=>false,
				'failure_message'=>"No Fixture Available for this tournament"
			);
			$this->load->view('status_message',$data);
		}
		else
		{
			$data['fixture']=$query->result_array();
		
			$this->load->view('schedule',$data);
		}
	}
	
	public function results()		//LATER
	{
		$query= $this->tournament_model->get_result();		
		
		if($query->num_rows()==0)
		{
			$data=array(
				'success'=>false,
				'fail_message'=>"No Result Available for this tournament"
			);
			$this->load->view('status_message',$data);
		}
		else
		{
			$data['result']=$query->result_array();
			$this->load->view('results',$data);
		}
	}
	
	/**
		<Implement>
	*/
	
	
	public function changePassword()		//LATER
	{
		
	}

	public function editProfile()				//LATER
	{
	
	}
	
	
	
	public function changeCaptain()				//LATER
	{
	
	}

	public function pointTable()	
	{
		//comment this after implementation
		$data=array(
				'success'=>true,
				'success_message'=>"Point Table will be added very soon"
			);
		$this->load->view('status_message',$data);
		
		/*
		<Implement>
		$this->load->view('point_table',$data);
		*/
	}
	
	public function howToPlay()		
	{
		// <Implement>
		//	Just adjust the view
		$this->load->view('how_to_play');
	}
	
	public function scoring()		
	{
		// <Implement>
		//	Just adjust the view 
		$this->load->view('how_to_play',$data);
	}
		
}