

$(".frm-search-lessons").on("submit", function(e){
	e.preventDefault();

	var search_str = $(".search-lessons-str").val();

	var search_str_1 = "";

	if (typeof search_str != "undefined"){
		search_str_1 = search_str.replace(/[^\w\s+]/gi, '');
	}

	if (search_str_1 != ""){
		window.location = base_url + "main_search_lessons/" + search_str_1;
	}
		
});