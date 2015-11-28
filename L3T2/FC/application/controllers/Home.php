<?php
defined('BASEPATH') OR exit('No direct script access allowed'); // basepath controller er directory access e kaje lage


class Home extends CI_Controller {
	 
	 /**
	 *	\brief Load Necessary Libraries and helpers
	 *
	 *	Load Models
	 */
	 public function __construct() 
     {
          parent::__construct();
		  
		  //1. Load Necessary Libraries and helpers
          
		  $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
		  $this->load->library('form_validation');
		  
			$data=array(
				'id' => 1,
				'HOWTOPLAY' => false,
				'SIGNUP' => false
			);
		  //2. Load Models
		  $this->load->model('user_model');
		  $this->load->model('tournament_model');
     }
	
	/**
	*	If user session is found, just redirect to user's homepage (view team or create team decided by user controller)
	*/
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
	
	/**
	* \brief Controller Function to manage user login
	*
	* If user login is successful, redirect to user's homepage. Otherwise, reload the page
	*/
	public function login()	
	{
		$data = array('email'=>trim($_POST['email']),'password'=>md5($_POST["password"]));
		
		$query= $this->user_model->get_loginInfo($data);
		
		if($query->num_rows()==1)
		{
			$loginInfo=$query->row_array();
			
			$_SESSION["user_id"]=$loginInfo['user_id'];
			$_SESSION["user_name"]=$loginInfo['user_name'];
			
			redirect('/user', 'refresh');
		}
		else
		{
			
			$loginData = array(
               'login_error' => true,
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
	
	/**
	* \brief Controller Function to manage user registration
	*
	* If user session is found, just redirect to user's homepage rather than showing register page
	*/
	public function register()	
	{
		if(isset($_SESSION["user_id"]))
		{
			redirect('/user', 'refresh');
		}
		else
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
	}
	
	/**
	* \brief Provides condition checking and database operation for user registration
	*/
	public function register_proc()
	{
			/**
				Password and confirm password inputs must match
			*/
			$pass=md5($this->input->post('password'));
			$conpass=md5($this->input->post('confirm_password'));

			if($pass!=$conpass)
			{
				$headerData=array(
					'id' => -1,
					'SIGNUP' => true,
					'HOWTOPLAY' => false
				);
				$this->load->view('templates/header',$headerData);
			
				$data=array(
				'password_match_error' => true,
				'already_exist_error'=> false
				);
				$this->load->view('registration',$data);
			}
			
			else
			{
				$headerData=array(
					'id' => -1,
					'SIGNUP' => true,
					'HOWTOPLAY' => false
				);
				$this->load->view('templates/header',$headerData);
			
				/**
					Extract necessary data from html input fields
				*/
				$data['user_id'] ='';

				$data['user_name'] =trim($this->input->post('user_name'));
				$data['email'] =trim($this->input->post('email'));
				$data['password'] =$pass;
				
				if(isset($_POST['day'])&&isset($_POST['month'])&&isset($_POST['year']))
				{
					$day=$_POST['day'];
					$month=$_POST['month'];
					$year=$_POST['year'];
					$data['birthday']=$year.'-'.$month.'-'.$day;
				}
				else $data['birthday'] ='';
				
				if(isset($_POST['Country'])) $data['country'] =$this->input->post('Country');
				else $data['country'] ='';
				
				/**
					If an user is already registered in the system, request for registration is denied
				*/
				$exists= $this->user_model->exist_user($data['email']);

				if($exists==1)
				{
					$data=array(
					'password_match_error' => false,
					'already_exist_error'=> true
					);
					$this->load->view('registration',$data);					
				}
				else
				{
					/**
						If everything is ok, register user in database
					*/
					$this->user_model->register($data);
					$data = array(
					   'login_error' => false,
					   'registration_success' => true
					);
					
					$this->load->view('home',$data);	
				}
			}
	}
	
	/**
		Show tournament fixture
	*/
	public function schedules()		
	{
		$headerData=array(
			'id' => 2,
			'SIGNUP' => false,
			'HOWTOPLAY' => false
		);
		$this->load->view('templates/header',$headerData);
		
		/**
			Load fixture from database (using tournament_model )
		*/
		$query= $this->tournament_model->get_fixture();		
		
		if($query->num_rows()==0)
		{
			$data=array(
				'success'=>false,
				'failure_message'=>"No Fixture Available for this tournament"
			);
			$this->load->view('status_message',$data);
		}
		else
		{
			$data['fixture']=$query->result_array();
		
			$this->load->view('scheduleBeforeLogin',$data);
		}
	}
	
	/**
		Show tournament results if any match is complete
	*/
	public function results()		
	{
		$headerData=array(
			'id' => 3,
			'SIGNUP' => false,
			'HOWTOPLAY' => false
		);
		$this->load->view('templates/header',$headerData);
		
		$query= $this->tournament_model->get_result();		
		
		if($query->num_rows()==0)
		{
			$data=array(
				'success'=>false,
				'fail_message'=>"No Result Available for this tournament"
			);
			$this->load->view('status_message_Before_login',$data);
		}
		else
		{
			$data['result']=$query->result_array();
			$this->load->view('resultsBeforeLogin',$data);
		}
	}
	
	/**
		Not yet implemented. Just need to link some sites like crickinfo which contains the point table
	*/
	public function pointTable()	
	{
		$headerData=array(
			'id' => 4,
			'SIGNUP' => false,
			'HOWTOPLAY' => false
		);
		$this->load->view('templates/header',$headerData);
		
		$data=array(
				'success'=>true,
				'success_message'=>"Point Table will be added very soon"
			);
		$this->load->view('status_message_Before_login',$data);
	}
	
	/**
		Kind of a user manual showing the rules of the game. No logical code. Totally done inside html
	*/
	public function howToPlay()		
	{
		$data=array(
			'id'=> -1,
			'SIGNUP' => false,
			'HOWTOPLAY' => true
		);
		$this->load->view('templates/header',$data);
		$this->load->view('how_to_play_Before_login',$data);
	}
	
	/**
		Introduction to our team. Another fully html task
	*/
	public function about_us()
	{
		$data=array(
			'id'=> -1,
			'SIGNUP' => false,
			'HOWTOPLAY' => false
		);
		$this->load->view('templates/header',$data);
		
		$this->load->view('aboutUs');
	}
}
