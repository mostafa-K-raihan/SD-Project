<?php

/**
*	LAST MODIFIED : 29-06-2015 04:02 PM
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	  
	 public function __construct()
     {
          parent::__construct();
		  
		  /**
		  *	Load Libraries , Models and Helpers
		  */
		  
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
		$this->load->model('match_model');
		
		
		$this->load->view('templates/header');
     }
	 
	/**
	*	[ADMIN HOME PAGE]
	*/
	
	public function index()			
	{
		/**	
		*	\brief Get Current Tournament Name		
		*/
		
		$query= $this->tournament_model->get_active_tournament();
		
		if($query->num_rows()==0)
		{
			echo 'No Active Tournament';
		}
		else
		{
			$result=$query->row_array();
			$data['tournament_name']=$result['tournament_name'];	/**< Current Tournament Name */
			
			$tournament_id=$result['tournament_id'];				/**< Current Tournament ID */
			
			/**
			*	\brief Get Upcoming Match Which has not been initiated by admin	
			*	
			*	After initiation, all tables that requires a match instance are created
			*/
			
			$query= $this->match_model->get_upcoming_match($tournament_id);
			
			if($query->num_rows()==0)
			{
				$data['home_team']='';				
				$data['away_team']='';				
				$data['match_id']='';
			}
			else
			{
				$result=$query->row_array();
				$data['home_team']=$this->team_model->get_team_name($result['team1_id']);				
				$data['away_team']=$this->team_model->get_team_name($result['team2_id']);				
				$data['match_id']=$result['match_id'];
			}
			
			/**
			*	Get Upcoming Phase Which Are Not Started By Admin
			*/
			
			$query= $this->tournament_model->get_upcoming_phase($tournament_id);
			
			if($query->num_rows()==0)
			{
				$data['upcoming_phase']='';
				$data['phase_id']='';
			}
			else
			{
				$result=$query->row_array();
				$data['upcoming_phase']=$result['phase_name'];
				$data['phase_id']=$result['phase_id'];
			}
			
			$this->load->view('admin_home',$data);
		}
		
	}
	
	/**
	*	Admin Logs out
	*/
	
	public function logout()	
	{
		$this->session->sess_destroy();	//!< Stop Session 
		
		/**
		*Redirect To Homepage
		*/
		
		redirect('/home', 'refresh');
	}
	
	public function schedules()	
	{
		$query= $this->tournament_model->get_fixture();		
		
		if($query->num_rows()==0)
		{
			$data=array(
				'success'=>false,
				'fail_message'=>"No Fixture Available for this tournament"
			);
			$this->load->view('status_message',$data);
		}
		else
		{
			$data['fixture']=$query->result_array();
			$this->load->view('schedule',$data);
		}
	}
	
	public function results()	
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
	
	public function start_phase_action($phase_id)	
	{
		$query= $this->admin_model->start_phase($phase_id);
		
		$data['success']=true;
		$data['success_message']="Data updated successfully to start the phase";
		$this->load->view('status_message',$data);
	}
	
	public function start_match_action($match_id)	
	{
		$query= $this->admin_model->start_match($match_id);
		$data['success']=true;
		$data['success_message']="Data updated successfully to start the match";
		$this->load->view('status_message',$data);
	}
	
}