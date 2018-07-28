
$(".form-submit-recover-password").on("submit", function(e){

	e.preventDefault();

	var student_number = $(".student_number").val();
	var student_email = $(".student_email").val();

	$.post(
		base_url + "recover_password",
		{
			"stdNum" : student_number,
			"stdEmail" : student_email
		},
		function(data){
			// console.log(data);

			if (data.done == "TRUE"){
				$(".btn-submit-for-pswd-recovery").attr("disabled", "disabled");

				$(".pswd-recovery-msg").html(data.msg).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");

				setTimeout(function(){
					window.location = base_url + "password_recovery_code/" + student_number;
				}, 500);

			}else{
				$(".pswd-recovery-msg").html(data.msg).removeClass("hidden-default").addClass("alert-danger");
			}
		}
	);

});


$(".form-submit-pswd-recovery-code").on("submit", function(e){

	e.preventDefault();

	var recovery_code = $(".recovery-code").val();

	$.post(
		base_url + "verify_pswd_recovery_code",
		{
			"recovery_code" : recovery_code
		},
		function(data){
			// console.log(data);

			if (data.done == "TRUE"){
				$(".btn-submit-recovery-code").attr("disabled", "disabled");

				$(".recovery-code-msg").html(data.msg).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");

				setTimeout(function(){
					window.location = base_url + "student_change_password_form";
				}, 500);

			}else{
				$(".recovery-code-msg").html(data.msg).removeClass("hidden-default").addClass("alert-danger");
			}
		}
	);

});


$(".password").on("keyup", function(){
	var pswd = $(this).val();

	var strength = passwordStrength(pswd);


	if (strength.length > 0){
		if (strength[0] === 3 || strength[0] === 4){
			$(".change-pswd-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");
		}else{
			$(".change-pswd-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-primary").addClass("alert-danger");
			return;
		}
	}
});


$(".confirm_password").on("keyup", function(){
	var confirm_pass = $(this).val();
	var pass = $(".password").val();

	if (confirm_pass != pass){
		$(".change-pswd-msg").html("Password doesn't match").removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");
	}else{
		$(".change-pswd-msg").html("").addClass("hidden-default").removeClass("alert-primary").addClass("alert-danger");
	}
});


$(".form-submit-new-password").on("submit", function(e){

	e.preventDefault();

	var new_password = $(".password").val();
	var confirm_new_password = $(".confirm_password").val();

	var strength = passwordStrength(new_password);

	if (strength.length > 0){
		if (strength[0] === 3 || strength[0] === 4){
			$(".change-pswd-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");
		}else{
			$(".change-pswd-msg").html(strength[1]).removeClass("hidden-default").removeClass("alert-primary").addClass("alert-danger");
			return;
		}
	}

	if (confirm_new_password != new_password){
		$(".change-pswd-msg").html("Password doesn't match").removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");
		return;
	}else{
		$(".change-pswd-msg").html("").addClass("hidden-default").removeClass("alert-primary").addClass("alert-danger");
	}

	$.post(
		base_url + "change_student_password",
		{
			"new_password" : sha512(new_password),
			"confirm_new_password" : sha512(confirm_new_password)
		},
		function(data){
			// console.log(data);

			if (data.done == "TRUE"){
				$(".btn-submit-recovery-code").attr("disabled", "disabled");

				$(".recovery-code-msg").html(data.msg).removeClass("hidden-default").removeClass("alert-danger").addClass("alert-primary");

				setTimeout(function(){
					window.location = base_url + "student_successfully_change_password";
				}, 500);

			}else{
				$(".recovery-code-msg").html(data.msg).removeClass("hidden-default").addClass("alert-danger");
			}
		}
	);

});