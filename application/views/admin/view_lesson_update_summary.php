
	<div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
            	<?php if (sizeof($lesson_data) == 1) : ?>

            		<p><?php echo $lesson_data[0]['dateAddedFormated'] ." / ". $lesson_data[0]['principle'] ." / ". $lesson_data[0]['topic'] ." / ". $lesson_data[0]['chapterTitle'] ?></p>

            		<h3><?php echo $lesson_data[0]['title'] ?></h3>

            	<?php endif; ?>
                
                <div class="line"></div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
            	<table class="table table-sm table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Summary</th>
                            <th scope="col">Update By</th>
                            <th scope="col">Date updated</th>
                        </tr>
                    </thead>

                    <tbody>
                    	<?php 
                    		$summary_len = sizeof($lesson_update_summary);
                    		if (sizeof($summary_len) > 0): ?>
                        	<?php
                        		for($i=0; $i<$summary_len; $i++){
                        			echo "<tr>";
                        				echo "<td>". ($i + 1) ."</td>";
                        				echo "<td>". $lesson_update_summary[$i]['updateSummary'] ."</td>";
                        				echo "<td>". $lesson_update_summary[$i]['UpdatedBy'] ."</td>";
                        				echo "<td>". $lesson_update_summary[$i]['dateUpdatedFormatted'] ."</td>";
                        			echo "</tr>";
                        		}
                        	?>
                    	<?php endif; ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>