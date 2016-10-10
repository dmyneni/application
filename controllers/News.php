<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news extends CI_Controller
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
		
		$this->form_validation->set_rules('headline', 'headline', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('category', 'category',  'trim|required');
		$this->form_validation->set_rules('details', 'details',  'trim|required');
		$user_id=$this->session->userdata('user_id');
		if ($this->session->userdata('username')=='') redirect('login');
		$data=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
		if ($this->input->post('btn_login') == "Submit"){
		
			$headline = $this->input->post('headline');
			$category = $this->input->post('category');
			$details=$this->input->post('details');
			$sdate=$this->input->post('sdate');
			$edate=$this->input->post('edate');
			$update_result = $this->news_model->addnews($headline,$category,$details,$sdate,$edate,$user_id,$this->menu_model->getTimeStamp());
			$this->session->set_flashdata('status', '<span class="text-success">Successfully Created</span>');
			$this->load->view('news_view');
		}else{
		$this->load->view('news_view',$data);
		}	
		$this->load->view('templates/footer');
	}
}