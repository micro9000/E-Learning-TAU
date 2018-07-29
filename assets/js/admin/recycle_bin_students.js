$(document).ready(function(){

	$("#restoreDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('studentID');

                restore_deleted_students(id);

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
					window.location = base_url + "recycle_bin_students";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    get_all_deleted_students();
});

function display_students(data){
	
	var display = "";
	$.each(data, function(i, student){
		display += "<tr>";
			display += "<td>"+ (i + 1) +"</td>";
			display += "<td>"+ student.stdNum +"</td>";
			display += "<td>"+ student.firstName +" "+ student.lastName +"</td>";
			display += "<td>"+ student.email +"</td>";
			display += "<td>"+ student.dateRegisteredFormated +"</td>";
			display += "<td>";
				display += "<table class='table-control-btns'>";
					display += "<tr>";

						display += "<td>";
							display += "<abbr title='Edit'>";
								display += "<a href='#' class='btn-undo-student' data-id='"+ student.id +"'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/undo.png' class='icon-undo'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";

						// display += "<td>";
						// 	display += "<abbr title='Delete' class='btn-delete-student' data-id='"+ student.id +"'>";
						// 		display += "<a href='#'>";
						// 			display += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
						// 		display += "</a>";	
						// 	display += "</abbr>";
						// display += "</td>";

					display += "</tr>";
				display += "</table>";
			display += "</td>";
		display += "</tr>";
		display += "</tr>";
	});

	$(".deleted_students").html(display);

	$(".loader_blocks").css("display", "none");
}


function get_all_deleted_students(){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_deleted_students",
		function(data){
			// console.log(data);
			display_students(data);
		}
	);
}

$(document).on("click", ".btn-undo-student", function(){

	var studentID = $(this).attr("data-id");

	if (studentID != ""){
		$("#restoreDialog").data('studentID', studentID).dialog('open');
	}

});

function restore_deleted_students(studentID){
	$.post(
		base_url + "restore_deleted_student_data",
		{
			"studentID" : studentID
		},
		function(data){
			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);
}

$(".btn-refresh").on("click", function(){
	get_all_deleted_students();
});

$(".btn-search-deleted-students").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var search_students = $(".search-students").val();

	$.post(
		base_url + "search_deleted_students",
		{
			"searchStr" : search_students
		},
		function(data){
			display_students(data);
		}
	);

});