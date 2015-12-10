<?php
/**
	Provide database support for `tournament` entity
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Tournament extends CI_Controller {
  
	public function __construct()
    {
        parent::__construct();
		  
		/// Load Necessary Libraries and helpers
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('html');
		$this->load->library('form_validation');
		
		if(isset($_SESSION["user_id"]))
		{
			die("Please Log out from your user account. ");
		}
		else
		{
			if(!isset($_SESSION["admin_id"]))
			{
				redirect('/home', 'refresh');
			}
		}
		  
		$this->load->model('admin_model');
		$this->load->model('tournament_model');
		$this->load->model('team_model');
		$this->load->model('player_model');
				
		$this->load->view('templates/header');
    }
	 
	/**
		Nothing
	*/
	public function index()
	{
	
	}
	
	/**
		CREATE TOURNAMENT : Show view (input form)
	*/
	public function createTournament()	
	{
		
		$query=$this->tournament_model->view_tournaments();

		$data['tournaments']=$query->result_array();

		$this->load->view('createTournament',$data);
	}
	
	/**
		CREATE TOURNAMENT : Process user input
	*/
	public function createTournament_proc()
	{
		$t_data['tournament_id']='';
		$t_data['tournament_name']=trim($this->input->post('tournament_name'));
		$t_data['start_date']=$_POST['start_year'].'-'.$_POST['start_month'].'-'.$_POST['start_day'];
		$t_data['end_date']=$_POST['end_year'].'-'.$_POST['end_month'].'-'.$_POST['end_day'];
		$t_data['is_active']='';
		$t_data['icon']='';
		$t_data['is_complete']='';
		
		$data['success']=$this->tournament_model->create_tournament($t_data);
		
		$data['success_message']="Tournament Created Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	/*
	public function deleteTournament()
	{
		//Load View
	}
	
	public function deleteTournament_proc()
	{
		
	}
	
	public function editTournamentInfo()
	{
		//Load View
	}
	
	public function editTournamentInfo_proc()
	{
	
	}
	
	public function addTournamentTeam()
	{
		
	}
	
	public function deleteTournamentTeam()
	{
		
	}
	*/
	
	/**
		UPDATE TOURNAMENT TEAM : Show view to select tournament
	*/
	public function updateTournamentTeam()	
	{
		$query=$this->tournament_model->get_all_tournaments();
		$data['tournaments']=$query->result_array();
		$data['step']=0;
		$this->load->view('updateTournamentTeams',$data);
	}

	/**
		UPDATE TOURNAMENT TEAM : Show view to select teams
	*/
	public function updateTournamentTeam_1()	
	{
		$tournament_id = $_POST['tournament_id'];
		$data['tournament_name']=$this->tournament_model->get_tournament_name($tournament_id);

		$data['step']=1;
		
		
		$query=$this->team_model->get_all_teams();

		$data['teams']=$query->result_array();
		
		$userdata=array('tournament_id'=>$tournament_id,'teams'=>$data['teams']);
		$this->session->set_userdata($userdata);
		
		$this->load->view('updateTournamentTeams',$data);
	}
	
	/**
		UPDATE TOURNAMENT TEAM : Process user input
	*/
	public function updateTournamentTeam_2()
	{
		$teams=$_SESSION['teams'];
		$tournament_id = $_SESSION['tournament_id'];
		
		foreach ($teams as $tm)
		{
			$tid=$tm['team_id'];
			
			if(isset($_POST[$tid]))
			{
				$this->tournament_model->add_tournament_team($tournament_id,$tid);
			}
			else
			{
				$this->tournament_model->delete_tournament_team($tournament_id,$tid);
			}
		}
		
		unset($_SESSION['tournament_id'],$_SESSION['teams']);
		
		$data['success'] = true;
		$data['success_message'] = "Tournament teams updated successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	/**
		SELECT ACTIVE TOURNAMENT : Show view to select
	*/
	public function activeTournament()
	{
		$query=$this->tournament_model->view_tournaments();

		$data['tournaments']=$query->result_array();

		$this->load->view('activeTournament',$data);
		//echo 'Select Active Tournament Here';
	}

	/**
		SELECT ACTIVE TOURNAMENT : Process user input
	*/
	public function activeTournament_proc()
	{
		$t_id = $_POST['tournament'];
		$this->tournament_model->update_active_tournament($t_id);
		
		$data['success']=true;
		$data['success_message']="Tournament Has Been Activated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
}