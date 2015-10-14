<?php
/**
	LAST UPDATE: 29-06-2015
	STATUS: COMPLETE
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Tournament extends CI_Controller {
  
	public function __construct()	//done
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
	 
	public function index()
	{
	
	}
	
	
	public function createTournament()	//UI
	{
		$this->load->view('createTournament');
	}
	
	public function createTournament_proc()	//CHECKING & CONFIRMATION
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Tournament Created Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
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
	
	public function updateTournamentTeam()	
	{
		$data['step']=0;
		$this->load->view('updateTournamentTeams',$data);
	}

	public function updateTournamentTeam_1()	//done
	{
		$data['step']=1;
		$this->load->view('updateTournamentTeams',$data);
	}

	public function updateTournamentTeam_proc()	//done
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Tournament Teams Have Been Updated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	public function activeTournament()	//UI
	{
		$this->load->view('activeTournament');
	}

	public function activeTournament_proc()	//Confirmation
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Tournament Has Been Activated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
}