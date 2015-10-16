<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	 
	 public function __construct()		//DONE
     {
          parent::__construct();
		  
		  //Load Necessary Libraries and helpers
          
		  $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
		  $this->load->library('form_validation');
		  
		  // <Load Admin Model>
     }
	 
	public function index()
	{
		$data = array(
           'login_error' => false
		);
		$this->load->view('admin-login',$data);
	}
	
	public function login()		
	{
		//Load Admin Home Page
		redirect('/admin', 'refresh');
	}
}
