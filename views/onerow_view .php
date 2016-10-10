    <div class="container">
		<?php 
				$counter=0;
				if (sizeof($bindlist)) {
					if ($missing_binds=='y') {
					$attributes = array("class" => "form-horizontal", "id" => "binds", "name" => "binds");
					echo form_open("/scripts/index", $attributes);?>
					<div class="col-md-8">
					<div class="row colbox">
					<div class="col-md-6 center h3"><?php echo $title; ?></div></div>
					<input type=hidden name=query_id value=<?php echo $query_id?>>
					<?php 
					foreach($bindlist as $bind) { 
					?>
					   <div class="form-group">
					   <div class="row colbox">
					   <div class="control-label col-md-4">
					   <label for="txt_script" class="control-label"><?php echo $bindalias[$bind];?></label><input type=hidden name=<?php $bind_name='bind_name_'.$counter; echo $bind_name ?> value="<?php echo $bind; ?> "/>
					   </div>
					   <div class="col-lg-3 col-sm-3">
							<input class="form-control" id="<?php $bind_name='bind_value_'.$counter; echo $bind;?>" name="<?php echo 'bind_value_'.$counter;?>" placeholder="test value" type="text" value="<?php 
							if (isset($bindvals[$counter])) {
								echo $bindvals[$counter]; 
							} else {
								echo "";
							}
							?>" />
					   </div>					   
					   </div>			   
					<?php 
					   echo form_close(); 
					   $counter++;
					   ?>
					   </div>
					   <?php
					}	
				}
				}
				if ($counter > 0) { ?>
					<div class="form-group">
					   <div class="col-lg-12 col-sm-12 text-center">
							<input type="hidden" name="txt_queryid" id="txt_queryid" value="<?php echo $query_id;?>">
							<input id="btn_action" name="btn_action" type="submit" class="btn btn-default" value="Query" />
							<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default" value="Cancel" />
					   </div>
					</div>		
				<?php } else { ?>
				<div class="col-md-8">
				<div><div class="col-md-8" pull-right><a href="<?php echo base_url()?>index.php/explain/index/<?php echo $query_id; ?>"> Explain</a></div>					
				<div class="col-md-2"><button class="btn btn-default pull-right" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button></div>		<div class="col-md-2"><button class="btn btn-default pull-right" onclick="goBack()"><i class="glyphicon glyphicon-step-backward"></i> Go Back</button></div>	</div>
		<div class="col-md-12 text-center h3"><?php echo $title; ?></div>
        <table id="table" class="table table-striped table-bordered" "pull-left">
            <thead>
                <tr>
				<?php
					foreach ($columns as $column)
					{
						echo "<th>$column[column_name]</th>";
                    }
				?>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
		</div>
		<div class ="col-md-4" "pull-right">
		  <div>
			<canvas id="myChart"  width="200" height="200"></canvas>
		  </div>
		</div>
				<?php } ?>
		</div>
    </div>


<script src="<?php echo base_url()?>application/assets/jquery/Chart.js"></script>
<script src="<?php echo base_url()?>application/assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>application/assets/datatables/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url()?>application/assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>application/assets/datatables/css/datatables.min.css"/> 


<script type="text/javascript">
 
