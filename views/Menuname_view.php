<div class="container">
     <div class="row">
          <div class="col-lg-6 col-sm-4 well">
          <?php 
          $attributes = array("class" => "form-horizontal", "id" => "menunameform", "name" => "menunameform");
          echo form_open("menuname/index", $attributes);?>
          <fieldset>
               <legend>Menu Name</legend>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-8">
                    <label for="username" class="control-label">Menu Name</label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control" id="menuname" name="menuname" placeholder="Menuname" type="text"  value="<?php echo $this->session->userdata('menuname'); ?>" />
                    <span class="text-danger"><?php echo form_error('menuname'); ?></span>
               </div>
               </div>
               </div>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="role" class="control-label">Roles</label>
               </div>
               <div class="col-lg-8 col-sm-8">
               <select class="form-control"  id="roles" name="roles"  >
               <?php 
               foreach ($sroles as $row)
                    {
                    	?>
                     <option value="<?php echo $row['role_id']; ?>" <?php if(strpos($rolelist, $row['role_id'])>0){echo 'selected';}?>  ><?php echo $row['role']; ?></option>
                    <?php } ?>
                    </select>
                    <span class="text-danger"><?php 
                    echo form_error('role'); ?></span>
               </div>
               </div>
               </div>
               
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="role" class="control-label">Menu Type</label>
               </div>
               <div class="col-lg-8 col-sm-8">
               <select class="form-control"  id="menutype" name="menutype"  >
				<option value="oracle">Oracle</option>
				<option value="mysql">Mysql</option>
				<option value="L0">All Users</option>
				<option value="L1">Contributor</option>
				<option value="L2">Administrator</option>               
                    </select>
               
               </div>
               </div>
               </div>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="comment" class="control-label">Description</label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <textarea  class="form-control" id="comment" name="comment" placeholder="Free text" rows="5"><?php echo set_value('comment'); ?></textarea>
                    <span class="text-danger"><?php echo form_error('comment'); ?></span>
               </div>
               </div>
               </div>
               <div class="form-group">
               <div class="col-lg-12 col-sm-12 text-center">
                    <input id="btn_login" name="btn_login" type="submit" class="btn btn-default" value="Submit" />
                    <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default" value="Cancel" />
               </div>
               </div>
               
          </fieldset>
          <?php echo form_close(); ?>
          <?php //echo $this->session->flashdata('msg'); ?>
          </div>
     </div>
</div>
<script type="text/javascript">
    
    $(document).ready(function() {
        
        $('#roles').multiselect();
    });
</script>     


