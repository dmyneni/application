<?php

//initilize the page
require_once("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Register";

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
							<h2>New User Registration </h2>				
							
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
					$attributes = array("class" => "smart-form", "id" => "register", "name" => "registerform");
					echo form_open("register/index", $attributes);?>
				<fieldset>
               <span class="text-success"><?php if (isset($smsg)) echo $smsg; ?></span>
			   
			   		<div class="row">
					<section>
						<label class="label col col-4">Username</label>
						<div class="col col-8">
							<label class="input"> <i class="icon-append fa fa-user"></i>
								<input class="form-control" id="username" name="username" placeholder="Username" type="text"  value="<?php   echo set_value('username');;?>" />
  								 
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('username'); ?></span>&nbsp;
				</div>

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


				<div class="row">
					<section>
						<label class="label col col-4">Email</label>
						<div class="col col-8">
							<label class="input"> <i class="icon-append fa fa-envelope-o"></i>
                    		<input class="form-control" id="email" name="email" placeholder="Email" type="text" value="<?php  echo set_value('email'); ?>" />
                    		
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('email'); ?>&nbsp;</span>
				</div>

				<div class="row">
					<section>
						<label class="label col col-4">Phone Number</label>
						<div class="col col-8">
							<label class="input"> <i class="icon-append fa fa-phone"></i>
                    		
                    		<input type="text" id="phone" name="phone" placeholder="Phone Number"  value="<?php  echo set_value('phone'); ?>" class="form-control" data-mask="(999) 999-9999" data-mask-placeholder= "X">
                    		
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('phone'); ?>&nbsp;</span>
				</div>
			
			<div class="row">
					<section>
						<label class="label col col-4">Role</label>
						<div class="col col-8">
							<label class="input"> <i class="icon-append fa fa-phone"></i>
                    		<select class="select2" size="5" multiple id="roles" name="roles[]"  >
               <?php 
               foreach ($roles as $row)
                    {
                    	?>
                     <option value="<?php echo $row['role_id']; ?>"><?php echo $row['role']; ?></option>
                    <?php } ?>
                    </select>
                    		
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('roles'); ?>&nbsp;</span>
				</div>
				
				
				<div class="row">
					<section>
						<label class="label col col-4">Any addition information for the administrator</label>
						<div class="col col-8">
							
                    		<textarea  class="form-control" id="comment" name="comment" placeholder="Free text" rows="5"><?php echo set_value('comment'); ?></textarea>
                    		
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('comment'); ?>&nbsp;</span>
				</div>
				<div class="row">
               <div class="col-lg-12 col-sm-12 text-center">
                    <input id="btn_login" name="btn_login" type="submit" class="btn btn-primary btn-sm" value="Submit" />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default btn-sm" value="Cancel" />
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



