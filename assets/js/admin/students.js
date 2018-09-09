
$(".student_id_num").on("keyup", function(){

	var id_num = $(this).val();

	// console.log(id_num);

	if (allNumeric(id_num) == false){
		$("#student_data_msg").html("Invalid student id number");
	}else{
		$("#student_data_msg").html("");
	}
});

$(".student_email").on("keyup", function(){
	var email = $(this).val();

	var is_valid = validateEmail(email);

	if (is_valid === false){
		$("#student_data_msg").html("Invalid email");
	}else{
		$("#student_data_msg").html("");
	}
});


$(".student_password").on("keyup", function(){
	var pswd = $(this).val();

	var strength = passwordStrength(pswd);

	if (strength.length > 0){
		if (strength[0] === 3 || strength[0] === 4){
			$("#student_data_msg").html("<br/>"+strength[1]);
		}else{
			$("#student_data_msg").html("<br/>"+strength[1]);
			return;
		}
	}
});


$(".student_confirm_password").on("keyup", function(){
	var confirm_pass = $(this).val();
	var pass = $(".student_password").val();

	if (confirm_pass != pass){
		$("#student_data_msg").html("Password doesn't match");
	}else{
		$("#student_data_msg").html("");
	}
});


function get_student_data_with_validation(task){
	
	var data = {"length" : 0};

	var student_id_num = $(".student_id_num").val();
	var student_email = $(".student_email").val();
	var student_lastname = $(".student_lastname").val();
	var student_firstname = $(".student_firstname").val();
	var student_password = $(".student_password").val();
	var student_confirm_password = $(".student_confirm_password").val();
	var student_section = $(".student_section").val();

	if (student_id_num !== ""){
		if (allNumeric(student_id_num) == false){
			$("#student_data_msg").html("Invalid student id number");
			return data;
		}else{
			$("#student_data_msg").html("");
		}
	}else{
		$("#student_data_msg").html("Input Password");
	}

	var is_valid = validateEmail(student_email);

	if (is_valid === false){
		$("#student_data_msg").html("Invalid email");
		return data;
	}else{
		$("#student_data_msg").html("");
	}

	data = {
		"student_id_num" : student_id_num,
		"email" : student_email,
		"lastname" : student_lastname,
		"firstname" : student_firstname,
		"section" : student_section,
		"length" : 4
	};


	if (task == "INSERT"){

		var strength = passwordStrength(student_password);

		if (strength.length > 0){
			if (strength[0] === 3 || strength[0] === 4){
				$("#student_data_msg").html("<br/>"+strength[1]);
			}else{
				$("#student_data_msg").html("<br/>"+strength[1]);
				return data;
			}
		}

		if (student_confirm_password != student_password){
			$("#student_data_msg").html("Password doesn't match");
			return data;
		}else{
			$("#student_data_msg").html("");
		}

		$.extend(data, {
			"password" : sha512(student_password),
			"confirm_pass" : sha512(student_confirm_password),
		});

	}else if ("UPDATE"){

		if (student_password !== ""){
			var strength = passwordStrength(student_password);

			if (strength.length > 0){
				if (strength[0] === 3 || strength[0] === 4){
					$("#student_data_msg").html("<br/>"+strength[1]);
				}else{
					$("#student_data_msg").html("<br/>"+strength[1]);
					return {"length" : 0};
				}
			}

			if (student_confirm_password != student_password){
				$("#student_data_msg").html("Password doesn't match");
				return {"length" : 0};
			}else{
				$("#student_data_msg").html("");
			}

			$.extend(data, {
				"password" : sha512(student_password),
				"confirm_pass" : sha512(student_confirm_password),
			});
		}
		// else{
		// 	return {"length" : 0};
		// }
		
	}

	return data;
}


