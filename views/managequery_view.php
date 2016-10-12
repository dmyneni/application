<?php //initilize the page
require_once ("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once ("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

 YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
 E.G. $page_title = "Custom Title" */

$page_title = "Manage Queries";

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

    <div class="container">
               <section id="widget-grid" class="">
		<br/>
			<!-- row -->
			<div class="row"> 
			<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
				
							<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2><?php echo $page_title;?></h2>
				        &nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-success btn-sm" onclick="add_query()"><i class="glyphicon glyphicon-plus"></i> Add Query</button>
        				&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
		
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
                    
                    <th data-hide="phone">Query ID</th>
                    <th data-class="expand">Query Title</th>
                    <th data-class="phone,tablet">Description</th>
                    <th data-hide="phone,tablet">Status</th>
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
        </section> <!-- end of section  -->
    </div>
    
<?php //include required scripts
include ("application/asset/inc/scripts.php");
?>
 
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
 
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
            "url": "<?php echo base_url() ?>index.php/managequery/ajax_list",
			type: "POST"
        },
  
        //Set column definition initialization properties.
        "columnDefs": [
        { 

			"targets": [ 0 ], 
			"createdCell": function (td, cellData, rowData, row, col) {
			$(td).html('<?php print "<a href=\"".base_url()."index.php/scripts/index/'+cellData+'\" title=\"Execute Query\">'+cellData+'</a>'";?>)
			},
        },        ],
 
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
 
 
 
function add_query()
{
	url = "<?php echo site_url('/createquery/index/')?>";
	document.location.href=url;
	//window.open(url,'_blank');
}

function edit_query(query_id)
{
	url = "<?php echo site_url('/createquery/index/')?>/" + query_id;
	document.location.href=url;
	//window.open(url,'_blank');
}
function edit_query1(query_id)
{
    save_method = 'update';
    
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
      //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('/managequery/ajax_edit/')?>/" + query_id,
        type: "POST",
        dataType: "JSON",
        success: function(output)
        {
            addoption(output.columnlist);
            $('[name="query_id"]').val(output.data.query_id);
            $('[name="query_title"]').val(output.data.query_title);
            $('[name="status"]').val(output.data.status);
            $('[name="txt_script"]').val(output.data.text);
            $('[name="description"]').val(output.data.description);
            $('[name="version"]').val(output.data.version);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit query'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    
}

 function addoption(columnlist)
 {
	 obj=document.getElementById("columnid");
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
function updaterole(val)
{
	//alert(val);
	selectobj=document.getElementById("roles").options;
	for(i=0; i< selectobj.length; i++)
	{
			
	    if(val.indexOf(selectobj[i].value)>=0)
		selectobj[i].selected="selected";
	    
	}
}
 
function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;
    //alert("durga");
    if(save_method == 'add') {
        url = "<?php echo site_url('/managequery/ajax_add')?>";
    } else {
        url = "<?php echo site_url('/managequery/ajax_update')?>";
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

function openacton()
{
	$('#modal_action').modal('show');
}
function delete_query(id)
{
    if(confirm('Are you sure you want to delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('/managequery/ajax_delete')?>/"+id,
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
                <h3 class="modal-title">Query Management</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                     <div class="form-group">
                            <label class="control-label col-md-3">Database Name</label>
                            <div class="col-md-9">
                                <?php if ($current_db_name == 'No DB')  { ?>
						<span class="text-danger">Select a database from the dropdown list at top right.</span>
					<?php } else { ?>
						<span class="normal"><?php echo $current_db_name?></span>
					<?php } ?> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Query ID</label>
                            <div class="col-md-9">
                                <input name="query_id" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Query Title</label>
                            <div class="col-md-9">
                                <input name="query_title" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">SQL Script</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="6" cols="100"  name="txt_script"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <input name="description" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Add</button>
                <button type="button" id="btnAction" onclick="openacton()" class="btn btn-primary">Add Action</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- End Bootstrap modal -->
<div class="modal fade" id="modal_action" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Add Action</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_action" class="form-horizontal">
                    <input type="hidden" value="" name="id_action"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Column </label>
                            <div class="col-md-9">
                             <select class="form-control"  id="columnid" name="columnid" >
				                    </select>
                            
                                <input name="query_id" class="form-control" type="hidden">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Comparision Typee</label>
                            <div class="col-md-9">
			                    <select class="form-control"  id="sel_comparision" name="sel_comparision" >
			                    <option value="Numaric">Numaric</option>
			                    <option value="String">String</option>
			                    <option value="boolean">Boolean</option>
			                    </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Condtion</label>
                            <div class="col-md-9">
			                    <select class="form-control"  id="sel_condition" name="sel_condition" >
			                    <option value=">">Greater than</option>
			                    <option value=">=">Greater than or Equal</option>
			                    <option value='Less Than'>Less than</option>
			                    <option value="<=">Less than or Equal</option>
			                    <option value="<>">Not Equal</option>
			                    <option value="=">Equals</option>
			                    <option value="Like">Like</option>
			                    </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Value</label>
                            <div class="col-md-9">
                                <input name="txt_value" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Foreground Color</label>
                            <div class="col-md-9">
                             <input class="basic" id="txt_fgcolor" name="txt_fgcolor"  type="color" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Background Color</label>
                            <div class="col-md-9">
                                <input class="basic"  id="txt_bgcolor" type="color" name="txt_bgcolor" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <input name="description" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <select name="status" class="form-control">
                                    <option value="approve">Pending Approval</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="saveaction()" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div>