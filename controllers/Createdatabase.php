<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class createdatabase extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          //$this->load->database();
          $this->load->library('form_validation');
          //load the login model
          $this->load->model('createdatabase_model');
          $this->load->model('menu_model');
          $this->load->database();
	}

     public function index()
     {   	
     	$status['smsg']='';
     	$status['error']='';
		
     	$this->form_validation->set_rules("databasetype", "databasetype", "trim|required");
     	$this->form_validation->set_rules("hostname", "hostname", "trim");
     	$this->form_validation->set_rules("account", "account", "trim|required");
     	$this->form_validation->set_rules("password", "password", "trim|required");
     	$this->form_validation->set_rules("dbname", "databasename", "trim");
		$this->form_validation->set_rules("tns", "tns", "trim");
     	$this->form_validation->set_value("port", "port", "trim|regex_match[/^[0-9]$/]");
		if ($this->session->userdata('username')=='') redirect('login');
     	$headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
     	$this->load->view('templates/header',$headerdata);
		if ($this->form_validation->run() == FALSE)
     	{
     		$this->load->view('createdatabase_view',$status);
     	} else if ($this->input->post('btn_validate') == "Validate") 
		{
     		//echo 'clicked on validate';
     		$dsn ="";
     		if($this->input->post("databasetype")=="mysql")
     		{
     			$dbdriver='mysqli://';
     			$dsn = 'mysqli://'.$this->input->post("account").':'.$this->input->post("password").'@'.$this->input->post("hostname").'/'.$this->input->post("dbname");
     				
     		} else if($this->input->post("databasetype")=="oracle")
			{
				$config['hostname'] = $this->input->post("tns");
				$config['username'] = $this->input->post("account");
				$config['password'] = $this->input->post("password");
				$config['database'] = $this->input->post("dbname");
				$config['dbdriver'] = "oci8";

			    $testconn=$this->load->database($config,TRUE);
				if ($testconn->error()) {
					$error=$testconn->error();
					if ($error['code']) {
						$status['error']= $error['code'].'-'.$error['message'];
					}
				} else {
					$status['smsg']='Database test connection is successfull';
				}
			 }
			 $this->load->view('createdatabase_view',$status);
     	}
     	else if ($this->input->post('btn_save') == "Save")
     	{
     		//echo 'submitting form';
     	    $this->createdatabase_model->insertdetails($this->input->post("dbname"),$this->input->post("databasetype"),$this->input->post("tns"),'dev',$this->input->post("hostname"),$this->input->post("account"),$this->input->post("password"),$this->input->post("description"));
			$this->load->view('createdatabase_view',$status);	 	
		}
		$this->load->view('templates/footer');
	 }
}