<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class changedb extends CI_Controller
{
     public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->database();
          $this->load->library('form_validation');
          $this->load->model('menu_model');
		  $this->load->helper('url');
}

     public function index()
     {
		if($this->session->userdata('username')=='') redirect('login');
		if (isset($_POST['current_account_id'])) {
			$account_id=$_POST['current_account_id'];
			$result=$this->menu_model->get_db_name($account_id);

			$user_data=array(
				'current_account_id'=>$account_id, 
				'current_db_name'=>$result['db_name']
				);

			$this->session->set_userdata($user_data);  // change DB
			
//			$headerdata=$this->menu_model->buildmenu($menu_id,$item_id);  // verify current menu is ok
		}
        redirect("changemenu/index/".$menu_id."/".$item_id);
     }
}?>

