<div id="main" role="main">
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
							<h2>Query Results</h2>				
							
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
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                <?php 
               foreach ($header as $row)
                    {
                    	?>
                     <th><?php echo $row; ?> </th>
                     <?php }?>
                </tr>
            </thead>
            <tbody>
            <?php 
               foreach ($dataset as $row)
                    {
                    	?>   
                     <tr>             
                     <?php	 foreach ($header as $field)
                    		{
                    	?>            
                     <td><?php echo $row[$field]; ?></td>
                     <?php }?>                       
                     </tr>
                     <?php }?>
            </tbody>
        </table>
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
    