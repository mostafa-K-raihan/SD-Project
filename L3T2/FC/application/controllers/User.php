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
		
		if(isset($_SESSION["user_id"]))
		{
			$this->load->model('user_model');
			$this->load->model('tournament_model');
			$this->load->model('match_model');
			$this->load->model('team_model');
			$this->load->model('player_model');
				
	//		$this->load->view('templates/header2');
		}
		else
		{
			redirect('/home', 'refresh');
		}  
     }
	 
	public function index()
	{
		$query=$this->tournament_model->get_active_tournament();
			
		if($query->num_rows()==0)
		{
			$data['success']=false;
			$data['fail_message']="No Tournament Running";
			$this->load->view('status_message',$data);
		}
		else
		{	
			$var=$this->user_model->exist_tournament_user($_SESSION['user_id']);
			
			if($var===0)
			{
				redirect('user/createTeam','refresh');
			}
			else
			{
				redirect('user/view_team','refresh');
			}
			
			
		}
	}
	
	public function view_points()			//baki
	{
		/*
		$data = array(
               'login_error' => false,
			   'registration_success' => false
			);
		*/
			
		$user_team=$this->user_model->get_user_match_team($_SESSION['user_id']);
		if($user_team==NULL)
		{
			$data['success']=false;
			$data['fail_message']="You donot have any previous team";
			$this->load->view('templates/header2');
			$this->load->view('status_message_Before_login',$data);
		}
		else
		{
			//print_r($user_team);
			$data['user_team']=array();
			
			$data['m_point']=$this->user_model->get_user_match_point($_SESSION['user_id']);
			$data['o_point']=$this->user_model->get_user_overall_point($_SESSION['user_id']);
			
			$data['team_name']=$this->user_model->user_team_name($_SESSION['user_id']);
			
			foreach($user_team['team_players'] as $u)
			{
				$info=array();
				$info['player_id']=$u['player_id'];
				
				$result=$this->player_model->get_player_info($info['player_id']);
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
			
				
			//GET MATCH DATA
			$query = $this->match_model->get_previous_match();
			$result=$query->row_array();
			$prev_match_id = $result['match_id'];
			
			$query=$this->match_model->get_match_info($prev_match_id);
			$data['matchData']=$query->row_array();

			$this->load->view('view_points',$data);
		}
	}
	
	public function logout()	//done
	{
		//Stop Session
		$this->session->sess_destroy();
		
		//Redirect To Homepage
		redirect('/home', 'refresh');
	}
	
	
	public function createTeam()		//Load Data for the view
	{
		//if user has already created a team, then he/she must not be allowed to access it again
		$query=$this->tournament_model->get_active_tournament();
			
		if($query->num_rows()==0)
		{
			$data['success']=false;
			$data['fail_message']="No Tournament Running";
			$this->load->view('status_message',$data);
		}
		else
		{	
			$var=$this->user_model->exist_tournament_user($_SESSION['user_id']);
			
			if($var!=0)
			{
				redirect('user/view_team','refresh');
			}
		}
		
		//If user doesn't give any specifications, pass all players data to the view
		//commented out, done dynamically using jQuery
		//else, pass selected players
		/*
		if(isset($_POST['team_id'])) $team['team_id']=$_POST['team_id'];
		else $team['team_id'] ='';
				
		if(isset($_POST['cat'])) $team['player_cat']=$_POST['cat'];
		else $team['player_cat']='';
			
		if(!isset($_SESSION['user_team']))$_SESSION['user_team']=array();
		*/
		
		//get running tournament id
		$team['tournament_id']=$this->tournament_model->get_active_tournament_id();
		
		//get the match id for which transfer(or team creation) is ongoing
		$match=$this->match_model->get_upcoming_match()->row_array();
		$match_id=$match['match_id'];
		
		//if no match_id, then transfer should be disabled
		if($match_id==NULL)
		{
			$data['success']=false;
			$data['fail_message']="Transfer Window is closed <br> Please try again later";
			$this->load->view('status_message',$data);
		}
		else
		{
			//get team list to show in the "select by team" option
			$q=$this->tournament_model->get_active_tournament_teams();
			$data['teams']=$q->result_array();
			
			//get player of the selected team, if team is not selected, get all players
			$data['players']=$this->tournament_model->get_tournament_players($team)->result_array();
			
			//fetch overall points for all players. payers[i] has overall points given by points[i]
			$data['points']=array();
			
			foreach ($data['players'] as $k) {
				$temp=$this->player_model->player_overall_point($k['Player_id']);
				array_push($data['points'], $temp);
			}
			
			//save data in session for successive use
			$_SESSION['players_data']=$data;
			
			//GET MATCH DATA
			$query = $this->match_model->get_next_match();
			$result=$query->row_array();
			$next_match_id = $result['match_id'];
			
			$query=$this->match_model->get_match_info($next_match_id);
			$data['matchData']=$query->row_array();

			//load the view
			$this->load->view('CT',$data);
		}
		
	}
	
	public function test()
	{
		$cur=$this->tournament_model->get_previous_match()->row_array();
		print_r($cur);
		$cur=$this->tournament_model->get_current_phase();
		print_r($cur);
	}
	public function createTeam_check()
	{
		
		// Unescape the string values in the JSON array
		$tableData = stripcslashes($_POST['pTableData']);
		
		// Decode the JSON array
		$tableData = json_decode($tableData,TRUE);

		/*
			CODE NEEDS TO BE ADJUSTED LATER
			-- declare the constants inside another class
		*/
		
		define("NUMBER_OF_PLAYERS",11); //change to 11 later
		define("MAX_TEAM_VALUE",10000);
		define("MAX_FROM_SAME_TEAM",3);
		//echo 'Test';
		//allowed team combinations
		$team_config=array(
			array(
				"wk"=>1,
				"bat"=>5,
				"bowl"=>3,
				"all"=>2
			),
			array(
				"wk"=>1,
				"bat"=>5,
				"bowl"=>4,
				"all"=>1
			),
			array(
				"wk"=>1,
				"bat"=>4,
				"bowl"=>5,
				"all"=>1
			),
			array(
				"wk"=>1,
				"bat"=>4,
				"bowl"=>4,
				"all"=>2
			),
			array(
				"wk"=>1,
				"bat"=>4,
				"bowl"=>3,
				"all"=>3
			),
			array(
				"wk"=>1,
				"bat"=>3,
				"bowl"=>5,
				"all"=>2
			),
			array(
				"wk"=>1,
				"bat"=>3,
				"bowl"=>4,
				"all"=>3
			)
		);
		
		//print_r($team_config);
		
		/*
			#INDEXES
				#PRIMARY INDEX: 0,1,2,...11
					#0-10 : player's data
					#11 : Captain id + Team Name
				#SECONDARY INDEX
					#FOR PRIMARY INDEX 0..10
						#player_name
						#player_cat
						#price
						#team_name
						#points
						#player_id
					#FOR PRIMARY INDEX 11
						#team_name : USER TEAM NAME
						#captain_id : PLAYER ID OF THE CAPTAIN SELECTED BY THE USER
		*/
		
		//CHECK USER TEAM VALUE
		
		$value=0;
		for($i=0;$i<NUMBER_OF_PLAYERS;$i++)
		{
			$value+=substr($tableData[$i]['price'],1);
		}
		
		//1.CHECK TEAM VALUE;
		if($value>MAX_TEAM_VALUE)
		{
			echo 'Your team value can not excede '.MAX_TEAM_VALUE.' . Please try again.';
		}
		else	//2. CHECK COMBINATION
		{
			
			$n_bat=0;
			$n_bowl=0;
			$n_wk=0;
			$n_all=0;
			
			$player_team_names=array();
			$user_team=array();
					
			//GET TEAM COMBO
			for($i=0;$i<NUMBER_OF_PLAYERS;$i++)
			{
				if($tableData[$i]['player_cat']==="BAT")
				{
					$n_bat++;
				}
				else if($tableData[$i]['player_cat']==="BOWL")
				{
					$n_bowl++;
				}
				else if($tableData[$i]['player_cat']==="WK")
				{
					$n_wk++;
				}
				else if($tableData[$i]['player_cat']==="ALL")
				{
					$n_all++;
				}
				
				//GET THE TEAM_NAMES WRT THE PLAYERS
				array_push($player_team_names,$tableData[$i]['team_name']);
				//GET PLAYER_ID 
				array_push($user_team,$tableData[$i]['player_id']);
				
			}
			
			//echo $n_bat.'::'.$n_bowl.'::'.$n_wk.'::'.$n_all;
			
			//CHECK TEAM CONFIGURATION
			$allow_combo=false;
			
			foreach($team_config as $valid)
			{
				if($valid['bat']==$n_bat && $valid['bowl']==$n_bowl && $valid['all']==$n_all && $valid['wk']==$n_wk)
				{
					$allow_combo=true;
					break;
				}
			}
			
			//echo '>>>'.$allow_combo;
			//$allow_combo = true; //delete it
			
			if($allow_combo)
			{
				
				//3. CHECK TEAM DISTRIBUTION
				$freqs = array_count_values($player_team_names);
				$max_same = max($freqs);
				//echo $max_same;
				if($max_same>MAX_FROM_SAME_TEAM)
				{
					//ALERT
					echo 'You can not take more than '.MAX_FROM_SAME_TEAM.' players from the same team. Please try again';
				}
				else
				{
					//OTHER CHECKS IF REQUIRED
					
					$cur_phase=$this->tournament_model->get_current_phase();
					//echo $cur_phase.':P';
					
					if($cur_phase===NULL)
					{
						$cur_phase=$this->tournament_model->get_upcoming_phase();
						//echo $cur_phase.':P';
						if($cur_phase===NULL)
						{
							//SEVERE ERROR
							die();
						}
					}
					
					//echo $cur_phase;
					
					//DO DATABASE OPERATIONS
					//IF, SOMEHOW, THERE IS AN EXISTING TEAM, THEN REDIRECT
					$var=$this->user_model->exist_tournament_user($_SESSION['user_id']);
			
					if($var!=0)
					{
						redirect('user/view_team','refresh');
					}
					else if($var==0)
					{
						//PROCEDE NORMALLY
						$user_id=$_SESSION['user_id'];
						
						$match=$this->match_model->get_upcoming_match()->row_array();
						$match_id=$match['match_id'];
						
						$captain_id=$tableData[NUMBER_OF_PLAYERS]['captain_id'];
						$team_name = $tableData[NUMBER_OF_PLAYERS]['team_name'];
						
						//print_r($user_team);
						
						$val=$this->user_model->create_user_match_team($user_id, $match_id,$captain_id,$user_team,$team_name);
						
						//INITIALIZE FREE TRANSFER DATA
						$this->user_model->create_user_phase_transfer_from_user($user_id, $cur_phase);
						
						//UNSET USER TEAM SESSION
						unset($_SESSION['players_data']);
						
						
						//LOAD SUCCESS MESSAGE
						echo 'Your Team has been created successfully!';
						
					}
				}
			}
			else
			{
				//ALERT
				echo 'Please check the rules and scoring system and find a valid combo for your team.';
			}
		}
		
	}
	
	public function createTeam_proc()	//CONFIRMATION
	{
		$data['success']=true;
		$data['success_message']="Team Successfully Created";
		$this->load->view('status_message',$data);
	}
	
	public function view_team()			//CHECK LATER
	{
		$data = array(
               'login_error' => false,
			   'registration_success' => false
			);
			
		$user_team=$this->user_model->get_current_user_match_team($_SESSION['user_id']);
		
		//print_r($user_team);
		//if current match is not found, then transfer window is closed. 
		//Just Show the old team, because it will be replicated after the transfer window re-opens
		if($user_team===NULL)
		{
			$user_team=$this->user_model->get_user_match_team($_SESSION['user_id']);
		}
		//Now, the user should have a team. Otherwise, he would be redirected to createTeam (#to be done)
		//So, it is safe to assume that user_team is not null

		//still we are checking this for safety
		if($user_team===NULL)
		{
			$data['success']=false;
			$data['fail_message']="You do not have a team registered for the tournament.";
			$this->load->view('status_message',$data);
		}
		else
		{
			
			$data['user_team']=array();
			
			//Shows player's point for the previous match. No need to show it here
			//$data['m_point']=$this->user_model->get_user_match_point($_SESSION['user_id']);		//Needs To Be Deleted From this and view
			
			//Data for overall points of each player
			$data['o_point']=$this->user_model->get_user_overall_point($_SESSION['user_id']);
			
			//Data for team name of user
			$data['team_name']=$this->user_model->user_team_name($_SESSION['user_id']);
			
			foreach($user_team['team_players'] as $u)
			{
				$info=array();
				$info['player_id']=$u['player_id'];
				
				$result=$this->player_model->get_player_info($info['player_id']);
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
			
			//GET MATCH DATA
			//match maynot need to be initialized
			$query = $this->match_model->get_next_match();
			$result=$query->row_array();
			$next_match_id = $result['match_id'];
			
			$query=$this->match_model->get_match_info($next_match_id);
			$data['matchData']=$query->row_array();
			$this->load->view('user_home',$data);			//View Needs Modification
		}
	}
	
	public function changeTeam()		//Load Data
	{
		$user_id=$_SESSION['user_id'];
		
		$query_result=$this->tournament_model->get_active_tournament_id();
		if($query_result===NULL)
		{
			$data['success']=false;
			$data['fail_message']="No tournament is running at this moment.";
			$this->load->view('status_message',$data);
		}
		else
		{
			//if a user doesn't have any team, he should create a team
			//commented for testing. uncomment later
			
			$var=$this->user_model->exist_tournament_user($_SESSION['user_id']);
			
			if($var==0)
			{
				redirect('user/createTeam','refresh');
			}
			
			$search_key['tournament_id']=$query_result;
			//get the match id for which transfer(or team creation) is ongoing
			$match=$this->match_model->get_upcoming_match()->row_array();
			$match_id=$match['match_id'];
			
			//if no match_id, then transfer should be disabled
			if($match_id==NULL)
			{
				$data['success']=false;
				$data['fail_message']="Transfer Window is closed <br> Please try again later";
				$this->load->view('status_message',$data);
			}
			else
			{
				//get team list to show in the "select by team" option
				$q=$this->tournament_model->get_active_tournament_teams();
				$data['teams']=$q->result_array();
				
				//get player of the selected team, if team is not selected, get all players
				$data['players']=$this->tournament_model->get_tournament_players($search_key)->result_array();
				
				//fetch overall points for all players. payers[i] has overall points given by points[i]
				$data['points']=array();
				
				foreach ($data['players'] as $k) {
					$temp=$this->player_model->player_overall_point($k['Player_id']);
					array_push($data['points'], $temp);
				}
				
				//save data in session for successive use
				$_SESSION['players_data']=$data;
				
				//Now load data for user's current team on the left side view
				$u_team=$this->user_model->get_current_user_match_team($user_id);
				//print_r($u_team);
				
				$cap=$u_team['captain'];
				$data['user_team']=array();
				$temp_team=$u_team['team_players'];
				
				$data['team_status']['value']=0;
				$data['team_status']['bat']=0;
				$data['team_status']['bowl']=0;
				$data['team_status']['all']=0;
				$data['team_status']['wk']=0;
				$data['captain_id']=$cap;
				
				foreach($temp_team as $p)
				{
					$pl_id=$p['player_id'];
						
					$inf=$this->player_model->get_player_info($pl_id);
					
					$pl_name=$inf['name'];
					$pl_cat=$inf['player_cat'];
					$pl_price=$inf['price'];
					
					$data['team_status']['value']+=$pl_price;
					if($pl_cat==="BAT")
					{
						$data['team_status']['bat']++;
					}
					else if($pl_cat==="BOWL")
					{
						$data['team_status']['bowl']++;
					}
					else if($pl_cat==="ALL")
					{
						$data['team_status']['all']++;
					}
					else if($pl_cat==="WK")
					{
						$data['team_status']['wk']++;
					}
					
					$pl_ov_points=$this->player_model->player_overall_point($pl_id);
					$pl_team=$inf['team_name'];
						
					$newPlayer=array('player_id'=>$pl_id,'player_name'=>$pl_name,
							'player_cat'=>$pl_cat,'price'=>$pl_price,
							'total_points'=>$pl_ov_points,'team_name'=>$pl_team);
								
					array_push($data['user_team'],$newPlayer);
				}
				
				$len=0;
				foreach($data['players'] as $p)
				{
					$len++;
				}
				
				for($index=0;$index<$len;$index++)
				{
					$val=false;
					foreach($data['user_team'] as $u)
					{
						if($data['players'][$index]['Player_id']==$u['player_id'])
						{
							$val=true;
							break;
						}
					}
					
					if($val==true)
					{
						$data['players'][$index]['Button_status']='false';
					}
				}
				
				//GET NUMBER OF REMAINING FREE TRANSFERS
				$data['free_transfers']=$this->user_model->get_remaining_transfers($user_id);
				$data['team_name']=$this->user_model->user_team_name($user_id);

				//GET MATCH DATA
				//match need to be initialized
				$query = $this->match_model->get_upcoming_match();
				$result=$query->row_array();
				$next_match_id = $result['match_id'];
				
				$query=$this->match_model->get_match_info($next_match_id);
				$data['matchData']=$query->row_array();
				
				//load the view
				$this->load->view('changeTeam',$data);
				
			}
		}	
	}
	public function changeTeam_check()
	{
		// Unescape the string values in the JSON array
		$tableData = stripcslashes($_POST['pTableData']);
		
		// Decode the JSON array
		$tableData = json_decode($tableData,TRUE);
		
		//print_r($tableData);
		define("NUMBER_OF_PLAYERS",11); //change to 11 later
		define("MAX_TEAM_VALUE",10000);
		define("MAX_FROM_SAME_TEAM",3);
		
		//allowed team combinations
		$team_config=array(
			array(
				"wk"=>1,
				"bat"=>5,
				"bowl"=>3,
				"all"=>2
			),
			array(
				"wk"=>1,
				"bat"=>5,
				"bowl"=>4,
				"all"=>1
			),
			array(
				"wk"=>1,
				"bat"=>4,
				"bowl"=>5,
				"all"=>1
			),
			array(
				"wk"=>1,
				"bat"=>4,
				"bowl"=>4,
				"all"=>2
			),
			array(
				"wk"=>1,
				"bat"=>4,
				"bowl"=>3,
				"all"=>3
			),
			array(
				"wk"=>1,
				"bat"=>3,
				"bowl"=>5,
				"all"=>2
			),
			array(
				"wk"=>1,
				"bat"=>3,
				"bowl"=>4,
				"all"=>3
			)
		);
		
		//calculate user team value
		$value=0;
		for($i=0;$i<NUMBER_OF_PLAYERS;$i++)
		{
			$value+=substr($tableData[$i]['price'],1);
		}
		
		//Condition 1.1 : Team VAlue Check
		if($value>MAX_TEAM_VALUE)
		{
			echo 'Your team value can not excede '.MAX_TEAM_VALUE.' . Please try again.';
		}
		else
		{
			$n_bat=0;
			$n_bowl=0;
			$n_wk=0;
			$n_all=0;
			
			$player_team_names=array();
			$user_team=array();
					
			//GET TEAM COMBO
			for($i=0;$i<NUMBER_OF_PLAYERS;$i++)
			{
				if($tableData[$i]['player_cat']==="BAT")
				{
					$n_bat++;
				}
				else if($tableData[$i]['player_cat']==="BOWL")
				{
					$n_bowl++;
				}
				else if($tableData[$i]['player_cat']==="WK")
				{
					$n_wk++;
				}
				else if($tableData[$i]['player_cat']==="ALL")
				{
					$n_all++;
				}
				
				//GET THE TEAM_NAMES WRT THE PLAYERS
				array_push($player_team_names,$tableData[$i]['team_name']);
				//GET PLAYER_ID 
				array_push($user_team,$tableData[$i]['player_id']);
				
			}
			
			
			
			$allow_combo=false;
			
			foreach($team_config as $valid)
			{
				if($valid['bat']==$n_bat && $valid['bowl']==$n_bowl && $valid['all']==$n_all && $valid['wk']==$n_wk)
				{
					$allow_combo=true;
					break;
				}
			}
			
			//CONDITION 1.2:: CHECK TEAM COMBINATION
			if($allow_combo)
			{
				$freqs = array_count_values($player_team_names);
				$max_same = max($freqs);
				//Condition 1.3:: MAX PLAYERS FROM THE SAME TEAM
				if($max_same>MAX_FROM_SAME_TEAM)
				{
					//ALERT
					echo 'You can not take more than '.MAX_FROM_SAME_TEAM.' players from the same team. Please try again';
				}
				else
				{
					$user_id = $_SESSION['user_id'];
					
					$ft=$this->user_model->get_remaining_transfers($_SESSION['user_id']);
					//echo $ft;
					
					$used_transfer=$this->user_model->get_used_transfers($user_id,$user_team);
					
					//Condition 2.1: No Transfer (Same Team Selected Again) -> only captain can be changed
					if($used_transfer==0)
					{
						$user_id=$_SESSION['user_id'];
					
						$match=$this->match_model->get_upcoming_match()->row_array();
						$match_id=$match['match_id'];
					
						$new_captain_id=$tableData[11]['captain_id'];
						
						$this->user_model->change_captain($user_id,$match_id,$new_captain_id);
						echo 'Your Team has been changed successfully!';
					}
					else
					{
						//Condition 2.2 : Transfer Limit Exceded
						if($ft!=='UNLIMITED' and $used_transfer>$ft)
						{
							//ERROR :: TRANSFER LIMIT EXCEDED. DISALLOW USER
							echo 'Transfer Limit Exceded';
						}
						else
						{
							$data['transfer_outs']=$this->user_model->get_transfer_outs($user_id,$user_team);
							$data['transfer_ins']=$this->user_model->get_transfer_ins($user_id,$user_team);
							
							$_SESSION['transfer_outs']=$data['transfer_outs'];
							$_SESSION['transfer_ins']=$data['transfer_ins'];
							$_SESSION['used_transfer']=$used_transfer;
							$_SESSION['new_captain_id']=$tableData[11]['captain_id'];
							$_SESSION['free_transfers']=$ft;
							
							echo 'CONFIRM TRANSFER';
						}
					}
		
				}
			}
			else
			{
				//ALERT
				echo 'Please check the rules and scoring system and find a valid combo for your team.';
			}
			
		}
	}
	
	public function changeTeam_confirm()
	{
		$data['transfer_outs']=$_SESSION['transfer_outs'];
		$data['transfer_ins']=$_SESSION['transfer_ins'];
		
		$data['used_transfer']=$_SESSION['used_transfer'];
		$data['free_transfers']=$_SESSION['free_transfers'];
		
		//BETTER IF THE VIEW IS REPLACED BY A POP-UP
		$this->load->view('confirm_transfer',$data);
	}
	
	public function changeTeam_proc()
	{
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
		
		//#REPLACE TEAM IN DATABASE AND ALSO UPDATE FREE TRANSFER COUNT
		$this->user_model->replace_team_players($user_match_team_id,$ins,$outs);
		
		unset(
			$_SESSION['transfer_outs'],
			$_SESSION['transfer_ins'],
			$_SESSION['used_transfer'],
			$_SESSION['new_captain_id']
		);
		
		$data=array(
			'success'=>true,
			'success_message'=>"Your transfers have been saved."
		);
		$this->load->view('status_message',$data);
	}
	
	public function topPlayers()				//done
	{
		$current_t=$this->tournament_model->get_active_tournament_id();
		if($current_t==NULL)
		{
			$data['success']=false;
			$data['fail_message']="No Player Record Found";
			$this->load->view('status_message',$data);
		}
		else
		{
			$data['top']=$this->player_model->top_players();
			$data['topUsers']=$this->user_model->top_users();
			
			$this->load->view('top_players',$data);
		}

	}
	
	public function schedules()				//done
	{
		$query= $this->tournament_model->get_fixture();		
		
		if($query->num_rows()==0)
		{
			//echo "No Fixture Available for this tournament";	//Load No Fixture View
			$data=array(
				'success'=>false,
				'failure_message'=>"No Fixture Available for this tournament"
			);
			$this->load->view('status_message',$data);
		}
		else
		{
			$data['fixture']=$query->result_array();
		
			$this->load->view('schedule',$data);
		}
	}
	
	public function results()		//DONE
	{
		$query= $this->tournament_model->get_result();		
		
		if($query->num_rows()==0)
		{
			
			$data=array(
				'success'=>false,
				'fail_message'=>"No Result Available for this tournament"
			);
			//ektu jhamela ase
			$this->load->view('templates/header2');
			$this->load->view('status_message_Before_login',$data);
		}
		else
		{
			$data['result']=$query->result_array();
			$this->load->view('results',$data);
		}
	}
	
	/**
		<Implement>
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

	public function pointTable()	
	{
		//comment this after implementation
		$data=array(
				'success'=>true,
				'success_message'=>"Point Table will be added very soon"
			);
		$this->load->view('status_message',$data);
		
		/*
		<Implement>
		$this->load->view('point_table',$data);
		*/
	}
	
	public function howToPlay()		
	{
		// <Implement>
		//	Just adjust the view
		$this->load->view('how_to_play');
	}
		
}