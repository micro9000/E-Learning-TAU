$(".loader_blocks").css("display", "block");

$(document).ready(function(){
	$(".loader_blocks").css("display", "none");

	$("#actionMsgDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            OK: function(){
            	var id = $(this).data('resultsID');

            	window.location = base_url + "chapter_take_quiz_results/" + id;

                $(this).dialog('close');
            }
        }
    });
})

$(".btn-submit-quiz").on("click", function(){

	if (quizID_global > 0){
		$(".loader_blocks").css("display", "block");

		$.post(
			base_url + "get_quiz_questions_and_choices_matrix",
			{"quizID" : quizID_global},
			function(data){
				console.log(data);
				var questionLen = data.length;

				var answersArr = [];
				var answersArrTmp = {};

				for (var i=0; i<questionLen; i++){

					var questionID = data[i].id;
					// console.log(questionID);
					var questionRightAnsLen = data[i].choicesCorrectAnsLen;
					var choices = data[i].choices;
					var choicesLen = choices.length;


					for(var j=0; j<choicesLen; j++){

						choiceID = choices[j].id;

						if (questionRightAnsLen >= 1){
							if ($("#choice_" + choiceID).prop("checked") == true){
								// console.log(choiceID + " - " + questionID +" - " + quizID_global +" - "+ chapterID_global);
								answersArrTmp = {
										"chapterID" : chapterID_global,
										"quizID" : quizID_global,
										"questionID" : questionID,
										"choiceID" : choiceID
									}

								answersArr.push(answersArrTmp);
							}
						}

					}

				}
				// console.log(answersArr);
				$.post(
					base_url + "insert_student_quiz_answer",
					{"ans" : answersArr},
					function(data){
						console.log(data);

						if (data.done == "TRUE"){
							setTimeout(function(){

								$("#actionMsgDialog").data('resultsID', data.quiz_results_ID).dialog('open');
								$(".loader_blocks").css("display", "none");

							}, 5000);
						}
					}
				);

			}
		);
	}

	
});