$.switcher();


// $(".switch-mark-as-admin").bootstrapSwitch('size', 'mini');
// $(".switch-mark-as-dean").bootstrapSwitch('size', 'mini');

// $("[name='mark-as-admin']").bootstrapSwitch();
// $("[name='mark-as-dean']").bootstrapSwitch();


function check_faculty_permissions(facultyIDTmp){
	// console.log(facultyIDTmp);
	$.post(
		base_url + "get_faculty_by_id",
		{
			"facultyID" : facultyIDTmp
		},
		function(data){
			console.log(data);

			setTimeout(function(){
				if (data.isAdmin == "1"){
					// $(".switch-mark-as-admin").bootstrapSwitch('state', true);
					// $('input[name=switch-mark-as-admin]').prop('checked', true);
					$(".switch-mark-as-admin").prop('checked', true);
					$(".ui-switcher").eq(0).attr("aria-checked", "true");
				}else{
					$(".switch-mark-as-admin").prop('checked', false);
				}

				if (data.isDean == "1"){
					// $(".switch-mark-as-dean").bootstrapSwitch('state', true);
					$(".switch-mark-as-dean").prop('checked', true);
					$(".ui-switcher").eq(1).attr("aria-checked", "true");
				}
			}, 500);
		}
	);
}

$(".switch-mark-as-admin").on("change", function(){
	var isChecked = $(this).prop("checked");
	// console.log(isChecked);

	var faculty_id = $(this).attr("data-id");

	if (isChecked == true){
		data = {
			"mark_as" : "admin",
			"facultyID" : faculty_id,
			"status" : "1"
		};
	}else{
		data = {
			"mark_as" : "admin",
			"facultyID" : faculty_id,
			"status" : "0"
		};
	}

	$.post(
		base_url + "mark_faculty_as_admin_or_dean",
		data,
		function(data){
			// console.log(data);
			if (data.done == "FALSE"){
				$(".actionMsg").html(data.msg);
				$("#actionMsgDialog").dialog('open');
			}
		}
	);
});

// $(".switch-mark-as-admin").on('switchChange.bootstrapSwitch', function(event, state) {

// 	var faculty_id = $(this).attr("data-id");
	  
//   	var data = {};

//   	if (state === true){

//   		data = {
//   				"mark_as" : "admin",
//   				"facultyID" : faculty_id,
//   				"status" : "1"
//   			};
  		

//   	}else if (state === false){
//   		data = {
// 			"mark_as" : "admin",
// 			"facultyID" : faculty_id,
// 			"status" : "0"
// 		};
//   	}

//   	$.post(
// 		base_url + "mark_faculty_as_admin_or_dean",
// 		data,
// 		function(data){
// 			console.log(data);
// 		}
// 	);
// });


$(".switch-mark-as-dean").on("change", function(){
	var isChecked = $(this).prop("checked");
	// console.log(isChecked);

	var faculty_id = $(this).attr("data-id");

	if (isChecked == true){
		data = {
			"mark_as" : "dean",
			"facultyID" : faculty_id,
			"status" : "1"
		};
	}else{
		data = {
			"mark_as" : "dean",
			"facultyID" : faculty_id,
			"status" : "0"
		};
	}

	$.post(
		base_url + "mark_faculty_as_admin_or_dean",
		data,
		function(data){
			// console.log(data);

			if (data.done == "FALSE"){
				$(".actionMsg").html(data.msg);
				$("#actionMsgDialog").dialog('open');
			}
		}
	);
});

// $(".switch-mark-as-dean").on('switchChange.bootstrapSwitch', function(event, state) {

//   	var faculty_id = $(this).attr("data-id");

//   	// console.log(faculty_id);

//   	var data = {};

//   	if (state === true){

//   		data = {
//   				"mark_as" : "dean",
//   				"facultyID" : faculty_id,
//   				"status" : "1"
//   			};
  		

