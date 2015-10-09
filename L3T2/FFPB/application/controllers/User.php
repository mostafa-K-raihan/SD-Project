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
	
	public function changeTeam()		//Load Data
	{
		$user_id=$_SESSION['user_id'];
		
		//SET SEARCH SETTINGS
		$search_key['tournament_id']=$this->tournament_model->get_active_tournament_id();
		
		if(isset($_POST['team_id'])) $search_key['team_id']=$_POST['team_id'];
		else $search_key['team_id'] ='';
				
		if(isset($_POST['cat'])) $search_key['player_cat']=$_POST['cat'];
		else $search_key['player_cat']='';
		
		$match=$this->match_model->get_upcoming_match()->row_array();
		$match_id=$match['match_id'];
		
		if($match_id==NULL)
		{
			echo 'Transfer Window is closed';
			echo '<br>';
			echo 'Please try again later';
			die();
		}
		else
		{
			$u_team=$this->user_model->get_current_user_match_team($user_id);
			$cap=$u_team['captain'];
			
			//SET USER TEAM INTO SESSION
			if(!isset($_SESSION['user_team']))
			{
				
				$_SESSION['user_team']=array();
				$temp_team=$u_team['team_players'];
				
				foreach($temp_team as $p)
				{
					$pl_id=$p['player_id'];
					
					$inf=$this->player_model->get_player_info($pl_id);
					
					$pl_name=$inf['name'];
					$pl_cat=$inf['player_cat'];
					$pl_price=$inf['price'];
					$pl_ov_points=$this->player_model->player_overall_point($pl_id);
					
					$newPlayer=array('player_id'=>$pl_id,'player_name'=>$pl_name,
							'player_cat'=>$pl_cat,'price'=>$pl_price,
							'total_points'=>$pl_ov_points);
							
					array_push($_SESSION['user_team'],$newPlayer);
				}
			}
		
			//GET NUMBER OF FREE TRANSFERS
			$data['free_transfers']=$this->user_model->get_remaining_transfers($user_id);
			
			$q=$this->tournament_model->get_active_tournament_teams();
			$data['teams']=$q->result_array();

			$data['players']=$this->tournament_model->get_tournament_players($search_key)->result_array();

			$data['points']=array();
			$data['captain']=$cap;
			
			foreach ($data['players'] as $k) {
				$temp=$this->player_model->player_overall_point($k['Player_id']);
				array_push($data['points'], $temp);
			}
			
			//print_r($data);
		}
		
		$_SESSION['players_data']=$data;		//SAVE SEARCH RESULT IN SESSION FOR TEMPORARY USE
		
		redirect('user/changeTeam_1','refresh');	
	}
	
	public function changeTeam_1()		//Load View
	{
		if(isset($_SESSION['players_data']))
		{
			$data=$_SESSION['players_data'];
		}
		else
		{
			echo 'Sorry! Something went wrong. <br/> Please Try Later';
		}
		$this->load->view('changeTeam',$data);
	}
	
	public function add_transfered_player()		//RUNNING
	{
		$newPlayer=array('player_id'=>$this->input->post('player_id'),'player_name'=>$this->input->post('name'),
		'player_cat'=>$this->input->post('cat'),'price'=>$this->input->post('price'),'total_points'=>$this->input->post('points'));
		
		$key = array_search($newPlayer, $_SESSION['user_team']); 
		
		if($key===FALSE) array_push($_SESSION['user_team'],$newPlayer);
		
		redirect('user/changeTeam_1','refresh');
	}
	
	public function remove_transfered_player()	//RUNNING
	{
		$newPlayer=array('player_id'=>$this->input->post('player_id'),'player_name'=>$this->input->post('name'),
		'player_cat'=>$this->input->post('cat'),'price'=>$this->input->post('price'),'total_points'=>$this->input->post('points'));
		
		$key = array_search($newPlayer, $_SESSION['user_team']); 
		unset($_SESSION['user_team'][$key]);
		
		redirect('user/changeTeam_1','refresh');
	}
	
	public function changeTeam_check()
	{
		//APPLY ALL CONDITIONS AS createTEAM_proc
		$user_id=$_SESSION['user_id'];
		$user_team=$_SESSION['user_team'];
		$user_team_players=array();
		
		$_SESSION['new_captain_id']=$_POST['captain'];
		
		
		
		//Calculate Keys for Condition Check
		$count=0;
		$value=0;
		foreach($user_team as $u)
		{
			$count++;
			$value+=$u['price'];
			
			array_push($user_team_players,$u['player_id']);
			
		}
		
		$ft=$this->user_model->get_remaining_transfers($user_id);
		
		$used_transfer=$this->user_model->get_used_transfers($user_id,$user_team_players);
		
		//Checks
		
		//Condition 0: No Transfer (Same Team Selected Again) -> only captain can be changed
		if($used_transfer==0)
		{
			//SHOW POP-UP MESSAGE
			
			$user_id=$_SESSION['user_id'];
		
			$match=$this->match_model->get_upcoming_match()->row_array();
			$match_id=$match['match_id'];
		
			$new_captain_id=$_SESSION['new_captain_id'];
			$this->user_model->change_captain($user_id,$match_id,$new_captain_id);
			
			redirect('user','refresh');
		}
		
		//Condition 1: Team must contain 11 players
		if($count!=11)
		{
			//SHOW ERROR POP-UP
			echo '11 Players Needed';
			
			//RELOAD PAGE
			redirect('user/changeTeam','refresh');
		}
		
		
		//Condition 2: Team Value must be <=10K
		if($value>10000)
		{
			//SHOW ERROR POP-UP
			echo 'Team Value Exceded';
			
			//RELOAD PAGE
			redirect('user/createTeam','refresh');
		}
		
		//ADD MORE CONDITIONS ...
		
		//Condition 3: CHECK MAXIMUM PLAYERS TAKEN FROM A TEAM
		
		//Condition 4: CHECK TEAM WIDTH (NUMBER OF BATSMAN, BOWLERS, WICKET KEEPERS AND ALL-ROUNDERS)
		
		//Condition 5: CHECK FREE TRANSFER LIMIT
		if($ft!='UNLIMITED' and $used_transfer>$ft)
		{
			//SHOW ERROR POP-UP
			echo 'Transfer Limit Exceded';
			
			//RELOAD PAGE
			redirect('user/createTeam','refresh');
		}
		
		//Everything Is OK
		
		//Show Transfer Ins and Transfer Outs
		$data['transfer_outs']=$this->user_model->get_transfer_outs($user_id,$user_team_players);
		$data['transfer_ins']=$this->user_model->get_transfer_ins($user_id,$user_team_players);
		
		$_SESSION['transfer_outs']=$data['transfer_outs'];
		$_SESSION['transfer_ins']=$data['transfer_ins'];
		
		$data['used_transfers']=$used_transfer;
		
		//BETTER IF THE VIEW IS REPLACED BY A POP-UP
		$this->load->view('confirm_transfer',$data);
	}
	
	public function changeTeam_proc()
	{
		/*NEED TESTING*/
		
		$user_id=$_SESSION['user_id'];
		
		$match=$this->match_model->get_upcoming_match()->row_array();
		$match_id=$match['match_id'];
		
		$new_captain_id=$_SESSION['new_captain_id'];
		
		$user_match_team_id=$this->user_model->get_user_match_team_id($user_id,$match_id);
		
		//#01 : Change Captain
		$this->user_model->change_captain($user_id,$match_id,$new_captain_id);
		
		//#02 : Replace Transferred Players
		$ins=$_SESSION['transfer_ins'];
		$outs=$_SESSION['transfer_outs'];
		
		
		$this->user_model->replace_team_players($user_match_team_id,$ins,$outs);
		
		//#03 : UNSET USER TEAM SESSION
		unset($_SESSION['user_team']);
		unset($_SESSION['players_data']);
		unset($_SESSION['transfer_outs']);
		unset($_SESSION['transfer_ins']);
		unset($_SESSION['new_captain_id']);
		
		//#04 : POP-UP MESSAGE
		echo 'Your Team Is Successfully Changed';
		
		//redirect('user','refresh');
		
	}
	
	
	public function createTeam()		//Load Data
	{
		$this->load->view('createTeam');
	}
	
	public function createTeam_proc()		//RUNNING
	{
		echo 'Team Successfully Created';
	}
	
	public function view_team()			//done
	{
		$data = array(
               'login_error' => false,
			   'registration_success' => false
			);
			
		$user_team=$this->user_model->get_current_user_match_team($_SESSION['user_id']);
		
		//if current match is not found, then transfer window is closed. 
		//Just Show the old team, because it will be replicated after the transfer window re-opens
		if($user_team==NULL)
		{
			$user_team=$this->user_model->get_user_match_team($_SESSION['user_id']);
		}
			
		$data['user_team']=array();
			
		$data['m_point']=$this->user_model->get_user_match_point($_SESSION['user_id']);		//Needs To Be Deleted From this and view
		$data['o_point']=$this->user_model->get_user_overall_point($_SESSION['user_id']);
			
		$data['team_name']=$this->user_model->user_team_name($_SESSION['user_id']);
		//echo '<br>';
			
			foreach($user_team['team_players'] as $u)
			{
				$info=array();
				$info['player_id']=$u['player_id'];
				//echo '<br>';
				$result=$this->player_model->get_player_info($info['player_id']);
				//print_r($result);
				$info['name']=$result['name'];
				$tmp=$this->team_model->get_team_name($result['team_id']);
				$info['team_name']=$tmp;
				$info['player_cat']=$result['player_cat'];
				$tmp=$this->player_model->player_overall_point($info['player_id']);
				$info['point']=$tmp;
				
				array_push($data['user_team'],$info);
			}
			$data['captain_id']=$user_team['captain'];
			$result=$this->player_model->get_player_info($data['captain_id']);
			$data['captain_name']=$result['name'];
			
			$this->load->view('user_home',$data);			//View Needs Modification
		
	}
	
	public function view_points()			//done
	{
		$data = array(
               'login_error' => false,
			   'registration_success' => false
			);
			
		$user_team=$this->user_model->get_user_match_team($_SESSION['user_id']);
		if($user_team==NULL)
		{
			echo 'No Previous Team';
		}
		else
		{
			//print_r($user_team);
			$data['user_team']=array();
			
			$data['m_point']=$this->user_model->get_user_match_point($_SESSION['user_id']);
			$data['o_point']=$this->user_model->get_user_overall_point($_SESSION['user_id']);
			
			$data['team_name']=$this->user_model->user_team_name($_SESSION['user_id']);
			//echo '<br>';
			
			foreach($user_team['team_players'] as $u)
			{
				$info=array();
				$info['player_id']=$u['player_id'];
				//echo '<br>';
				$result=$this->player_model->get_player_info($info['player_id']);
				//print_r($result);
				$info['name']=$result['name'];
				$tmp=$this->team_model->get_team_name($result['team_id']);
				$info['team_name']=$tmp;
				$info['player_cat']=$result['player_cat'];
				$tmp=$this->player_model->get_player_last_match_point($info['player_id']);
				$info['point']=$tmp;
				
				array_push($data['user_team'],$info);
			}
			$data['captain_id']=$user_team['captain'];
			$result=$this->player_model->get_player_info($data['captain_id']);
			$data['captain_name']=$result['name'];
			
			$this->load->view('view_points',$data);
		}
	}
	
	
	public function topPlayers()				//done
	{
		$current_t=$this->tournament_model->get_active_tournament_id();
		if($current_t==NULL)
		{
			echo 'No Player Record Found';
		}
		else
		{
			$data['top']=$this->player_model->top_players();
			$this->load->view('top_players',$data);
		}

	}
	
	public function schedules()				//done
	{
		$query= $this->tournament_model->get_fixture();		
		
		if($query->num_rows()==0)
		{
			echo "No Fixture Available for this tournament";	//Load No Fixture View
		}
		$data['fixture']=$query->result_array();
		
		$this->load->view('schedule',$data);
	}
	
	public function results()		//LATER
	{
		$query= $this->tournament_model->get_result();		
		
		if($query->num_rows()==0)
		{
			echo "No Result Found for this tournament";	//Load No Fixture View
		}
		$data['result']=$query->result_array();

		$this->load->view('results',$data);
	}
	
	/**
		UNPROCESSED
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