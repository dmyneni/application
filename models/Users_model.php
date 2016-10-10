<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Users_model extends CI_Model {
 
    var $table = 'users';
   var $column_order = array();
   //var $column_search = array();
    //var $column_order =  array('user_id','username','status','approved_by'); 
    //array('user_id','username','status','approved_by'); //set column field database for datatable orderable
    var $column_search = array('username','status','approved_by','role'); //set column field database for datatable searchable 
    var $order = array('username','asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
		$this->db_target= $this->load->database('default', TRUE);
		$this->setcolumns();
   }
   public function setcolumns()
   {
   	    $tcolumn_order = array();
		$sql="select user_id,username,status,approved_by from users";
		//$query = $this->db_target->query($sql);
		$query = $this->db_target->query($sql);
		foreach ($query->list_fields() as $field)
		{
			array_push($tcolumn_order,$field);
			//echo $field;
		}
		 $this->column_order=$tcolumn_order;
   
   	
   }
   
    private function _get_datatables_query()
    {  	
        //$this->db_target->from($this->table);
		$this->db_target->query("select user_id,username,status from users");
        $i = 0;
    }
 
    function get_datatables()
    {
		if (isset($_POST['length'])) {
        if($_POST['length'] != -1)
        $this->db_target->limit($_POST['length'], $_POST['start']); 
		}
        $query = $this->db_target->query("select user_id,username,status,approved_by from users");
		$results=array('tabledata'=>$query->result_array(),'count_filtered'=>$query->num_rows());
        return $results;
    }
 
    public function get_by_id($user_id)
    {
        $this->db_target->from($this->table);
        $this->db_target->where('user_id',$user_id);
        $query = $this->db_target->get();
 
        return $query->row();
    }
 
    public function save($data,$roles)
    {
        $this->db_target->insert($this->table, $data);
        //$roleArray = explode(',', $roles);
       // $tell="";
        $newid=$this->db_target->insert_id();
        foreach ($roles as $selectedOption)
        {
        	
        	$aroles=array('user_id'=>$newid,
        			'role_id'=>$selectedOption,
        			'status'=>'approve'
        	);
        	//$tell=$tell.$newid.$selectedOption.'</br>';
        	$this->db_target->insert('user_roles',$aroles);
        }
        //return $this->db_target->insert_id();
        return $newid;
    }
 
    public function update($where, $data,$roles)
    {
        $this->db_target->update($this->table, $data, $where);
        //$roleArray = explode(',', $roles);
        //$sql="";
        $this->db_target->where('user_id', $data['user_id']);
        $this->db_target->delete('user_roles');
        foreach ($roles as $selectedOption)
        {
        	$rroles=array('user_id'=>$data['user_id'],
        			'role_id'=>$selectedOption,
        			'status'=>'approve'
        	);
        	$this->db_target->insert('user_roles',$rroles);
        	
        	/*$sql="select role_id from user_roles where user_id=".$data['user_id'].' and role_id='.$selectedOption ;
        	//echo $sql;
             $query = $this->db_target->query($sql);
             if($query->num_rows()==0)
             {
        	 $this->db_target->insert('user_roles',$rroles);
             }*/
        }
        return $this->db_target->affected_rows();
        //return $sql;
    }
 
    public function delete_by_id($user_id)
    {
        $this->db_target->where('user_id', $user_id);
        $this->db_target->delete($this->table);
        $this->db_target->where('user_id', $user_id);
        $this->db_target->delete('user_profiles');
        $this->db_target->where('user_id', $user_id);
        $this->db_target->delete('user_roles');
    }
    
    public function getRoles($user_id)
    {
    	$sql="select role from roles, user_roles where user_roles.role_id=roles.role_id and user_roles.user_id =?";
    	$query = $this->db_target->query($sql,array($user_id));
    	
    	$roles="";
    	foreach($query->result() as $row) {
    		if($roles !='')
    		{
    			$roles=$roles.','.$row->role;
    		}else {
    			
    			$roles=$row->role;
    		}
    	}
    	return $roles;
    }
    public function getRoleids($user_id)
    {
    	$sql="select user_roles.role_id  from roles, user_roles where user_roles.role_id=roles.role_id and user_roles.user_id =?";
    	$query = $this->db_target->query($sql,array($user_id));
    	 
    	$roles=[];
    	foreach($query->result() as $row) {
    		array_push($roles,$row->role_id);
    	}
    	return $roles;
    }
    
 public function roledetails()
 {
 	$sqlr = "Select `role_id`,`role` FROM `roles`";
 	$query = $this->db->query($sqlr);
 	return $query->result_array();
 }
 
}