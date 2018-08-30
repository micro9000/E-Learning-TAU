$(".student_number").on("keyup", function(){

	var id_num = $(this).val();

	// console.log(id_num);

	if (allNumeric(id_num) == false){
		$(".registration-msg").html("Invalid student id number").removeClass("hidden-default").addClass("alert-danger");
	}else{
		$(".registration-msg").html("").addClass("hidden-default").removeClass("alert-danger");
	}
});


$(".emailAdd").on("keyup", function(){
	var email = $(this).val();

	var is_valid = validateEmail(email);

	if (is_valid === false){
		$(".registration-msg").html("Invalid email").removeClass("hidden-default").addClass("alert-danger");
	}else{
		$(".registration-msg").html("").addClass("hidden-default").removeClass("alert-danger");
	}
});

$(".password").on("keyup", function(){
	var pswd = $(this).val();

	var strength = passwordStrength(pswd);

	if (strength.length > 0){
		if (strength[0] === 3 || strength[0] === 4){
			// $("#student_data_msg").html("<br/>"+);
			$(".registration-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");
		}else{
			$(".registration-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-primary").addClass("alert-danger");
			return;
		}
	}
});


$(".confirmPassword").on("keyup", function(){
	var confirm_pass = $(this).val();
	var pass = $(".password").val();

	if (confirm_pass != pass){
		$(".registration-msg").html("Password doesn't match").removeClass("hidden-default").addClass("alert-danger");
	}else{
		$(".registration-msg").html("").addClass("hidden-default").removeClass("alert-danger");
	}
});


function get_student_data_with_validation(){
	
	var data = {"length" : 0};

	var student_id_num = $(".student_number").val();
	var student_email = $(".emailAdd").val();
	var student_lastname = $(".lastName").val();
	var student_firstname = $(".firstName").val();
	var student_password = $(".password").val();
	var student_confirm_password = $(".confirmPassword").val();

	if (student_id_num !== ""){
		if (allNumeric(student_id_num) == false){
			$(".registration-msg").html("Invalid student id number").removeClass("hidden-default").addClass("alert-danger");
			return data;
		}else{
			$(".registration-msg").html("").addClass("hidden-default").removeClass("alert-danger");
		}

	}else{
		$(".registration-msg").html("Input Password").removeClass("hidden-default").addClass("alert-danger");
	}

	var is_valid = validateEmail(student_email);

	if (is_valid === false){
		$(".registration-msg").html("Invalid email").removeClass("hidden-default").addClass("alert-danger");
		return data;
	}else{
		$(".registration-msg").html("").addClass("hidden-default").removeClass("alert-danger");
	}

	var strength = passwordStrength(student_password);

	if (strength.length > 0){
		if (strength[0] === 3 || strength[0] === 4){
			$(".registration-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");
		}else{
			$(".registration-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-primary").addClass("alert-danger");
			return data;
		}
	}

	if (student_confirm_password != student_password){
		$(".registration-msg").html("Password doesn't match").removeClass("hidden-default").addClass("alert-danger");
		return data;
	}else{
		$(".registration-msg").html("").addClass("hidden-default").removeClass("alert-danger");
	}

	data = {
		"student_id_num" : student_id_num,
		"email" : student_email,
		"lastname" : student_lastname,
		"firstname" : student_firstname,
		"password" : sha512(student_password),
		"confirm_pass" : sha512(student_confirm_password),
		"length" : 6
	};

	return data;
}



$(".btn-agree-to-collec-pr-info").on("click", function(){

	$(".loader_blocks").css("display", "block");

	var std_data = get_student_data_with_validation();

	// console.log(std_data);
	
	if (std_data.length > 0){
		$.post(
			base_url + "student_initial_registration",
			std_data,
			function(data){
				console.log(data);

				if (data.done == "TRUE"){
					$(".btn-register").attr("disabled", "disabled");

					$(".registration-msg").html(data.msg).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");

					setTimeout(function(){
						window.location = base_url + "student_registration_code/" + std_data.student_id_num;
					}, 500);

				}else{
					$(".registration-msg").html(data.msg).removeClass("hidden-default").addClass("alert-danger");
					$(".loader_blocks").css("display", "none");
				}
			}
		);
	}

});

// $(".form-signin").on("submit", function(e){

// 	e.preventDefault();

// 	var std_data = get_student_data_with_validation();
	
// 	if (std_data.length > 0){
// 		$.post(
// 			base_url + "student_initial_registration",
// 			std_data,
// 			function(data){
// 				console.log(data);

// 				if (data.done == "TRUE"){
// 					$(".btn-register").attr("disabled", "disabled");

// 					$(".registration-msg").html(data.msg).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");

// 					setTimeout(function(){
// 						window.location = base_url + "student_registration_code/" + std_data.student_id_num;
// 					}, 500);

// 				}else{
// 					$(".registration-msg").html(data.msg).removeClass("hidden-default").addClass("alert-danger");
// 				}
// 			}
// 		);
// 	}

// });


$(".btn-submit-registration-code").on("click", function(){

	var registration_code = $(".registration-code").val();

	if (registration_code.length == 6){
		$(".registration-code-msg").html("").addClass("hidden-default").removeClass("alert-danger");

		$.post(
			base_url + "verify_registration_code",
			{
				"registration_code" : registration_code
			},
			function(data){
				// console.log(data);

				if (data.done == "TRUE"){
					window.location = base_url + "registration_done_msg";
				}
			}
		);

	}else{
		$(".registration-code-msg").html("Invalid Code").removeClass("hidden-default").addClass("alert-danger");
	}


});