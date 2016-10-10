<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class createquery_model extends CI_Model
{
 
     function __construct()
     {
          // Call the Model constructor
          parent::__construct();
          $this->load->helper('date');		 
		  $this->tools_db=$this->load->database('default',TRUE);   
     }

     function insertdetails($title, $description, $query_type,$sql,$version)
     {
     	$data=array(
     			'query_title'=>$title,
     			'version'=>$version,
     			'description'=>$description,
     			'text'=>$sql,
     			'status'=>'active',
				'query_type'=>$query_type,
     			'created'=>'now()'
     	);
     	$this->db->insert('queries', $data);
		$query_id=$this->db->insert_id();
     	$this->insertcolumns($query_id);
        return 	$query_id;
     }
     
     function insertcolumns($query_id)
     {	
//	    $DB1=$this->loaddatabase($this->session->userdata['current_account_id']);
		
     	$counter=1;
     	foreach($this->session->userdata['fields'] as $field)
     	{
     		$colarray=array('query_id'=> $query_id,
     				'column_name'=>$field->name,
					'datatype'=>$field->type,
					'max_length'=>$field->max_length,	
     				'visible'=>'true',
					'sortable'=>'true',
					'searchable'=>'true',
     				'status'=>'active',
     				'position'=>$counter
     		);
     		$counter=$counter+1;
     		$this->db->insert('query_columns', $colarray);
     	}

     	$counter=1;
		if ($this->session->userdata['binds']) {
			foreach($this->session->userdata['binds'] as $key=>$vals)
			{
				$bindarray=array('query_id'=> $query_id,
						'bind_name'=>$key,
						'alias'=>$vals['alias'],
						'bind_order'=>$counter,
						'bind_type'=>$vals['type'],
						'positions'=>$vals['positions']
				);
				$counter++;
				$this->db->insert('query_binds', $bindarray);
			}		
		}
     }

     function get_query($query_id)
     {	
		$sql="select query_id,query_title,version,description,text,status from queries where query_id=?";
		$query=$this->db->query($sql,array($query_id));
		return $query->result_array()[0];
     }
	 
     function get_binds($query_id)
     {	
		$sql="select bind_name, if(ifnull(alias,'')='',bind_name,alias) alias,positions from query_binds where query_id=? order by bind_order";
		$query=$this->db->query("$sql",array($query_id));
		$bindlist=$query->result_array();

		$binds=[];
		foreach ($bindlist as $bind) {
			foreach ($bind as $key=>$var) {
				if ($key=='bind_name')
					$bind_name=$var;
				else if ($key=='alias')
				  $binds[$bind_name]['alias']=$var;
				else if ($key=='positions')
					$binds[$bind_name]['positions']=$var;
			}
			$binds[$bind_name]['value']='';
		}
		return $binds;
     }	 
	 
	 function get_db_type($account_id)
     {	
		$sql="select db_type from db_accounts a, db_details b where a.db_id=b.db_id and account_id=?";
		$query=$this->db->query($sql,array($account_id));
		return $query->result_array()[0]['db_type'];
     }
     
     function validatequery($sql,$binds)
     {
		 $bindvals=[];
		 $bindlist=[];
		 if (isset($binds)) {
			foreach($binds as $bind=>$var) {
				$sql=str_replace(':'.$bind,'?',$sql); 
				$positions=explode(',',$var['positions']);
				foreach ($positions as $var2) {
					$bindvals[$var2]=$var['value'];
				}
			}
		 }
		 $cnt=0;
		 foreach ($bindvals as $var=>$value) {
			 $bindlist[]=$bindvals[$cnt];
			 $cnt++;
		 }
     	$DB1=$this->loaddatabase($this->session->userdata['current_account_id']);
		if (isset($bindvals)) {
			if (! $query = $DB1->query($sql,$bindlist)) {
				$error=$DB1->error();
				$data['error']= $error; // Has keys 'code', 'message' and 'offset'
			}
		} else {
			if (! $query = $DB1->query($sql)) {
				$error=$DB1->error();
				$data['error']= $error['error']; // Has keys 'code', 'message' and 'offset'
			}
		}
		if ($query) {
			$fields = $query->field_data();		
			while ($results=$query->unbuffered_row()) {
				$cnt=0;
				foreach ($results as $val) {
					if ($fields[$cnt]->type=='CLOB') {
						$row[$fields[$cnt]->name]=$this->read_clob($val);
					} else {
						$row[$fields[$cnt]->name]=$val;
					}
					$cnt++;
				}
				$dataset[]=$row;		
			}


			$this->session->set_userdata(['fields'=>$query->field_data()]);
			$data['header']=$query->list_fields();
			if (isset($dataset)) 
				$data['dataset']=$dataset;

     	}
     	$DB1->close();
     	return $data;
     }
 
function read_clob($field) {
    return $field->read($field->size());
} 
     
     function loaddatabase($accountid)
     {
     	$sql="select account,db_name,db_type,hostname,encrypted_pwd, tns FROM db_accounts a,db_details d,lockbox l where a.db_id=d.db_id and a.account_id=l.account_id and a.account_id=?";
     	//echo $sql.'</br>' ;
     	$query = $this->db->query($sql,array($accountid));
     	$row=$query->result_array();
		if ($query->num_rows() == 0) {
			print "no rows found for DB account_id=$accountid<br>";
			exit;
		}
		if ($row[0]['db_type'] == 'mysql') {
     	   $dsn = 'mysqli://'.$row[0]['account'].':'.$row[0]['encrypted_pwd'].'@'.$row[0]['hostname'].'/'.$row[0]['db_name'];
     	   $DB1 = $this->load->database($dsn, TRUE);
		} elseif ($row[0]['db_type'] == 'oracle') {
			$config['hostname'] = $row[0]['tns'];
			$config['username'] = $row[0]['account'];
			$config['password'] = $row[0]['encrypted_pwd'];
			$config['database'] = $row[0]['db_name'];
			$config['dbdriver'] = "oci8";

			$DB1=$this->load->database($config,TRUE);
		
		}
     	return $DB1;	
     }
	
function list_binds($sql) {	
	$sql.=' ';
	$segments = preg_split('/".*?"|\'.*?\'/', $sql);
	$x=sizeof($segments);
	if (isset($_SESSION['query_id'])) 
		$id=$this->session->userdata['query_id'];
	else 
		$id='new';
	if (isset($_SESSION['binds'])) {
		$binds=$this->session->userdata['binds'];
		foreach ($binds as $key=>$var) {
			$binds[$key]['positions']='';  // reset location, but retain other data that may have been entered for a bind alias or value
		}
	}
	if ($x > 0) {
		$cnt=0;
		foreach ($segments as $var) {
			while (preg_match_all('/:([^#]+?) /', $var, $matches)) {			
				$var=str_replace(':',' ',$var);
				foreach ($matches[1] as $var2) {
					if (!isset($binds[$var2])) {
						$binds[$var2]='';
						$binds[$var2]['value']=null;
						$binds[$var2]['alias']='';
						$binds[$var2]['positions']='';
						$binds[$var2]['type']='number';
					}
					if (strlen($binds[$var2]['positions'])>0) 
						$binds[$var2]['positions'] .=",";
					$binds[$var2]['positions'] .="$cnt";					
					$cnt++;
				}										
			}
		}
		if ($cnt==0) return false;
	}
	return $binds;
}
}

