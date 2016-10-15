<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Users extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model','user');
        $this->load->model('menu_model');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->database();
    }
 
    public function index()
    {   	
		if ($this->session->userdata('username')=='') redirect('login');
    	$data=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
    	$data['roles']=$this->user->roledetails();
 #   	$this->load->view('templates/header',$headerdata);
		$this->load->view('users_view',$data);
		$this->load->view('templates/footer');
    }
 
    public function ajax_list()
    {
        $list = $this->user->get_datatables();
        $data = array();
		if (isset($_POST['start'])) {
			$no = $_POST['start'];
		} else {
			$no=1;
		}
        foreach ($list['tabledata'] as $user) {
            $no++;
            $row = array();
            $row[] = $user['user_id'];
			$row[] = $user['username'];
            $row[] = $user['status'];
            $row[] = $user['approved_by'];		
            $row[]=$this->user->getRoles($user['user_id']);
            //add html for action
            $row[] ='<button class="btn btn-xs btn-default" data-original-title="Edit Row" onclick="edit_user('."'".$user['user_id']."'".')"\"><i class="fa fa-pencil"></i></button><button class="btn btn-xs btn-default" data-original-title="Delete" onclick="delete_user('."'".$user['user_id']."'".')" \><i class="fa fa-times"></i></button>';
 
            $data[] = $row;
        }

		if (isset($_POST['draw'])) {
		$draw=$_POST['draw'];
	} else {
		$draw=1;
	}
        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => $list['count_filtered'],
                        "recordsFiltered" => $list['count_filtered'],
                        "data" => $data
        		        //"search"=> $this->user->column_search 
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($user_id)
    {
        $row = $this->user->get_by_id($user_id);
        $data = array(
        		'user_id' => $row->user_id,
        		'username' => $row->username,
        		'status' => $row->status,
        		'approved_by' => $row->approved_by,
        		'roles'=>$this->user->getRoleids($row->user_id)
        );
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
    	
        $data = array(
                'user_id' => $this->input->post('user_id'),
                'username' => $this->input->post('username'),
                'status' => $this->input->post('status'),
                'approved_by' => $this->input->post('approved_by'),
        		
            );
        $roles=$this->input->post('sroles');
        $roleArray = explode(',', $roles);
        $insert = $this->user->save($data,$roleArray); 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $data = array(
                'user_id' => $this->input->post('user_id'),
                'username' => $this->input->post('username'),
                'status' => $this->input->post('status'),
                'approved_by' => $this->input->post('approved_by'),
            );
        $roles=$this->input->post('sroles');
        $roleArray = explode(',', $roles);
        $retval=$this->user->update(array('user_id' => $this->input->post('user_id')), $data,$roleArray);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($user_id)
    {
        $this->user->delete_by_id($user_id);
        $this->db->where('user_id',$user_id);
        $this->db->delete('user_roles');
        echo json_encode(array("status" => TRUE));
    }
 
}