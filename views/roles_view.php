<?php //initilize the page
require_once ("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once ("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

 YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
 E.G. $page_title = "Custom Title" */

$page_title = "Manage Roles";

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
			<!-- row -->
			<div class="row"> 
			<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<br>
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2> Manage Roles</h2>
							&nbsp;&nbsp;&nbsp;<button class="btn btn-primary btn-sm" onclick="add_role()"><i class="glyphicon glyphicon-plus"></i> Add Role</button>
							&nbsp;&nbsp;&nbsp;<button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
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
        <table id="table" class="table table-striped table-bordered table-hover" width="100%">
            <thead>
                <tr>
                <?php 
                $i=0;
               foreach ($tbheader as $row)
                    {
                    	
                    	if($i==0){?>
                    <th data-class="expand"><?php echo $row ?></th>
                     <?php }else {?>
                     <th data-hide="phone,tablet"><?php echo $row ?></th>
                    <?php }
                    $i=$i+1;}?>
                    <th >Action</th>
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
            "url": "<?php echo base_url();?>index.php/roles/ajax_list",
			type: "POST"
        },
        //Set column definition initialization properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
 


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
 
 
 
function add_role()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Role'); // Set Title to Bootstrap modal title
}
 
function edit_role(role_id)
{
    save_method = 'update';
    
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
      //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('/roles/ajax_edit/')?>/" + role_id,
        type: "POST",
        dataType: "JSON",
        success: function(data)
        {
 
            $('[name="role_id"]').val(data.role_id);
            $('[name="role"]').val(data.role);
			$('[name="description"]').val(data.short_desc);
            $('[name="status"]').val(data.status);
            $('[name="created_by"]').val(data.created_by);
            $('[name="updated_by"]').val(data.updated_by);
            $('[name="approved_by"]').val(data.approved_by);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Role'); // Set title to Bootstrap modal title
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    
}

function updatestatus(val)
{
	obj=document.getElementId("status");
	for(i=0; i< obj.options.lenth;i++)
	{
		if(document.getElementById("status").options[i].value==val)
			document.getElementById("status").options[i].selected=true;
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
        url = "<?php echo site_url('/roles/ajax_add')?>";
    } else {
        url = "<?php echo site_url('/roles/ajax_update')?>";
    }
    getrole();
    //alert(document.getElementById("sroles").value)
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
 
function delete_role(id)
{
    if(confirm('Are you sure you want to delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('/roles/ajax_delete')?>/"+id,
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
                <h3 class="modal-title">Role Management</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/> 
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Role ID</label>
                            <div class="col-md-9">
                                <input name="role_id" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Role Name</label>
                            <div class="col-md-9">
                                <input name="role" placeholder="Role Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <input name="description" placeholder="Description" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                            <div class="col-md-9">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <select id="status" name="status" class="form-control">
                                    <option value="approve" >Pending Approval</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- End Bootstrap modal -->