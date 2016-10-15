<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class newspresentation extends CI_Controller
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
		$this->load->model('news_model');
		$this->load->model('menu_model');
		
	}

	function index()
	{
		
		$user_id=$this->session->userdata('user_id');
		if ($this->session->userdata('username')=='') redirect('login');
	   $data = ['news' =>$this->news_model->getnews()];
		$this->load->view('newspresentation_view',$data);

	}
}