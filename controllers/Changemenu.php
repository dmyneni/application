<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class changemenu extends CI_Controller
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
//		$menu_id = $this->uri->segment(3);
		$item_id=$this->uri->segment(3);

		$user_data=array(
//			'current_menu_id'=>$menu_id,
			'current_menu_item_id'=>$item_id
		);
		$this->session->set_userdata($user_data);

		$link = $this->menu_model->get_item($item_id);

		if (!$link) $link='news'; // default
		redirect($link);
     }
}?>

