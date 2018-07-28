
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

	var student_email = $(".student_email").val();
	var student_lastname = $(".student_lastname").val();
	var student_firstname = $(".student_firstname").val();
	var student_password = $(".student_password").val();
	var student_confirm_password = $(".student_confirm_password").val();

	var is_valid = validateEmail(student_email);

	if (is_valid === false){
		$("#student_data_msg").html("Invalid email");
		return data;
	}else{
		$("#student_data_msg").html("");
	}

	data = {
		"email" : student_email,
		"lastname" : student_lastname,
		"firstname" : student_firstname,
		"length" : 3
	};

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

	return data;
}


$(".btn-update-student-data").on("click", function(){
	var student_data = get_student_data_with_validation("UPDATE");
	
	if (student_data.length > 0){
		$.post(
			base_url + "update_student_data",
			student_data,
			function(data){
				// console.log(data);
				$("#student_data_msg").html(data.msg);

				if (data.done === "TRUE"){
					setTimeout(function(){
						window.location.reload();
					}, 500)
				}
			}
		);
	}

});