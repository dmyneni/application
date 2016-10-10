<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class login extends CI_Controller
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
          //get the posted values
          $username = $this->input->post("txt_username");
          $password = $this->input->post("txt_password");
	  
		$current_menu_id=1; // since there is no session, use the configuration default
		$current_item=38; 


          //set validations
          $this->form_validation->set_rules("txt_username", "Username", "trim|required");
          $this->form_validation->set_rules("txt_password", "Password", "trim|required");		  
          if($this->session->userdata('username')!='')
          {

			redirect("changemenu/index/".$this->session->userdata('current_menu_id')."/".$this->session->userdata('current_item_id'));           
          }
          else if ($this->form_validation->run() == FALSE)
          {
              //validation fails  

			$page_nav = array(
				"1" => array(
					"title" => "Home",
					"icon" => "fa-home",
					"sub" => array(
						"38" => array(
							"title" => "Login",
							"url" => base_url().'index.php/login'
						),
					)
				)
			);			

			$data['page_nav']=$page_nav;
			$this->load->view('login_view',$data);
			$this->load->view('templates/footer');
          }
          else
          {
               //validation succeeds
               if ($this->input->post('btn_login') == "Login")
               {
                    //check if username and password is correct
                    $usr_result = $this->login_model->get_user($username, $password);
                    if ($usr_result->user_id > 0 ) //active user record is present
                    {
                    	$profdet=$this->login_model->get_profile($usr_result->user_id);
                    	$roledet=$this->login_model->get_roles($usr_result->user_id);
                    	if(isset($profdet))
							if (!$profdet->default_menu_id) $profdet->default_menu_id=1; // default
                    	{//set the session variables
                         $sessiondata = array(
                              'username' => $username,
                         	  'user_id'=>$usr_result->user_id, 
                         		'default_menu_id'=>$profdet->default_menu_id,
                        		'default_menu_item_id'=>$profdet->default_menu_item_id,
								'current_menu_id'=>$profdet->default_menu_id,
                        		'current_menu_item_id'=>$profdet->default_menu_item_id,
                         		'default_query_id'=>$profdet->default_query_id,
                         		'default_rpt_id'=>$profdet->default_rpt_id,
								'default_bind_values'=>$profdet->default_bind_values,
                         		'img_id'=>$profdet->img_id,
                         		'default_account_id'=>$profdet->default_account_id,
                         		'roles'=>$roledet,
                              'loginuser' => TRUE
                         );
                         
                         $this->session->set_userdata($sessiondata);

                         redirect("changemenu/index/".$this->session->userdata('default_menu_id')."/".$this->session->userdata('default_menu_item_id'));
                    	}
                    }
                    else
                    {
                         $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                         redirect('login/index');
                    }
               }
               else
               {
                    redirect('login/index');
               }
          }
     }
}?>

