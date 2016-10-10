<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menuname_model extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
          $this->load->helper('date');
          
     }
          
     function roledetails()
     {
     	$sqlr = "Select role_id,role FROM roles where role!='Active user'";
     	$query = $this->db->query($sqlr);
     	return $query->result_array();
     
     	//ajax curd
     }
     function menudetails()
     {
     	$sqlr = "Select menu_id,menu_name FROM menus where status ='active'";
     	$query = $this->db->query($sqlr);
     	return $query->result_array();
     
     }
     function querydetails()
     {
     	$sqlr = "Select query_id,query_title FROM queries where status ='active'";
     	$query = $this->db->query($sqlr);
     	return $query->result_array();
     }
     function addmenuname($menuname,$role,$menutype,$comment,$user_id,$curtimestamp)
     {
     	$menu=array(
     	
     			'menu_name'=>$menuname,
     			'description'=>$comment,
     			'menu_type'=>$menutype,
     			'created_by'=>$user_id,
     			'created'=>$curtimestamp,
     			'default_menu_item'=>1
     	);
     	$this->db->insert('menus', $menu);
     	$menuid=$this->db->insert_id();
     	return $menuid;
     }
     
     function addmenuitem($menuid,$menuitemtype,$menuitem,$link,$comment,$user_id,$curtimestamp)
     {
	     	$menu=array(
	     		
	     			'menu_id'=>$menuid,
	     			'text'=>$menuitem,
	     			'item_desc'=>$comment,
	     			'link'=>$link,
	     			'type'=>$menuitemtype,
	     			'created_by'=>$user_id,
	     			'created'=>$curtimestamp
	     	);
	     	$this->db->insert('menu_items', $menu);
	     	$menuitemid=$this->db->insert_id();
	     	return $menuitemid;
     	}
     
}