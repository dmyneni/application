<?php

//initilize the page
require_once("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Edit Profile";

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
				<article class="col-sm-8 col-md-12 col-lg-6">
					
					<!-- Widget ID (each widget will need unique ID) registrtion form-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
							<h2>Edit User Profile </h2>				
							
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
          $attributes = array("class" => "smart-form", "id" => "registerform", "name" => "registerform");
          echo form_open("editprofile/index", $attributes);?>
          <fieldset>
			
					<div class="row">
					<section>
						<label class="label col col-4">Username</label>
						<div class="col col-8">
							<label class="input"> <i class="icon-append fa fa-user"></i>
								<input class="form-control" id="username" name="username" placeholder="Username" type="text" readonly="true" value="<?php echo $this->session->userdata('username'); ?>" />
  								 
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
                    		<input class="form-control" id="email" name="email" placeholder="Email" type="text" value="<?php echo $profile->email_address; ?>" />
                    		
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
                    		<input  id="phone" name="phone" type="tel" placeholder="Phone Number"  value="<?php echo $profile->phone_number; ?>" />
                    		
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
               foreach ($sroles as $row)
                    {
                    	?>
                     <option value="<?php echo $row['role_id']; ?>" <?php if(strpos($rolelist, $row['role_id'])>0){echo 'selected';}?>  ><?php echo $row['role']; ?></option>
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
						<label class="label col col-4">Default Menu</label>
						<div class="col col-8">
							<label class="input"> 
							
               <select class="form-control"  id="menuname" name="menuname"  >
               <?php
               foreach ($menu as $mrow)
                    {
                    	?>
                     <option value="<?php echo $mrow['menu_id']; ?>" <?php if($profile->default_menu_id==$mrow['menu_id']){echo 'selected';}?>  ><?php echo $mrow['menu_name'];?></option>
                    <?php } ?>
                    </select>
                    		
							</label>
							</div>
				</section>
				</div>
				<div class="row">
				<span class="text-danger"><?php echo form_error('menuname'); ?>&nbsp;</span>
				</div>

				<div class="row">
					<section>
						<label class="label col col-4">Default Database</label>
						<div class="col col-8">
							<label class="input"> 
 							<select class="form-control"  id="dbname" name="dbname"  >
			               <?php 
			               foreach ($dbname as $srow)
			                    {
			                    	?>
			                     <option value="<?php echo $srow['account_id']; ?>" <?php if($profile->default_account_id== $srow['account_id']){echo 'selected';}?>  ><?php echo $srow['db_name']?></option>
			                    <?php } ?>
			                    
                    </select>
                    </label>
                    </div>
				</section>
				</div>

				
				<div class="row">
				<span class="text-danger"><?php echo form_error('dbname'); ?>&nbsp;</span>
				</div>
          </fieldset>
          	<footer>
			<button type="submit" name="btn_login" id="btn_login" class="btn btn-primary btn-sm" value="Submit">
				Submit
			</button>
			<button type="button" name="btn_cancel" id="btn_cancel" class="btn btn-default btn-sm" >
				Cancel
			</button>

									</footer>
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


