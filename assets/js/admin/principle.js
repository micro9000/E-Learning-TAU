
$(".btn-add-principle").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var agriculture_principle = $(".agriculture_principle").val();

	$.post(
		base_url + "add_agri_principle",
		{
			"principle" : agriculture_principle
		},
		function(data){
			// console.log(data);

			$("#agriculture_principle_msg").html(data.msg);

			if (data.done === "TRUE"){
				setTimeout(function(){
					window.location = base_url + "admin_agriculture_principles";
				}, 500);
			}else{
				$(".loader_blocks").css("display", "none");
			}

			
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
			principles += "<td>"+ principleList.dateAddedFormated +"</td>";
			principles += "<td>"+ principleList.dateModifyFormated +"</td>";
			
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

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_principles",
		function(data){
			// console.log(data);
			display_principles_on_table(data);

			$(".loader_blocks").css("display", "none");
		}
	);
}

function delete_principle(principleID){

	$(".loader_blocks").css("display", "block");

	if (principleID != ""){
		$.post(
			base_url + "delete_principle",
			{
				"principleID" : principleID
			},
			function(data){
				// console.log(data);

				$(".loader_blocks").css("display", "none");

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

	$(".loader_blocks").css("display", "block");

	var principleID = $(this).attr("data-id");
	window.location = base_url + "admin_agriculture_principles/" + principleID;
});

$(".btn-cancel-update-principle").on("click", function(){
	window.location = base_url + "admin_agriculture_principles";
})

$(".btn-update-principle").on("click", function(){

	$(".loader_blocks").css("display", "block");

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
			// if (data.done == "TRUE"){
				
			// }

			$(".loader_blocks").css("display", "none");
			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');
		}
	);

});


$(".btn-search-principle").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var search_principle = $('.search-principle').val();

	$.post(
		base_url + "search_principles",
		{
			"searchStr" : search_principle
		},
		function(data){
			// console.log(data);
			display_principles_on_table(data);

			$(".loader_blocks").css("display", "none");
		}
	);
});

$(".btn-refresh").on("click", function(){
	if (principleID == 0){
		get_all_principles();
	}
});