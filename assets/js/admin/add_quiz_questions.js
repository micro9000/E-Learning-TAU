
var action_row = 0;

var current_choice_char = "a";

$(".btn-add-new-choice").on("click", function(){

	var choice_tmp = "";

	var new_index = (action_row + 1);

	current_choice_char = nextChar(current_choice_char);

	choice_tmp += "<tr id='choice_row_"+ new_index +"'>";
		// choice_tmp += "<td>"+ new_index +"</td>";
		choice_tmp += "<td>"+ current_choice_char +".</td>";
		choice_tmp += "<td class='ans'>";
			choice_tmp += "<div class='form-group'>";
				choice_tmp += "<div class='form-check'>";
			    	choice_tmp += "<input class='form-check-input choice_num_"+ new_index +"_ans' type='checkbox' id='right_ans_"+ new_index +"'>";
			    	choice_tmp += "<label class='form-check-label' for='right_ans_"+ new_index +"'> Answer </label>";
			    choice_tmp += "</div>";
			choice_tmp += "</div>";
		choice_tmp += "</td>"
		choice_tmp += "<td class='choice_str'>";
			choice_tmp += "<div class='form-group'>";
            	choice_tmp += "<input type='text' class='form-control input_choice choice_num_"+ new_index +"' placeholder='Choice'>";
            choice_tmp += "</div>";
		choice_tmp += "</td>";

		// choice_tmp += "<td>";
		// 	choice_tmp += "<a href='#' data-choice-idx='"+ new_index +"' class='btn-remove-choice-row'>Remove</a>";
		// choice_tmp += "</td>";
	choice_tmp += "</tr>";

	action_row += 1;
	// console.log(new_index);
	// console.log(action_row);
	$("#question_choices").append(choice_tmp);

});

$(".btn-add-question-choices").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var input_question = $(".input_question").val();
	var choice_len = $(".input_choice").length;

	var questionIDTmp = 0;


	var choice = "";
	var isAnsTrue = "";
	var isChoiceIsRightAns = 0;

	if (input_question != ""){
		if (choice_len > 0){

			if (quiz_id > 0){

				//Validation
				// Count number of right answer
				var countRightAns = 0;
				for(var i=0; i<choice_len; i++){
					isAnsTrue = $(".choice_num_"+ i +"_ans").prop("checked");

					if (isAnsTrue == true){
						countRightAns += 1;
					}
				}
				if (countRightAns == 0){
					$("#quiz_question_ans_msg").html("No Selected right answer");
					$(".loader_blocks").css("display", "none");
					return;
				}

				//Validation
				// choice is not empty string
				for(var i=0; i<choice_len; i++){
					choice = $(".choice_num_" + i).val();

					if (choice === ""){
						$("#quiz_question_ans_msg").html("Please fill up all choices");
						$(".loader_blocks").css("display", "none");
						return;
					}
				}

				choice = "";
				isAnsTrue = "";

				$.post(
					base_url + "add_quiz_question",
					{
						"quizID" : quiz_id,
						"question" : input_question
					},
					function(data){
						// console.log(data);

						$("#quiz_question_ans_msg").html(data.msg);

						if (data.done == "TRUE"){
							questionIDTmp = data.questionID;

							// console.log(questionIDTmp);

							var formData = new FormData();

							formData.append("questionID", questionIDTmp);
							formData.append("choiceLen", choice_len);

							for(var i=0; i<choice_len; i++){
								
								choice = $(".choice_num_" + i).val();
								isAnsTrue = $(".choice_num_"+ i +"_ans").prop("checked");


								if (choice !== ""){
									isChoiceIsRightAns = (isAnsTrue == true) ? 1 : 0; // 1 - right ans

									formData.append("choice_" + i, choice);
									formData.append("isChoiceIsRightAns_" + i, isChoiceIsRightAns);
								}

							}


							$.ajax({
							    url: base_url + "add_question_choice",
							    type: 'POST',
							    data: formData,
							    processData: false, // Don't process the files
							    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
							    success: function(data, textStatus, jqXHR) {
							    	// console.log(data);

							    	$("#quiz_question_ans_msg").html(data.msg);

							    	if (parseInt(quiz_id) > 0){
										get_all_quiz_questions(quiz_id);
									}

							    	$(".loader_blocks").css("display", "none");
							    }
							    
							});

						}else{
							$(".loader_blocks").css("display", "none");
						}

					}
				);

			}else{
				$("#quiz_question_ans_msg").html("Invalid quiz id");
			}

		}else{
			$("#quiz_question_ans_msg").html("Please add choices and right answer");
		}
	}else{
		$("#quiz_question_ans_msg").html("Please add question.");
	}

	// console.log(questions_len);

		

});

