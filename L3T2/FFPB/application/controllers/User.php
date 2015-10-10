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

        $this->load->view('templates/header2');
		
		// < LOAD MODELS >
		  
     }
	 
	public function index()
	{
		redirect('user/createTeam','refresh');
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
	
	public function view_team()			//UI
	{
		$this->load->view('user_home');			//View Needs Modification
	}
	
	public function view_points()			//UI
	{
		$this->load->view('view_points');
	}
	
	public function topPlayers()				//UI
	{
		$this->load->view('top_players');
	}
	
	public function schedules()				//done
	{
		$this->load->view('schedule');
	}
	
	public function results()		//LATER
	{
		$this->load->view('results');
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


	public function pointTable()		//LATER
	{
		echo "pointTable Test";
	}
	
	public function howToPlay()		//LATER
	{
		echo "howToPlay Test";
	}
	
	public function rules()		//LATER
	{
		echo "Rules Test";
	}
	
	public function scoring()		//LATER
	{
		echo "scorings Test";
	}
		
}