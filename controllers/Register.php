<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','session'));
		$this->load->model(array('register_model'));
		$this->load->helper(array('form', 'url','security'));
		$this->load->database();
		$this->load->model('menu_model');
	}

	function index(){

	
		//$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('username', 'User name', 'trim|required|alpha_dash|min_length[3]|max_length[20]|xss_clean|callback_validateuser');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|min_length[3]|max_length[20]|matches[password]');
		$this->form_validation->set_rules('email', 'Email',  'trim|required|min_length[3]|max_length[30]|valid_email');
		$this->form_validation->set_rules('phone', 'Phone Number',  'trim|regex_match[/^\([0-9]{3}\) [0-9]{3}-[0-9]{4}$/]');

		$current_menu_id=1; // since there is no session, use the configuration default
		$current_item=1; 
		$headerdata=$this->menu_model->buildmenu($current_menu_id,$current_item);		
		if(($this->session->userdata('username')!=""))
		{
			redirect('changemenu/index/1');
		}else if ($this->form_validation->run() == FALSE){
			$data=['roles'=>$this->register_model->roledetails()];
		
			$this->load->view('templates/header',$data);
			$this->load->view('register_view',$data);
			$this->load->view('templates/footer');
		}else if ($this->input->post('btn_login') == "Submit"){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			//$password = do_hash($this->input->post('password'), 'md5'); // MD5
			$email = $this->input->post('email');
			$phone=$this->input->post('phone');
			$comment=$this->input->post('comment');
			$roles=$this->input->post('roles');
	
			$insert_result = $this->register_model->insertuser($username,$password,$email,$phone,$comment,$roles);
			//echo $username;
			//echo $password;
			echo "User $username successfully created";
			//echo $insert_result;
		}


	}

	function validateuser($username)
	{
		$this->form_validation->set_message('validateuser','This user already exist. Please enter different username');
		$usr_result = $this->register_model->get_user($username);
		if($usr_result>0 )
			return false;
		else 
			return true;
	}


}


?>
