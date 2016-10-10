<script src="<?php echo base_url()?>application/assets/spectrum/spectrum.js"></script>

<div class="container">
     <div class="row">
          <div class="col-lg-6 col-sm-6 well">
          <?php 
          $attributes = array("class" => "form-horizontal", "id" => "addaction", "name" => "addaction");
          echo form_open("/addaction/index", $attributes);?>
          <fieldset>
               <legend>Create Action</legend>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-8 col-sm-8">
               <?php echo $this->session->flashdata('status'); ?>
               <input type="hidden" name="query_id" value=""/>
               </div>
               </div>
                </div>    
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="role" class="control-label">Column Name</label>
               </div>
               <div class="col-lg-8 col-sm-8">
               <select class="form-control"  id="columnid" name="columnid" >
               <?php 
               foreach ($column_details as $row)
                    {
                    	?>
                     <option value="<?php echo $row['column_id']; ?>" <?php if( intval(set_value('columnid'))==  $row['column_id']){echo 'selected="selected"';}?> ><?php echo $row['column_name']; ?></option>
                    <?php }php?>
                    </select>

               </div>
               </div>
               </div>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="sel_comparision" class="control-label">Comparision Type</label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <select class="form-control"  id="sel_comparision" name="sel_comparision" >
                    <option value="numeric">numeric</option>
                    <option value="string">string</option>
                    <option value="boolean">boolean</option>
                    </select>
               </div>
               </div>
               </div>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="sel_condition" class="control-label">Condition</label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <select class="form-control"  id="sel_condition" name="sel_condition" >
                    <option value="gt">Greater than</option>
                    <option value="ge">Greater than or Equal</option>
                    <option value="lt">Less than</option>
                    <option value="le">Less than or Equal</option>
                    <option value="ne">Not Equal</option>
                    <option value="eq">Equals</option>
                    <option value="like">Like</option>
                    </select>
               </div>
               </div>
               </div>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="txt_value" class="control-label">Value</label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <input class="basic" id="txt_value" name="txt_value"  type="text" value="<?php echo set_value('txt_value'); ?>" />
               </div>
               </div>
               </div>
               
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="txt_fgcolor" class="control-label">Foregound Color</label>
               </div>
               <div class="col-lg-8 col-sm-8">
			   			   <?php $_POST{'txt_fgcolor'} = isset($_POST{'txt_fgcolor'}) ? $_POST{'txt_fgcolor'} : '#000000'; ?>
                    <input class="basic" id="txt_fgcolor" name="txt_fgcolor"  type="color" value="<?php echo set_value('txt_fgcolor'); ?>" />
               </div>
               </div>
               </div>
               
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
               <label for="txt_bgcolor" class="control-label">Background Color</label>
               </div>
               <div class="col-lg-8 col-sm-8">
			   <?php $_POST{'txt_bgcolor'} = isset($_POST{'txt_bgcolor'}) ? $_POST{'txt_bgcolor'} : '#ffff00'; ?>
               <input class="basic"  id="txt_bgcolor" type="color" name="txt_bgcolor" value="<?php echo set_value('txt_bgcolor');?>"/>
               </div>
               </div>
               </div>
                <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="txt_description" class="control-label">Description</label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control" id="txt_description" name="txt_description" placeholder="Description" type="text" value="<?php echo set_value('txt_description'); ?>" />
               </div>
               </div>
               </div>              
               <div class="form-group">
               <div class="col-lg-12 col-sm-12 text-center">
                    <input id="btn_login" name="btn_login" type="submit" class="btn btn-default" value="Create" />
                    <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default" value="Cancel" />
                    <?php //echo validation_errors(); ?>
                    
               </div>
               </div>
               
				
          </fieldset>
          <?php echo form_close(); ?>
          </div>
     </div>
</div>

<script type="text/javascript">
$("#picker").spectrum({
	    color: tinycolor,
	    flat: bool,
	    showInput: bool,
	    showInitial: bool,
	    showAlpha: bool,
	    disabled: bool,
	    localStorageKey: string,
	    showPalette: bool,
	    showPaletteOnly: bool,
	    showSelectionPalette: bool,
	    clickoutFiresChange: bool,
	    cancelText: string,
	    chooseText: string,
	    className: string,
	    preferredFormat: string,
	    maxSelectionSize: int,
	    palette: [[string]],
	    selectionPalette: [string]
	});
</script>


