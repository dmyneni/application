<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class managemenu extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('managemenu_model','qry');
        $this->load->model('menu_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
    }
 
    public function index()
    {   	
		if ($this->session->userdata('username')=='') redirect('login');
    	$headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
    	$data=['dbname'=>$this->qry->dbdetails()];
    	$this->load->view('templates/header',$headerdata);
		$this->load->view('managequery_view',$data);
		$this->load->view('templates/footer');
    }
 
    public function ajax_list()
    {
        $list = $this->qry->get_datatables();
        $data = array();
		if (isset($_POST['start'])) {
			$no = $_POST['start'];
		} else {
			$no=1;
		}
        foreach ($list['tabledata'] as $query) {
            $no++;
            $row = array();
            $row[] = $query['query_id'];
			$row[] = $query['query_title'];
            $row[] = $query['description'];
            $row[] = $query['status'];
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_query('."'".$query['query_id']."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
 
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
 
    public function ajax_edit($query_id)
    {
        $row = $this->qry->get_by_id($query_id);
        //foreach($data as $row)
        //array_push($data,$this->user->getRoleids($user_id));
        $data = array(
        		'query_id' => $row->query_id,
        		'query_title' => $row->query_title,
        		'text' => $row->text,
        		'description' => $row->description,
        		'version' => $row->version,
        );
        //$columnlist = $this->qry->getColums($query_id);
        $output= array('data'=>$data,"columnlist"=>$this->qry->getColums($query_id));
        echo json_encode($output);
    }
 
    public function ajax_add()
    {
    	
	$insert_id=$this->createquery_model->insertdetails($this->input->post('query_title'), $this->input->post('description'), $this->input->post('txt_script'),1.0);
	echo json_encode(array("status" => TRUE,"columnlist"=>$this->qry->getColums($insert_id)));
    }
 
    public function ajax_update()
    {
       $insert_id=$this->createquery_model->insertdetails($this->input->post('query_title'), $this->input->post('description'), $this->input->post('txt_script'),$this->input->post('version'));
       echo json_encode(array("status" => TRUE,"columnlist"=>$this->qry->getColums($insert_id)));
    }
 
 
}