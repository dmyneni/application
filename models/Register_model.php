<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class register_model extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
     }

     //get the username & password from tbl_usrs
     function get_user($usr)
     {
          $sql = "select * from users where username = '" . $usr . "'";
          $query = $this->db->query($sql);
          return $query->num_rows();
     }
        
     public function insertuser($username,$password,$email,$phone,$comment,$roles)
     {
     	$data=array(
     			'username'=>$username,
     			'status'=>'approve',
     			'encrypted_pwd'=>md5($password)
     	);
     	$this->db->insert('users',$data);
     	
     	$sql = "select user_id from users where username = '" . $username . "'";
     	$query = $this->db->query($sql);
     	foreach ($query->result() as $row)
     	{
     		$user_id =$row->user_id;
     	}
     	// inserting data into user_profile table
     	$profile=array(
     			'user_id'=>$user_id,
     			'email_address'=>$email,
     			'phone_number'=>$phone,
     			'text_validated'=>$comment
     	);
     	$this->db->insert('user_profiles',$profile);
     	
     	// inserting data into user_role table
     	foreach ($roles as $selectedOption)
     	{
     		$roles=array('user_id'=>$user_id,
     				'role_id'=>$selectedOption,
     				'status'=>'approve'
     				);
     		
     		$this->db->insert('user_roles',$roles);
     	}
     }
     
     function defaultaccount()
     {
     	$sqlr = "Select `menu_id`,`menu_name` FROM `toolbox`.`menus`";
        $query = $this->db->query($sqlr);
     	return $query->result_array();     	
     }
     
     function roledetails()
     {
     	$sqlr = "Select `role_id`,`role` FROM `toolbox`.`roles` where `role`!='Active user'";
     	$query = $this->db->query($sqlr);
     	return $query->result_array();
     	
     	//ajax curd
     }
      
     function databasedetails()
     {
     	     	
     	$sqlr = "Select `db_id`,`db_name` FROM `toolbox`.`db_details`";
     	$query = $this->db->query($sqlr);
     	return $query->result_array();
     }
      
}?>

