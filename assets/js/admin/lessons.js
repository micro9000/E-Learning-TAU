$(".advance_search_date_range").datepicker();

$(document).ready(function(){
	get_all_lessons_by_current_user();
});

$(".btn-refresh").on("click", function(){
	get_all_lessons_by_current_user();
});

function get_all_lessons_by_current_user(){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_lessons_by_current_user",
		function(data){
			pagination_and_display(data);
		}
	);
}

function pagination_and_display(data){
	display_result_counts(data);
	$('#lessons_pagination').pagination({
	    dataSource: data,
	    pageSize: 5,
        autoHidePrevious: true,
	    autoHideNext: true,
	    callback: function(data, pagination) {
	        display_lessons(data);
	    }
	});
}


function limit_200_words($s) {
    return preg_replace('/((\w+\W*){199}(\w+))(.*)/', '${1}', $s);    
}

function display_result_counts(data) {
	$("#search_length").html("Results: " + data.length);
}

function display_lessons(data){
	
	var display = "";
	var limit_content;

	var contentTmp = "";
	var randomNumber = 0;
	var substringLen = [500, 400, 450, 300, 600, 550, 350, 480, 650, 580];

	$.each(data, function(i, lesson){

		display += "<div class='content-panel'>";
			display += "<div class='post_wrapper'>";

				display += "<div class='post_date'>";
				display += lesson.dateAddedFormated +" / "+ lesson.principle +" / "+ lesson.topic +" / "+ lesson.chapterTitle;
				display += "</div>";

				display += "<div class='post_title'><h3>"+ lesson.title +"</h3></div>";

				display += "<div class='post_by'> By ";
				display += lesson.AddedByUser;
				display += "</div>";

				if (lesson.content.match(/<p>(.*?)<\/p>/g) !== null){
					limit_content = lesson.content.match(/<p>(.*?)<\/p>/g).map(function(val){
						return val.replace(/<\/?p>/g,'');
					 });
				}else{
					limit_content = lesson.content;
				}

				for(var j=0; j<limit_content.length; j++){
					if (limit_content[j].indexOf("<img") === -1){
						contentTmp += limit_content[j];
					}
				}

				randomNumber = Math.floor((Math.random() * 10) + 1);

				display += "<div class='post_description'>";
				display += "<p>" + contentTmp.substring(0, substringLen[randomNumber]) + "...<a href='"+ base_url + "faculty_view_lesson/"+ lesson.id + "/"+ lesson.slug +"' class='link-read-more'>Read more</a></p>";
				display += "</div>";

				// display += "<div class='post_description'>";
				// display += "<p>" + limit_content[0].substring(0, 400) + "...<a href='#' class='link-read-more'>Read more</a></p>";
				// display += "</div>";

				contentTmp = "";

				display += "<div class='action_buttons'>";
					display += "<table>";
                        display += "<tr>";

                        	if (userType === "admin_faculty" || userType == "dean_admin_faculty"){
                        		display += "<td>";
	                                display += "<a href='#' class='btn-delete-lesson' data-lesson-id='"+ lesson.id +"'><span class='fa fa-trash-alt'></span> Delete</a>";
	                            display += "</td>";
                        	}

                            display += "<td>";
                                display += "<a href='"+ base_url + "add_lessons/" + lesson.id +"' data-lesson-id='"+ lesson.id +"'><span class='fa fa-edit'></span> Update</a>";
                            display += "</td>";

                            display += "<td>";
                                display += "<a href='"+ base_url + "view_lesson_update_summary/"+ lesson.id +"/"+ lesson.slug +"' target='_blank'><span class='fa fa-eye'></span> Update Summary</a>";
                            display += "</td>";

                        display += "</tr>";
                    display += "</table>";
                display += "</div>";

			display += "</div>";
		display += "</div>";

	});

	$("#search_lessons_results").html(display);

	$(".loader_blocks").css("display", "none");
}

$(".btn-search-lessons").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var search_str = $(".search-lessons").val();

	if (search_str !== ""){
		$.post(
			base_url + "search_lessons",
			{
				"search_str" : search_str
			},
			function(data){
				// console.log(data);
				pagination_and_display(data);
			}
		);
	}else{
		$(".loader_blocks").css("display", "none");
	}
		
});

$(".principleID").on("change", function(){

	$(".loader_blocks").css("display", "block");

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

			$(".loader_blocks").css("display", "none");
		}
	);

});


$(".sub_topic_ID").on("change", function(){

	$(".loader_blocks").css("display", "block");

	var sub_topic_ID = $(this).val();

	$.post(
		base_url + "get_all_chapters_by_topic_id",
		{
			"topicID" : sub_topic_ID
		},
		function(data){
			// console.log(data);

			var options = "<option></option>";

			$.each(data, function(i, chapter){
				options += "<option value='"+ chapter.id +"'>"+ chapter.chapterTitle +"</option>";
			});

			$("#select_chapter_ID").html(options);

			$(".loader_blocks").css("display", "none");
		}
	);

});


$(".btn-advance-search-lesson").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var principleID = $(".principleID").val();
	var topicID = $(".sub_topic_ID").val();
	var chapterID = $(".chapter_id").val();
	var lesson_title = $(".lesson_title").val();
	var faculty_id_number = $(".faculty_id_number").val();

	var startDate = $("#addedStartDate").val();
	var endDate = $("#addedEndDate").val();

	$.post(
		base_url + "advance_search_lessons",
		{
			"principleID" : principleID,
			"topicID" : topicID,
			"chapterID" : chapterID,
			"lesson_title" : lesson_title,
			"faculty_id_number" : faculty_id_number,
			"startDate" : startDate,
			"endDate" : endDate
		},
		function(data){
			// console.log(data);
			pagination_and_display(data);
			$(".btn-close-advance-search").trigger("click");
		}
	);
});

function delete_lesson(id){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "delete_lesson",
		{
			"lessonID" : id
		},
		function(data){
			// console.log(data);

			$(".loader_blocks").css("display", "none");

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

                var id = $(this).data('lesson_id');
                // alert(id);
                delete_lesson(id);

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
					window.location = base_url + "chapters_lessons";
				}, 500);
                $(this).dialog('close');
            }
        }
    });
})

$(document).on("click", ".btn-delete-lesson", function(e){

	e.preventDefault();

	var lesson_id = $(this).attr("data-lesson-id");

	if (lesson_id != ""){
		$("#deleteDialog").data('lesson_id', lesson_id).dialog('open');
	}
});