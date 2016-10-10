<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class editprofile extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		$this->load->model('editprofile_model');
		$this->load->model('menu_model');
		
	}

	function index()
	{
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|min_length[3]|max_length[20]|matches[password]');
		$this->form_validation->set_rules('email', 'Email',  'trim|required|min_length[3]|max_length[30]|valid_email');
		$this->form_validation->set_rules('phone', 'Phone',  'trim|regex_match[/^[0-9]{10}$/]');
		
		$user_id=$this->session->userdata('user_id');
		if ($this->session->userdata('username')=='') redirect('login');
		$roles=$this->session->userdata('roles');
		$rolelist='';
		foreach ($roles as $row)
		{
			$rolelist=$rolelist.",".$row['role_id'];
		}
		$profile=array('sroles'=>$this->editprofile_model->roledetails(),
				'menu'=>$this->editprofile_model->getmenunames(),
				'dbname'=>$this->editprofile_model->getdbnames(),
				'profile'=>$this->editprofile_model->get_profile($user_id),
				'rolelist'=>$rolelist
		);
		$headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
		if ($this->input->post('btn_login') == "Submit"){
		
			$password = $this->input->post('password');
			$email = $this->input->post('email');
			$phone=$this->input->post('phone');
			$comment=$this->input->post('comment');
			$nroles=$this->input->post('roles');
		    $menuname=$this->input->post('menuname');
		    $account_id=$this->input->post('dbname');
			$update_result = $this->editprofile_model->update_profile($user_id,$password,$email,$phone,$nroles,$rolelist,$menuname,$account_id);
			$this->load->view('templates/header',$data);
			$this->session->set_userdata('default_menu_id',$menuname);
			$this->session->set_userdata('default_account_id',$account_id);
			redirect("changemenu/index/".$this->session->userdata('default_menu_id'));
		}else{
			$this->load->view('templates/header',$headerdata);
			$this->load->view('editprofile_view',$profile);
			$this->load->view('templates/footer');
		}	
	}
}