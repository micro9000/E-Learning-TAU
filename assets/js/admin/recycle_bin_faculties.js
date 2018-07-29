$(document).ready(function(){

	$("#restoreDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('facultyID');
                
                restore_faculty(id);

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
					window.location = base_url + "recycle_bin_principle";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    get_all_deleted_faculties();
});

function display_faculties(data){
	// console.log(data);
	var display = "";

	$.each(data, function(i, faculty){
		display += "<tr>";
			display += "<td>"+ (i + 1) +"</td>";
			display += "<td>"+ faculty.facultyIDNum +"</td>";
			display += "<td>"+ faculty.firstName +" "+ faculty.lastName +"</td>";
			display += "<td>"+ faculty.email +"</td>";
			display += "<td>"+ faculty.dateRegisteredFormated +"</td>";
			display += "<td>"+ faculty.addedBy +"</td>";

			if (faculty.isAdmin == "1"){
				display += "<td style='text-align:center'><span class='fa fa-check-circle'></span></td>";
			}else{
				display += "<td></td>";
			}

			if (faculty.isDean == "1"){
				display += "<td style='text-align:center'><span class='fa fa-check-circle'></span></td>";
			}else{
				display += "<td></td>";
			}
			
			display += "<td>";
				display += "<table class='table-control-btns'>";
					display += "<tr>";

						display += "<td>";
							display += "<abbr title='Undo'>";
								display += "<a href='#' class='btn-undo-faculty' data-id='"+ faculty.id +"'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/undo.png' class='icon-undo'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";

						// display += "<td>";
						// 	display += "<abbr title='Delete' class='btn-delete-faculty' data-id='"+ faculty.id +"'>";
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

	$(".deleted_faculties").html(display);

	$(".loader_blocks").css("display", "none");
}


function get_all_deleted_faculties(){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_deleted_faculties",
		function(data){
			display_faculties(data);
		}
	);
}

$(document).on("click", ".btn-undo-faculty", function(data){
	var facultyID = $(this).attr("data-id");

	if (facultyID != ""){
		$("#restoreDialog").data('facultyID', facultyID).dialog('open');
	}
});

function restore_faculty(facultyID){
	$.post(
		base_url + "restore_deleted_faculty_data",
		{
			"facultyID" : facultyID
		},
		function(data){
			console.log(data);
		}
	);
}

$(".btn-refresh").on("click", function(){
	get_all_deleted_faculties();
});

$(".btn-search-deleted-faculties").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var search_faculty = $(".search-faculties").val();

	$.post(
		base_url + "search_deleted_faculty",
		{
			"searchStr" : search_faculty
		},
		function(data){
			display_faculties(data);
		}
	);

});