<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->database();
		$this->load->library('form_validation');
		//load the login model
		$this->load->model('login_model');
	}
	
	public function index()
	{
		unset($_SESSION['username']);
		unset($_SESSION['user_id']);			

		redirect('login/index');
	}
	
}