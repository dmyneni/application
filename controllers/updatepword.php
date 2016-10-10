<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class updatepword extends CI_Controller
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
          //load the login model
          $this->load->model('login_model');
          $this->load->model('menu_model');
}

     public function index()
     {
       $current_menu_id=1; // since there is no session, use the configuration default
		$current_item=1; 
		$password = $this->input->post("password");
		$headerdata=$this->menu_model->buildmenu($current_menu_id,$current_item);
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('passconf', 'Confirm Password', 'trim|required|min_length[3]|max_length[20]|matches[password]');
		$this->load->view('templates/header',$headerdata);
               if ($this->input->post('btn_login') == "Update")
               {
         		$user_id=$this->session->userdata('user_id');
         		$email_id = $this->session->userdata('encry_email');
               	$upemail=$this->login_model->get_updatepasswd($emailId,$user_id,$password);
               	redirect('login/index');
               }
               else
               {
               	$user_id = $this->uri->segment(3);
               	$email_id = $this->uri->segment(4);
               	$sessiondata = array(
               			'user_id'=> $user_id,
               			'encry_email'=> $email_id
               	);
               	$this->session->set_userdata($sessiondata);
               	
               	$this->load->view('updatepword_view');
               }
               $this->load->view('templates/footer');
          }
}?>

