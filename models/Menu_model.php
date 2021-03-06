<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class menu_model extends CI_Model
{
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->helper('date');
	}

	public function getTimeStamp()
	{
		$datestring = '%Y-%m-%d %H:%i:%s';
		$time = now("America/Chicago");
		$curtimestamp=mdate($datestring, $time);
		return $curtimestamp;
	}
	public function buildmenu()
	{
		
		if (! isset($current_account_id)) {
			if ($this->session->userdata('default_account_id')) {
				$current_account_id=$this->session->userdata('current_account_id');
			} else 
				$current_account_id=1;  //default
			$this->session->set_userdata(['current_account_id'=>$current_account_id]);
		}		

		if ($results=$this->get_db_name($current_account_id))
		{
			$current_db_name=$results['db_name'];
		}
		$page_nav=$this->get_menus();

		$data=array('page_nav'=>$page_nav,
				'databases'=>$this->get_databases(),'current_account_id'=>$current_account_id,'current_db_name'=>$current_db_name);
		return $data;
	}
	
	function get_db_type($account_id) 
	{
		$sql="select db_type from db_accounts a, db_details d where a.db_id=d.db_id and a.account_id=?";
		$query = $this->db->query($sql,array($account_id));
		return $query->result_array()[0];
	}		
	
	
	function get_db_name($account_id) 
	{
		$sql="select db_name from db_accounts a, db_details d where a.db_id=d.db_id and a.account_id=?";

		$query = $this->db->query($sql,array($account_id));
		if ($query->num_rows()) {			
			return $query->result_array()[0];
		} else {
			return array('db_name'=>'No DB');
		}
	}
	
	function get_menus()
	{
		/*
		1) Active menu
		2) User created the menu themself
		3) or Is a system menu
		4) Is for the same type of menu that the database is
		5) Is limited to the short list that user wants to see
		*/
//	$user_id=$this->session->userdata('user_id');
		$current_account_id=$this->session->userdata('current_account_id');	
		$sql="select
		menu_id,text,icon,type,class from menus2 where level=1 and (class='system' or class=(select db_type from db_accounts a, db_details d where a.db_id=d.db_id and a.account_id=?)) order by priority";
// check users role and preferences to restrict the list after testing.
		$query = $this->db->query($sql,array($current_account_id));	
		$result=$query->result_array();
		$nav=[];
		$cnt=0;
		foreach($result as $row) {
			$nav[$row['menu_id']]=array('title'=>$row['text'],'icon'=>$row['icon']);
			if ($row['type']=='menu' && $row['class']!='system') {
				$nav[$row['menu_id']]['title_append']='<div hidden id="target-'.$cnt.'" class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)"><font color=white><i>Can drop here</i></font><font color=red background=white> <i class="fa fa-bullseye" aria-hidden="true"></i></font></div>';
				$cnt++;
			}
		}
	
		$sql="select
		menu_id,text,icon,type,parent_menu_id,link_id,class from menus2 where level=2 and (class='system' or class=(select db_type from db_accounts a, db_details d where a.db_id=d.db_id and a.account_id=?)) order by parent_menu_id, priority";
// check users role and preferences to restrict the list after testing.
		$query = $this->db->query($sql,array($current_account_id));	
		$result=$query->result_array();
		$sub=[];
		$p_parent_id='';
		foreach($result as $row) {
			if ($p_parent_id != $row['parent_menu_id']) {
				if ($p_parent_id=='') {
					$p_parent_id=$row['parent_menu_id'];
				} else {
					$nav[$p_parent_id]['sub']=$sub;	
					$sub=[];
					$p_parent_id=$row['parent_menu_id'];
				}
			}
			$sub[$row['menu_id']]=array('title'=>$row['text'],'icon'=>$row['icon']);
			if ($row['link_id']) 
				$sub[$row['menu_id']]['url']=base_url().'index.php/changemenu/index/'.$row['menu_id'];
			else {
				if ($row['type']=='menu' && $row['class']!='system') {
					$nav[$row['menu_id']]['title_append']='<div hidden id="target-'.$cnt.'" class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)"><font color=white><i>Can drop here</i></font><font color=red background=white> <i class="fa fa-bullseye" aria-hidden="true"></i></font></div>';
					$cnt++;
				}
			}
		}
		if ($sub) {
			$nav[$p_parent_id]['sub']=$sub;				
		}
		// Assumes only 3 levels deep.  SmartAdmin will support 5 levels deep, if want to expand.
		$sql="select
		l2.menu_id,l2.text,l2.icon,l2.parent_menu_id,l1.menu_id main_menu_id from menus2 l2, menus2 l1 where l1.menu_id=l2.parent_menu_id and l2.level=3 and (l2.class='system' or l2.class=(select db_type from db_accounts a, db_details d where a.db_id=d.db_id and a.account_id=?)) order by l2.parent_menu_id, l2.priority";
		// check users role and preferences to restrict the list after testing.
		$query = $this->db->query($sql,array($current_account_id));	
		$result=$query->result_array();
		$sub=[];
		$p_parent_id='';
		foreach($result as $row) {
			$main_menu_id=$row['main_menu_id'];
			if ($p_parent_id != $row['parent_menu_id']) {
				if ($p_parent_id=='') {
					$p_parent_id=$row['parent_menu_id'];
				} else {
					$nav[$main_menu_id]['sub'][$p_parent_id]['sub']=$sub;	
					$sub=[];
					$p_parent_id=$row['parent_menu_id'];
				}
			}			
			$sub[$row['menu_id']]=array('title'=>$row['text'],'icon'=>$row['icon'],'url'=>base_url().'index.php/changemenu/index/'.$row['menu_id']);
		}
		if ($sub) {
			$nav[$main_menu_id]['sub'][$p_parent_id]['sub']=$sub;				
		}		

		return $nav;
	}
	
	
	function get_databases()
	{
		/*
		1) Active database
		2) Granted through a role
		3) or created by the user as a contributor
		-- 4) Is limited to the short list that user wants to see
		*/
		$sql="select account_id,db_name 
		from db_accounts a, db_details b 
		where a.db_id=b.db_id 
		and a.status='active' 
		and (
			exists (
				select 1 
				from roles r, user_roles ur 
				where r.role_id=ur.role_id 
				and role='Contributor' 
				and ur.user_id=? 
				and a.created_by=ur.user_id
			) 
			or exists(
				select 1 from roles r, db_account_roles dr 
				where r.role_id=dr.role_id 
				and dr.account_id=a.account_id
			)
		)"; 
		/*and a.account_id in (
			select value 
			from user_preferences 
			where user_id=? 
			and name='account_id'
		) */
		$sql.="
		order by db_name";
		/*$query = $this->db->query($sql,array(13,13));*/
		$query = $this->db->query($sql,array(13));
		return $query->result_array();
	}
	
	function get_item($menu_item_id)
	{
		$sql="select l2.parent_menu_id l1_parent_menu_id,i.parent_menu_id l2_parent_menu_id,i.menu_id,l.link_id, i.text i_text, l2.text l2_text, l1.text l1_text,link_type,linkstr,target_id 
		from links l join menus2 i on l.link_id=i.link_id 
		left outer join menus2 l2 on l2.menu_id=i.parent_menu_id 
		left outer join menus2 l1 on l1.menu_id=l2.parent_menu_id
		where i.menu_id=?";

        $query = $this->db->query($sql,array($menu_item_id));
		$result=$query->result_array();

		$row=$result[0];  // find first if in more than one menu
		if ($row['link_type'] == 'query') {
			$link=$row['linkstr'].'/index/'.$row['target_id'];
		} elseif($row['link_type'] == 'system') {
			$link=$row['linkstr'];
		}
		if ($row['l2_parent_menu_id']) 
			$menu_path=$row['l2_parent_menu_id'].'/'.$row['menu_id'];
		else
			$menu_path='';

		if ($row['l1_text']) {
			$breadcrumbs=array([$row['l1_text']=>''],[$row['l2_text']=>''],[$row['i_text']=>$menu_path]);
		} else {
			$breadcrumbs=array($row['l2_text']=>'',$row['i_text']=>$menu_path);				
		}


		$this->session->set_userdata(['menu_path'=>$menu_path]);
		$this->session->set_userdata(['breadcrumbs'=>$breadcrumbs]);
	
		return $link;
	}
}