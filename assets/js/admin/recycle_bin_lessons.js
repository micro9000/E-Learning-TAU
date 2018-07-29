$(document).ready(function(){

	$("#restoreDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('lessonID');
                	
                restore_deleted_lesson(id);

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
            	// get_all_principles();
            	setTimeout(function(){
					window.location = base_url + "recycle_bin_lessons";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    get_all_deleted_lessons_by_current_user();
});

function display_deleted_lessons(data){
	var display = "";

	$.each(data, function(i, lesson){

		display += "<tr>";
			display += "<td>"+ (i + 1) +"</td>";
			display += "<td>"+ lesson.title +"</td>";
			display += "<td>"+ lesson.chapterTitle +"</td>";
			display += "<td>"+ lesson.topic +"</td>";
			display += "<td>"+ lesson.principle +"</td>";
			display += "<td>"+ lesson.AddedByUser +"</td>";

			display += "<td>";
				display += "<table class='table-control-btns'>";
					display += "<tr>";

						display += "<td>";
							display += "<abbr title='Restore'>";
								display += "<a href='#' class='btn-undo-lesson' data-id='"+ lesson.id +"'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/undo.png' class='icon-undo'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";

						// display += "<td>";
						// 	display += "<abbr title='Delete' class='btn-delete-principle' data-id='"+ lesson.id +"'>";
						// 		display += "<a href='#'>";
						// 			display += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
						// 		display += "</a>";	
						// 	display += "</abbr>";
						// display += "</td>";

					display += "</tr>";
				display += "</table>";
			display += "</td>";

		display += "</tr>";

	});

	$(".deleted_principles").html(display);

	$(".loader_blocks").css("display", "none");
}

function get_all_deleted_lessons_by_current_user(){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_deleted_lessons_by_current_user",
		function(data){
			display_deleted_lessons(data);
		}
	);
}

$(document).on("click", ".btn-undo-lesson", function(){

	var lessonID = $(this).attr("data-id");

	if (lessonID != ""){
		$("#restoreDialog").data('lessonID', lessonID).dialog('open');
	}
});


function restore_deleted_lesson(lessonID){
	$.post(
		base_url + "restore_deleted_lesson",
		{
			"lessonID" : lessonID
		},
		function(data){
			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);
}

$(".btn-refresh").on("click", function(){
	get_all_deleted_lessons_by_current_user();
});

$(".btn-search-deleted-lessons").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var search_lesson = $(".search-lessons").val();

	$.post(
		base_url + "search_deleted_lessons",
		{
			"search_str" : search_lesson
		},
		function(data){
			display_deleted_lessons(data);
		}
	);
});