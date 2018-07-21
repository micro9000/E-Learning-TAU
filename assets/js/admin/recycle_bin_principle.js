$(document).ready(function(){

	$("#restoreDialog").dialog({
        autoOpen: false,
        resizable: false,
        modal: true,
        buttons:{
            YES: function(){
                var id = $(this).data('principleID');
                
                restore_principle(id);

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

	get_all_delete_principles();
});

function display_principles_on_table(data){
	
	var principles = "";

	$.each(data, function(i, principleList){

		principles += "<tr>";
			principles += "<td>"+ (i + 1) +"</td>";
			principles += "<td>"+ principleList.principle +"</td>";
			principles += "<td>"+ principleList.facultyName +"</td>";
			principles += "<td>"+ principleList.dateAddedFormated +"</td>";
			principles += "<td>"+ principleList.dateModifyFormated +"</td>";
			
			principles += "<td>";
				principles += "<table class='table-control-btns'>";
					principles += "<tr>";

						principles += "<td>";
							principles += "<abbr title='Restore'>";
								principles += "<a href='#' class='btn-undo-principle' data-id='"+ principleList.id +"'>";
									principles += "<img src='"+ base_url +"assets/imgs/icons/undo.png' class='icon-undo'>";
								principles += "</a>";	
							principles += "</abbr>";
						principles += "</td>";

						// principles += "<td>";
						// 	principles += "<abbr title='Delete' class='btn-delete-principle' data-id='"+ principleList.id +"'>";
						// 		principles += "<a href='#'>";
						// 			principles += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
						// 		principles += "</a>";	
						// 	principles += "</abbr>";
						// principles += "</td>";

					principles += "</tr>";
				principles += "</table>";
			principles += "</td>";
			
		principles += "</tr>";
	});

	$(".deleted_principles").html(principles);
}

function get_all_delete_principles(){
	$.post(
		base_url + "get_all_deleted_principles",
		function(data){
			display_principles_on_table(data);
		}
	);
}

$(".btn-refresh").on("click", function(){
	get_all_delete_principles();
});

$(document).on("click", ".btn-undo-principle", function(){
	var principleID = $(this).attr("data-id");

	if (principleID != ""){
		$("#restoreDialog").data('principleID', principleID).dialog('open');
	}
});

function restore_principle(principleID){
	$.post(
		base_url + "restore_principle",
		{
			"principleID" : principleID
		},
		function(data){
			// console.log(data);

			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);
}

$(".btn-search-deleted-principle").on("click", function(){

	var search_principle = $(".search-principle").val();

	$.post(
		base_url + "search_deleted_principles",
		{
			"searchStr" : search_principle
		},
		function(data){
			display_principles_on_table(data);
		}
	);

});