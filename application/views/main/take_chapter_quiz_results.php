
    <div class="wrapper">
        <div class="content">
            <div class="container">
            	<?php if ($quiz_data == null || sizeof($quiz_data) == 0): ?>
            		<?php show_404(); ?>
            	<?php else: ?>
            		<!-- <pre>
            			<?php
            				// print_r($quiz_questions);
            				// print_r($quiz_data);
							// print_r($chapterData);
							// print_r($topicData);
							// print_r($principleData);

							// echo $quizID;
            				// print_r($numberOfRightAns);
						?>
            		</pre> -->
            		
	                <div class="row">
	                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                    	<div class="content-panel">

	                    		<div class="take_quiz">
	                    			<div class="row">
	                    				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	                    					<h4>
			                    				<?php
			                    					if ($quiz_data != NULL){
			                    						if (sizeof($quiz_data) > 0){
			                    							echo $quiz_data['quizTitle'];
			                    						}
			                    					}
			                    				?>
			                    			</h4>
			                    			<strong>
			                    				<?php
			                    					if ($principleData != NULL){
			                    						if (sizeof($principleData) > 0){
			                    							echo $principleData['principle'];
			                    						}
			                    					}

			                    					echo " / ";

			                    					if ($topicData != NULL){
			                    						if (sizeof($topicData) > 0){
			                    							echo $topicData['topic'];
			                    						}
			                    					}

			                    					echo " / ";

			                    					if ($chapterData != NULL){
			                    						if (sizeof($chapterData) > 0){
			                    							echo $chapterData['chapterTitle'];
			                    						}
			                    					}
			                    				?>
			                    			</strong>
	                    				</div>
	                    				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	                    					<h4>Score: <?php 
                									$scoreTmp = (sizeof($quiz_results) > 0) ? $quiz_results['score'] : 0;
                									$numRightAns = (sizeof($numberOfRightAns) > 0) ? $numberOfRightAns['count'] : 0;
                									echo $scoreTmp ." / ". $numRightAns; 
	                    						?></h4>
	                    					<strong>
	                    						<?php echo (sizeof($quiz_results) > 0) ? $quiz_results['dateTaketFormat'] : 0; ?>
	                    					</strong>
	                    				</div>
	                    			</div>
			                    			

	                    			<br/>
		                       		<hr class="style2"></hr>
		                       		<br/>

		                       		<table style="width: 100%;" id="take_quiz_table">
		                       			<thead>
					                        <tr>
					                            <th scope="col" style="width: 10%;">#</th>
					                            <th scope="col">Questions</th>
					                        </tr>
					                    </thead>
					                    <tbody>
					                    	<tr style="border-bottom: 5px solid gray">
					                    		<td></td>
					                    		<td></td>
					                    	</tr>
					                    	<?php

							                    $ansLen = sizeof($quiz_answers);
					                    		$questionsLen = sizeof($quiz_questions_choices_matrix);

					                    		for($i=0; $i<$questionsLen; $i++){
					                    			echo "<tr>";
							                    		echo "<td>". ($i+1) ."</td>";
							                    		echo "<td><strong>". $quiz_questions_choices_matrix[$i]['question'] ."</strong></td>";
							                    	echo "</tr>";

							                    	$questionID = $quiz_questions_choices_matrix[$i]['id'];

							                    	$choicesCorrectAnsLen = (int) $quiz_questions_choices_matrix[$i]['choicesCorrectAnsLen'];

							                    	$choices = $quiz_questions_choices_matrix[$i]['choices'];

							                    	$choicesLen = sizeof($choices);

							                    	if ($choicesCorrectAnsLen >= 1){ // Radio buttons

							                    		echo "<tr class='question_choice_separator'>";
								                    		echo "<td></td>";
								                    		echo "<td>";
								                    			echo "<table style='width: 100%'>";
								                    				$letterTmp = 'a';
										                    		for($j=0; $j<$choicesLen; $j++){

										                    			$choiceID = $choices[$j]['id'];
										                    			$choiceStr = $choices[$j]['choiceStr'];

									                    				echo "<tr>";
									                    					echo "<td>";
									                    						echo "<div class='form-check'>";
																					echo "<table style='width: 50%;'>";
																						echo "<tr>";
																							echo "<td style='width: 5%;'>";
																						  	for($a=0; $a<$ansLen; $a++){
																						  		if ($quiz_answers[$a]['questionID'] == $questionID && $quiz_answers[$a]['choiceID'] == $choiceID && $choices[$j]['isRightAns'] == "1"){
																						  			echo "<span class='fa fa-check'></span> ";
																						  		}else if ($quiz_answers[$a]['questionID'] == $questionID && $quiz_answers[$a]['choiceID'] == $choiceID && $choices[$j]['isRightAns'] == "0"){
																						  			echo "<span class='fa fa-times'></span> ";
																						  		}
																						  	}
																						  	echo "</td>";
																						  	echo "<td style='width: 5%;'><strong>".$letterTmp.".</strong></td>";

																						  	echo "<td><label class='form-check-label' for='choice_". $choiceID ."'>";
																						    	echo $choiceStr;
																						  	echo "</label><td>";
																					  	echo "</tr>";
																					echo "</table>";
																				echo "</div>";
									                    					echo "</td>";
									                    				echo "</tr>";

									                    				$letterTmp++;
										                    		}
										                    	echo "</table>";
									                    	echo "</td>";
									                    echo "</tr>";

							                    	}else{
							                    		echo "<tr class='question_choice_separator'>";
							                    			echo "<td></td>";
							                    			echo "<td></td>";
							                    		echo "</tr>";
							                    	}
							                    	// echo ""
					                    		}
					                    	?>
		
					                    </tbody> 
		                       		</table>

						                       		
	                    		</div>
	                    	</div>
	                    </div>
	                </div>

	            <?php endif; ?>

            </div>

        </div>
    </div>

    <div class="loader_blocks"></div>
   