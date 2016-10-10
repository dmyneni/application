<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class explain extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
		  $this->load->helper(array('html','url'));
          $this->load->database();
          $this->load->model('explain_model');
		  $this->load->model('scripts_model');
		  $this->load->helper('form');
		  $this->load->model('menu_model');
	}

     public function index()
     {
		 $user_id=$this->session->userdata('user_id');
		$username=$this->session->userdata('username');
		if ($this->session->userdata('username')=='') redirect('login');
        $headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
		$this->load->view('templates/header',$headerdata);
		$this->session->unset_userdata('query_id');

		if ($this->uri->segment(3)) {			
			$query_id = $this->uri->segment(3);
		}
		$data=$this->scripts_model->get_query($query_id);
		if ($data==0) {
			$errmsg=array('errmsg'=>"Couldn't find script ID $query_id");
			$this->load->view('errors_view',$errmsg);
		} else {
			$this->load->view('explain_view',$data);
		}
		$this->load->view('templates/footer');	
    }		
}

