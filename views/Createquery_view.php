<?php

//initilize the page
require_once("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("application/asset/inc/header.php");

//menu navigation
$menu_path=explode('/',$this->session->userdata('menu_path'));
if (sizeof($menu_path) == 2) 
	$page_nav[$menu_path[0]]["sub"][$menu_path[1]]["active"] = true;
else if (sizeof($menu_path) == 3) 
		$page_nav[$menu_path[0]]["sub"][$menu_path[1]]["sub"][$menu_path[2]]["active"] = true;
	
include("application/asset/inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Forms"] = "";
		include("application/asset/inc/ribbon.php");
	?>

	<!-- MAIN CONTENT -->
			
<br/>
		<!-- widget grid -->
		<section id="widget-grid" class="">


			<!-- START ROW -->

			<div class="row">

				<!-- NEW COL START -->
					<!-- NEW COL START -->
				<article class="col-sm-8 col-md-12 col-lg-10">
					
					<!-- Widget ID (each widget will need unique ID) registrtion form-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
<!--							<span class="widget-icon"> <i class="fa fa-edit"></i> </span> -->
							<h2><?php echo $title;?></h2>				
							
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
          <?php 
          $attributes = array("class" => "smart-form", "id" => "createquery", "name" => "createquery");
          echo form_open("/createquery/index", $attributes);?>
          <fieldset>

               <div class="row">
					<section>
						<label class="label col col-4"><?php echo $this->session->flashdata('status');?></label>
				</section>
				</div>
				<div class="row">
				<span class="text-danger">&nbsp;</span>
				</div>
				<div class="row">
					<section>
						<label class="label col col-2">Database</label>
						<div class="col col-9">
							<label class="input"> 
									<?php if ($current_db_name == 'No DB')  { ?>
						<span class="text-danger">Select a database from the dropdown list at top right.</span>
					<?php } else { ?>
						<span class="normal"><?php echo $current_db_name?></span>
					<?php } ?>
  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('txt_title'); ?>&nbsp;</span>
				</div>

                <div class="row">
					<section>
						<label class="label col col-2">Query Title</label>
						<div class="col col-6">
							<label class="input"> 
								<input class="form-control" id="txt_title" name="txt_title" placeholder="Query title" type="text" value="<?php echo set_value('txt_title'); ?>" />
  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('txt_title'); ?></span>&nbsp;
				</div>
                    
                <div class="row">
					<section>
						<label class="label col col-2">SQL Query</label>
						<div class="col col-9">
							<label class="input"> 
								<textarea  onchange=disable_create(); rows="6" cols="90" id="txt_script" name="txt_script" placeholder="SQL statement"><?php echo set_value('txt_script');?></textarea>
  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('txt_script'); ?></span>&nbsp;
				</div>
				<?php
				if (isset($bindlist)) {
					$counter=0;
					foreach($bindlist as $bind) { ?>
					   <div class="row colbox">
					   <div class="control-label col-md-3">
					   <label for="txt_script" class="control-label"><?php echo $bind;?></label><input type=hidden name=<?php $bind_name='bind_name_'.$counter; echo $bind_name ?> value="<?php echo $bind; ?> "/>
					   </div>
					   <div class="col-lg-3 col-sm-3">
							<input class="form-control" id="<?php $bind_name='bind_value_'.$counter; echo $bind;?>" name="<?php echo 'bind_value_'.$counter;?>" placeholder="test value" type="text" value="<?php echo $bindvals[$bind]['value']; ?>" />
					   </div>
					   <div class="col-lg-3 col-sm-3">
							<input class="form-control" id="<?php $bind_name='bind_alias_'.$counter; echo $bind_name;?>" name="<?php echo $bind_name;?>" placeholder="alias" type="text" value="<?php echo $bindvals[$bind]['alias']; ?>" />
					   </div>					   
					   </div>
					<?php 
					   $counter++;
					}	
				}					
				?>

				<div class="row">
					<section>
						<label class="label col col-2">Description</label>
						<div class="col col-9">
							<label class="input"> 
								<textarea class="form-control" rows="4" cols="90" id="txt_script" name="txt_description" placeholder="Description"><?php echo set_value('txt_description');?></textarea>
  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('txt_description'); ?></span>&nbsp;
				</div>

	   
               
               <div class="row" align="right">
                    <input type="hidden" name="txt_queryid" id="txt_queryid" value="<?php echo $query_id;?>">
					<input type="hidden" name="txt_verion" id="txt_version" value="<?php echo set_value('txt_version'); ?>">
                    
                    <input id="btn_validate" name="btn_validate" type="submit" class="btn btn-primary btn-sm" value="Validate" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_create" name="btn_create" type="submit" class="btn btn-primary btn-sm" value="Create" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_action" name="btn_action" type="submit" class="btn btn-primary btn-sm" value="Add Action" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_columns" name="btn_columns" type="submit" class="btn btn-primary btn-sm" value="Column Options" />					
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default btn-sm" value="Cancel" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                    
               </div>
               
               
				
          </fieldset>
          <?php echo form_close(); ?>
						</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
			

				</article>
				<!-- END COL -->		

			</div>

			<!-- END ROW -->

		</section>
		<!-- end widget grid -->

</div>
		<!-- Modal -->
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->


<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("application/asset/inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) -->
<script src="<?php echo ASSETS_URL; ?>application/asset/js/plugin/jquery-form/jquery-form.min.js"></script>



<?php 
	//include footer
	include("application/asset/inc/google-analytics.php"); 
?>    

     <script type="text/javascript">
     if(document.getElementById("txt_queryid").value=="") {
		 if (document.getElementById("validated").value != 1) {
			document.getElementById("btn_create").disabled = true;
		 }
		document.getElementById("btn_action").disabled = true;
		document.getElementById("btn_columns").disabled = true;
	 } else {
		document.getElementById("btn_action").disabled = false;
		document.getElementById("btn_columns").disabled = false;
	 }
	function disable_create() {
		document.getElementById("btn_create").disabled = true;
		document.getElementById("btn_columns").disabled = true;
		document.getElementById("btn_action").disabled = true;
	}
     </script>

