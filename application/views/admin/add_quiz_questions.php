
    <div class="container">
        <div class="row">

        	<?php if (sizeof($quiz_data) > 0 && isset($quiz_data['id'])) : ?>

	            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                <h4>Quiz: <?php echo $quiz_data['quizTitle']; ?></h4>
	                <div class="line"></div>
	            </div>

	            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	               	<div class="form-group">
	                    <label for="input_question">Question</label>
	                    <input type="text" class="form-control input_question" id="input_question" placeholder="Question">
	                </div>

	                <table class="table table-bordered table-hover">
	                	<thead>
	                		<tr>
	                			<!-- <th style="width: 5%;">#</th> -->
	                			<th style="width: 5%;">Letter</th>
	                			<th style="width: 10%; text-align: center">Right Ans?</th>
	                			<th>Choice
	                				<button type="submit" class="btn btn-primary btn-add-new-choice" style="font-size: 10px; padding: 2px;">
				                		<span class="fa fa-plus-square"></span> Add choice
				                	</button>
				                	<!-- <button type="submit" class="btn btn-primary btn-reset" style="font-size: 10px; padding: 2px;">
				                		<span class="fa fa-sync-alt"></span> Reset
				                	</button> -->
	                			</th>
	                			<!-- <th style="width: 5%;"></th> -->
	                		</tr>
	                	</thead>
	                	<tbody id="question_choices">
	                		<tr>
	                			<!-- <td>1</td> -->
	                			<td>a.</td>
		                		<td class="ans">
		                			<div class="form-group">
									    <div class="form-check">
									      	<input class="form-check-input choice_num_0_ans" type="checkbox" id="right_ans_0">
									      	<label class="form-check-label" for="right_ans_0"> Answer </label>
									    </div>
									</div>
		                		</td>
		                		<td class="choice_str">
		                			<div class="form-group">
					                    <input type="text" class="form-control input_choice choice_num_0" placeholder="Choice">
					                </div>
		                		</td>
		                		<!-- <td></td> -->
		                	</tr>
	                	</tbody>
		                	
	                </table>

	                <div class="form-group">
	                	<button type="submit" class="btn btn-primary btn-add-question-choices">
	                		<span class="fa fa-plus-square"></span> Submit
	                	</button>
	                    <div id="quiz_question_ans_msg"></div>
	                </div>


	            	<div class="line"></div>
	            	<br/>
	            </div>

	            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

	            	<table class="table table-sm table-striped table-bordered table-hover">
	                    <thead>
	                        <tr>
	                            <th scope="col" style="width: 5%;">#</th>
	                            <th scope="col">Question</th>
	                            <th scope="col" style="width: 15%;">User</th>
	                            <th scope="col" style="width: 15%;">Date Added</th>
	                            <th scope="col" style="width: 10%;">Control</th>
	                        </tr>
	                    </thead>
	                    <tbody id="quiz_questions_list_tb">
	                    </tbody>   
	                </table>

	            </div>

	        <?php else: ?>

	        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                <h4>Quiz Not found</h4>
	            </div>

	        <?php endif; ?>

        </div>
    </div>
    
    <div class="loader_blocks"></div>

    <!-- Update Quiz Question -->
    <div class="modal fade" id="updateQuestionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Question</h5>
                <button type="button" class="close btn-close-advance-search" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            
                            <div class="form-group">
                                <input type="text" class="form-control quiz_question" id="to_update_question" placeholder="Question *">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-update-quiz-question">
                                <span class="fa fa-edit"></span> Update</button>
                            </div>
                            <p id="update_quiz_question_msg"></p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div>
    </div>


    <!-- Update Question Choice-->
    <div class="modal fade" id="updateQuestionChoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Choice</h5>
                <button type="button" class="close btn-close-advance-search" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            
                            <div class="form-group">
                                <input type="text" class="form-control" id="to_update_choice" placeholder="Choice *">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-update-question-choice">
                                <span class="fa fa-edit"></span> Update</button>
                            </div>
                            <p id="update_question_choice_msg"></p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div>
    </div>


    <!-- Add Question Choice-->
    <div class="modal fade" id="addQuestionChoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new choice</h5>
                <button type="button" class="close btn-close-advance-search" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            
                            <div class="form-group">
							    <div class="form-check">
							      	<input class="form-check-input choice_num_0_ans" type="checkbox" id="new_choice_right_ans">
							      	<label class="form-check-label" for="new_choice_right_ans"> Answer </label>
							    </div>
							</div>

                            <div class="form-group">
                                <input type="text" class="form-control" id="new_question_choice" placeholder="Choice *">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-add-new-question-choice">
                                <span class="fa fa-edit"></span> Add</button>
                            </div>
                            <p id="add_question_choice_msg"></p>

                        </div>
                    </div>
                </div>

            </div>
        </div>
      </div>
    </div>
    
    <!-- Hidden by default -->
    <div id="deleteQuestionDialog" title="Delete Question">
        <p>Are you sure you want to delete this question?</p>
    </div>


    <!-- Hidden by default -->
    <div id="deleteQuestionChoiceDialog" title="Delete Choice">
        <p>Are you sure you want to delete this choice?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>

    <script type="text/javascript">
    	var quiz_id = "<?php echo (isset($quizID)) ? $quizID : 0; ?>";
    </script>