var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 
        "processing": true, //Feature control the processing indicator.
        "serverSide": false, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
		//"bInfo": false,
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url()?>index.php/scripts/ajax_list",
			type: "POST"
        },
 
        //Set column definition initialization properties.
       "columnDefs": [
        { 

  
<?php
	
$position_list='';
foreach ($actions as $action) {
				$position_list.=(string)($action['position']-1).',';
				if (isset($action['link_id'])) $has_one=1 ;
}

if (isset($has_one)) { // not needed otherwise
	$cnt=0;
	foreach ($columns as $column) {
		$column_position{$column['column_name']}=$cnt;
		$cnt++;
	}	
}
?>
            "targets": [ <?php echo $position_list ?>], 
			"createdCell": function (td, cellData, rowData, row, col) {
<?php foreach ($actions as $action) {
				$position=$action['position']-1;
				$value=$action['value'];
				$equality=$action['equality'];
				$bgcolor=$action['bgcolor'];
				$fontcolor=$action['fontcolor'];
				$comparison_type=$action['comparison_type'];
				$link_id=$action['link_id'];
				?>
				if (test_action(cellData,<?php echo "'$value','$equality','$comparison_type'" ?> )) {
					<?php if ($bgcolor) { ?>
						$(td).css('background','<?php echo $bgcolor; ?>')
					<?php }
					if ($fontcolor) { ?>
						$(td).css('color','<?php echo $fontcolor; ?>')				
					<?php } 
					if ($link_id) {  ?>
						 $(td).html('<?php print "<a href=\"".base_url()."index.php/scripts/index/".$links[$link_id]['linkstr']."'";
						 foreach ($key_pairs as $key) {
							 if ($key['type']=='session') {
								 print "/".$$this->session->$parameter;
							 } elseif ($key['type']=='column') { 
								 print '+\'/\'+rowData['.$column_position[$key['column_name']].']';
							 }
						 } 
						 print '+\'"  title="'.$links[$link_id]['label'].'">\'+cellData+\'</a>\')
';
					} ?>
				}
				<?php		} ?>	
			},

		}
		],

		  "columns": [
		  <?php 
		  $cnt=0;
		  foreach ($columns as $column) {
			  $cnt++;
				if ($cnt != $column['position']) continue;
				$sortable=$column['sortable'];
				$searchable=$column['searchable'];
				$visible=$column['visible'];
			   ?>
		{ "orderable": <?php echo $sortable; ?>,
		"searchable":<?php echo $searchable; ?>,
		"visible":<?php echo $visible; ?>
		},
		  <?php } ?>
  ],
		"initComplete": function(settings,json) {
		<?php 
		  $cnt=0;$cnt2=0;
		  foreach ($columns as $column) {
			  if ($column['chart_labels_column'] == true ) {
				echo "labeldata=table.column(".$cnt.").data().toArray(),
				";
				$chart=true;
			  } elseif ($column['chart_color']) {
				echo "chartdata".$cnt2."=table.column(".$cnt.").data().toArray(),
				";
				$cnt2++;
			  }
			  $cnt++;
		  }
		  if ($cnt>0) { 
			echo "drawChart();
			";
		  } ?>
		  
		},
    });
		


});
		
		
function drawChart() {		
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
		labels: labeldata,
        datasets: [
		<?php 
		  $cnt=0;
		  foreach ($columns as $column) {
			  if ($column['chart_color']) {
print "      {
	        label: '".$column['chart_label']."',
			fill: false,
			borderColor: '".$column['chart_color']."',
			borderWidth: 1,
		  data: chartdata".$cnt."},
		  ";
		  $cnt++;
		  }
		}?>
		]
    }
});
	$('#myChart').on('click', function(evt){		
			var activePoints = myChart.getElementAtEvent(evt);
			var datasetIndex = activePoints[0]._datasetIndex;
			var index = activePoints[0]._index;
			table.search(myChart.tooltip._data.labels[index]).draw();
		}
	);

}


function test_action(data,val,eq,comptype)
{
		if (comptype == 'numeric') {
			val=Number(val);
			data=Number(data);
		}
		if (comptype == 'string') {
			val=String(val);
			data=String(val);
			if (eq == 'like') {
				if (val === data) {
					return true;
				}
			}
		}

		if (eq == 'eq') {
			if (val === data) {
				return true;
			}
		} else if (eq == 'lt') {
			if (data < val) {
				return true;
			}
		} else if (eq == 'gt') {
			if (data > val) {
				return true;
			}
		} else if ( eq == 'ne') {
			if (data != val) {
				return true;
			}
		}
		return false;
}


		
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
function goBack() {
    window.history.back();
}
				
</script>
