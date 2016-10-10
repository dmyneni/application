<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class addaction extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('menu_model');
	
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the login model
		$this->load->model('addaction_model');
	
	}
	public function index()
	{
		if ($this->uri->segment(3)) {	
			$query_id=$this->uri->segment(3);	
			$this->session->set_userdata(['query_id'=>$query_id]);
		}
		$query_id=$this->session->userdata('query_id');
		
		$this->session->set_flashdata('status', '<span class="text-success"></span>');
		if ($this->form_validation->run() == FALSE)
		{
			$headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
			$this->load->view('templates/header',$headerdata);
			$dataset=['column_details'=>$this->addaction_model->get_columns($query_id)];
			$this->load->view('addactions_view',$dataset);
				
		}
			if ($this->input->post('btn_save') == "Create")
               {
               	//echo $this->input->post('btn_login');
               	$column_id=$this->input->post("columnid");
               	$condition=$this->input->post("sel_condition");
               	$value=$this->input->post("txt_value");
               	$fgcolor=$this->input->post("txt_fgcolor");
               	$bgcolor=$this->input->post("txt_bgcolor");
               	$description=$this->input->post("txt_description");
               	$comparison_type=$this->input->post("sel_comparision");
               	//echo $condition.'  '.$value.'  '.$column_id.' '.$fgcolor;
               	$this->addaction_model->insert_actions($column_id,$condition,$value,$fgcolor,$bgcolor,$description,$comparison_type);
               	//$dataset=['column_details'=>$this->addaction_model->get_columns(59)];
               	$this->form_validation->set_value("status","Successfully created");
               	//$this->load->view('addactions_view',$dataset);
               }
	}
}