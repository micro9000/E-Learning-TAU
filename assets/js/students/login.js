
$(".form-signin").on("submit", function(e){
	e.preventDefault();

	$(".loader").toggleClass("hidden-default");

	// alert("HI");
	var student_number = $(".student_number").val();
	var pass = $(".password").val();

	$.post(
		base_url + "student_login",
		{
			"stdNum" : student_number,
			"password" : sha512(pass)
		},
		function(data){
			// console.log(data);
			if (data.done === 'TRUE'){
				window.location = base_url + "home_page";
			}
		}
	);
})