<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Defines Server Actions For Site Home Page
*/
class Home extends CI_Controller {
	 
	 public function __construct()		
     {
          parent::__construct();
		  
		  /// Load Necessary Libraries and helpers
          
		  $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
		  $this->load->library('form_validation');
		  
		  /// Load Admin Model
		  $this->load->model('admin_model');
     }
	 
	/**
		If admin session is found, redirect to admin home page ; Otherwise prompt for login
	*/	
	public function index()
	{
		if(isset($_SESSION["admin_id"]))
		{
			redirect('/admin', 'refresh');
		}
		else
		{
			
			$data = array(
               'login_error' => false
			);
			$this->load->view('admin-login',$data);
		}
	}
	
	/**
		Provides functionality for admin login. Very trivial
	*/
	public function login()		
	{
		if(isset($_POST['admin_id']) && isset($_POST['password']))
		{
			/// Password is hashed using md5() hashing
			$data = array('admin_id'=>trim($_POST['admin_id']),'password'=>md5($_POST["password"]));
			
			$query= $this->admin_model->get_loginInfo($data);
			
			if($query->num_rows()==1)
			{
				$loginInfo=$query->row_array();
				
				$_SESSION["admin_id"]=$loginInfo['admin_id'];
				
				/// If login is successful, Load User Admin Page
				redirect('/admin', 'refresh');
			}
			else
			{
				$data = array(
				   'login_error' => true
				);
				$this->load->view('admin-login',$data);
			}
		}
		else
		{
			$data = array(
				   'login_error' => false
				);
				$this->load->view('admin-login',$data);
		}
		
	}
}
