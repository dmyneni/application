<?php //initilize the page
require_once ("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once ("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

 YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
 E.G. $page_title = "Custom Title" */
 

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";

include ("application/asset/inc/header.php");

//menu navigation
$menu_path=explode('/',$this->session->userdata('menu_path'));
if (sizeof($menu_path) == 2) 
	$page_nav[$menu_path[0]]["sub"][$menu_path[1]]["active"] = true;
else if (sizeof($menu_path) == 3) 
		$page_nav[$menu_path[0]]["sub"][$menu_path[1]]["sub"][$menu_path[2]]["active"] = true;
	
include ("application/asset/inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Scripts"] = "";
		include("application/asset/inc/ribbon.php");
	?>

    <div class="container">
       <section id="widget-grid" class="">	
			<!-- row -->
			<div class="row"> 
			<!-- NEW WIDGET START -->
				<article class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<br>
						<header>
							<div class="pull-right"><a href=<?php echo base_url(); echo "index.php/explain/index/$query_id"?>>Explain</a>&nbsp; &nbsp; </div><div >&nbsp; &nbsp;
												<div draggable="true" onmousedown="highlightTarget()" onmouseup="hideTarget()" ondrag="myFunction(event)" ondragstart="dragStart(event)" ondragend="hideTarget()" ondrag="dragging(event)" draggable="true" id="dragtarget" class="col-sm-3 col-md-3 col-lg-4"><span class="widget-icon"> <i class="fa fa-table"></i> </span><?php echo $title; ?></div> 
																			</div>
						</header>
						<!-- widget div-->
						<div>		
							<!-- end widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->
							<!-- widget content -->
							<div class="widget-body no-padding">
								<table id="table" class="table table-striped table-bordered" "pull-left" width=100%>
									<thead>
										<tr>
											<?php
											$cnt=0;
											foreach ($columns as $column)
											{
												if ($cnt==0)
													$class='data-class="expand"';
												else if ($cnt>3)
													$class='data-hide="phone,tablet"';
												else if ($cnt<=3)
													$class='data-hide="phone"';
												echo "<th $class>$column[column_name]</th>";
												$cnt++;
											}
											?>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<!-- end widget content -->	
						</div>
						<!-- end widget div -->		
					</div>
				</article>
			</div> <!-- end of row  -->
		</section>
	</div>

<?php //include required scripts
include ("application/asset/inc/scripts.php");
?> 

<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>application/assets/bootstrap/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>application/assets/bootstrap/css/bootstrap-multiselect.css" type="text/css"/>

<script type="text/javascript">
 
var save_method; //for save method string
var table;

$(document).ready(function() {
	var responsiveHelper_datatable_col_reorder = undefined;
	
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};
    //datatables
    table = $('#table').DataTable({
     	"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
   
        "processing": true, //Feature control the processing indicator.
        "serverSide": false, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "autoWidth" : true,
        "preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_col_reorder) {
				responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#table'), breakpointDefinition);
			}
		},"rowCallback" : function(nRow) {
			responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
		},"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_col_reorder.respond();
		},
 
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url() ?>index.php/scripts/ajax_list",
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
						 $(td).html('<?php print "<a href=\"".base_url()."index.php/scripts/index/".$links[$link_id]['target_id']."'";
						 foreach ($key_pairs as $key) {
							 if ($key['type']=='session') {
								 print "/".$this->session->$parameter;
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

function dragStart(event) {
    event.dataTransfer.setData("Text", event.target.id);
}

function dragging(event) {
    document.getElementById("dragtarget").innerHTML = "Drop onto the desired menu";
}

function allowDrop(event) {
    event.preventDefault();
}

function highlightTarget() {
	element=document.getElementById("target-1");
	element.style.display='block';
}

function hideTarget() {
	element=document.getElementById("target-1");
	element.style.display='none';
}

function drop(event) {
    event.preventDefault();
    var data = event.dataTransfer.getData("Text");
	var newItem=document.getElementById(data).innerHTML;
	var toMenu=event.target.innerHTML;
    if (toMenu.length == 0) { 
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(xmlhttp.responseText);
            } else {
				alert('ready='+this.readyState+',status='+this.status+','+xmlhttp.responseText);
			}
        };
        xmlhttp.open("GET", htmlEncode("<?php echo base_url()?>index.php/scripts/ajax_chg_menu/"+newItem+"/"+toMenu, true));
			                alert('y'+xmlhttp.responseText);
        xmlhttp.send();
    }
	                alert('x'+xmlhttp.responseText);
}

function htmlEncode(value){
  //create a in-memory div, set it's inner text(which jQuery automatically encodes)
  //then grab the encoded contents back out.  The div never exists on the page.
  return $('<div/>').text(value).html();
}		
</script>
</div> <!-- main -->