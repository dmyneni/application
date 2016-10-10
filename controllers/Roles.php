<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Roles extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('roles_model','role');
        $this->load->model('menu_model');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
		$this->load->helper('form');
    }
 
    public function index()
    {
		if ($this->session->userdata('username')=='') redirect('login');
        $data=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
		$data['tbheader']= $this->role->column_order;
#		$this->load->view('templates/header',$headerdata);
		$this->load->view('roles_view',$data);
		$this->load->view('templates/footer');
    }
 
    public function ajax_list()
    {
    	
        $list = $this->role->get_datatables();
        $data = array();
		if (isset($_POST['start'])) {
			$no = $_POST['start'];
		} else {
			$no=1;
		}
        foreach ($list as $role) {
            $no++;
            $row = array();
            $row[] = $role->role_id;
            $row[] = $role->role;
            $row[] = $role->short_desc;
            $row[] = $role->status;
            $row[] = $role->created_by;
            $row[] = $role->updated_by;
            $row[] = $role->approved_by;
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_role('."'".$role->role_id."'".')"><i class="glyphicon glyphicon-pencil">Edit</i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_role('."'".$role->role_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
 
            $data[] = $row;
        }
		if (isset($_POST['draw'])) {
		$draw=$_POST['draw'];
	} else {
		$draw=1;
	}
        $output = array(
                        "draw" => $draw,
                        "recordsTotal" => $this->role->count_all(),
                        "recordsFiltered" => $this->role->count_filtered(),
                        "data" => $data
        		        
        		        //"search"=> $this->user->column_search 
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($role_id)
    {
        $row = $this->role->get_by_id($role_id);
        $data = array(
        		'role_id' => $row->role_id,
        		'role' => $row->role,
        		'status' => $row->status,
        		'short_desc' => $row->short_desc,
        );
        echo json_encode($data);
    }
 
    public function ajax_add()
    {
        $data = array(
                'role_id' => $this->input->post('role_id'),
                'role' => $this->input->post('role'),
        		'description' => $this->input->post('description'),
                'status' => $this->input->post('status'),
                //'approved_by' => $this->input->post('approved_by'),
        		
            );
        $insert = $this->role->save($data); 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $data = array(
                'role_id' => $this->input->post('role_id'),
                'role' => $this->input->post('role'),
        		'description' => $this->input->post('description'),
                'status' => $this->input->post('status'),
                'approved_by' => $this->input->post('approved_by'),
            );
        $retval=$this->role->update(array('role_id' => $this->input->post('role_id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($role_id)
    {
        $this->role->delete_by_id($role_id);
        echo json_encode(array("status" => TRUE));
    }
 
}