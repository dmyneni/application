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
<?php 
$i=0;
               foreach ($news as $row)
                    {
     	?>		

				<!-- NEW COL START -->
					<!-- NEW COL START -->
					<?php if (($i % 2) == 0)
					{?>
				<article class="col-sm-12 col-md-12 col-lg-6">
					<!-- Widget ID (each widget will need unique ID) registrtion form-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2><?php echo $row['headline'];?></h2>				
							
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
							<?php echo $row['details']; ?>
          						</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
				</article>
				<?php }?>
				<!-- END COL -->		
<!--  Second column -->
	<?php if (($i % 2) == 1)
					{?>
				<article class="col-sm-12 col-md-12 col-lg-6">
					<!-- Widget ID (each widget will need unique ID) registrtion form-->
					<div class="jarviswidget" id="wid-id-4" data-widget-editbutton="false" data-widget-custombutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2><?php echo $row['headline']; ?></h2>				
							
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
							<?php echo $row['details']; ?>
          						</div>
							<!-- end widget content -->
							
						</div>
						<!-- end widget div -->
						
					</div>
					<!-- end widget -->
				</article>
				<?php }?>
				<!-- END COL -->		
<?php

$i=$i+1;
                    
                    }?>




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
