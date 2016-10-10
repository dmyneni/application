<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class createquery extends CI_Controller
{

     public function __construct()
     {
          parent::__construct();
          $this->load->library('session');
          $this->load->model('menu_model');
          
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->helper('html');
          $this->load->database();
          $this->load->library('form_validation');
         $this->load->model('createquery_model');
         $this->load->model('addaction_model');
        }
      public function index()
     {
          //get the posted values
     	  if ($this->session->userdata('username')=='') {
			  redirect('login');
		  }
     	  $this->session->set_flashdata('status', '<span class="text-success"></span>');
          $sqltext = $this->input->post("txt_script");
		  $bindcnt=0;

		  foreach ($_POST as $key=>$val) {  # set bind values provided in the form
			  if (strpos($key, "ind_") != false ) { 
				$var=explode("_",$key);
				if ($var[1]=='name') {
					$bind=$val;
					$bindcnt++;
				} elseif ($var[1]=='value' ){
					$binds[trim($bind)][$var[1]]=$val;	
					if (is_numeric($val)) {
						$binds[trim($bind)]['type']='number';
					} else {
						$binds[trim($bind)]['type']='string';
					}
				} elseif ($var[1]=='alias' ){
					$binds[trim($bind)][$var[1]]=$val;
				} elseif ($var[1]=='positions' ){
					$binds[trim($bind)][$var[1]]=$val;
				}
			  }
		  }

		  $this->session->unset_userdata('binds');
		  if ($bindcnt > 0 )  #  Overwrite any previously tested bind values
			  $this->session->set_userdata(['binds'=>$binds]);	  			  

          $this->form_validation->set_rules("txt_script", "Script", "trim|required");
		  $this->form_validation->set_rules("txt_title", "Title", "trim|required");
          $this->form_validation->set_value("status","");
	      $headerdata=$this->menu_model->buildmenu($this->session->userdata('menu_id'),$this->session->userdata('menu_item_id'));
	      $this->load->view('templates/header',$headerdata);
     
		  if ($this->uri->segment(3)) {  # segment 3 is query_id
			  	$query_id = $this->uri->segment(3);
				$this->session->set_userdata(['query_id'=>$query_id]);	
		  } else {
			  if ($this->input->post('btn_validate') != "Validate") {
				$this->session->unset_userdata('query_id');		
			  }
		  }
			  if ($this->session->userdata('query_id')) {
					$data['query']=$this->createquery_model->get_query($this->session->userdata('query_id'));
					if (!isset($binds)) {  # not provided in post
						$data['binds']=$this->createquery_model->get_binds($this->session->userdata('query_id'));							
					} else {
						$data['binds']=$binds;
					}
				
					$data['query_id']=$this->session->userdata('query_id');
					$data['title']='Edit Query';
					$data['validate_failed']=0;
			  } else {
					$data['query']=['query_title'=>'','version'=>'','description'=>'','text'=>''];
					$data['query_id']='';
					$data['title']='Create Query';
					$data['validate_failed']=0;
			  }		
		  if ($this->form_validation->run() == FALSE) {
			  $data['validate_failed']=1;			  
			  $this->load->view('createquery_view',$data);			
          } else if ($this->input->post('btn_create') == "Create" || $this->input->post('btn_create') == "Update" ) {
			$db_type=$this->createquery_model->get_db_type($this->session->userdata('current_account_id'));
			
			$version=$this->input->post("txt_version");

			if($version=="") {
				$version=1.0;
			} else {
				print "version=$version<br>";
				$ver=explode('.',$version);
				$seg=sizeof($ver);
				print "seg=$seg<br>";
				if ($seg==1) {
					$ver[1]=0;
					$seg++;
				}
				$ver[$seg-1]++;
				$cnt=0;
				$version='';
				foreach ($ver as $var){
					print "var=$var<br>";
					if ($cnt>0) $version.='.';
					$version.="$var";
					$cnt++;
				}
				print "version=$version<br>";
				exit;
			}
			print "version=$version<br>";
			$query_id=$this->createquery_model->insertdetails($this->input->post("txt_title"), $this->input->post("txt_description"), $db_type,$sqltext,$version);
			#$this->session->set_userdata('query_id'=>$query_id);
			$data['query_id']=$query_id;
			$data['title']='Edit Query';

			$this->form_validation->set_value("status","Successfully created");
			$this->session->set_flashdata('status', '<span class="text-success">Successfully created</span>');
			$this->load->view('createquery_view',$data);          
		  }else if ($this->input->post('btn_validate') == "Validate") {	
			if ($binds=$this->createquery_model->list_binds($sqltext)) {
				foreach ($binds as $bind=>$var) {
					if (!isset($var['value'])) 
						$missing_binds='y';
				}
				$data['binds']=$binds;	
				if (isset($missing_binds)) {
					$data['validate_failed']=1;
					$this->session->set_flashdata('status', '<span class="text-danger">Provide testing values</span>');
					$this->load->view('createquery_view',$data);
				} else {
					$testresult=$this->createquery_model->validatequery($sqltext,$binds);
				}

			} else {
				$testresult=$this->createquery_model->validatequery($sqltext,null);
			}		
				if (isset($testresult)) {
					if(sizeof($testresult)==1)
					{
						$error=$testresult['error'];
						$this->session->set_flashdata('status', '<span class="text-danger">'.$error['message'].'</span>');
						$data['validate_failed']=1;
						$this->load->view('createquery_view',$data);
					}else
					{
						$this->session->set_flashdata('status', '<span class="text-success">Review the output below and then save the changes.</span>');
						$data['validate_failed']=0;
						$this->load->view('createquery_view',$data);
						$this->load->view('templates/testresults',$testresult);
					}
				}
                    
               }
               else if ($this->input->post('btn_action') == "Add Action")
			   {
                   $dataset=["columdet"=>$this->addaction_model->getColums($this->input->post("txt_queryid")),"query_id"=>$this->input->post("txt_queryid")];
                   $this->load->view('manageaction_view',$dataset);
              }
                    
 
     }
}
?>
