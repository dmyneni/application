<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class explain_model extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function get_query($qid)
     {
          $sql = "select query_title as title,text as query from queries where query_id=?";
          $query = $this->db->query($sql,array($qid));
		  return $query->row();
     }
	 
	 function get_actions($qid)
     {
          $sql = "select column_name,value,equality,fontcolor,bgcolor,shortdesc,lookup_name,comparison_type,label,class,priority,link_id ,chart_type,max_length,chart_label,chart_labels_column from query_columns a, actions b, column_actions c where a.query_id=? and a.column_id=c.column_id and b.action_id=c.action_id order by priority";
		  $query=$this->db->query("$sql",array($qid));
		  return  $query->result_array();
     }
	 
	 function get_links($link_list)
     {
          $sql = "select link_id,linkstr,linkpath from links where link_id in ($link_list)";
          $query = $this->db->query($sql);
		  return $query->row();
     }
}?>