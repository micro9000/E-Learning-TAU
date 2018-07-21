$(document).ready(function(){

		$("#restoreDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('topicID');
                
                restore_sub_topic(id);

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
					window.location = base_url + "recycle_bin_principle_sub_topic";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    get_all_deleted_sub_topics();
});

function display_sub_topics(data){
	var sub_topics = "";

	$.each(data, function(i, topics){

		sub_topics += "<tr>";
			sub_topics += "<td>"+ (i + 1) +"</td>";
			sub_topics += "<td>"+ topics.topic +"</td>";
			sub_topics += "<td>"+ topics.principle +"</td>";
			sub_topics += "<td>"+ topics.facultyName +"</td>";
			sub_topics += "<td>"+ topics.dateAddedFormated +"</td>";
			sub_topics += "<td>"+ topics.dateModifyFormated +"</td>";

			sub_topics += "<td>";
				sub_topics += "<table class='table-control-btns'>";
					sub_topics += "<tr>";

						sub_topics += "<td>";
							sub_topics += "<abbr title='Restore'>";
								sub_topics += "<a href='#' class='btn-undo-topic' data-id='"+ topics.id +"'>"; //data-principle-id='"+ topics.principleID +"'
									sub_topics += "<img src='"+ base_url +"assets/imgs/icons/undo.png' class='icon-undo'>";
								sub_topics += "</a>";	
							sub_topics += "</abbr>";
						sub_topics += "</td>";

						// sub_topics += "<td>";
						// 	sub_topics += "<abbr title='Delete' class='btn-delete-topic' data-id='"+ topics.id +"'>";
						// 		sub_topics += "<a href='#'>";
						// 			sub_topics += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
						// 		sub_topics += "</a>";	
						// 	sub_topics += "</abbr>";
						// sub_topics += "</td>";

					sub_topics += "</tr>";
				sub_topics += "</table>";
			sub_topics += "</td>";

		sub_topics += "</tr>";

	});

	$(".deleted_sub_topics").html(sub_topics);
}

function get_all_deleted_sub_topics(){
	$.post(
		base_url + "get_all_deleted_principles_sub_topics",
		function(data){
			display_sub_topics(data);
		}
	);
}

$(".btn-refresh").on("click", function(){
	get_all_deleted_sub_topics();
});

$(document).on("click", ".btn-undo-topic", function(){

	var topicID = $(this).attr("data-id");

	if (topicID != ""){
		$("#restoreDialog").data('topicID', topicID).dialog('open');
	}

});


function restore_sub_topic(topicID){
	$.post(
		base_url + "restore_principle_sub_topic",
		{
			"topicID" : topicID
		},
		function(data){
			// console.log(data);
			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);
}



$(".btn-search-deleted-sub-topic").on("click", function(){
	var search_sub_topic = $(".search-sub-topic").val();

	$.post(
		base_url + "search_deleted_principles_sub_topics",
		{
			"searchStr" : search_sub_topic
		},
		function(data){
			display_sub_topics(data);
		}
	);
});