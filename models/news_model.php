<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class news_model extends CI_Model
{
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
          $this->load->helper('date');
     }
          
     
     function addnews($headline,$category,$details,$sdate,$edate,$user_id,$curtimestamp)
     {
     	$news=array(
     	
     			'headline'=>$headline,
     			'category'=>$category,
     			'details'=>$details,
     			'start_time'=>$sdate,
     			'end_time'=>$edate,
     			'created_by'=>$user_id,
     			'created'=>$curtimestamp
     	);
     	$this->db->insert('news', $news);
     	$menuid=$this->db->insert_id();
     	return $menuid;
     }
     
     function getnews()
     {
     	$datestring = '%Y-%m-%d 00:00:00';
     	$time = now("America/Chicago");
     	$curtimestamp=mdate($datestring, $time);
     	//echo "select headline,details from news where start_time>='".$curtimestamp."'";
     	$query =$this->db->query("select headline,details from news where start_time>='".$curtimestamp."'");
     	return $query->result_array();
     }
     

}