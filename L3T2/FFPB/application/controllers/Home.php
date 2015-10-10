<?php
defined('BASEPATH') OR exit('No direct script access allowed'); // basepath controller er directory access e kaje lage


class Home extends CI_Controller {
	 
	 public function __construct() 
     {
          parent::__construct();
		  
		  //1. Load Necessary Libraries and helpers
          
		  $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
		  $this->load->library('form_validation');
		  
		  //do some work
		  //< load model >
		  
		  //3. Load Template
		  $this->load->view('templates/header');
     }
	 
	public function index()	
	{
		if(isset($_SESSION["user_id"]))
		{			
			redirect('/user', 'refresh');
		}
		else
		{
			
			$data = array(
               'login_error' => false,
			   'registration_success' => false
			);
			
			$this->load->view('home',$data);
		}
		
	}
	
	public function login()	
	{
		//switching to user controller: user homepage
		redirect('/user', 'refresh');
		
	}
	
	public function register()	
	{
		$data=array(
			'password_match_error' => false,
			'already_exist_error'=> false
		);
		$this->load->view('registration',$data);
	}
	
	public function register_proc()
	{
		echo 'Registration Complete';
	}
	
	
	public function schedules()		
	{
		// <Implement>
		$this->load->view('schedule');
	}
	
	public function results()		
	{
		// <Implement>
		$this->load->view('results');
	}
	
	public function pointTable()	
	{
		// <Implement>
	}
	
	public function howToPlay()		
	{
		// <Implement>
	}
	
	public function rules()			
	{
		// <Implement>
	}
	
	public function scoring()		
	{
		// <Implement>
	}
	
}
