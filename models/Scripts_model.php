<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class scripts_model extends CI_Model {
	
    var $column_order = array();
    var $column_search = array();

 
    public function __construct()
    {
        parent::__construct(); 
		$this->tools_db=$this->load->database('default',TRUE); 
    }
 
    function get_datatables($sql)
    {
		$DB1=$this->loaddatabase($this->session->userdata['current_account_id']);
		if (isset($_POST['length'])) {
			if($_POST['length'] != -1)
				$DB1->limit($_POST['length'], $_POST['start']); 
		}

		$query_id=$this->session->userdata['query_id'];
		if (isset($_SESSION['binds'])) {
			$binds=$this->session->userdata['binds'];
			if (isset($binds)) {
				foreach($binds as $bind=>$var) {
					$sql=str_replace(':'.$bind,'?',$sql); 
					$positions=explode(',',$var['positions']);
					foreach ($positions as $var2) {
						$bindvals[$var2]=$binds[$bind]['value'];
					}
				}
			}
		}
		if (isset($bindvals)) {
			$cnt=0;
			foreach ($bindvals as $bind) {
				$bindlist[$cnt]=$bindvals[$cnt];
				$cnt++;
			}
			if (! $query = $DB1->query($sql,$bindlist)) 
				$error=$DB1->error();
		} else {
			if(! $query = $DB1->query($sql))
				$error=$DB1->error();
		}
		$rows=0;
		if (! isset($error)) {
			if (isset($query)) {
				$fields = $query->field_data();		# check data type
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
					$rows++;
				}
			}		
		}
		if ($rows==0) {
			if (isset($error) ) 
				$dataset['error']=$error;
			else
				$dataset['error']='no rows found';
		}
        return $dataset;
    }
	
	function read_clob($field) {
		return $field->read($field->size());
	} 	
	
	function get_query($query_id)
	{
		$sql="select text,query_title,version,query_type,description,format from queries where query_id=?";
		$query=$this->tools_db->query("$sql",array($query_id));
		$row=$query->result_array();
		if (sizeof($row)==0) {
			return 0;
		}
		$data = array(
				'query_id'=>$query_id,
        		'sql' => $row[0]['text'],
        		'title' => $row[0]['query_title'],
        		'version' => $row[0]['version'],
				'query_type' => $row[0]['query_type'],
				'description' => $row[0]['description'],
				'format' => $row[0]['format'],				
        );
		$binds=$this->session->userdata('binds');

		$sql="select bind_name, if(ifnull(alias,'')='',bind_name,alias) alias,positions from query_binds where query_id=? order by bind_order";
		$query=$this->tools_db->query("$sql",array($query_id));
		$bindlist=$query->result_array();

		foreach ($bindlist as $bind) {
			foreach ($bind as $key=>$var) {
				if ($key=='bind_name')
					$bind_name=$var;
				else if ($key=='alias')
				  $binds[$bind_name]['alias']=$var;
				else if ($key=='positions')
					$binds[$bind_name]['positions']=$var;
			}
			if (!isset($binds[$bind_name]['value'])) 
				$binds[$bind_name]['value']='';
		}

	
		$cnt=0;
		if (isset($_SESSION['urivals'])) {
			$urivals=$this->session->userdata['urivals'];
			if ($urivals[sizeof($urivals)-1]=='redo')
				$data['missing_binds']='y';
			$this->session->unset_userdata('urivals');
		}

		if (isset($binds)) {
			foreach ($binds as $bind_name=>$var) {
				if ($binds[$bind_name]['value']=='') {
					if (isset($urivals[$cnt])) {
						$binds[$bind_name]['value']=$urivals[$cnt];
					} else {
						$data['missing_binds']='y';
					}
				}
				$cnt++;
			}
			$data['binds']=$binds;
		}


		$this->session->set_userdata(['binds'=>$binds]);
		
		$sql="select lower(column_name) column_name,position,sortable,searchable,visible,chart_labels_column,chart_label,chart_color,datatype from query_columns where query_id=? order by position";
		$query=$this->tools_db->query("$sql",array($query_id));
		$data['columns']=$query->result_array();

		$sql="select a.column_id,lower(column_name) column_name ,
		c.action_id,label,value,bgcolor,fontcolor,equality,link_id,
		comparison_type,position from query_columns a, actions b, column_actions c 
		where a.column_id=c.column_id and b.action_id=c.action_id and query_id=?";
		$query=$this->tools_db->query("$sql",array($query_id));
		$cnt=0;
		$actions=[];
		foreach ($query->result_array() as $row) {
			$actions[$row['column_name']]=$row;
			$cnt++;
		}
		$data['actions']=$actions;
		
		$sql="select link_id, label,link_type,linkstr,target_id from links where link_id in (select a.link_id from query_columns c, column_actions ca, actions a where c.query_id=? and c.column_id=ca.column_id and ca.action_id=a.action_id) order by link_id";
        $query = $this->db->query($sql,array($query_id));
		$result=$query->result_array();
		$links=[];
		foreach ($result as $row) {
			$links[$row['link_id']]=$row;
		}
		$data['links']=$links;

		$sql="select l.link_id,l.linkstr,kp.name,kp.type,kp.parameter,
kp.literal_value, kp.column_name 
from links l, link_keys lk ,key_pairs kp 
where l.link_id=lk.link_id
and lk.key_id=kp.key_id 
and l.link_id in (
select a.link_id from query_columns c, column_actions ca, actions a where c.query_id=? and c.column_id=ca.column_id 
and ca.action_id=a.action_id)
order by l.link_id, kp.position";
        $query = $this->db->query($sql,array($query_id));
		$data['key_pairs']=$query->result_array();		
		return  $data;
	}	
	
	function add_menu_item($toMenu,$newItem) {
		$sql="select m.menu_id, max(priority) priority,menu_type from menus m, menu_items mi where m.menu_id=mi.menu_id and menu_name=? group by menu_id,menu_type";
		$query = $this->db->query($sql,array($toMenu));
		$results1=$query->result_array();	
		$sql="select max(query_id) query_id from queries where query_title=? and version=(select max(version) from queries where query_title=? and status='active') and status='active'";		
		
		$query = $this->db->query($sql,array($newItem,$newItem));
		$results2=$query->result_array();	
		$sql="select link_id from links where link_type='query' and target_id=?";		
		$query = $this->db->query($sql,array($results2[0]['query_id']));
		$results=$query->result_array();
		if ($query->num_rows() > 0) {
			$link_id=$results[0]['link_id'];
		} else {
			echo "link is missing for query ".$results2[0]['query_id']."<br>";
		}
		$sql="insert into menu_items (menu_id,text,priority,link_id,class,status) values (?,?,?,?,?,'active')";
		$query = $this->db->query($sql,array($results1[0]['menu_id'],$newItem,(int)(($results1[0]['priority'])+5),$link_id,$results1[0]['menu_type']));
	}

	function loaddatabase($accountid)
    {
     	$sqlr="select account,db_name,db_type,hostname,encrypted_pwd, tns FROM db_accounts a,db_details d,lockbox l where a.db_id=d.db_id and a.account_id=l.account_id and a.account_id=?";
     	//echo $sqlr.'</br>' ;
     	$query = $this->db->query($sqlr,array($accountid));
     	$row=$query->result_array();
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
}


