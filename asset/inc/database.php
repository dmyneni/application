<?php

function conn_repo_db() {
	$mysqli = new mysqli("localhost", "tools", "Tools1234567890!", "toolbox");
	if ($mysqli->connect_error) {
		die('Connect Error: ' . $mysqli->connect_error);
	}

return $mysqli;
}

function get_menu($repo) {

	$sql="select m.menu_id,menu_name,menu_item_id,text menu_item, linkstr, target_id, icon
	from menus m left join menu_items mi 
	on m.menu_id=mi.menu_id 
	left join links l on mi.link_id=l.link_id
	order by m.priority,mi.priority";

	if ($result = $repo->query($sql)) {

		/* fetch associative array */
		$p_menu_id='';
		$nav=[];
		while ($row = $result->fetch_assoc()) {
			if ($row['menu_id'] != $p_menu_id){
				if ($p_menu_id != '') 
					$nav[$p_menu_id]['sub']=$sub;
				$sub=[];			
				if($row['menu_item_id']) {
					$sub[$row['menu_item_id']]=array('title'=>$row['menu_item'],'url'=>base_url().'index.php/'.$row['linkstr'].'/index/'.$row['target_id']);
				}
				$nav[$row['menu_id']]=array('title'=>$row['menu_name'],'icon'=>$row['icon']);
				$p_menu_id=$row['menu_id'];
			} else {
				$sub[$row['menu_item_id']]=array('title'=>$row['menu_item'],'url'=>base_url().'index.php/'.$row['linkstr'].'/index/'.$row['target_id']);
			}
		}
		/* free result set */
		$result->free();
		return $nav;
	}
}

	function get_query($repo,$query_id)
	{
		$sql="select text,query_title,version,query_type,description,format from queries where query_id=?";
		$stmt=$repo->prepare("$sql");
		if(mysqli_error($repo)) {
			return array('error'=>mysqli_error($repo));
		}
		$stmt->bind_param('d',$query_id);
		$stmt->execute();
		$res=$stmt->get_result();
		$row=$res->fetch_array(MYSQLI_ASSOC);
		if (sizeof($row)==0) {
			return array('error'=>"Query ID $query_id was not found");
		} else {
			$query = array(
					'query_id'=>$query_id,
					'sql' => $row['text'],
					'title' => $row['query_title'],
					'version' => $row['version'],
					'query_type' => $row['query_type'],
					'description' => $row['description'],
					'format' => $row['format'],				
			);
			$data['query']=$query;
			if (isset($_SESSION['binds']))
				$binds=$_SESSION['binds'];

			$sql="select bind_name, if(ifnull(alias,'')='',bind_name,alias) alias,positions from query_binds where query_id=? order by bind_order";
			$stmt=$repo->prepare("$sql");
			if(mysqli_error($repo)) {
				return array('error'=>mysqli_error($repo));
			}
			$stmt->bind_param('d',$query_id);
			$stmt->execute();
			$res=$stmt->get_result();
			$row=$res->fetch_array(MYSQLI_ASSOC);
			if (sizeof($row)==0) {
				$binds=[];
			} else {
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
			}
		}
	
		$cnt=0;
		if (isset($_SESSION['urivals'])) {
			$urivals=$_SESSION['urivals'];
			if ($urivals[sizeof($urivals)-1]=='redo')
				$data['missing_binds']='y';
			unset($_SESSION['urivals']);
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

		$sql="select lower(column_name) column_name,position,sortable,searchable,visible,chart_labels_column,chart_label,chart_color,datatype from query_columns where query_id=? order by position";
		$stmt=$repo->prepare("$sql");
		if(mysqli_error($repo)) {
			return array('error'=>mysqli_error($repo));
		}
		$stmt->bind_param('d',$query_id);
		$stmt->execute();
		$res=$stmt->get_result();
		$columns=[];
		while ($row=$res->fetch_array(MYSQLI_ASSOC))
			array_push($columns,$row);		
		$data['columns']=$columns;

		$sql="select a.column_id,lower(column_name) column_name ,
		c.action_id,label,value,bgcolor,fontcolor,equality,link_id,
		comparison_type,position from query_columns a, actions b, column_actions c 
		where a.column_id=c.column_id and b.action_id=c.action_id and query_id=?";
		$stmt=$repo->prepare("$sql");
		if(mysqli_error($repo)) {
			return array('error'=>mysqli_error($repo));
		}
		$stmt->bind_param('d',$query_id);
		$stmt->execute();
		$res=$stmt->get_result();
		$actions=[];
		while ($row=$res->fetch_array(MYSQLI_ASSOC))
			$actions[$row['column_name']]=$row;
		$data['actions']=$actions;

		$sql="select link_id, label,link_type,linkstr,target_id from links where link_id in (select a.link_id from query_columns c, column_actions ca, actions a where c.query_id=? and c.column_id=ca.column_id and ca.action_id=a.action_id) order by link_id";
		$stmt=$repo->prepare("$sql");
		if(mysqli_error($repo)) {
			return array('error'=>mysqli_error($repo));
		}
		$stmt->bind_param('d',$query_id);
		$stmt->execute();
		$res=$stmt->get_result();
		$links=[];
		while ($row=$res->fetch_array(MYSQLI_ASSOC))
			array_push($links,$row);		
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
		$stmt=$repo->prepare("$sql");
		if(mysqli_error($repo)) {
			return array('error'=>mysqli_error($repo));
		}
		$stmt->bind_param('d',$query_id);
		$stmt->execute();
		$res=$stmt->get_result();
		$key_pairs=[];
		while ($row=$res->fetch_array(MYSQLI_ASSOC))
			array_push($key_pairs,$row);		
		$data['key_pairs']=$key_pairs;
		return  $data;
	}	
	
	function get_datatables($conn,$sql)
    {
		if (isset($_POST['length'])) {
			if($_POST['length'] != -1)
				$conn->limit($_POST['length'], $_POST['start']); 
		}

		if (isset($_SESSION['binds'])) { 
			$binds=$_SESSION['binds'];
			
/*			foreach($binds as $bind=>$var) {  # bind not named
				$sql=str_replace(':'.$bind,'?',$sql); 
				$positions=explode(',',$var['positions']);
				foreach ($positions as $var2) {
					$bindvals[$var2]=$binds[$bind]['value'];
				}
			}
		}
		
		if (isset($bindvals)) {
			$cnt=0;
			foreach ($bindvals as $bind) {
				$bindlist[$cnt]=$bindvals[$cnt];
				$cnt++;
			}
*/
		} else 
			$binds=[];
		$stid = oci_parse($conn, $sql);
		foreach ($binds as $key=>$val) 	# named binds for oci
			oci_bind_by_name($stid, $key, $binds[$key]);

		if (! oci_execute($stid)) { 
			$data['error']==oci_error($stid);
			return $data;
		}
		$table_data=[];
		$rows=0;
		while(($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			array_push($table_data,$row);
			$rows++;
		}

/*		$rows=0;
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
*/
		if ($rows==0) {
			if (isset($error) ) 
				$table_data['error']=$error;
			else
				$table_data['error']='no rows found';
		}
        return $table_data;
    }
	
	function read_clob($field) {
		return $field->read($field->size());
	}
	
function connect_target($repo,$account_id) {
	
	$sql="select account,db_name,db_type,hostname,encrypted_pwd, tns FROM db_accounts a,db_details d,lockbox l where a.db_id=d.db_id and a.account_id=l.account_id and a.account_id=?";	
	$stmt=$repo->prepare("$sql");
	if(mysqli_error($repo)) {
		return array('error'=>mysqli_error($repo));
	}
	$stmt->bind_param('d',$account_id);
	$stmt->execute();
	$res=$stmt->get_result();
	$row=$res->fetch_array(MYSQLI_ASSOC);

	if ($row['db_type']=='oracle')	
		$conn = oci_connect($row['account'], $row['encrypted_pwd'], $row['tns']);
	
	return $conn;
}


?>

