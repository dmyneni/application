<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class managequery extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('managequery_model','qry');
        $this->load->model('createquery_model');
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
    	$data['dbname']=$this->qry->dbdetails();
    	//$this->load->view('templates/header',$headerdata);
		$this->load->view('managequery_view',$data);
		$this->load->view('templates/footer');
    }
 
    public function ajax_list()
    {
    	$db_type=$this->createquery_model->get_db_type($this->session->userdata('current_account_id'));
        $list = $this->qry->get_datatables($db_type);
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
			$row[] ='<a href="'.base_url().'index.php/explain/index/'.$query['query_id'].'" >Explain</a>';
            //$row[] = $query['description'];
            $row[] = $query['status'];
            //add html for action
            //$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_query('."'".$query['query_id']."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            $row[] = '<button class="btn btn-xs btn-default" data-original-title="Edit Row" onclick="edit_query('."'".$query['query_id']."'".')"\"><i class="fa fa-pencil"></i></button>';
 
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