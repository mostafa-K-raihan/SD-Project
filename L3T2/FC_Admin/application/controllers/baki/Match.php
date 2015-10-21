<?php
/**
	LAST UPDATED: 30-06-2015 04:32 pm
	STATUS: REPLICATION COMPLETE
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Match extends CI_Controller {
	  
	 public function __construct()
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
	
	/**
	*Update Match Table
	*/
	
	public function createMatch()
	{
		$data['step']=0;
		$this->load->view('createNewMatch',$data);
	}
	
	public function createMatch_proc()
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Match Created Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	public function updateMatchInfo()
	{
		$data['step']=0;
		$this->load->view('updateMatch',$data);
	}
	
	public function updateMatchInfo_1()
	{
		$data['step']=1;
		$this->load->view('updateMatch',$data);
	}
	
	public function updateMatchInfo_proc()
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Match Info Updated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	
	public function updateMatchStat()		//STEP -01 : SELECT MATCH
	{
		$data['step']=0;
		$this->load->view('updateMatchStats',$data);
	}
	
	public function updateMatchStat_1()		//STEP -02 : UPDATE HOME TEAM STATS FORM
	{
		$data['step']=1;
		$this->load->view('updateMatchStats',$data);
	}


	public function updateMatchStat_2()		//STEP-03 : UPDATE AWAY TEAM STATS FORM
	{
		$data['step']=2;
		$this->load->view('updateMatchStats',$data);
	}

	public function updateMatchStat_proc($num)		//UPDATE STATS IN DATABASE
	{		
		$data['success']=true;	//must be calculated later
		$data['success_message']="Match Stat Updated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
}