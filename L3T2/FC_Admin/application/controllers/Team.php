<?php
/**
	Provide database support(CRUD) for `team` entity and related functionality
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {
		  
	public function __construct()		
    {
         parent::__construct();
		  
		 /// Load Necessary Libraries and helpers
         $this->load->library('session');
         $this->load->helper('form');
         $this->load->helper('url');
         $this->load->helper('html');
		 $this->load->library('form_validation');
		  
		if(isset($_SESSION["user_id"]))
		{
			die("Please Log out from your user account. ");
		}
		else
		{
			if(!isset($_SESSION["admin_id"]))
			{
				redirect('/home', 'refresh');
			}
		}
		  
		$this->load->model('admin_model');
		$this->load->model('tournament_model');
		$this->load->model('team_model');
		$this->load->model('player_model');		
		
		$this->load->view('templates/header');
    }
	
	
	public function index()			
	{
		redirect('team/createTeam');
	}
	
	/**
	*	CREATE A TEAM : Show View
	*/
	public function createTeam()	
	{
		/**
		*	CREATE A TEAM : Show View to input player info
		*/
		if(isset($_POST['players']) && isset($_POST['team_name']))
		{
			$data['players']=$this->input->post('players');
			$data['team_name']=$this->input->post('team_name');

			$teamInfo = array(
			        'players'  => $data['players'],
			        'team_name'=>$data['team_name']
			);

			$this->session->set_userdata($teamInfo);

			$team_data['team_id']='';
			$team_data['team_name']=$data['team_name'];
			$team_data['jersy_image']='';

			if(!$this->team_model->create_team($team_data))
			{
					redirect('team/create_team_failure','refresh');
			}
			else $this->load->view('admin_addTeam',$data);
		}
		/**
		*	CREATE A TEAM : Show View to input team name and number of players
		*/
		else
		{
			$data['players']=0;
			$data['team_name']='';

			$this->load->view('admin_addTeam',$data);	
		}
	}

	/**
	*	CREATE A TEAM : Process User Input
	*/
	public function createTeam_proc()	
	{
		$team = $_SESSION['team_name'];
		$team_id=$this->team_model->get_team_id($team);

		$count=$_SESSION['players'];
		for($i=1;$i<=$count;$i++)
		{
			$name = 'name'.$i;
			$cat = 'cat'.$i;
			$price = 'price'.$i;

			$player_data['player_id']='';
			$player_data['price']=$this->input->post($price);
			$player_data['player_cat']=$this->input->post($cat);
			$player_data['name']=$this->input->post($name);
			$player_data['team_id']=$team_id;
			$player_data['image']='';

			if(!$this->player_model->add_player($player_data))
			{
				redirect('team/create_team_failure','refresh');
			}
		}

		unset(
				$_SESSION['team_name'],
				$_SESSION['players']
			);

		$data['success']=true;	//must be calculated later
		$data['success_message']="Team Created Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}

	/**
	*	CHANGE TEAM INFO : Nothing done
	*/
	public function changeTeamInfo()
	{
	
	}
	
	/**
	*	ADD NEW PLAYER : Show view to select team
	*/
	public function addPlayer()		
	{
		/// Select any of the existing Teams
		
		$query=$this->team_model->get_all_teams();

		$data['teams']=$query->result_array();
		$data['step']=0;
		$this->load->view('addPlayer',$data);
	}
	
	/**
	*	ADD NEW PLAYER : Show view to input player info
	*/
	public function addPlayer_1()	
	{
		$team_id = $_POST['team_id'];
		$data['team_name']=$this->team_model->get_team_name($team_id);

		$data['step']=1;
		
		$userdata=array('team_id'=>$team_id);
		$this->session->set_userdata($userdata);
		
		$query=$this->team_model->get_team_players($team_id);

		$data['players']=$query->result_array();
		$this->load->view('addPlayer',$data);
	}
	
	/**
	*	ADD NEW PLAYER : Process user input
	*/
	public function addPlayer_2()	
	{
		$player_data['player_id']='';
		$player_data['price']=$this->input->post('price');
		$player_data['player_cat']=$this->input->post('player_cat');
		$player_data['name']=$this->input->post('player_name');
		$player_data['team_id']=$_SESSION['team_id'];
		$player_data['image']='';

		unset($_SESSION['team_id']);
		if(!$this->player_model->add_player($player_data))
		{
			$data['success'] = false;
		}
		else $data['success'] = true;
		
		$data['success_message']="Player Added Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
	
	
	/*
	
	public function changePlayerInfo()
	{
	
	}
	
	*/
	
	/**
	*	UPDATE TEAM SHEET : Show view to select team
	*/
	public function updateTeamSheet()
	{
		$tid=$this->tournament_model->get_active_tournament_id();
		if($tid==NULL)
		{
			echo 'No Active Tournament';
		}
		else
		{
			$query=$this->tournament_model->get_active_tournament_teams();
			$data['teams']=$query->result_array();
			$data['step']=0;
			$this->load->view('updateTeamSheet',$data);
		}
	}

	/**
	*	UPDATE TEAM SHEET : Show view to select players
	*/
	public function updateTeamSheet_1()
	{
		$team_id = $_POST['team_id'];
		$data['team_name']=$this->team_model->get_team_name($team_id);

		$data['step']=1;
		
		
		$query=$this->team_model->get_team_players($team_id);

		$data['players']=$query->result_array();
		
		$userdata=array('team_id'=>$team_id,'players'=>$data['players']);
		$this->session->set_userdata($userdata);
		
		$this->load->view('updateTeamSheet',$data);
	}

	/**
	*	UPDATE TEAM SHEET : Process user input
	*/
	public function updateTeamSheet_2()
	{
		$players=$_SESSION['players'];
		
		foreach ($players as $pl)
		{
			$pid=$pl['player_id'];
			
			if(isset($_POST[$pid]))
			{
				$this->tournament_model->add_tournament_player($pid);
			}
			else
			{
				$this->tournament_model->delete_tournament_player($pid);
			}
		}
		
		unset($_SESSION['team_id'],$_SESSION['players']);
		
		$data['success']=true;	//must be calculated later
		$data['success_message']="Team Sheet updated Successfully";
		$data['fail_message']="Something went wrong. Please try again";
		$this->load->view('status_message',$data);
	}
}