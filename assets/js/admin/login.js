
$(".form-signin").on("submit", function(e){
	e.preventDefault();

	// $(".loader").toggleClass("hidden-default");

	// alert("HI");
	var faculty_number = $(".faculty_number").val();
	var pass = $(".password").val();

	// console.log((sha512(pass)));
	$.post(
		base_url + "admin_login",
		{
			"facNum" : faculty_number,
			"password" : sha512(pass)
		},
		function(data){
			// console.log(data);

			$(".login-msg").html(data.msg).removeClass("hidden-default");

			if (data.done === 'TRUE'){
				window.location = base_url + "admin_main_panel";
			}else{
				$(".login-msg").html(data.msg).addClass("alert-danger");
			}
		}
	);
});