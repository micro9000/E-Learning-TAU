

    <div class="wrapper">
        <div class="content">
            <div class="container">
            	<?php if ($quiz_data == null || sizeof($quiz_data) == 0): ?>
            		<?php show_404(); ?>
            	<?php else: ?>

	                <div class="row">
	                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                    	<div class="content-panel">

	                    		<div class="take_quiz">
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

							                    	if ($choicesCorrectAnsLen == 1){ // Radio buttons

							                    		echo "<tr class='question_choice_separator'>";
								                    		echo "<td></td>";
								                    		echo "<td>";
								                    			echo "<table>";
										                    		for($j=0; $j<$choicesLen; $j++){

										                    			$choiceID = $choices[$j]['id'];
										                    			$choiceStr = $choices[$j]['choiceStr'];

									                    				echo "<tr>";
									                    					echo "<td>";
									                    						echo "<div class='form-check'>";
																				  	echo "<input class='form-check-input question_". $questionID ."' type='radio' name='question_". $questionID ."' id='choice_". $choiceID ."' data-choice-id='". $choiceID ."' value=''>";
																				  	echo "<label class='form-check-label' for='choice_". $choiceID ."'>";
																				    	echo $choiceStr;
																				  	echo "</label>";
																				echo "</div>";
									                    					echo "</td>";
									                    				echo "</tr>";
										                    		}
										                    	echo "</table>";
									                    	echo "</td>";
									                    echo "</tr>";

							                    	}else if ($choicesCorrectAnsLen > 1){ // Checkbox

							                    		echo "<tr class='question_choice_separator'>";
								                    		echo "<td></td>";
								                    		echo "<td>";
								                    			echo "<table>";
										                    		for($j=0; $j<$choicesLen; $j++){

										                    			$choiceID = $choices[$j]['id'];
										                    			$choiceStr = $choices[$j]['choiceStr'];

									                    				echo "<tr>";
									                    					echo "<td>";
									                    						echo "<div class='form-check'>";
																				  	echo "<input class='form-check-input question_". $questionID ."' type='checkbox' id='choice_". $choiceID ."' data-choice-id='". $choiceID ."' value=''>";
																				  	echo "<label class='form-check-label' for='choice_". $choiceID ."'>";
																				    	echo $choiceStr;
																				  	echo "</label>";
																				echo "</div>";
									                    					echo "</td>";
									                    				echo "</tr>";
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
					                    	<tr>
					                    		<td colspan="2">
					                    			<div class="form-group">
						                                <button type="submit" class="btn btn-primary btn-submit-quiz">
						                                <span class="fa fa-plus-square"></span> Submit</button>
						                            </div>
					                    		</td>
					                    	</tr>
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

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p>Submitted successfully!</p>
    </div>

    <div class="loader_blocks"></div>

    <script type="text/javascript">
    	var quizID_global = <?php echo ($quiz_data != NULL) ? (sizeof($quiz_data) > 0) ? $quiz_data['id'] : 0 : 0; ?>;
    	var chapterID_global = <?php echo ($chapterData != NULL) ? (sizeof($chapterData) > 0) ? $chapterData['id'] : 0 : 0; ?>;
    	
    	// alert(chapterID_global);
    </script>