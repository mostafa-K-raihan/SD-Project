<?php
/**
	LAST MODIFIED: 30-06-2015
	STATUS: REPLICATION COMPLETE
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Phase extends CI_Controller {
 
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
	* Update Phase Table
	*/
	
	
	public function addPhases()
	{
		if(isset($_POST['phases']) && isset($_POST['tournament_name']))
		{
			$data['phases']=$this->input->post('phases');
			$this->load->view('admin_addPhase',$data);
		}

		else
		{
			$data['phases']=0;
			$data['tournament_name']='';
			
			$this->load->view('admin_addPhase',$data);	
		}
		
	}
	
	public function addPhases_proc()	//done
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Phase Created Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	/**
	public function deletePhase()
	{
	
	}
	
	public function deletePhase_proc()
	{
	
	}
	*/
	
	public function updatePhases()
	{
		$data['step']=0;
		$this->load->view('updatePhase',$data);
	}
	
	public function updatePhases_proc()
	{
			$data['step']=1;
			
			$this->load->view('updatePhase',$data);
	}
	
	public function updatePhases_proc2()
	{
		$data['success']=true;	//must be calculated later
		$data['success_message']="Phase Updated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
}