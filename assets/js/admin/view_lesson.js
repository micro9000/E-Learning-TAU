$(document).ready(function(){
	if (lessonID > 0){
		get_all_lesson_comments(lessonID);
	}
});

function display_comments(data){
	var display = "";

	$.each(data, function(i, comment){

		display += "<div class='card comments_wrapper'>";
			display += "<div class='card-header'>";
				display += "<span class='fa fa-comment-alt'></span><strong> "+ comment.commentedBy +"</strong> made post " + comment.timelapse;
			display += "</div>";
			display += "<div class='card-body'>";
				display += "<p class='card-text'>"+ comment.comments +"</p>";
			display += "</div>";

			// if (stdNum == comment.stdNum_facNum){
			// 	display += "<div class='card-footer'>";
			// 		display += "<button class='btn btn-primary'><span class='fa fa-trash-alt'></span> Delete</button> ";
			// 		// display += "<button class='btn btn-primary'><span class='fa fa-edit'></span> Edit</button>";
			// 	display += "</div>";
			// }

			
		display += "</div>";

	});

	$(".comments_list").html(display);
}

function get_all_lesson_comments(lessonIDTmp){
	$.post(
		base_url + "get_all_lesson_comments",
		{'lessonID' : lessonIDTmp},
		function(data){
			// console.log(data);
			display_comments(data);
		}
	);
}

$(".btn-add-comment").on("click", function(){

	var comments = $(".lesson_comments").val();
	var lessonID = $(this).attr("data-lesson-id");

	$.post(
		base_url + "faculty_add_lesson_comment",
		{
			"lessonID" : lessonID,
			"comments" : comments
		},
		function(data){
			// console.log(data);
			if (data.done == "TRUE"){
				
				$("#share_comment_msg").html(data.msg);

				setTimeout(function(){
					$(".lesson_comments").val("");
					$("#share_comment_msg").html("");

					if (lessonID > 0){
						get_all_lesson_comments(lessonID);
					}
				}, 1000);
					
			}
		}
	);

});