// $(document).on("click", ".btn-remove-choice-row", function(e){

// 	e.preventDefault();

// 	var choice_idx = $(this).attr("data-choice-idx");

// 	$("#question_choices tr#choice_row_" + choice_idx).remove();

// });

function nextChar(c) {
    return String.fromCharCode(c.charCodeAt(0) + 1);
}


function display_questions_choices(data){

	var display = "";

	$.each(data, function(i, question){

		// console.log(question);

		display += "<tr>";
		display += "<td>"+ (i + 1) +"</td>";

		display += "<td>";
			display += "<strong>"+ question.question +"</strong>";

			var choices = question.choices;

			display += "<table style='width: 100%; font-size: 8px; margin-top: 10px; '>";
				display += "<thead>";
					display += "<tr>";
						display += "<th>Letter</th>";
						display += "<th>Choice</th>";
						display += "<th>Answer</th>";
						display += "<th>Control</th>";
					display += "</tr>";
				display += "</thead>";
				display += "<tbody>";

				$.each(choices, function(j, choices){

					// console.log(choices);

					display += "<tr>";

						if (j == 0){
							display += "<td>a.</td>";
						}else{
							display += "<td>"+ nextChar('a') +"</td>";
						}

						display += "<td>"+ choices.choiceStr +"</td>";

						if (choices.isRightAns == "1"){
							display += "<td>True</td>";
						}else{
							display += "<td></td>";
						}

						display += "<td class='choice-btns'>";
							display += "<a href='#' class='btn-edit-choice' data-toggle='modal' data-target='#updateQuestionChoiceModal' data-id='"+ choices.id +"'>Edit</a>";
							display += "<a href='#' class='btn-delete-choice' data-id='"+ choices.id +"'>Delete</a>";
						display += "</td>";
						
					display += "</tr>";
				
			});
				display += "</tbody>";
			display += "</table>";
			
		display += "</td>";
		display += "<td>"+ question.facultyName +"</td>";
		display += "<td>"+ question.dateAddedFormatted +"</td>";
		display += "<td>";
			display += "<table class='table-control-btns'>";
				display += "<tr>";
					display += "<td>";
						display += "<abbr title='Edit'>";
							display += "<a href='#' class='btn-update-question' data-toggle='modal' data-target='#updateQuestionModal' data-id='"+ question.id +"'>";
								display += "<img src='"+ base_url +"assets/imgs/icons/edit.png' class='icon-edit'>";
							display += "</a>";	
						display += "</abbr>";
					display += "</td>";
					display += "<td>";
						display += "<abbr title='Delete' class='btn-delete-question' data-id='"+ question.id +"'>";
							display += "<a href='#'>";
								display += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
							display += "</a>";	
						display += "</abbr>";
					display += "</td>";
					display += "<td>";
							display += "<abbr title='Add Choice' class='btn-add-new-question-choice-modal' data-toggle='modal' data-target='#addQuestionChoiceModal'  data-id='"+ question.id +"'>";
								display += "<a href='#'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/add.png' class='icon-add'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";
				display += "</tr>";
			display += "</table>";
		display += "</td>";

		display += "</tr>";
	});

	$("#quiz_questions_list_tb").html(display);
}

function get_all_quiz_questions(quizID){

	$.post(
		base_url + "get_quiz_questions_and_choices_matrix",
		{"quizID" : quizID},
		function(data){
			// console.log(data);
			display_questions_choices(data);
		}
	);
}

$(document).ready(function(){

	if (parseInt(quiz_id) > 0){
		get_all_quiz_questions(quiz_id);
	}

	$("#deleteQuestionDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('questionID');
                // alert(id);
                delete_quiz_question(id);

                $(this).dialog('close');
            },
            NO: function(){
                $(this).dialog('close');
            }
        }
    });


    $("#deleteQuestionChoiceDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('choiceID');
                // alert(id);
                delete_question_choice(id);

                $(this).dialog('close');
            },
            NO: function(){
                $(this).dialog('close');
            }
        }
    });

     $("#actionMsgDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            OK: function(){
            	setTimeout(function(){
					window.location.reload();
				}, 500);
                $(this).dialog('close');
            }
        }
    });
});


