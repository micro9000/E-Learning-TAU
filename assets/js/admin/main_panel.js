$(document).ready(function(){
	get_all_students_quizzes_results();
});

function get_all_students_quizzes_results(){
	$.post(
		base_url + "get_all_stds_quizzes_results",
		function(data){
			// console.log(data);
			display_quizzes_results(data);
		}
	);
}

function display_quizzes_results(data){

	var display = "";

	$.each(data, function(i, result){
		display += "<tr>";

			display += "<td>"+ (i + 1) +"</td>";
			display += "<td>"+ result.dateTakenFormat +"</td>";
			display += "<td>"+ result.score +" / " + result.rightAnsLen +"</td>";
			display += "<td>"+ result.chapterTitle +"</td>";
			display += "<td>"+ result.quizTitle +"</td>";
			display += "<td>"+ result.stdName +"</td>";
			display += "<td>"+ result.stdNum +"</td>";
			display += "<td><a href='"+ base_url + "std_quiz_view_results/"+ result.id +"/"+ result.stdNum +"' target='_blank' style='color: blue; text-decoration: underline;'>results</a></td>";

		display += "</tr>";
	});

	$("#std_quizzes_results").html(display);

}