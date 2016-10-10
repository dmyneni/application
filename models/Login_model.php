<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login_model extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function get_user($usr, $pwd)
     {
          $sql = "select * from users where username = '" . $usr . "' and encrypted_pwd = '" . md5($pwd) . "' and status = 'active'";
          echo $sql;
          $query = $this->db->query($sql);
          return  $query->row();
     }
     
     public function get_profile($user_id)
     {
     	//echo $user_id;
     	
     	$sql = "SELECT email_address,phone_number,default_menu_id,default_account_id,default_query_id,default_menu_item_id,default_rpt_id ,default_bind_values,img_id FROM user_profiles where user_id=?";
     	$query = $this->db->query($sql,array($user_id));
     	return  $query->row();
     }

     public function get_roles($user_id)
     {
     		$sqlr = "Select `role_id` FROM `toolbox`.`user_roles` where `user_id`=$user_id";
     		$query = $this->db->query($sqlr);
     		return $query->result_array();
     }
     
     public function get_email($email)
     {
     	echo "select user_id from user_profiles where email_address='".$email."'";
     	$query = $this->db->query("select user_id from user_profiles where email_address='".$email."'" );
     	return  $query->row();
     }
     public function get_upemail($email,$user_id)
     {
     	$upemail=md5($email);
     	//echo 'from:'.$user_id;
     	$data = array('fotgotpassword'=> $upemail);
     	$this->db->where('user_id', $user_id);
     	$this->db->update('users', $where);
     	//echo 'Durga';
     	return $upemail;
     }
     function get_updatepasswd($email,$user_id,$password)
     {
     	$data = array('encrypted_pwd' => md5($password));
     	$this->db->where('user_id',$user_id);
     	$this->db->update('users', $data);
     }
}?>

