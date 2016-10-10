<?php //initilize the page
require_once ("application/asset/inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once ("application/asset/inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

 YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
 E.G. $page_title = "Custom Title" */

$page_title = "Explain";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";

include ("application/asset/inc/header.php");

///menu navigation
$menu_path=explode('/',$this->session->userdata('menu_path'));
if (sizeof($menu_path) == 2) 
	$page_nav[$menu_path[0]]["sub"][$menu_path[1]]["active"] = true;
else if (sizeof($menu_path) == 3) 
		$page_nav[$menu_path[0]]["sub"][$menu_path[1]]["sub"][$menu_path[2]]["active"] = true;
	
include ("application/asset/inc/nav.php");
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Scripts"] = "";
		include("application/asset/inc/ribbon.php");
	?>    <div class="container">
		<div class="col-md-12">
		<div class="col-lg-7 col-sm-6 ">
		<div><h3><?php echo "Query Explanation"; ?></h3></div>
		</div>
		<div class="col-md-3"><button class="btn btn-default" onclick="goBack()"><i class="glyphicon glyphicon-step-backward"></i> Go Back</button></div>
				<div class="col-lg-9 col-sm-6">
					Title: <b><?php echo $title;?></b>
				</div>
				<div class="col-lg-4 col-sm-4 well pull-right" >
				<span class="h4">Score: 50</span>	
				<span class="pull-right"><a href=<?php echo base_url();?>index.php/scripts/index/table/1000>Usage History</a></span>
				<div><span>Contributed by:</span><span><a href=<?php echo base_url();?>index.php/scripts/index/table/1000><?php echo "Danny Knox";?></a></span></div>
				<div><span>On:</span><span><?php echo "July 20, 2016";?></span></div>
				</div>				
				<div class="col-lg-7 col-sm-6 well">
					<span class="h4">Description</span><span class="pull-right"><a href=<?php echo base_url();?>index.php/createquery/index/<?php echo $query_id?>>Edit</a></span>
					<p><pre><?php echo $description;?></pre></p>		
				</div>

				
				<div class="col-lg-7 col-sm-5 well">				
					<span class="h4">SQL Text</span><span class="pull-right"><a href=<?php echo base_url();?>index.php/createquery/index/<?php echo $query_id?>>Edit</a></span>
				   <?php
						echo SqlFormatter::format($sql);
					?>
				</div>

				<div class="col-lg-4 col-sm-4 well pull-right" >
					<span class="h4">Visualization Actions</span><span class="pull-right"><a href=<?php echo base_url();?>index.php/manageaction/index/<?php echo $query_id?>>Edit</a></span>
					<div "col-lg-12 col-sm-4">
				   <?php 
					$cnt=0;
					foreach ($actions as $row) {
						$eq=['gt'=>'greater than','lt'=>'less than','eq'=>'equals','ne'=>'not equal','ge'=>'greater than or equal','le'=>'less than or equal'];
						print $row['column_name']." ".$eq[$row['equality']]." ".$row['value']." bgcolor=".$row['bgcolor'].",".$row['fontcolor']."<br>";
						$cnt++;
					}
					if ($cnt == 0) { ?>
						There are no actions on this data set			   
					<?php } ?>
					</div>
				</div>
				<div class="col-lg-4 col-sm-4  well pull-right">
					<span class="h4">Bind Values</span><span class="pull-right"><a href=<?php echo base_url();?>index.php/managecolumns/index/<?php echo $query_id?>>Edit</a></span>
					<div>
				   <?php 
				   if (!isset($binds)) {
					   ?>There are no bind values in this query
				   <?php } else {
						print "<table width=100%><tr><th>Bind Name</th><th>Alias</th></tr>";
						foreach ($binds as $bind=>$var) {
							print "<tr><td>".$bind."</td><td>".$var['alias']."</td></tr>";
						}
						print "</table>"; 					   
				   }
				   ?>
					</div>
				</div>				
				<div class="col-lg-4 col-sm-4  well pull-right">
					<span class="h4">Columns</span><span class="pull-right"><a href=<?php echo base_url();?>index.php/managecolumns/index/<?php echo $query_id?>>Edit</a></span>
						<?php print "<table width=100%><tr><th>Column Name</th><th>Sortable</th><th>Searchable</th><th>Visible</th></tr>";
						foreach ($columns as $col) {
							print "<tr><td>".$col['column_name']."</td><td>";
							if ($col['sortable']=='true')
								print "<i class=\"fa fa-check\" aria-hidden=\"true\"></i>";
							print "&nbsp;</td><td>";
							if ($col['searchable']=='true')
								print "<i class=\"fa fa-check\" aria-hidden=\"true\"></i>";
							print "&nbsp;</td><td>";
							if ($col['visible']=='true')
								print "<i class=\"fa fa-check\" aria-hidden=\"true\"></i>";
							print "&nbsp;</td></tr>";
						}
						print "</table>"; ?>
				</div>
				<div class="col-lg-4 col-sm-4  well pull-right">
					<span class="h4">Chart</span><span class="pull-right"><a href=<?php echo base_url();?>index.php/managecolumns/index/<?php echo $query_id?>>Edit</a></span>
					<div>
						<?php print "<table width=100%><tr><th>Column Name</th><th>Chart Label</th><th>Chart Color</th><th>X-Axis</th></tr>";
						foreach ($columns as $col) {
							if ($col['chart_color']) {
								print "<tr><td>".$col['column_name']."</td><td>".$col['chart_label']."</td><td>";
								if ($col['chart_labels_column']) {
									print "yes";
								} else {
									print "&nbsp;";
								}
								print "</td></tr>";
							}
						}
						print "</table>"; ?>
					</div>
				</div>

				
				<div class="col-lg-7 col-sm-4  well">
					<span class="h4">Other Details</span>
					<div>
					<?php print "Query ID: $query_id<br>";
					print "Version: $version<br>";
					print "Query type: $query_type<br><br>";
					print "Created by: <br>";
					print "Last modified by: <br>";?>
				</div>
				</div>

            </div>
        </div>
    </div>
</div>
</div> <!-- main -->
<?php //include required scripts
include ("application/asset/inc/scripts.php");
?> 
<script>
function goBack() {
    window.history.back();
}
</script>