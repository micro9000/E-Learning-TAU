$(document).ready(function(){
	$(".dateRange").datepicker();
	get_all_audit_trails();
});

function get_all_audit_trails(){
	$.post(
		base_url + "get_all_audit_trails",
		function(data){
			pagination_and_display(data);
		}
	);
}

function pagination_and_display(data){
	$('#audit_trail_pagination').pagination({
	    dataSource: data,
	    pageSize: 20,
        autoHidePrevious: true,
	    autoHideNext: true,
	    callback: function(data, pagination) {
	        display_audit_trails(data);
	    }
	});
}

function display_audit_trails(data){
	var display = "";

	$.each(data, function(i, audit){
		display += "<tr>";
			display += "<td>"+ (i + 1) +"</td>";
			display += "<td>"+ audit.actionDone +"</td>";
			display += "<td>"+ audit.affectedModule +"</td>";
			display += "<td>"+ audit.DoneBy +"</td>";
			display += "<td>"+ audit.dateTrans +"</td>";
		display += "</tr>";
	});

	$(".audit_trail_list").html(display);
}

$(".btn-search-audit-trail").on("click", function(){
	var affectedModule = $(".affectedModule").val();
	var start_date = $(".start_date").val();
	var end_date = $(".end_date").val();

	$.post(
		base_url + "search_audit_trail",
		{
			"affectedModule" : affectedModule,
			"startDate" : start_date,
			"endDate" : end_date
		},
		function(data){
			pagination_and_display(data);
		}
	);
});