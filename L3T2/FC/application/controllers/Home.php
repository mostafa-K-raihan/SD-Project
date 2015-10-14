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
		  
     }
	 
	public function index()	
	{
		if(isset($_SESSION["user_id"]))
		{			
			redirect('/user', 'refresh');
		}
		else
		{
			
			$loginData = array(
               'login_error' => false,
			   'registration_success' => false
			);
			$data=array(
				'id' => 1,
				'HOWTOPLAY' => false,
				'SIGNUP' => false
			);
			
			$this->load->view('templates/header',$data);
			$this->load->view('home', $loginData);
		}
		
	}
	
	public function login()	
	{
		//switching to user controller: user homepage
		redirect('/user', 'refresh');
		
	}
	
	public function register()	
	{
		$regData=array(
			'password_match_error' => false,
			'already_exist_error'=> false
		);
		$data=array(
				'id' => -1,
				'SIGNUP' => true,
				'HOWTOPLAY' => false
			);
		$this->load->view('templates/header',$data);
		$this->load->view('registration',$regData);
		
	}
	
	public function register_proc()
	{
		echo 'Registration Complete';
	}
	
	
	public function schedules()		
	{
		// <Implement>
		$data=array(
			'id' => 2,
			'SIGNUP' => false,
			'HOWTOPLAY' => false
		);
		$this->load->view('templates/header',$data);
		$this->load->view('schedule',$data);
	}
	
	public function results()		
	{
		// <Implement>
		$data=array(
			'id' => 3,
			'SIGNUP' => false,
			'HOWTOPLAY' => false
		);
		$this->load->view('templates/header',$data);
		$this->load->view('results',$data);
	}
	
	public function pointTable()	
	{
		// <Implement>
		$data=array(
			'id' => 4,
			'SIGNUP' => false,
			'HOWTOPLAY' => false
		);
		$this->load->view('templates/header',$data);
		$this->load->view('point_table',$data);
	}
	
	public function howToPlay()		
	{
		// <Implement>
		$data=array(
			'id'=> -1,
			'SIGNUP' => false,
			'HOWTOPLAY' => true
		);
		$this->load->view('templates/header',$data);
		$this->load->view('how_to_play',$data);
	}
	//eita most probably dorkar nai confirmation needed
	public function rules()			
	{
		// <Implement>
	}
	
	public function scoring()		
	{
		// <Implement>
				$data=array(
			'id'=> -1,
			'SIGNUP' => false,
			'HOWTOPLAY' => true,
			
		);
		$this->load->view('templates/header',$data);
		$this->load->view('how_to_play',$data);
	}
	
}
