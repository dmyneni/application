<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class createdatabase_model extends CI_Model {
	
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->load->helper('date');
	
	}
	function insertdetails($db_name,$db_type,$tns,$db_class,$hostname,$account,$PWD,$description)
	{
		$this->db->trans_begin();
		if ($db_type == 'mysql') {
			$statement="insert into db_details(db_name,db_type,db_class,hostname,created_by,created) values(?,?,?,?,?,?)";
			$this->db->query($statement,array($db_name,$db_type,$db_class,$hostname,1,now()));
			$dbid=$this->db->insert_id();
		} elseif ($db_type == 'oracle') {
			$statement="insert into db_details(db_name,db_type,tns,db_class,created_by,created) values(?,?,?,?,?,?)";
			$this->db->query($statement,array($db_name,$db_type,$tns,$db_class,1,now()));
			$dbid=$this->db->insert_id();
		} else {
			print "$db_type is not supported";
			exit;
		}
		$accdetails="insert into db_accounts(db_id,account,short_desc,status,created_by,created) values(?,?,?,?,?,?)";
		
		$this->db->query($accdetails,array($dbid,$account,$description,'ACTIVE',1,now()));
		
		$accid=$this->db->insert_id();
		$lockdet="insert into lockbox (account_id,encrypted_pwd,status,created) values(?,?,?,?)";
		$this->db->query($lockdet, array($accid,$PWD,'ACTIVE',now()));
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
		$this->db->trans_complete();
	}
	
	
}
