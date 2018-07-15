

$(".principleID").on("change", function(){

	var principleID = $(this).val();

	$.post(
		base_url + "get_principles_sub_topics_by_principle",
		{
			"principleID" : principleID
		},
		function(data){
			// console.log(data);

			var options = "<option></option>";

			$.each(data, function(i, topic){
				// console.log(topic.id);

				options += "<option value='"+ topic.id +"'>"+ topic.topic +"</option>";
			});

			$(".sub_topic_ID").html(options);
		}
	);

});


$(".btn-add-chapter").on("click", function(){
	var principleID = $(".principleID").val();
	var sub_topic_ID = $(".sub_topic_ID").val();
	var topic_chapter = $(".topic_chapter").val();

	$.post(
		base_url + "add_topic_new_chapter",
		{
			"principleID" : principleID,
			"topicID" : sub_topic_ID,
			"chapterTitle" : topic_chapter
		},
		function(data){
			// console.log(data);

			$("#topic_chapter_msg").html(data.msg);

			if (data.done === "TRUE"){
				setTimeout(function(){
					window.location.reload();
				}, 500);
			}
		}
	);
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
								display += "<a href='#' class='btn-edit-chapter' data-id='"+ chapter.id +"'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/edit.png' class='icon-edit'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";
						display += "<td>";
							display += "<abbr title='Delete' class='btn-delete-chapter' data-id='"+ chapter.id +"'>";
								display += "<a href='#'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";
					display += "</tr>";
				display += "</table>";
			display += "</td>";
		display += "</tr>";

	});

	$("#chapters_list_tb").html(display);
}

function get_all_chapters(){
	$.post(
		base_url + "get_all_chapters",
		function(data){
			// console.log(data);
			display_chapters(data);
		}	
	);
}

function get_chapter_by_id(chapterID){
	$.post(
		base_url + "get_chapter_by_id",
		{
			"chapterID" : chapterID
		},
		function(data){
			// console.log(data);
			$(".principleID").val(data.principleID).change();

			setTimeout(function(){
				$(".sub_topic_ID").val(data.topicID).change();
			}, 500);
			// 

		}
	);
}

function delete_topic_chapter(chapterID){
	$.post(
		base_url + "delete_topic_chapter",
		{
			"chapterID" : chapterID
		},
		function(data){
			// console.log(data);

			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);
}

$(document).ready(function(){

	$("#deleteDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('chapterID');
                delete_topic_chapter(id);

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
					window.location = base_url + "sub_topic_chapters";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    if (chapterID == 0){
    	get_all_chapters();
    }else if (chapterID > 0){
    	get_chapter_by_id(chapterID);
    }
});



$(".btn-update-chapter").on("click", function(){

	var chapterID = $(this).attr("data-id");
	var principleID = $(".principleID").val();
	var sub_topic_ID = $(".sub_topic_ID").val();
	var topic_chapter = $(".topic_chapter").val();

	$.post(
		base_url + "update_topic_chapter",
		{
			"chapterID" : chapterID,
			"principleID" : principleID,
			"topicID" : sub_topic_ID,
			"chapterTitle" : topic_chapter
		},
		function(data){
			console.log(data);

			$("#topic_chapter_msg").html(data.msg);

			if (data.done === "TRUE"){
				setTimeout(function(){
					window.location.reload();
				}, 500);
			}
		}
	);
});

$(".btn-cancel-update-chapter").on("click", function(){
	window.location = base_url + "sub_topic_chapters";
});

$(document).on("click", ".btn-edit-chapter", function(){
	var chapter = $(this).attr("data-id");
	window.location = base_url + "sub_topic_chapters/" + chapter;
});


$(document).on("click", ".btn-delete-chapter", function(){

	var chapterID = $(this).attr("data-id");

	if (chapterID != ""){
		$("#deleteDialog").data('chapterID', chapterID).dialog('open');
	}
});

$(".btn-refresh").on("click", function(){
	if (chapterID == 0){
    	get_all_chapters();
    }else if (chapterID > 0){
    	get_chapter_by_id(chapterID);
    }
});

$(".btn-search-chapter").on("click", function(){
	var search_str = $(".search-chapter").val();

	$.post(
		base_url + "search_topics_chapters",
		{
			"search_str" : search_str
		},
		function(data){
			// console.log(data);
			display_chapters(data);
		}
	);
})