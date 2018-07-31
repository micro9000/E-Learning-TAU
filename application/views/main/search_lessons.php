   
    <div class="wrapper">
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<div class="content-panel" style="margin-bottom: 0; padding: 20px;">

                    		<h6>Results: <?php echo $lessons_data_len; ?></h6>

                       	</div>
                    </div>
                </div>

	            <?php if ($lessons_data != null || sizeof($lessons_data) > 0): ?>
	                <div class="row">

	                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">

	                       	<?php

	                            for($i=0; $i<$lessons_data_len; $i++){

	                                echo "<div class='content-panel'>";
	                                    echo "<div class='row'>";
	                                        echo "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>";

	                                            echo "<div class='post_wrapper'>";
	                                                    echo "<div class='row'>";

	                                                        echo "<div class='col-lg-3 col-md-3 col-sm-6 col-xs-6' style='padding: 0 !important;'>";
	                                                            echo "<div class='post_cover cover_portrait'>";
	                                                                echo "<img src=".base_url("uploads/lessons/cover/".$lessons_data[$i]['coverPhoto']).">"; 
	                                                            echo "</div>";
	                                                        echo "</div>";

	                                                        echo "<div class='col-lg-9 col-md-9 col-sm-6 col-xs-6'>";

	                                                            echo "<div class='post_date'>";
	                                                                echo $lessons_data[$i]['dateAddedFormated'] ." / ". $lessons_data[$i]['principle'] ." / ".$lessons_data[$i]['topic'];
	                                                            echo "</div>";

	                                                            echo "<div class='post_title'>";
	                                                                echo $lessons_data[$i]['title'];
	                                                            echo "</div>";

	                                                            echo "<div class='post_by'> By ";
	                                                                echo $lessons_data[$i]['AddedByUser'];
	                                                            echo "</div>";

	                                                            echo "<div class='post_description'><p>";
	                                                                echo get_content_summary_helper($lessons_data[$i]['content']) . "...<br/><a href='". base_url("view_lesson/".$lessons_data[$i]['id']."/".$lessons_data[$i]['slug']) ."' class='link-read-more'>Read more</a>";
	                                                            echo "</p></div>";

	                                                        echo "</div>";

	                                                    echo "</div>";
	                                                echo "</div>";

	                                        echo "</div>";
	                                    echo "</div>";
	                                echo "</div>";
	                            }
	                        ?>
	                    </div>

	                </div>

	            <?php else: ?>
	            	<div class="row">
		            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px">
	                       	<div class="content-panel" >
	                       		<div class="content-panel" style="margin-bottom: 0; padding: 20px; text-align: center">
	                       			<p>Your search string did not match any documents.</p>
	                       		</div>
	                       	</div>
	                    </div>
	                </div>
	            <?php endif; ?>

            </div>

        </div>
    </div>
