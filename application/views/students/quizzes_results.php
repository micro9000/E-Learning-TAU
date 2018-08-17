	
	<div class="wrapper">
		<div class="content">
			<div class="container">

		        <div class="row">

		            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		            	<div class="quizzes-results-wrapper">
		            		<div class="row">
		            			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		            				<h3>Quizzes Results</h3>
		            				<div class="line"></div>
		            			</div>
			                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                       	<?php //print_r($quizzes_results); ?>

			                        <table class="table table-sm table-striped table-bordered table-hover">
					                    <thead>
					                        <tr>
					                            <th scope="col">#</th>
					                            <th scope="col">Date Taken</th>
					                            <th scope="col">Score</th>
					                            <th scope="col">Chapter</th>
					                            <th scope="col">Quiz</th>
					                            <th scope="col">View</th>
					                        </tr>
					                    </thead>
					                    
					                    <tbody>
					                    	<?php 

					                    		$quizzes_len = sizeof($quizzes_results);

					                    		for($i=0; $i<$quizzes_len; $i++){

					                    			echo "<tr>";
					                    				echo "<td>". ($i + 1) ."</td>";
					                    				echo "<td>". $quizzes_results[$i]['dateTakenFormat'] ."</td>";
					                    				echo "<td>". $quizzes_results[$i]['score'] ." / ". $quizzes_results[$i]['rightAnsLen'] ."</td>";
					                    				echo "<td>". $quizzes_results[$i]['chapterTitle'] ."</td>";
					                    				echo "<td>". $quizzes_results[$i]['quizTitle'] ."</td>";
					                    				echo "<td><a href='". base_url("chapter_take_quiz_results/" . $quizzes_results[$i]['id']) ."' target='_blank' style='color: blue; text-decoration: underline;'>results</a></td>";
					                    			echo "</tr>";

					                    		}
					                    		
					                    	?>
					                    </tbody>
					                </table>
			                    </div>
			                </div>
		            	</div>

		            </div>
		        </div>
		    </div>
		</div>
	</div>

		    


