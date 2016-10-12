<?php

//initilize the page
require_once("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Add DB Connection";

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
				<article class="col-sm-8 col-md-12 col-lg-8">
					
					<!-- Widget ID (each widget will need unique ID) registrtion form-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
							<h2>Add DB Connection</h2>				
							
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
          $attributes = array("class" => "smart-form", "id" => "createdatabase", "name" => "createdatabaseform");
          echo form_open("createdatabase/index", $attributes);?>
          <fieldset>

               <span class="text-success"><?php  echo $smsg; ?></span>
			   <span class="text-danger"><?php  echo $error; ?></span>
               
               <div class="row">
					<section>
						<label class="label col col-2">Database Type</label>
						<div class="col col-6">
							<label class="input"> 
								<select onchange="settype()" class="form-control"  id="databasetype" name="databasetype"  >
							   <option value="">Select database type</option>
				               <option value="mysql">Mysql</option>
				               <option value="oracle">Oracle</option>
				               </select>
  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('databasetype'); ?></span>&nbsp;
				</div>
				
				<div id=mysqltype style="display:block">
						<div class="row">
							<section>
								<label class="label col col-2">Hostname</label>
								<div class="col col-6">
									<label class="input"> 
										<input class="form-control" id="hostname" name="hostname" placeholder="Hostname" type="text" value="<?php echo set_value('hostname'); ?>" />
		  								 
									</label>
									</div>
						</section>
						</div>
						<div class="row">
						<span class="text-danger"><?php echo form_error('hostname'); ?></span>&nbsp;
						</div>
						
		               <div class="row" id="portdiv">
							<section>
								<label class="label col col-2">port</label>
								<div class="col col-6">
									<label class="input"> 
										<input class="form-control" id="port" name="port" placeholder="Port Number" type="text" value="<?php echo set_value('port'); ?>" />
		  								 
									</label>
									</div>
						</section>
						</div>
						<div class="row">
						<span class="text-danger"><?php echo form_error('port'); ?></span>&nbsp;
						</div>
               </div><!--mysqltype -->          
			   
			   <div id=oracletype style="display:none">
						<div class="row">
							<section>
								<label class="label col col-2">TNS Entry</label>
								<div class="col col-6">
									<label class="input"> 
										<textarea class="form-control" rows="6" cols="100" id="tns" name="tns"><?php echo set_value('tns');?></textarea>
		  								 
									</label>
									</div>
						</section>
						</div>
						<div class="row">
						<span class="text-danger"><?php echo form_error('tns'); ?></span>&nbsp;
						</div>
			   </div> <!--oracletype -->

						<div class="row">
							<section>
								<label class="label col col-2">Database Account</label>
								<div class="col col-6">
									<label class="input"> 
										<input class="form-control" id="account" name="account" placeholder="Database Account" type="text" value="<?php echo set_value('account'); ?>" />
		  								 
									</label>
									</div>
						</section>
						</div>
						<div class="row">
						<span class="text-danger"><?php echo form_error('account'); ?></span>&nbsp;
						</div>



               <div class="row">
					<section>
						<label class="label col col-2">Password</label>
						<div class="col col-6">
							<label class="input"> 
							<input class="form-control" id="password" name="password" placeholder="Password" type="password" value="<?php echo set_value('password'); ?>" />
			 
							</label>
							</div>
				</section>
				</div>
				
				<div class="row">
				<span class="text-danger"><?php echo form_error('password'); ?></span>&nbsp;
				</div>
               
               
               <div class="row">
					<section>
						<label class="label col col-2">Database Name</label>
						<div class="col col-6">
							<label class="input"> 
								<input class="form-control" id="dbname" name="dbname" placeholder="Database Name" type="text" value="<?php echo set_value('dbname'); ?>" />
  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('dbname'); ?></span>&nbsp;
				</div>
				
              
               <div class="row">
					<section>
						<label class="label col col-2">Class</label>
						<div class="col col-6">
							<label class="input"> 
			               <select class="form-control"  id="db_class" name="db_class"  >
						   <option value="dev">Development</option>
			               <option value="test">Test</option>
			               <option value="prod">Production</option>
			               </select>
							</label>
							</div>
				</section>
				</div>
				<div class="row">
						<span class="text-danger"><?php echo form_error('db_class'); ?></span>&nbsp;
						</div>

               <div class="row">
					<section>
						<label class="label col col-2">Database Type</label>
						<div class="col col-6">
							<label class="input"> 
								<input class="form-control" id="description" name="description" placeholder="Description" type="text" value="<?php echo set_value('description'); ?>" />  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
						<span class="text-danger"><?php echo form_error('description'); ?></span>&nbsp;
						</div>
               
               
               <div class="form-group">
               <div class="col-lg-12 col-sm-12 text-center">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_validate" name="btn_validate" type="submit" class="btn btn-primary btn-sm" value="Validate" />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_save" name="btn_save" type="submit" class="btn btn-primary btn-sm" value="Save" />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default btn-sm" value="Cancel" />
                    <br/>
               </div>
               </div>
               
          </fieldset>
          <?php echo form_close(); ?>
          <?php //echo $this->session->flashdata('msg'); ?>
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
    
 function settype()
 {
	 if(document.getElementById("databasetype").value=="mysql") {
		 document.getElementById("port").value="3306";
		 document.getElementById("mysqltype").style.display='block';
		 document.getElementById("oracletype").style.display='none';
	 }
	 else
	 {
		document.getElementById("mysqltype").style.display='none';
		document.getElementById("oracletype").style.display='block';
	 }
 }
</script>

