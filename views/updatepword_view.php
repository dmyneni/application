<?php

//initilize the page
require_once("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Reset Password";

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
				<article class="col-sm-8 col-md-12 col-lg-4">
					
					<!-- Widget ID (each widget will need unique ID) registrtion form-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
							<h2>Reset Password </h2>				
							
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
          $attributes = array("class" => "smart-form", "id" => "updatepwordform", "name" => "updatepwordform");
          echo form_open("updatepword/index", $attributes);?>
          <fieldset>
               <div class="row">
					<section>
						<label class="label col col-4">Password</label>
						<div class="col col-8">
							<label class="input"> <i class="icon-append fa fa-lock"></i>
                    		<input class="form-control" id="password" name="password" placeholder="Password" type="password" value="<?php echo set_value('password'); ?>" />
                    		
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('password'); ?>&nbsp;</span>
				</div>               

               				<div class="row">
					<section>
						<label class="label col col-4">Confirm Password</label>
						<div class="col col-8">
							<label class="input"> <i class="icon-append fa fa-lock"></i>
                    		<input class="form-control" id="passwordf" name="passwordf" placeholder="Password" type="password" value="<?php echo set_value('passwordf'); ?>" />
                    		
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('passwordf'); ?>&nbsp;</span>
				</div>

               <div class="col-lg-12 col-sm-12 text-center">
                    <input id="btn_login" name="btn_login" type="submit" class="btn btn-primary btn-sm" value="Update" />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default btn-sm" value="Cancel" />
               </div>
          </fieldset>
          <?php echo form_close(); ?>
          <?php echo $this->session->flashdata('msg'); ?>
          </div>
     </div>
</div>
     


