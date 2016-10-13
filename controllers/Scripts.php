<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class scripts extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
        $this->load->model('scripts_model');
		$this->load->model('menu_model');
        $this->load->helper('form');		
        $this->load->helper('url');
		$this->load->database();
	}
 
    public function index()
    {
		$user_id=$this->session->userdata('user_id');
		$username=$this->session->userdata('username');
		if ($this->session->userdata('username')=='') redirect('login');
        $headerdata=$this->menu_model->buildmenu();
		$this->session->unset_userdata('query_id');
		if ($this->uri->segment(3)) {		
			$query_id = $this->uri->segment(3);
			$this->session->unset_userdata('binds');
			$cnt=4;
			while ($seg=$this->uri->segment($cnt)) {
				$urivals[$cnt-4]=$seg;
				$cnt++;
			}
			if (isset($urivals)) 
				$this->session->set_userdata(['urivals'=>$urivals]);
			else {
				$this->session->unset_userdata('urivals');
			}
			$this->session->set_userdata(['query_id'=>$query_id]);
		} else {
			if ($this->input->post('btn_action') == "Query") {
				$query_id=$this->input->post('query_id');
				$this->session->set_userdata(['query_id'=>$query_id]);

				  foreach ($_POST as $key=>$val) {
					  if (strpos($key, "ind_") != false ) { # any name like bind...
						$var=explode("_",$key);
						if ($var[1]=='name') {
							$bind=$val;
						} elseif ($var[1]=='value' ){
							$binds[trim($bind)][$var[1]]=$val;	
						}
					  }
				  }
				  $this->session->set_userdata(['binds'=>$binds]);
			}
		}
		
		$this->load->view('templates/header',$headerdata);	
		if (!isset($query_id)) {
			$errmsg=array('errmsg'=>"No query has been selected");
			$this->load->view('errors_view',$errmsg);
		} else {
			$dataset=$this->scripts_model->get_query($query_id); 

			if ($dataset==0) {
				$errmsg=array('errmsg'=>"Couldn't find script ID $query_id");
				$this->load->view('errors_view',$errmsg);
			} else {
					if (isset($dataset['binds']))
						$binds=$dataset['binds'];
					if (isset($binds)) {
						$session_binds=$this->session->userdata('binds');
						foreach ($binds as $bind=>$var) {
							if (!isset($session_binds[$bind]['value'])) 
								$dataset['missing_binds']='y';
						}
						$dataset['binds']=$binds;
						if (isset($data['missing_binds'])) {
							$this->session->set_flashdata('status', '<span class="text-danger">Provide bind values</span>');
						}
						
					}					
					if ($dataset['format'] == 'row') {
						$this->load->view('scripts_row_view',$dataset);
					} else {
						$this->load->view('scripts_table_view',$dataset);							
					}
			}
		}
		$this->load->view('templates/footer');	
    }
 
    public function ajax_list()
    {
		$query_id=$this->session->userdata('query_id');
		$results=$this->scripts_model->get_query($query_id);

		$sql=$results['sql'];

		$title=$results['title'];
		$format=$results['format'];
		if (isset($results['binds'])) 
			$list = $this->scripts_model->get_datatables($sql,$results['binds']);
		else 
			$list = $this->scripts_model->get_datatables($sql);	
		if (! isset($list['error'])) {
			if (isset($_POST['start'])) {
				$no = $_POST['start'];
			} else {
				$no=1;
			}
			$data = array();
			if (isset($_POST['draw'])) {
				$draw=$_POST['draw'];
			} else {
				$draw=1;
			}
			if ($format != 'row') {
				foreach ($list as $script) {
					$no++;
					$row = array();
					foreach ($script as $key=>$val)
					{
						$row[] = $val;
					}
					$data[] = $row;
				}
			} else {  // one row
				foreach ($list[0] as $key=>$val) {
					$no++;
					$data[]=array($key,$val);
				}

			}
			$all_rows=count($list);

			$cnt=sizeof($data);
			$output = array(
				"draw" => $draw,
				"title" => $title,
				"recordsFiltered" => $cnt,
				"recordsTotal" => $cnt,
				"data" => $data
			);
		} else {
			$output=$list;
		}
        echo json_encode($output);
    }
 
 	public function ajax_about($query_id)
    {
        $data = array(
			'query_details' => $this->script->get_query($query_id),
			'actions' => $this->script->get_actions($query_id),
			'links' => $this->script->get_links($query_id)
        );
        echo json_encode($data);
    }
	
	public function ajax_chg_menu($new_item,$to_menu) {
		$result=$this->scripts_model->add_menu_item(urldecode($to_menu),urldecode($new_item));
	}
	
}