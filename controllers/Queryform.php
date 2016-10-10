<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class queryform extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('queryform_model');
        $this->load->model('menu_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
    }
 
    public function index()
    {   	
		if ($this->session->userdata('username')=='') redirect('login');
		if ($this->uri->segment(3)) {
			$query_id = $this->uri->segment(3);
		}else {
			$query_id=$this->input->post("query_id");
		}
    	$headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
    	$data=['columns'=>$this->queryform_model->get_by_id($query_id),'query_id'=>$query_id,'bindval'=>$this->queryform_model->get_bindval($query_id)];
    	$this->load->view('templates/header',$headerdata);
		$this->load->view('queryforms_view',$data);
		$this->load->view('templates/footer');
    }
 
    public function ajax_bindupdate()
    {
    	$query_id=$this->input->post("query_id");
    	$result=$this->queryform_model->get_bindval($query_id);
    	foreach ($result as $row)
    	{
    		$bind_id=$row['bind_id'];
    		$alias=$this->input->post('alias'.$bind_id);
    		$data = array(
    				'alias'=>$alias
				) ;   				
				$insert = $this->queryform_model->update_bind($data,$bind_id);
    		
    	}
    	echo json_encode(array("status" => TRUE));
    }
    public function ajax_columnupdate()
    {
    	
    	
    	$query_id=$this->input->post("query_id");
    	$result=$this->queryform_model->get_by_id($query_id);
    	$search='0';
    	$visi='0';
    	$sort='0';
    	foreach ($result as $row)
    	{
    		//$search='221';
    		$column_id=$row['column_id'];
    		if(!empty($_POST['search'.$column_id]))
    			$search='1';
    		if(!empty($_POST['visi'.$column_id]))
    			$visi='1';
    		if(!empty($_POST['sort'.$column_id]))
    			$sort='1';
    		$data = array(
    				'sortable' => $sort,
    				'visible' =>$visi ,
    				'searchable' => $search 
    		
    		);
    		$insert = $this->queryform_model->update_columns($data,$column_id);
    	}
        echo json_encode(array("status" => TRUE,"search"=>$search));
    }
    public function ajax_chartupdate()
    {
    	 
    	 
    	$query_id=$this->input->post("query_id");
    	$result=$this->queryform_model->get_by_id($query_id);
    	$chartlabel = $_POST['chart_labels_column'];
    	foreach ($result as $row)
    	{
    		$column_id=$row['column_id'];
    		if($chartlabel==$column_id)
    			$chartlabel='true';
    		else 
    			$chartlabel='false';
    					$data = array(
    							'chart_color' => $this->input->post('chclr'.$column_id),
    							'chart_label' =>$this->input->post('lbl'.$column_id),
    							'chart_labels_column' => $chartlabel
    
    					);
    					$insert = $this->queryform_model->update_columns($data,$column_id);
    	}
    	echo json_encode(array("status" => TRUE,"search"=>$chartlabel));
    }
 
 
}