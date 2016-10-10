<div class="container" >
        <h3 style="font-size:15pt">Query Results</h1>
        <br />
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