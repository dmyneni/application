<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class manageaction extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('manageaction_model','qry');
        $this->load->model('addaction_model');
        $this->load->model('menu_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        //$queryId=$this->uri->segment(3);
    }
 
    public function index()
    {   
    	//echo "i am here";
    	if ($this->uri->segment(3)) {
    		$query_id = $this->uri->segment(3);
    		}else {
    			$query_id=$this->input->post("query_id");
    		}
    			
    		
    		echo $query_id;
		if ($this->session->userdata('username')=='') redirect('login');
    	$headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
    	$data=['columdet'=>$this->addaction_model->getColums($query_id),'query_id'=>$query_id];
    	//$this->load->view('templates/header',$headerdata);
		$this->load->view('manageaction_view',$data);
		$this->load->view('templates/footer');
    }
 
    public function ajax_list($query_id)
    {
        $list = $this->qry->get_datatables($query_id);
        $data = array();
		if (isset($_POST['start'])) {
			$no = $_POST['start'];
		} else {
			$no=1;
		}
        foreach ($list['tabledata'] as $user) {
            $no++;
            $row = array();
            $row[] = $user['action_id'];
			$row[] = $user['column_name'];
            $row[] = $user['equality'];
            $row[] = $user['value'];
            $row[] = $user['bgcolor'];
            $row[] = $user['fontcolor'];			
            $row[] = $user['shortdesc'];
            //$row[] = $user['shortdesc'];
            //add html for action
            //$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_action('."'".$user['action_id']."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_user('."'".$user['action_id']."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $row[] = '<button class="btn btn-xs btn-default" data-original-title="Edit Row" onclick="edit_action('."'".$user['action_id']."'".')"\"><i class="fa fa-pencil"></i></button><button class="btn btn-xs btn-default" data-original-title="Delete" onclick="delete_user('."'".$user['action_id']."'".')" \><i class="fa fa-times"></i></button>';
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
 
    public function ajax_edit($action_id,$query_id)
    {
        $row = $this->qry->get_by_id($action_id);
        $data = array(
        		'action_id' => $row->action_id,
        		'column_id' => $row->column_id,
        		'equality' => $row->equality,
        		'value' => $row->value,
        		'fontcolor' => $row->fontcolor,
        		'bgcolor' => $row->bgcolor,
        		'shortdesc' => $row->shortdesc,
        		'label' => $row->label,
        		'priority' => $row->priority,
				'link_id'=>$row->link_id,
        		'comparison_type'=>$row->comparison_type
        );
        $output= array('data'=>$data,"columnlist"=>$this->qry->getColums($query_id));
        echo json_encode($output);
    }
 
    public function ajax_add()
    {
    	
	$msg=$this->qry->insert_actions($this->input->post('column_id'),$this->input->post('equality'), $this->input->post('value'), $this->input->post('fontcolor'),$this->input->post('bgcolor'),$this->input->post('shortdesc'),$this->input->post('sel_comparision'),$this->input->post('priority'),$this->input->post('label'),$this->input->post('link_id'));
	echo json_encode(array("status" => TRUE,"msg"=>$msg));
    }
 
    public function ajax_update()
    {
       $msg=$this->qry->update_actions($this->input->post('action_id'),$this->input->post('equality'), $this->input->post('value'), $this->input->post('fontcolor'),$this->input->post('bgcolor'),$this->input->post('shortdesc'),$this->input->post('sel_comparision'),$this->input->post('priority'),$this->input->post('label'),$this->input->post('link_id'),$this->input->post('status'));
       echo json_encode(array("status" => TRUE,"msg"=>$msg));
    }
 
    public function ajax_delete($action_id)
    {
        $this->qry->delete_by_id($action_id);
        $this->db->where('action_id',$action_id);
        $this->db->delete('user_roles');
        echo json_encode(array("status" => TRUE));
    }
 
}