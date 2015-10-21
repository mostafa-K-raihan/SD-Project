<?php
/**
	LAST UPDATE: 29-06-2015 04:23 PM
	STATUS: COMPLETE
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {
		  
	public function __construct()		//DONE
    {
         parent::__construct();
		  
		 //Load Necessary Libraries and helpers
         $this->load->library('session');
         $this->load->helper('form');
         $this->load->helper('url');
         $this->load->helper('html');
		 $this->load->library('form_validation');
		  
		$this->load->view('templates/header');
    }
	
	
	public function index()			//DONE
	{
		redirect('team/createTeam');
	}
	
	/**
	*	USE CASE:: CREATE A TEAM
	*/
	
	public function createTeam()	
	{
		if(isset($_POST['players']) && isset($_POST['team_name']))
		{
			$data['players']=$this->input->post('players');
			$data['team_name']=$this->input->post('team_name');

			$this->load->view('admin_addTeam',$data);
		}

		else
		{
			$data['players']=0;
			$data['team_name']='';

			$this->load->view('admin_addTeam',$data);	
		}
	}
	
	public function createTeam_proc()
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Team Created Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}

	/**
	*	USE CASE:: CHANGE TEAM INFO
	*/
	
	public function changeTeamInfo()
	{
	
	}
	
	/**
	*	USE CASE:: ADD NEW PLAYER
	*/
	
	public function addPlayer()		//DONE
	{
		$data['step']=0;
		$this->load->view('addPlayer',$data);
	}
	
	public function addPlayer_1()	//DONE
	{
		$data['step']=1;
		$this->load->view('addPlayer',$data);
	}
	
	public function addPlayer_2()	//DONE
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Player Added Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	
	/**
	*	USE CASE:: CHANGE PLAYER INFO
	*/
	
	public function changePlayerInfo()
	{
	
	}
	
	/**
	*	USE CASE:: UPDATE TEAM SHEET
	*/
	
	public function updateTeamSheet()
	{
		$data['step']=0;
		$this->load->view('updateTeamSheet',$data);
	}

	public function updateTeamSheet_1()	//done
	{
		$data['step']=1;
		$this->load->view('updateTeamSheet',$data);
	}

	public function updateTeamSheet_2()	//done
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Team Sheet updated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
}