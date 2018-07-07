
$(".btn-add-sub-topic").on("click", function(){

	var principleID = $(".principleID").val();
	var principle_sub_topic = $(".principle_sub_topic").val();

	// console.log(principleID);
	$.post(
		base_url + "add_principle_sub_topic",
		{
			"principleID" : principleID,
			"sub_topic" : principle_sub_topic
		},
		function(data){
			// console.log(data);

			$("#principle_sub_topic_msg").html(data.msg);
			setTimeout(function(){
				window.location.reload();
			}, 500);
		}
	);

});

function get_all_principles_sub_topics(){
	$.post(
		base_url + "get_all_principles_sub_topic",
		function(data){
			console.log(data);
			display_sub_topics(data);
		}
	);
}

function display_sub_topics(data){
	var sub_topics = "";

	$.each(data, function(i, topics){

		sub_topics += "<tr>";
			sub_topics += "<td>"+ (i + 1) +"</td>";
			sub_topics += "<td>"+ topics.topic +"</td>";
			sub_topics += "<td>"+ topics.principle +"</td>";
			sub_topics += "<td>"+ topics.facultyName +"</td>";
			sub_topics += "<td>"+ topics.dateAdded +"</td>";
			sub_topics += "<td>"+ topics.dateModify +"</td>";

			sub_topics += "<td>";
				sub_topics += "<table class='table-control-btns'>";
					sub_topics += "<tr>";
						sub_topics += "<td>";
							sub_topics += "<abbr title='Edit'>";
								sub_topics += "<a href='#' class='btn-edit-topic' data-id='"+ topics.id +"'>"; //data-principle-id='"+ topics.principleID +"'
									sub_topics += "<img src='"+ base_url +"assets/imgs/icons/edit.png' class='icon-edit'>";
								sub_topics += "</a>";	
							sub_topics += "</abbr>";
						sub_topics += "</td>";
						sub_topics += "<td>";
							sub_topics += "<abbr title='Delete' class='btn-delete-topic' data-id='"+ topics.id +"'>";
								sub_topics += "<a href='#'>";
									sub_topics += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
								sub_topics += "</a>";	
							sub_topics += "</abbr>";
						sub_topics += "</td>";
					sub_topics += "</tr>";
				sub_topics += "</table>";
			sub_topics += "</td>";

		sub_topics += "</tr>";

	});

	$("#sub_topics_list_tb").html(sub_topics);
}

function delete_principle_sub_topic(topicID){
	if (topicID != ""){
		$.post(
			base_url + "delete_principle_sub_topic",
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
}

$(document).ready(function(){

	$("#deleteDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('topicID');

                delete_principle_sub_topic(id);

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
					window.location.reload();;
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    if (topicID == 0){
    	get_all_principles_sub_topics();
    }
	
});

$(document).on("click", ".btn-delete-topic", function(){

	var topicID = $(this).attr("data-id");

	if (topicID != ""){
		$("#deleteDialog").data('topicID', topicID).dialog('open');
	}

});

$(document).on("click", ".btn-edit-topic", function(){
	var topicID = $(this).attr("data-id");

	window.location = base_url + "admin_principles_sub_topics/" + topicID;
});

$(".btn-cancel-update-sub-topic").on("click", function(){
	window.location = base_url + "admin_principles_sub_topics";
});