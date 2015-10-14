<?php
/**
	LAST MODIFIED : 29-06-2015 04:02 PM
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	  
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
	 
	/**
	*	ADMIN HOME PAGE
	*/
	
	public function index()			
	{
		$this->load->view('admin_home');
	}
	
	public function logout()	
	{
		//Stop Session
		$this->session->sess_destroy();
		
		//Redirect To Homepage
		redirect('/home', 'refresh');
	}
	
	public function schedules()	
	{
		// <Copy From User Views>
		$this->load->view('schedule');
	}
	
	public function results()	
	{
		// <Copy From User Views>
		$this->load->view('results');
	}
}