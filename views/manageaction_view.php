<?php //initilize the page
require_once ("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once ("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

 YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
 E.G. $page_title = "Custom Title" */

$page_title = "Manage Actions";

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
		$breadcrumbs["Tables"] = "";
		include("application/asset/inc/ribbon.php");
	?>
	<br/>
<input type="hidden" id="query_id" name="query_id" value="<?php echo $query_id ?>"/>
    <div class="container">
       <section id="widget-grid" class="">		
			<!-- row -->
			<div class="row"> 
			<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
							<span class="widget-icon"> &nbsp;<i class="fa fa-table"></i> </span>
							<h2>Manage Action</h2>
							&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-success btn-sm" onclick="add_action()"><i class="glyphicon glyphicon-plus"></i> Add action</button>
        					&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        					&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-default btn-sm" onclick="edit_query()"><i class="glyphicon glyphicon-refresh"></i> Edit Query</button>
						</header>		
						<!-- widget div-->
						<div>		
							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->		
							<!-- widget content -->
							<div class="widget-body no-padding">							
        <table id="table" class="table table-striped table-bordered" width="100%">
            <thead>
                <tr>
                    <th data-hide="phone">action_id</th>
                    <th data-hide="expand" >Column name</th>
					<th data-hide="phone">Operator</th>
                    <th data-hide="phone,tablet">Value</th>
                    <th data-hide="phone,tablet">Display color</th>					
                    <th data-hide="phone,tablet">Font color</th>
                    <th data-hide="phone,tablet">Description</th>
                    <th data-hide="phone,tablet">Action</th>
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
 
 
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="<?php echo ASSETS_URL;?>/spectrum/spectrum.js"></script>
<link href="<?php echo ASSETS_URL;?>/spectrum/spectrum.css" rel="stylesheet" type="text/css">

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
    	"sDom": "<'dt-toolbar'<'col-xs-10 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",  
        "processing": true, //Feature control the processing indicator.
        "serverSide": false, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "autoWidth" : true,
        // Load data for the table's content from an Ajax source
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
        "ajax": {
            "url": "<?php echo base_url() ?>index.php/manageaction/ajax_list/<?php echo $query_id ?>",
            data: $('#form').serialize(),
			type: "POST"
        },
 
        //Set column definition initialization properties.
        "columnDefs": [
        { 
			"targets": [ 4 ], 
			"createdCell": function (td, cellData, rowData, row, col) {
						$(td).css('background',cellData),
						$(td).css('color',rowData[5]),
						$(td).html('Example')
			},
		}],
			"columns": [
				{ "orderable": false,
				"searchable":false,
				"visible":false		},
				{ "orderable": true,
				"searchable":true,
				"visible":true		},
				{ "orderable": false,
				"searchable":false,
				"visible":true		},
				{ "orderable": false,
				"searchable":false,
				"visible":true		},	
				{ "orderable": false,
				"searchable":false,
				"visible":true		},
				{ "orderable": false,
				"searchable":false,
				"visible":false		},	
				{ "orderable": false,
				"searchable":true,
				"visible":true		},
				{ "orderable": false,
				"searchable":false,
				"visible":true		},	
			],				
    });
    //alert(table.type)
    
    

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

});
 
 
 
function add_action()
{
    save_method = 'add';
    $('#column_id').attr('disabled', false)
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Action'); // Set Title to Bootstrap modal title
}
function edit_query()
{
	
document.location.href=<?php echo base_url()?>+"index.php/createquery/index/"+document.getElementById("query_id").value;
}
 
function edit_action(column_id)
{
	
    save_method = 'update';
    //document.getElementById("column_id").readOnly=true;    
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
      //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('/manageaction/ajax_edit/')?>/" + column_id+"/"+document.getElementById("query_id").value,
        type: "POST",
        dataType: "JSON",
        success: function(output)
        {
            //addoption(output.columnlist);
            $('[name="action_id"]').val(output.data.action_id);
            $('[name="column_id"]').val(output.data.column_id);
			$('[name="equality"]').val(output.data.equality);
            $('[name="value"]').val(output.data.value);
            $('[name="fontcolor"]').val(output.data.fontcolor);
            $('[name="bgcolor"]').val(output.data.bgcolor);
            $('[name="shortdesc"]').val(output.data.shortdesc);
            $('[name="status"]').val(output.data.status);
            $('[name="sel_comparision"]').val(output.data.comparison_type);
            $('#column_id').attr('disabled', true)
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    
}

function addoption(columnlist)
{
	 obj=document.getElementById("column_id");
	 for(i=0; i<columnlist.length; i++ )
	 {
		 var optionobj=document.createElement("option");
		 optionobj.text=columnlist[i].column_name;
		 optionobj.value=columnlist[i].column_id;
		 obj.add(optionobj);
		 //alert(obj.options.length);
	 }
}
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
    //alert("durga");
    if(save_method == 'add') {
        url = "<?php echo site_url('/manageaction/ajax_add')?>";
    } else {
        url = "<?php echo site_url('/manageaction/ajax_update')?>";
    }
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
        	//alert(data.rrr);
            if(data.status) //if success close modal and reload ajax table
            {
                
                $('#modal_form').modal('hide');
                reload_table();
            }
 
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data '+errorThrown);
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 
 
        }
    });
}
 
function delete_user(id)
{
    if(confirm('Are you sure you want to delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('/manageaction/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data: '+errorThrown);
            }
        });
 
    }
}

</script>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Action Management</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Column</label>
                            <div class="col-md-7">
									<input type="hidden" name="action_id" value=''>
                                    <select class="form-control"  id="column_id" name="column_id" >
                                    <?php 
               foreach ($columdet as $row)
                    {
                    	?>
                     <option value="<?php echo $row['column_id']; ?>"  ><?php echo $row['column_name']; ?></option>
                    <?php } ?>
				                    </select>
						   <span class="help-block"></span>
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="control-label col-md-4">Comparision Type</label>
                            <div class="col-md-7">
			                    <select class="form-control"  id="sel_comparision" name="sel_comparision" >
			                    <option value="Numaric">Numeric</option>
			                    <option value="String">String</option>
			                    <option value="boolean">Boolean</option>
			                    </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Condition</label>
                            <div class="col-md-7">
			                    <select class="form-control"  id="equality" name="equality" >
			                    <option value="gt">Greater than</option>
			                    <option value="ge">Greater than or Equal</option>
			                    <option value='lt'>Less than</option>
			                    <option value="le">Less than or Equal</option>
			                    <option value="ne">Not Equal</option>
			                    <option value="eq">Equals</option>
			                    <option value="like">Like</option>
								<option value="in">In</option>
			                    </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Value</label>
                            <div class="col-md-7">
                                <input name="value" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Foreground Color</label>
                            <div class="col-md-7">
                             <input class="basic" id="fontcolor" name="fontcolor"  type="color" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Background Color</label>
                            <div class="col-md-7">
                                <input class="basic"  id="bgcolor" type="color" name="bgcolor" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-4">Description</label>
                            <div class="col-md-7">
                                <input name="shortdesc" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- /.modal -->
<!-- End Bootstrap modal -->
</div>