$(".btn-add-student-data").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var student_data = get_student_data_with_validation("INSERT");

	if (student_data.length > 0){
		$.post(
			base_url + "add_student",
			student_data,
			function(data){
				// console.log(data);
				$("#student_data_msg").html(data.msg);

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


function display_students(data){

	// console.log(data);
	
	var display = "";
	$.each(data, function(i, student){
		display += "<tr>";
			display += "<td>"+ (i + 1) +"</td>";
			display += "<td>"+ student.stdNum +"</td>";
			display += "<td>"+ student.firstName +" "+ student.lastName +"</td>";
			display += "<td>"+ student.email +"</td>";
			display += "<td>"+ student.stdSection +"</td>";
			display += "<td>"+ student.dateRegisteredFormated +"</td>";
			display += "<td>";
				display += "<table class='table-control-btns'>";
					display += "<tr>";
						display += "<td>";
							display += "<abbr title='Edit'>";
								display += "<a href='#' class='btn-edit-student' data-id='"+ student.id +"'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/edit.png' class='icon-edit'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";
						display += "<td>";
							display += "<abbr title='Delete' class='btn-delete-student' data-id='"+ student.id +"'>";
								display += "<a href='#'>";
									display += "<img src='"+ base_url +"assets/imgs/icons/delete.png' class='icon-delete'>";
								display += "</a>";	
							display += "</abbr>";
						display += "</td>";
					display += "</tr>";
				display += "</table>";
			display += "</td>";
		display += "</tr>";
		display += "</tr>";
	});

	$("#stdNum_list_tb").html(display);

	$(".loader_blocks").css("display", "none");
}

function pagination_and_display(data){
	$('#student_pagination').pagination({
	    dataSource: data,
	    pageSize: 20,
        autoHidePrevious: true,
	    autoHideNext: true,
	    callback: function(data, pagination) {
	    	// console.log(data);
	        display_students(data);
	    }
	});
}

function get_all_students(){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_student",
		function(data){
			// console.log(data);
			pagination_and_display(data);
		}
	);
}

function delete_student(studentID){
	$.post(
		base_url + "delete_student",
		{
			"studentID" : studentID
		},
		function(data){
			// console.log(data);

			$(".actionMsg").html(data.msg);
			$("#actionMsgDialog").dialog('open');

			$(".loader_blocks").css("display", "none");
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

                var id = $(this).data('student_id');
                // alert(id);
                delete_student(id);

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
					window.location = base_url + "students";
				}, 500);
                $(this).dialog('close');
            }
        }
    });

    if (studentID == 0){
    	get_all_students();
    }

});


$(document).on("click", ".btn-delete-student", function(){
	var studentID = $(this).attr('data-id');

	if (studentID != ""){
		$("#deleteDialog").data('student_id', studentID).dialog('open');
	}
})

$(document).on("click", ".btn-edit-student", function(){
	var studentID = $(this).attr('data-id');

	window.location = base_url + "students/" + studentID;
});

$(".btn-cancel-update-student-data").on("click", function(){
	window.location = base_url + "students";
})

$(".btn-update-student-data").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var student_data = get_student_data_with_validation("UPDATE");
	

	var studentID = $(this).attr("data-id");

	if (studentID > 0 && studentID !== ""){

		$.extend(student_data, {"studentID" : studentID});
		
		if (student_data.length > 0){
			$.post(
				base_url + "update_student",
				student_data,
				function(data){
					// console.log(data);
					$("#student_data_msg").html(data.msg);

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
	}else{
		$(".loader_blocks").css("display", "none");
	}

});


$(".btn-search-student").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var search_str = $(".search-student").val();

	if (search_str !== ""){

		// console.log(search_str);

		$.post(
			base_url + "search_students",
			{"searchStr" : search_str},
			function(data){
				// console.log(data);
				pagination_and_display(data);
			}
		);

	}
});

$(".btn-refresh").on("click", function(){
	if (studentID == 0){
    	get_all_students();
    }
});

// $('.student_id_num').on('keyup', function() {

// 	var stdNum = $(this).val();

//     $.post(
//    		base_url + "validate_student_number",
//    		{
//    			"student_id_num" : stdNum
//    		},
//    		function(data){
//    			console.log(data);
//    			$("#student_data_msg").html(data.msg);
//    		}
//    	);

// });


$(".btn-upload-student-numbers").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var formData = new FormData();

	formData.append("student_numbers", $(".student-numbers")[0].files[0]);
		
	var request = $.ajax({
        url: base_url + "student_number_mass_upload",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false
    });

    request.done(function(data){
        // console.log(data);
        if (data.done == "TRUE"){

        	$("#student_num_mass_upload_msg").html(data.msg);

        	$(".loader_blocks").css("display", "none");
        }
    });

});

function pagination_and_display_students(data){

	// console.log(data);

	$("#students_nums_len").html(data.length);

	$('#student_nums_pagination').pagination({
	    dataSource: data,
	    pageSize: 15,
        autoHidePrevious: true,
	    autoHideNext: true,
	    callback: function(data, pagination) {
	        display_student_numbers(data);
	    }
	});
}

function display_student_numbers(data){

	var stdNums = "";

	$.each(data, function(i, numbers){
		stdNums += "<tr>";
			stdNums += "<td>"+ (i + 1) +"</td>";
			stdNums += "<td>"+ numbers.stdNum +"</td>";
		stdNums += "</tr>";
	});

	$("#student_numbers_list").html(stdNums);

	$(".loader_blocks").css("display", "none");

}

function get_all_student_numbers(){

	$(".loader_blocks").css("display", "block");

	$.post(
		base_url + "get_all_student_numbers",
		function(data){
			// console.log(data);
			pagination_and_display_students(data);
		}
	);
}

$(".btn-view-student-numbers").on("click", function(){
	get_all_student_numbers();
})

$(".btn-search-student-number").on("click", function(){

	var stdNumSearch = $(".search-student-number").val();

	if (stdNumSearch !== ""){

		$.post(
			base_url + "search_student_nums",
			{
				"search" : stdNumSearch
			},
			function(data){
				pagination_and_display(data);
			}
		);

	}	

});