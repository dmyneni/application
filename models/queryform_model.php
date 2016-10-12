<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class queryform_model extends CI_Model {
 
    var $table = 'query_columns';
 
    public function __construct()
    {
        parent::__construct();
		$this->db_target= $this->load->database('default', TRUE);
		
   }
    
 
    public function get_by_id($query_id)
    {
        $this->db_target->from($this->table);
        $this->db_target->where('query_id',$query_id);
        $query = $this->db_target->get();
        return $query->result_array();
        
    }
    public function update_columns($columndata,$column_id)
    {
    	$this->db_target->where('column_id',$column_id);
    	$this->db_target->update('query_columns',$columndata);
    	return "Successfully updated";
    }
    
    function get_bindval($query_id)
    {
    	$this->db_target->from('query_binds');
    	$this->db_target->where('query_id',$query_id);
    	$query = $this->db_target->get();
    	return $query->result_array();
    	 
    	
    }
    function update_bind($data,$bind_id)
    {$this->db_target->where('bind_id',$bind_id);
    	$this->db_target->update('query_binds',$data);
    	return "Successfully updated";
    	
    }

}