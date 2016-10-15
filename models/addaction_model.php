<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class addaction_model extends CI_Model
{
	
	  
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
          $this->load->helper('date');
     }
     
     function getColums($queryid)
     {
     	$qrystr="select column_id,column_name from query_columns where query_id=".$queryid;
     	$query = $this->db->query($qrystr);
     	return $query->result_array();
     	
     }
     function insert_actions($column_id,$condition,$value,$fgcolor,$bgcolor,$description,$comparison_type)
     {
     	$data=array(
     			'column_id'=>$column_id
     	);
     	$this->db->insert('column_actions', $data);
     	$actionid=$this->db->insert_id();
     	$actiondata=array(
     			'action_id'=>$actionid,
     			'value'=>$value,
     			'equality'=>$condition,
     			'fontcolor'=>$fgcolor,
     			'bgcolor'=>$bgcolor,
     			'shortdesc'=>$description,
     			'comparison_type'=>$comparison_type
     	);
     	$this->db->insert('actions', $actiondata);
     	
     }

}
