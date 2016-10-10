<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class manageaction_model extends CI_Model {
 
    var $table = 'queries';
   var $column_order = array('action_id', 'column_name','equality','value','fontcolor','bgcolor','shortdesc');
   //var $column_search = array();
    //var $column_order =  array('user_id','username','status','approved_by'); 
    //array('user_id','username','status','approved_by'); //set column field database for datatable orderable
    var $column_search = array('action_id', 'column_name','equality','value','fontcolor','bgcolor','shortdesc'); //set column field database for datatable searchable 
    var $order = array('action_id','asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
		$this->db_target= $this->load->database('default', TRUE);
   }
 
    function get_datatables($query_id)
    {
		if (isset($_POST['length'])) {
        if($_POST['length'] != -1)
        $this->db_target->limit($_POST['length'], $_POST['start']); 
		}
		//echo $query;
		$sql="select query_id,ca.action_id, column_name,equality,value,fontcolor,bgcolor,shortdesc,comparison_type 
		from column_actions ca,query_columns qc,actions a
		where ca.column_id = qc.column_id 
		and ca.action_id=a.action_id 
		and qc.query_id=?";

        $query = $this->db_target->query($sql,array($query_id));
		$results=array('tabledata'=>$query->result_array(),'count_filtered'=>$query->num_rows());
        return $results;
    }
 
    public function get_by_id($action_id)
    {
    	
    	$sqlr="select column_actions.action_id, column_id,equality,value,fontcolor,bgcolor,shortdesc,status,comparison_type from column_actions,actions where column_actions.action_id=actions.action_id and column_actions.action_id=".$action_id;
    	$query = $this->db_target->query($sqlr);
        return $query->row();
    }
 
 
    public function delete_by_id($action_id)
    {
        $this->db_target->where('action_id', $action_id);
        $this->db_target->delete('actions');
        $this->db_target->where('action_id', $action_id);
        $this->db_target->delete('column_actions');
        
       
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
    function insert_actions($column_id,$condition,$value,$fgcolor,$bgcolor,$description,$comparison_type,$priority,$label,$link_id)
    {
		//alert('add action');
    		$actiondata=array(
    				'value'=>$value,
    				'equality'=>$condition,
    				'fontcolor'=>$fgcolor,
    				'bgcolor'=>$bgcolor,
    				'shortdesc'=>$description,
					'label'=>$label,
					'priority'=>$priority,
					'link_id'=>$link_id,
    				'comparison_type'=>$comparison_type
    		);
    		
    		$this->db->insert('actions', $actiondata);
    		$actionid=$this->db->insert_id();
    		$data=array(
    				'column_id'=>$column_id,
    				'action_id'=>$actionid
    		);
    		$this->db->insert('column_actions', $data);
    		
    		return "Successfully added";
    		
    }
    function update_actions($action_id,$condition,$value,$fgcolor,$bgcolor,$description,$comparison_type,$priority,$link_id,$label,$status)
    {
    	
    	$actiondata=array(
    			'value'=>$value,
    			'equality'=>$condition,
    			'fontcolor'=>$fgcolor,
    			'bgcolor'=>$bgcolor,
    			'shortdesc'=>$description,
    			'comparison_type'=>$comparison_type,
				'label'=>$label,
				'priority'=>$priority,
				'link_id'=>$link_id,
    			'status'=>$status
    	);
    	//$this->db->set($actiondata);
    	$this->db->where('action_id',$action_id);
    	$this->db->update('actions',$actiondata);
    	return "Successfully updated";
    
    }
    
 
}