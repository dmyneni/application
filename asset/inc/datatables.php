<?php 
	$repo=conn_repo_db();
	$conn=connect_target($repo,12);
	$data=get_query($repo,99);

	$table_data=get_datatables($conn,$data['query']['sql']);

	?>
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
		
						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"
		
						-->
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2><?php print $data['query']['title']; ?> </h2>
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
		
						        <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
									<thead>			                
										<tr>
										<?php 
											foreach ($data['columns'] as $key=>$array) 
												print "<th data-hide=\"phone\">".$array['column_name']."</th>"; 
										?>
										</tr>
									</thead>
									<tbody>
										<?php										
											foreach ($table_data as $key=>$row) {
												print "<tr>";
												foreach($row as $key=>$val) {
													print "<td>".$val."</td>";
												}
												print "</tr>";
											}
										?>										
									</tbody>
								</table>
		
							</div>
							<!-- end widget content -->
		
						</div>
						<!-- end widget div -->
		
					</div>
					<!-- end widget -->
				</article>