function delete_quiz_question(questionID){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "delete_quiz_question",
		{
			"questionID" : questionID
		},
		function(data){
			// console.log(data);

			$(".loader_blocks").css("display", "none");

			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);

}

$(document).on("click", ".btn-delete-question", function(){

	var questionID = $(this).attr("data-id");

	if (questionID != "" || typeof questionID != 'undefined'){

		$("#deleteQuestionDialog").data('questionID', questionID).dialog('open');

	}

});

$(document).on("click",".btn-update-question",function(){
	var question_id = $(this).attr("data-id");

	$.post(
		base_url + "get_quiz_questions_by_id",
		{
			"questionID" : question_id
		},
		function(data){

			if (typeof data.id !== 'undefined'){
				if (data.id > 0){
					$("#to_update_question").val(data.question);

					$(".btn-update-quiz-question").attr("data-id",question_id);
				}else{
					$("#update_quiz_question_msg").html("Can't update this question").css('color', 'red');
				}
			}
				

		}
	);
});

$(".btn-update-quiz-question").on("click", function(){

	var question_id = $(this).attr("data-id");
	var updated_question = $("#to_update_question").val();

	if (question_id != "" && updated_question != ""){

		$(".loader_blocks").css("display", "block");

		$.post(
			base_url + "update_quiz_question",
			{
				"questionID" : question_id,
				"question" : updated_question
			},
			function(data){
				// console.log(data);

				// $(".loader_blocks").css("display", "none");

				alert(data.msg);

				window.location.reload();
			}
		);

	}


});


$(document).on("click", ".btn-edit-choice", function(){
	var choice_id = $(this).attr("data-id");

	if (choice_id != ""){
		$.post(
			base_url + "get_questions_choice_by_id",
			{
				"choiceID" : choice_id
			},
			function(data){

				if (typeof data.id !== 'undefined'){
					if (data.id > 0){
						$("#to_update_choice").val(data.choiceStr);

						$(".btn-update-question-choice").attr("data-id",choice_id);
					}else{
						$("#update_question_choice_msg").html("Can't update this choice").css('color', 'red');
					}
				}

			}
		);
	}
});


$(".btn-update-question-choice").on("click", function(){

	var choiceID = $(this).attr("data-id");
	var choice = $("#to_update_choice").val();

	if (choiceID !== "" && choice !== ""){
		// alert("HI");
		$.post(
			base_url + "update_question_choice",
			{
				"choiceID" : choiceID,
				"choice" : choice
			},
			function(data){
				// console.log(data);

				alert(data.msg);

				window.location.reload();
			}
		);
	}
		
});

function delete_question_choice(choiceID){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "delete_question_choice",
		{
			"choiceID" : choiceID
		},
		function(data){
			// console.log(data);

			$(".loader_blocks").css("display", "none");

			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);

}


$(document).on("click", ".btn-delete-choice", function(e){
	e.preventDefault();

	var choiceID = $(this).attr("data-id");

	if (choiceID != "" || typeof choiceID != 'undefined'){

		$("#deleteQuestionChoiceDialog").data('choiceID', choiceID).dialog('open');

	}
});

$(document).on("click", ".btn-add-new-question-choice-modal", function(){
	var questionID = $(this).attr("data-id");

	if (questionID !== ""){
		$(".btn-add-new-question-choice").attr("data-question-id", questionID);
	}
});

$(".btn-add-new-question-choice").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var isAnsTrue = $("#new_choice_right_ans").prop("checked");
	var isAns = (isAnsTrue == true) ? 1 : 0;

	var questionID = $(this).attr("data-question-id");
	var new_choice = $("#new_question_choice").val();

	if (questionID !== "" && new_choice !== ""){

		$.post(
			base_url + "add_new_question_choice",
			{
				"questionID" : questionID,
				"choice" : new_choice,
				"isAns" : isAns
			},
			function(data){
				// console.log(data);

				alert(data.msg);

				window.location.reload();

			}
		);

	}

});