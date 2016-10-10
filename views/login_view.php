<?php

//initilize the page
require_once("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Login";

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
				<article class="col-sm-6 col-md-12 col-lg-4">
					
					<!-- Widget ID (each widget will need unique ID) registrtion form-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
							<h2>Login </h2>				
							
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
          $attributes = array("class" => "smart-form", "id" => "loginform", "name" => "loginform");
          echo form_open("login/index", $attributes);?>
        
								
								<!-- <form id="smart-form-register" class="smart-form"> -->
									<header>
										Login
									</header>

									<fieldset>
										<section>
											<div class="row">
												<label class="label col col-3">Username</label>
												<div class="col col-9">
													<label class="input"> <i class="icon-append fa fa-user"></i>
														<input type="text" name="txt_username">
													</label>
												</div>
											</div>
										</section>

										<section>
											<div class="row">
												<label class="label col col-3">Password</label>
												<div class="col col-9">
													<label class="input"> <i class="icon-append fa fa-lock"></i>
														<input type="password" name="txt_password">
													</label>
												</div>
											</div>
										</section>
										<section>
										<div class="note">
														<a href="javascript:void(0)">Request an account</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<a href="javascript:void(0)" align="right">Forgot password?</a>
													</div>
										</section>
									</fieldset>

								<footer>
										<button type="submit" name="btn_login" id="btn_login" class="btn btn-primary" value="Login">
											Login
										</button>
										<button type="button" name="btn_cancel" id="btn_cancel" class="btn btn-default" >
											Cancel
										</button>

									</footer>											
							 <?php echo form_close(); ?>
          					<?php echo $this->session->flashdata('msg'); ?>
								
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