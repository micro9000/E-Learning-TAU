
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
});

function get_faculty_data_with_validation(){
	
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

	return data;
}


$(".btn-update-profile-data").on("click", function(){
	var data = get_faculty_data_with_validation();

	if (data.length >= 4){
		
		$.post(
			base_url + "update_faculty_profile",
			data,
			function(data){
				// console.log(data);
				$("#faculty_data_msg").html(data.msg);

				if (data.done === "TRUE"){
					setTimeout(function(){
						window.location.reload();
					}, 500)
				}
			}
		);

	}
});