    <div class="container">
		<?php 
			$counter=0;
			if ($this->session->userdata('binds')) {
				$binds=$this->session->userdata('binds');
				if (isset($missing_binds)) {
					$attributes = array("class" => "form-horizontal", "id" => "binds", "name" => "binds");
					echo form_open("/scripts/index", $attributes);?>
					<div class="col-md-8">
					<div class="row colbox">
					<div class="col-md-6 center h3"><?php echo $title; ?></div>
					</div>
					<input type=hidden name=query_id value=<?php echo $query_id?>>
					<?php 
					if (isset($binds)) {
					$counter=0;
					$display_binds='';					
					foreach($binds as $key=>$var) { 
						if ($counter > 0) $display_binds.=', ';
						$display_binds.='<b>'.$binds[$key]['alias'].':</b> '.$binds[$key]['value'];
						$counter++;
					}
					print "$display_binds";
					?>
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
				<div class="col-md-12 text-center"><?php 
				$counter=0;
				$binds='';
/*				foreach($bindvals as $bind) { 
					if ($counter > 0) $binds.=', ';
					$binds.='<b>'.$bindalias[$bind].':</b>'.$bind[value];
					$counter++;
				}*/
				print "$binds";
				?>
				</div>
			<table id="table" class="table table-striped table-bordered" "pull-left">
				<thead>
					<tr><th>Column Name</th><th>Value</th></tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
				<?php } ?>
		</div>
    </div>

<script src="<?php echo base_url()?>application/assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>application/assets/datatables/js/dataTables.bootstrap.js"></script>
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
            "targets": [ 0,1 ], 
			"createdCell": function (td, cellData, rowData, row, col) {
				if (col == 0) { 
					$(td).css('background','#eeeeee')
					$(td).css('color','#000000')
				} else {
					<?php foreach ($actions as $action) {
					$position=$action['position']-1;
					$value=$action['value'];
					$equality=$action['equality'];
					$bgcolor=$action['bgcolor'];
					$fontcolor=$action['fontcolor'];
					$comparison_type=$action['comparison_type'];
					$link_id=$action['link_id'];
					?>
					if (row == <?php echo $position;?>) {
					if (test_action(cellData,<?php echo "'$value','$equality','$comparison_type'" ?> )) {
						<?php if ($bgcolor) { ?>
							$(td).css('background','<?php echo $bgcolor; ?>')
						<?php }
						if ($fontcolor) { ?>
							$(td).css('color','<?php echo $fontcolor; ?>')				
						<?php } 
						if ($link_id) {  ?>
							 $(td).html('<?php print "<a href=\"".base_url()."index.php/scripts/index/".$links[$link_id]['linkstr'].'/'.$links[$link_id]['linkstr']."'";
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
					}
									<?php		} ?>
				}
	
			},

		}
		],
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
