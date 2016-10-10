<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class About extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
    }
 
    public function index()
    {
		if ($this->session->userdata('username')=='') redirect('login');
        $headerdata=$this->menu_model->buildmenu();
		$dataset='';
		$this->load->view('templates/header',$headerdata);
		$this->load->view('about_view',$dataset);
		$this->load->view('templates/footer');
    }
}
