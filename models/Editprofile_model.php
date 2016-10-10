<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class editprofile_model extends CI_Model
{
     function __construct()
     {
          parent::__construct();
     }
     public function get_profile($user_id)
     {
     	$sql = "SELECT email_address,phone_number,default_menu_id,default_account_id,default_query_id,default_menu_id,default_rpt_id ,default_bind_values FROM user_profiles where user_id=?";
     	//echo $sql;
     	$query = $this->db->query($sql,array($user_id));
     	return  $query->row();
     }
     
     function roledetails()
     {
     	$sqlr = "Select role_id,role FROM roles where role!='Active user'";
     	$query = $this->db->query($sqlr);
     	return $query->result_array();
     }
     
     function getmenunames()
     {
     	$query = $this->db->query("select menu_id,menu_name from menus m where m.status='active' and (exists (select 1 from roles r, user_roles ur where r.role_id=ur.role_id and role='Contributor' and ur.user_id=".$this->session->userdata('user_id')." and m.created_by=ur.user_id) or exists(select 1 from roles r, menu_roles mr where r.role_id=mr.role_id and mr.menu_id=m.menu_id))");
     	return $query->result_array();
     }
     
     function getdbnames()
     {
     	$query = $this->db->query("select account_id,db_name from db_accounts a, db_details b where a.db_id=b.db_id and a.status='active' and (exists (select 1 from roles r, user_roles ur where r.role_id=ur.role_id and role='Contributor' and ur.user_id=".$this->session->userdata('user_id')." and a.created_by=ur.user_id) or exists(select 1 from roles r, db_account_roles dr where r.role_id=dr.role_id and dr.account_id=a.account_id))");
     	return $query->result_array();
     }
     function update_profile($user_id,$password,$email,$phone,$roles,$rolelist,$default_menu_id,$default_account_id)
     {
     	if($password !="")
     	{
     	$data = array(
     		'encrypted_pwd'=>md5($password)
     	);
     	
     	$this->db->where('user_id', $user_id);
     	$this->db->update('user', $data);
     	}

     	$profile=array(
     		
     			'email_address'=>$email,
     			'phone_number'=>$phone,
     			'default_menu_id'=>$default_menu_id,
				'default_menu_item_id'=>0,
     			'default_account_id'=>$default_account_id
     	);
     	$this->db->where('user_id',$user_id);
     	$this->db->update('user_profiles', $profile);
     	foreach ($roles as $selectedOption)
     	{
     		if(!(strpos($rolelist,$selectedOption)>0))
     		{
     		$role=array('user_id'=>$user_id,
     				'role_id'=>$selectedOption,
     				'status'=>'approve'
     		);
     		 
     		$this->db->insert('user_roles',$role);
     		}
     	}
     }
}