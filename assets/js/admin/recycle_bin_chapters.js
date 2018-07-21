$(document).ready(function(){

	$("#restoreDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('chapterID');
                
                restore_deleted_chapter(id);

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
					window.location = base_url + "recycle_bin_chapters";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    get_all_deleted_chapters();
});


function display_chapters(data){
	var display = "";

	$.each(data, function(i, chapter){

		display += "<tr>";
			display += "<td>"+ (i + 1) +"</td>";
			display += "<td>"+ chapter.chapterTitle +"</td>";
			display += "<td>"+ chapter.topic +"</td>";
			display += "<td>"+ chapter.principle +"</td>";
			display += "<td>"+ chapter.facultyName +"</td>";
			display += "<td>"+ chapter.dateAddedFormated +"</td>";
			display += "<td>"+ chapter.dateModifyFormated +"</td>";
			display += "<td>";
				display += "<table class='table-control-btns'>";
					display += "<tr>";

						display += "<td>";
							display += "<abbr title='Edit'>";
								display += "<a href='#' class='btn-undo-chapter' data-id='"+ chapter.id +"'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/undo.png' class='icon-undo'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";

						// display += "<td>";
						// 	display += "<abbr title='Delete' class='btn-delete-chapter' data-id='"+ chapter.id +"'>";
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

	$(".deleted_chapters").html(display);
}


function get_all_deleted_chapters(){
	$.post(
		base_url + "get_all_deleted_topics_chapters",
		function(data){
			display_chapters(data);
		}
	);
}


$(document).on("click", ".btn-undo-chapter", function(){
	var chapterID = $(this).attr("data-id");

	if (chapterID != ""){
		$("#restoreDialog").data('chapterID', chapterID).dialog('open');
	}
});

function restore_deleted_chapter(chapterID) {
	$.post(
		base_url + "restore_deleted_topic_chapter",
		{
			"chapterID" : chapterID
		},
		function(data){
			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);
}

$(".btn-refresh").on("click", function(){
	get_all_deleted_chapters();
});

$(".btn-search-deleted-chapters").on("click", function(){

	var search_chapter = $(".search-chapters").val();

	$.post(
		base_url + "search_deleted_topics_chapters",
		{
			"search_str" : search_chapter
		},
		function(data){
			display_chapters(data);
		}
	);

});