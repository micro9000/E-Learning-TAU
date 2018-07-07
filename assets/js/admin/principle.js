
$(".btn-add-principle").on("click", function(){

	var agriculture_principle = $(".agriculture_principle").val();

	$.post(
		base_url + "add_agri_principle",
		{
			"principle" : agriculture_principle
		},
		function(data){
			// console.log(data);

			$("#agriculture_principle_msg").html(data.msg);

			setTimeout(function(){
				window.location = base_url + "admin_agriculture_principles";
			}, 500);
		}
	);

});

function display_principles_on_table(data){
	
	var principles = "";

	$.each(data, function(i, principleList){

		principles += "<tr>";
			principles += "<td>"+ (i + 1) +"</td>";
			principles += "<td>"+ principleList.principle +"</td>";
			principles += "<td>"+ principleList.facultyName +"</td>";
			principles += "<td>"+ principleList.dateAdded +"</td>";
			principles += "<td>"+ principleList.dateModify +"</td>";
			
			principles += "<td>";
				principles += "<table class='table-control-btns'>";
					principles += "<tr>";
						principles += "<td>";
							principles += "<abbr title='Edit'>";
								principles += "<a href='#' class='btn-edit-principle' data-id='"+ principleList.id +"'>";
									principles += "<img src='"+ base_url +"assets/imgs/icons/edit.png' class='icon-edit'>";
								principles += "</a>";	
							principles += "</abbr>";
						principles += "</td>";
						principles += "<td>";
							principles += "<abbr title='Delete' class='btn-delete-principle' data-id='"+ principleList.id +"'>";
								principles += "<a href='#'>";
									principles += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
								principles += "</a>";	
							principles += "</abbr>";
						principles += "</td>";
					principles += "</tr>";
				principles += "</table>";
			principles += "</td>";
			
		principles += "</tr>";
	});

	$("#principle_list_tb").html(principles);
}

function get_all_principles(){
	$.post(
		base_url + "get_all_principles",
		function(data){
			// console.log(data);
			display_principles_on_table(data);
		}
	);
}

function delete_principle(principleID){
	if (principleID != ""){
		$.post(
			base_url + "delete_principle",
			{
				"principleID" : principleID
			},
			function(data){
				// console.log(data);

				$(".actionMsg").html(data.msg);
				$("#actionMsgDialog").dialog('open');
				// if (data.done === "TRUE"){

				// }
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
                var id = $(this).data('principleID');
                delete_principle(id);

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
					window.location = base_url + "admin_agriculture_principles";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    if (principleID == 0){
    	get_all_principles();
    }
	
});


$(document).on("click", ".btn-delete-principle", function(){

	var principleID = $(this).attr("data-id");

	if (principleID != ""){
		$("#deleteDialog").data('principleID', principleID).dialog('open');
	}
});

$(document).on("click", ".btn-edit-principle", function(){
	var principleID = $(this).attr("data-id");
	window.location = base_url + "admin_agriculture_principles/" + principleID;
});

$(".btn-cancel-update-principle").on("click", function(){
	window.location = base_url + "admin_agriculture_principles";
})

$(".btn-update-principle").on("click", function(){
	var principleID = $(this).attr("data-id");
	var agriculture_principle = $(".agriculture_principle").val();

	$.post(
		base_url + "update_principle",
		{
			"principleID" : principleID,
			"principle" : agriculture_principle
		},
		function(data){
			// console.log(data);
			if (data.done == "TRUE"){
				$(".actionMsg").html(data.msg);
				$("#actionMsgDialog").dialog('open');
			}
		}
	);

});