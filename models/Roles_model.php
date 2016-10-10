<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Roles_model extends CI_Model {
 
    var $table = 'roles';
   var $column_order = array();
   //var $column_search = array();
    //var $column_order =  array('user_id','username','status','approved_by'); 
    //array('user_id','username','status','approved_by'); //set column field database for datatable orderable
    var $column_search = array(); 
    //array('username','status','approved_by','role'); //set column field database for datatable searchable 
    var $order = array('role','asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
		$this->db_target= $this->load->database('default', TRUE);
		$this->setcolumns();
		$this->setserachcolumns();
   }
   public function setcolumns()
   {
   	    $tcolumn_order = array();
		$sql="select Role_id,role,short_desc as description, status,created_by,updated_by,approved_by from roles";
		//$query = $this->db_target->query($sql);
		$query = $this->db_target->query($sql);
		foreach ($query->list_fields() as $field)
		{
			array_push($tcolumn_order,$field);
			//echo $field;
		}
		 $this->column_order=$tcolumn_order;
   
   	
   }
   public function setserachcolumns()
   {
   	$tcolumn_order = array();
   	$sql="select Role_id,role,short_desc, status,created_by,updated_by,approved_by from roles";
   	$query = $this->db_target->query($sql);
   	foreach ($query->list_fields() as $field)
   	{
   		array_push($tcolumn_order,$field);
   		//echo $field;
   	}
   	$this->column_search=$tcolumn_order;
   	 
   
   }
   
    private function _get_datatables_query()
    {
    	
        $this->db_target->from($this->table);
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
			if (isset($_POST['search']['value'])) {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db_target->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db_target->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db_target->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db_target->group_end(); //close bracket
            }
            $i++;
			}
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db_target->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db_target->order_by(key($order), $order[key($order)]);
        } 
    }
 
    function get_datatables()
    {
    	
        $this->_get_datatables_query();
		if (isset($_POST['length'])) {
        if($_POST['length'] != -1)
        $this->db_target->limit($_POST['length'], $_POST['start']); 
		}
        $query = $this->db_target->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db_target->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db_target->from($this->table);
        return $this->db_target->count_all_results();
    }
 
    public function get_by_id($role_id)
    {
        $this->db_target->from($this->table);
        $this->db_target->where('role_id',$role_id);
        $query = $this->db_target->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db_target->insert($this->table, $data);
        return $this->db_target->insert_id();
      
    }
 
    public function update($where, $data)
    {
        $this->db_target->update($this->table, $data, $where);
        
        return $this->db_target->affected_rows();
        //return $sql;
    }
 
    public function delete_by_id($role_id)
    {
        $this->db_target->where('role_id', $role_id);
        $this->db_target->delete($this->table);
    }
    
    
    public function colheader()
    {
    	$sqlr="select column_name,position from query_columns where query_id=60 and  position in(1,3)";
    	$quyresult=$this->db->query($sqlr);
    	return $quyresult->result_array();
     }
 
 
}