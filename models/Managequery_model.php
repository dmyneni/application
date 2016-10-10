<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class managequery_model extends CI_Model {
 
    var $table = 'queries';
   var $column_order = array('query_id','query_title','description','status');
   //var $column_search = array();
    //var $column_order =  array('user_id','username','status','approved_by'); 
    //array('user_id','username','status','approved_by'); //set column field database for datatable orderable
    var $column_search = array('query_id','query_title','description','status'); //set column field database for datatable searchable 
    var $order = array('query_title','asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
		$this->db_target= $this->load->database('default', TRUE);
   }
   
    private function _get_datatables_query()
    {  	
        //$this->db_target->from($this->table);
		$this->db_target->query("select query_id,query_title,description,version,status from queries");
        $i = 0;
    }
 
    function get_datatables()
    {
		if (isset($_POST['length'])) {
        if($_POST['length'] != -1)
        $this->db_target->limit($_POST['length'], $_POST['start']); 
		}
        $query = $this->db_target->query("select query_id,query_title,description,status from queries order by query_id desc");
		$results=array('tabledata'=>$query->result_array(),'count_filtered'=>$query->num_rows());
        return $results;
    }
 
    public function get_by_id($query_id)
    {
        $this->db_target->from($this->table);
        $this->db_target->where('query_id',$query_id);
        $query = $this->db_target->get();
 
        return $query->row();
    }
 
    
 
    public function update($where, $data,$roles)
    {
        $this->db_target->update($this->table, $data, $where);
        return $this->db_target->affected_rows();
        //return $sql;
    }
 
    
    
    function getColums($queryid)
    {
    	$qrystr="select column_id,column_name from query_columns where query_id=".$queryid;
    	$query = $this->db->query($qrystr);
    	return $query->result_array();
    
    } 
    function dbdetails()
    {
    	$sqlr = "Select account_id,account FROM db_accounts";
    	$query = $this->db->query($sqlr);
    	return $query->result_array();
    }

 
}