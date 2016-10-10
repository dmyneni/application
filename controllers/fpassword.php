<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class fpassword extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->library('email');
          $this->load->helper('html');
          $this->load->database();
          $this->load->library('form_validation');
          //load the login model
          $this->load->model('login_model');
          $this->load->model('menu_model');
}

     public function index()
     {
          //get the posted values
          $email = $this->input->post("txt_email");
          
		  
		$current_menu_id=1; // since there is no session, use the configuration default
		$current_item=1; 
		$headerdata=$this->menu_model->buildmenu($current_menu_id,$current_item);
		//$this->load->view('templates/header',$headerdata);
		
          //set validations
   				$this->form_validation->set_rules('email', 'Email',  'trim|required|min_length[3]|max_length[30]|valid_email');
   		               //validation succeeds
               if ($this->input->post('btn_login') == "Submit")
               {
               	$usr_result = $this->login_model->get_email($email);
               	$user_id=$usr_result->user_id;
               	echo '</br>'.$user_id;
               	if($user_id > 0)
               	{
               		$upemail=$this->login_model->get_upemail($email,$user_id);
               		echo '</br>'.$upemail;
               		//$this->email->set_header('mailtype','HTML');
               		$this->email->set_mailtype('html');
               		$this->email->from('mynenibhavani@gmail.com', 'Admin');
               		$this->email->to($email);
               		$this->email->subject('Update Password');
               		$this->email->message('Please click the below link :</br> <a href="http://localhost/dev2/index.php/updatepword/index/"'.$user_id.'/'.$upemail.'>Update Password</a>');
               		$this->email->send();
               		echo $this->email->print_debugger();
               		 
               		
               		redirect('login/index');
               	}
               	else 
               	{
               		$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User does not exist with this email!</div>');
               		redirect('fpassword/index');
               	}
               }
               else
               {
                    $this->load->view('fpassword_view');
               }
               $this->load->view('templates/footer');
          }
     
}?>