//   	}else if (state === false){
//   		data = {
// 			"mark_as" : "dean",
// 			"facultyID" : faculty_id,
// 			"status" : "0"
// 		};
//   	}

//   	$.post(
// 		base_url + "mark_faculty_as_admin_or_dean",
// 		data,
// 		function(data){
// 			console.log(data);

// 			if (data.done == "FALSE"){
// 				$(".actionMsg").html(data.msg);
// 				$("#actionMsgDialog").dialog('open');
// 			}
				
// 		}
// 	);
// });

$(".faculty_id_num").on("keyup", function(){

	var id_num = $(this).val();

	// console.log(id_num);

	if (allNumeric(id_num) == false){
		$("#faculty_data_msg").html("Invalid faculty id number");
	}else{
		$("#faculty_data_msg").html("");
	}
});


$(".faculty_email").on("keyup", function(){
	var email = $(this).val();

	var is_valid = validateEmail(email);

	if (is_valid === false){
		$("#faculty_data_msg").html("Invalid email");
	}else{
		$("#faculty_data_msg").html("");
	}
});

$(".faculty_password").on("keyup", function(){
	var pswd = $(this).val();

	var strength = passwordStrength(pswd);

	if (strength.length > 0){
		if (strength[0] === 3 || strength[0] === 4){
			$("#faculty_data_msg").html("<br/>"+strength[1]);
		}else{
			$("#faculty_data_msg").html("<br/>"+strength[1]);
			return;
		}
	}
});

$(".faculty_confirm_password").on("keyup", function(){
	var confirm_pass = $(this).val();
	var pass = $(".faculty_password").val();

	if (confirm_pass != pass){
		$("#faculty_data_msg").html("Password doesn't match");
	}else{
		$("#faculty_data_msg").html("");
	}
})

function get_faculty_data_with_validation(task){
	
	var data = {"length" : 0};

	var faculty_id_num = $(".faculty_id_num").val();
	var faculty_email = $(".faculty_email").val();
	var faculty_lastname = $(".faculty_lastname").val();
	var faculty_firstname = $(".faculty_firstname").val();
	var faculty_password = $(".faculty_password").val();
	var faculty_confirm_password = $(".faculty_confirm_password").val();


	if (faculty_id_num !== ""){
		if (allNumeric(faculty_id_num) == false){
			$("#faculty_data_msg").html("Invalid faculty id number");
			return data;
		}else{
			$("#faculty_data_msg").html("");
		}
	}else{
		$("#faculty_data_msg").html("Input Password");
	}

	var is_valid = validateEmail(faculty_email);

	if (is_valid === false){
		$("#faculty_data_msg").html("Invalid email");
		return data;
	}else{
		$("#faculty_data_msg").html("");
	}

	data = {
		"faculty_id_num" : faculty_id_num,
		"email" : faculty_email,
		"lastname" : faculty_lastname,
		"firstname" : faculty_firstname,
		"length" : 4
	};

	if (task == "INSERT"){

		var strength = passwordStrength(faculty_password);

		if (strength.length > 0){
			if (strength[0] === 3 || strength[0] === 4){
				$("#faculty_data_msg").html("<br/>"+strength[1]);
			}else{
				$("#faculty_data_msg").html("<br/>"+strength[1]);
				return data;
			}
		}

		if (faculty_confirm_password != faculty_password){
			$("#faculty_data_msg").html("Password doesn't match");
			return data;
		}else{
			$("#faculty_data_msg").html("");
		}

		$.extend(data, {
			"password" : sha512(faculty_password),
			"confirm_pass" : sha512(faculty_confirm_password),
		});

	}else if ("UPDATE"){

		if (faculty_password !== ""){
			var strength = passwordStrength(faculty_password);

			if (strength.length > 0){
				if (strength[0] === 3 || strength[0] === 4){
					$("#faculty_data_msg").html("<br/>"+strength[1]);
				}else{
					$("#faculty_data_msg").html("<br/>"+strength[1]);
					return {"length" : 0};
				}
			}

			if (faculty_confirm_password != faculty_password){
				$("#faculty_data_msg").html("Password doesn't match");
				return {"length" : 0};
			}else{
				$("#faculty_data_msg").html("");
			}

			$.extend(data, {
				"password" : sha512(faculty_password),
				"confirm_pass" : sha512(faculty_confirm_password),
			});
		}
		// else{ // here
		// 	return {"length" : 0};
		// }
		
	}

	return data;
}

