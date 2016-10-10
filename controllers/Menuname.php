<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menuname extends CI_Controller
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
		$this->load->model('menuname_model');
		$this->load->model('menu_model');
		
	}

	function index()
	{
		
		$this->form_validation->set_rules('menuname', 'Menuname', 'trim|required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('roles', 'Roles',  'trim|required');
		$this->form_validation->set_rules('menutype', 'menutype',  'trim|required');
		//$datestring = '%Y-%m-%d %H:%i:%s';
		//$time = now("America/Chicago");
		//echo now("America/Chicago")."</br>";
		//echo mdate($datestring, $time);
		
		$user_id=$this->session->userdata('user_id');
		if ($this->session->userdata('username')=='') redirect('login');
		$profile=array('sroles'=>$this->menuname_model->roledetails());
		$headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
		if ($this->input->post('btn_login') == "Submit"){
		
			$menuname = $this->input->post('menuname');
			$role = $this->input->post('roles');
			$menutype=$this->input->post('menutype');
			$comment=$this->input->post('comment');
			$update_result = $this->menuname_model->addmenuname($menuname,$role,$menutype,$comment,$user_id,$this->menu_model->getTimeStamp());
			$this->load->view('templates/header',$data);
			$this->session->set_userdata('default_menu_id',$menuname);
			$this->session->set_userdata('default_account_id',$dbname);
			redirect("newmenu/index/".$this->session->userdata('default_menu_id'));
			//echo "User $username successfully created";
			//echo $insert_result;
		}else{
		$this->load->view('templates/header',$headerdata);
		$this->load->view('menuname_view',$profile);
		$this->load->view('templates/footer');
		}	
	}
}