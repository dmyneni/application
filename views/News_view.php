<?php

//initilize the page
require_once("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Add News Items";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("application/asset/inc/header.php");

//menu navigation
$menu_path=explode('/',$this->session->userdata('menu_path'));
if (sizeof($menu_path)<2)
	$menu_path=array('1','8'); # hard coded as the default
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
							<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
							<h2><?php echo $page_title ?></h2>				
							
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
          $attributes = array("class" => "smart-form", "id" => "newsform", "name" => "newsform","onsubmit" =>"getdata()");
          echo form_open("news", $attributes);?>
          <fieldset>
          <div class="row">
					<section>
						<label class="label col col-4"><?php echo $this->session->flashdata('status');?></label>
				</section>
				</div>
          
               <div class="row">
					<section>
						<label class="label col col-2">Headline</label>
						<div class="col col-5">
							<label class="input"> 
								<input class="form-control" id="headline" name="headline" placeholder="headline" type="text" value="<?php echo set_value('headline'); ?>" />
  								 
							</label>
							</div>
				</section>
				</div>
				               <div class="row">
				<span class="text-danger"><?php echo form_error('headline'); ?></span>&nbsp;
				</div>
               <div class="row">
					<section>
						<label class="label col col-2">Category</label>
						<div class="col col-5">
							<label class="input"> 
							<select class="form-control"  id="category" name="category"  >
								<option value="oracle">Oracle</option>
								<option value="mysql">Mysql</option>
								<option value="L0">All Users</option>
								<option value="L1">Contributor</option>
								<option value="L2">Administrator</option>               
				                    </select>
  								 
							</label>
							</div>
				</section>
				</div>
               <div class="row">
				<span class="text-danger"><?php echo form_error('category'); ?></span>&nbsp;
				</div>               
               
               <div class="row">
					<section>
						<label class="label col col-2">Start Date</label>
						<div class="col col-5">
						<div class="input-group">
							<input type="text" name="sdate" placeholder="Select a date" class="form-control datepicker" data-dateformat="yy-mm-dd">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
							</div>
				</section>
				</div>
               <div class="row">
				<span class="text-danger"><?php echo form_error('sdate'); ?></span>&nbsp;
				</div>
				
				<div class="row">
					<section>
						<label class="label col col-2">End Date</label>
						<div class="col col-5">
						<div class="input-group">
							<input type="text" name="edate" placeholder="Select a date" class="form-control datepicker" data-dateformat="yy-mm-dd">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
							</div>
				</section>
				</div>
               <div class="row">
				<span class="text-danger"><?php echo form_error('edate'); ?></span>&nbsp;
				</div>
				<div class="row">
					<section>
						<label class="label col col-2">Description<input type="hidden" id="details" name="details"/></label>
						<div class="col col-9">
						<div id="summernote" class="summernote" ><?php echo form_error('details'); ?></div>
					   </div>
					    </section>	
										</div>
               <div class="row">
				<span class="text-danger"><?php echo form_error('details'); ?></span>&nbsp;
				</div>
               
               <div class="form-group">
               <div class="col-lg-12 col-sm-12 text-center">
                    <input id="btn_login" name="btn_login"  type="submit" class="btn btn-primary btn-sm" value="Submit" />
                    <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default btn-sm" value="Cancel" />
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

<script src="<?php echo ASSETS_URL; ?>/js/plugin/summernote/summernote.min.js"></script>



<script type="text/javascript">
function getdata()
{
	//$('.summernote').code();
	//alert($('#summernote').summernote('code'));
	document.getElementById("details").value=$('#summernote').summernote('code');
	//document.getElementById("newsform").submit()
}

$(document).ready(function() {

	//alert("augrra")
	$('.summernote').summernote({
		height: 200,
		toolbar: [
	    ['style', ['style']],
	    ['font', ['bold', 'italic', 'underline', 'clear']],
	    ['fontname', ['fontname']],
	    ['color', ['color']],
	    ['para', ['ul', 'ol', 'paragraph']],
	    ['height', ['height']],
	    ['table', ['table']],
	    ['insert', ['link', 'picture', 'hr']],
	    ['view', ['fullscreen', 'codeview', 'help']]

	  ]
	});
})


</script>     


<?php 
	//include footer
	include("application/asset/inc/google-analytics.php"); 
?>    