$(".btn-add-faculty-data").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var faculty_data = get_faculty_data_with_validation("INSERT");

	if (faculty_data.length > 0){
		$.post(
			base_url + "add_faculty",
			faculty_data,
			function(data){
				// console.log(data);
				$("#faculty_data_msg").html(data.msg);

				if (data.done === "TRUE"){
					setTimeout(function(){
						window.location.reload();
					}, 500)
				}else{
					$(".loader_blocks").css("display", "none");
				}
			}
		);
	}else{
		$(".loader_blocks").css("display", "none");
	}
});


$(".btn-update-faculty-data").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var facultyID = $(this).attr("data-id");

	var faculty_data = get_faculty_data_with_validation("UPDATE");

	$.extend(faculty_data, {"facultyID" : facultyID});

	// console.log(faculty_data);
	if (faculty_data.length > 0){
		$.post(
			base_url + "update_faculty",
			faculty_data,
			function(data){
				// console.log(data);
				$("#faculty_data_msg").html(data.msg);

				if (data.done === "TRUE"){
					setTimeout(function(){
						window.location.reload();
					}, 500)
				}else{
					$(".loader_blocks").css("display", "none");
				}
			}
		);
	}else{
		$(".loader_blocks").css("display", "none");
	}

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
							display += "<abbr title='Edit'>";
								display += "<a href='#' class='btn-edit-faculty' data-id='"+ faculty.id +"'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/edit.png' class='icon-edit'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";
						display += "<td>";
							display += "<abbr title='Delete' class='btn-delete-faculty' data-id='"+ faculty.id +"'>";
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

	$("#faculty_list_tb").html(display);

	$(".loader_blocks").css("display", "none");
}


function get_all_faculties(){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_faculties",
		function(data){
			// console.log(data);
			display_faculties(data);
		}
	);
}

function delete_faculty_data(facultyID){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "delete_faculty",
		{
			"facultyID" : facultyID
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

                var id = $(this).data('faculty_id');
                delete_faculty_data(id);

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
					window.location = base_url + "faculties";
				}, 500);
                $(this).dialog('close');
            }
        }
    });



    if (facultyID > 0){
    	check_faculty_permissions(facultyID);
    }else{
    	get_all_faculties();
    }
	
	// setTimeout(function(){
	// 	$("[name='my-checkbox']").trigger('click');
	// }, 500);

	
});


$(document).on("click", ".btn-edit-faculty", function(){
	
	$(".loader_blocks").css("display", "block");

	var faculty_id = $(this).attr("data-id");
	window.location = base_url + "faculties/" + faculty_id;
})

$(".btn-cancel-update-faculty-data").on("click", function(){
	window.location = base_url + "faculties";
});


$(document).on("click", ".btn-delete-faculty" ,function(){

	var faculty_id = $(this).attr("data-id");
	if (faculty_id != ""){
		$("#deleteDialog").data('faculty_id', faculty_id).dialog('open');
	}

});


$(".btn-search-faculty").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var search_faculty = $(".search-faculty").val();

	if (search_faculty != ""){
		$.post(
			base_url + "search_faculties",
			{"searchStr" : search_faculty},
			function(data){
				// console.log(data);
				display_faculties(data);
			}
		);
	}else{
		$(".loader_blocks").css("display", "none");
	}
});

$(".btn-refresh").on("click", function(){
	get_all_faculties();
});