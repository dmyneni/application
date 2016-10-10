<script src="<?php echo base_url()?>application/assets/spectrum/spectrum.js"></script>
<link href="<?php echo base_url()?>application/assets/spectrum/spectrum.css" rel="stylesheet" type="text/css">

    <div class="container">
        <h3>User Data</h3>
        <br />
        <button class="btn btn-success" onclick="updatecolstatus()"><i class="glyphicon glyphicon-plus"></i> Update Colstatus</button>
        <button class="btn btn-default" onclick="updateChart()"><i class="glyphicon glyphicon-refresh"></i> Update Chart selection</button>
        <button class="btn btn-success" onclick="updatebind()"><i class="glyphicon glyphicon-plus"></i> Update binds</button>
        <br />
        <br />

<script src="<?php echo base_url()?>/application/assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>/application/assets/datatables/js/dataTables.bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>/application/assets/datatables/css/datatables.min.css"/> 
 
<script type="text/javascript">
 
var save_method; //for save method string
var table;
 

function updatecolstatus()
{

	save_method = 'add';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Update Columns'); // Set Title to Bootstrap modal title
}
function updatebind()
{
    save_method = 'bind';
    $('#bind_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Bind Values'); // Set Title to Bootstrap modal title
}
function updateChart()
{
    save_method = 'chart';
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form1').modal('show'); // show bootstrap modal
    $('.modal-title').text('Update Chart'); // Set Title to Bootstrap modal title
}

function savechart()
{
	$('#btnSave1').text('saving...'); //change button text
    $('#btnSave1').attr('disabled',true); //set button disable 
    var url;

        url = "<?php echo site_url('/queryform/ajax_chartupdate')?>";
    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form1').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            alert(data.search);
            if(data.status) //if success close modal and reload ajax table
            {
                
                $('#modal_form1').modal('hide');
            }
 
            $('#btnSave1').text('save'); //change button text
            $('#btnSave1').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data '+errorThrown);
            $('#btnSave1').text('save'); //change button text
            $('#btnSave1').attr('disabled',false); //set button enable 
 
        }
    });
}

function savebind()
{
	$('#btnSave2').text('saving...'); //change button text
    $('#btnSave2').attr('disabled',true); //set button disable 
    var url;

        url = "<?php echo site_url('/queryform/ajax_chartupdate')?>";
    
    $.ajax({
        url : url,
        type: "POST",
        data: $('#bindform').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            alert(data.search);
            if(data.status) //if success close modal and reload ajax table
            {
                
                $('#bind_form').modal('hide');
            }
 
            $('#btnSave1').text('save'); //change button text
            $('#btnSave1').attr('disabled',false); //set button enable 
 
 
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data '+errorThrown);
            $('#btnSave2').text('save'); //change button text
            $('#btnSave2').attr('disabled',false); //set button enable 
 
        }
    });
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
        url = "<?php echo site_url('/queryform/ajax_bindupdate')?>";
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            alert(data.search);
            if(data.status) //if success close modal and reload ajax table
            {
                
                $('#modal_form').modal('hide');
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
 

</script>
 
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Column Management</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden"  name="query_id" value="<?php echo $query_id;?>"/> 
                    <div class="form-body">
            <table id="table" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th></th>
                    <th>Sortable</th>
					<th>Visible</th>
                    <th>Searchable</th>
                </tr>
            </thead>
            <tbody>
            
            <?php 
               foreach ($columns as $row)
                    {
                    	?>
             <tr>
             <td><b><?php echo $row['column_name']; ?></b></td>
             <td><input type="checkbox" <?php if($row['searchable']=='1') echo 'checked ' ?> id="sort<?php echo $row['column_id']; ?>" name="sort<?php echo $row['column_id']; ?>"> </td>
             <td><input type="checkbox" <?php if($row['visible']=='1') echo 'checked ' ?> id="visi<?php echo $row['column_id']; ?>" name="visi<?php echo $row['column_id']; ?>"></td> 
             <td><input type="checkbox" <?php if($row['sortable']=='1') echo 'checked ' ?> id="search<?php echo $row['column_id']; ?>" name="search<?php echo $row['column_id']; ?>"> </td>
             
             </tr>       	
                    	
            <?php }?>
            </tbody>
        </table>
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
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form1" role="dialog"  >
    <div class="modal-dialog" style="width:100%">
        <div class="modal-content" style="width:100%">
            <div class="modal-header" style="width:100%">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Chart Management</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form1" class="form-horizontal">
                    <input type="hidden"  name="query_id" value="<?php echo $query_id;?>"/> 
                    <div class="form-body">
            <table id="table1" class="table table-striped table-bordered" >
            <tr><td>X- Axies</td><td>Y- Axies</td></tr> 
            <tr><td>
                   
            <table id="table1" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th></th>
                    <th>Chart Label</th>
                </tr>
            </thead>
            <tbody>
            
            <?php 
               foreach ($columns as $row)
                    {
                    	?>
             <tr>
             <td><b><?php echo $row['column_name']; ?></b></td>
             <td><input type="radio" value="<?php echo $row['column_id']; ?>" <?php if($row['chart_labels_column']=='true') echo 'checked ' ?> id="chart_labels_column" name="chart_labels_column"> </td>
             </tr>       	
                    	
            <?php }?>
            </tbody>
        </table>
        </td><td>
          <!-- table for y axies -->
            <table id="table2" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th></th>
                    <th>Chart Color</th>
                    <th>Chart Label</th>
                </tr>
            </thead>
            <tbody>
            
            <?php 
               foreach ($columns as $row)
                    {
                    	?>
             <tr>
             <td><b><?php echo $row['column_name']; ?></b></td>
             <td>
             <input class="basic"  id="chclr<?php echo $row['column_id']; ?>" type="color" name="chclr<?php echo $row['column_id']; ?>" />
             </td>
             <td><input  id="lbl<?php echo $row['column_id']; ?>" type="text" name="lbl<?php echo $row['column_id']; ?>" />
             
             </td>
             </tr>       	
                    	
            <?php }?>
            </tbody>
        </table>
        
        </td></tr>
        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="savechart()" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>    
    <!--  Bind val tables -->
    <div class="modal fade" id="bind_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Bind Values</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="bindform" class="form-horizontal">
                    <input type="hidden"  name="query_id" value="<?php echo $query_id;?>"/> 
                    <div class="form-body">
            <table id="table" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th></th>
                    <th>Alias Name</th>
                </tr>
            </thead>
            <tbody>
            
            <?php 
               foreach ($bindval as $row)
                    {
                    	?>
             <tr>
             <td><b><?php echo $row['bind_name']; ?></b></td>
             <td><input type="text" value="<?php echo $row['alias']; ?>"  id="alias<?php echo $row['bind_id']; ?>" name="alias<?php echo $row['bind_id']; ?>"> </td>
            </tr>       	
                    	
            <?php }?>
            </tbody>
        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave3" onclick="savebind()" class="btn btn-primary btn-sm">Save</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

</div>