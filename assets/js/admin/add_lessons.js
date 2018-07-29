$(".principleID").on("change", function(){

	$(".loader_blocks").css("display", "block");

	var principleID = $(this).val();

	$.post(
		base_url + "get_principles_sub_topics_by_principle",
		{
			"principleID" : principleID
		},
		function(data){
			// console.log(data);

			var options = "<option></option>";

			$.each(data, function(i, topic){
				// console.log(topic.id);

				options += "<option value='"+ topic.id +"'>"+ topic.topic +"</option>";
			});

			$(".sub_topic_ID").html(options);

			$(".loader_blocks").css("display", "none");
		}
	);

});


$(".sub_topic_ID").on("change", function(){

	$(".loader_blocks").css("display", "block");

	var sub_topic_ID = $(this).val();

	$.post(
		base_url + "get_all_chapters_by_topic_id",
		{
			"topicID" : sub_topic_ID
		},
		function(data){
			// console.log(data);

			var options = "<option></option>";

			$.each(data, function(i, chapter){
				options += "<option value='"+ chapter.id +"'>"+ chapter.chapterTitle +"</option>";
			});

			$("#select_chapter_ID").html(options);

			$(".loader_blocks").css("display", "none");
		}
	);

});

$(".chapter_id").on("change", function(){

	$(".loader_blocks").css("display", "block");

	if ($(this).val() === null){
		$(this).css("border", "1px solid red");
	}else{
		$(this).css("border", "1px solid #ced4da");
	}

	$(".loader_blocks").css("display", "none");
});


$(".lesson_title").on("keyup", function(){
	if ($(this).val() === ""){
		$(this).css("border", "1px solid red");
	}else{
		$(this).css("border", "1px solid #ced4da");
	}
})



// tinymce.init({
//   selector: 'textarea.tinymce',  // change this value according to your HTML
//   plugins: 'image code',
//   file_browser_callback: function(field_name, url, type, win) {
//     win.document.getElementById(field_name).value = 'my browser value';
//   },
// });

tinymce.init({
	selector: 'textarea.tinymce',
    	/* theme of the editor */
	theme: "modern",
	skin: "lightgray",
	
	/* width and height of the editor */
	width: "100%",
	height: 800,
	
	/* display statusbar */
	statubar: true,
		
	relative_urls:false,

	/* plugin */
	plugins: [
		"advlist autolink link image lists charmap print preview hr anchor pagebreak",
		"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		"save table contextmenu directionality emoticons template paste textcolor"
	],

	/* toolbar */
	toolbar: "save_lesson_content | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | imageupload | print preview media fullpage | forecolor backcolor emoticons",
	
	/* style */
	style_formats: [
		{title: "Headers", items: [
			{title: "Header 1", format: "h1"},
			{title: "Header 2", format: "h2"},
			{title: "Header 3", format: "h3"},
			{title: "Header 4", format: "h4"},
			{title: "Header 5", format: "h5"},
			{title: "Header 6", format: "h6"}
		]},
		{title: "Inline", items: [
			{title: "Bold", icon: "bold", format: "bold"},
			{title: "Italic", icon: "italic", format: "italic"},
			{title: "Underline", icon: "underline", format: "underline"},
			{title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
			{title: "Superscript", icon: "superscript", format: "superscript"},
			{title: "Subscript", icon: "subscript", format: "subscript"},
			{title: "Code", icon: "code", format: "code"}
		]},
		{title: "Blocks", items: [
			{title: "Paragraph", format: "p"},
			{title: "Blockquote", format: "blockquote"},
			{title: "Div", format: "div"},
			{title: "Pre", format: "pre"}
		]},
		{title: "Alignment", items: [
			{title: "Left", icon: "alignleft", format: "alignleft"},
			{title: "Center", icon: "aligncenter", format: "aligncenter"},
			{title: "Right", icon: "alignright", format: "alignright"},
			{title: "Justify", icon: "alignjustify", format: "alignjustify"}
		]}
	],

    setup: function(editor) {
        var add_img = $('<input id="tinymce-uploader" type="file" name="pic" accept="image/*" style="display:none">');
        $(editor.getElement()).parent().append(add_img);

        var save_lesson_content = $('<input id="btn-save-lesson-content" type="submit" name="btnSaveLessonContent" style="display:none">');

        add_img.on("change",function(){
            var input = add_img.get(0);
            var file = input.files[0];

	        var input = add_img.get(0);
			var data = new FormData();
			data.append('upload_file', file);

			$(".loader_blocks").css("display", "block");

			$.ajax({
			    url: base_url + "upload_lesson_img",
			    type: 'POST',
			    data: data,
			    processData: false, // Don't process the files
			    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
			    success: function(data, textStatus, jqXHR) {
			    	// console.log(data);

			    	if (data.is_upload_done == "TRUE"){
			    		editor.insertContent('<img class="content-img" src="' +  base_url +"uploads/lessons/content/"+ data.results.upload_data.file_name + '"/>');
			    		// console.log('<img class="content-img" src="' +  base_url +"uploads/lessons/content/"+ data.results.upload_data.file_name + '"/>');
			    	}else{

			    		editor.notificationManager.open({
						  	text: data.results.error,
						  	type: 'error',
						  	timeout: 5000
						});
			    	}

			    	$(".loader_blocks").css("display", "none");
			      	
			    }
			    
			});
        });

        save_lesson_content.on("click", function(){

        	var content = editor.getContent(); //tinymce.get("lesson_content").getContent();

			var chapter_id = $(".chapter_id").val();
			var lesson_title = $(".lesson_title").val();

			var cover_len = $(".lesson_cover_photo")[0].files.length;

			var formData = new FormData();

			if (chapter_id !== null){
				formData.append("chapter_id", chapter_id);
			}else{
				$(".chapter_id").css("border", "1px solid red");
				return;
			}

			if (lesson_title === ""){
				$(".lesson_title").css("border", "1px solid red");
				return;
			}else{
				formData.append("lesson_title", lesson_title);
			}

			if (cover_len > 0){
				formData.append("cover_photo_len", cover_len);
				formData.append("cover_photo", $(".lesson_cover_photo")[0].files[0]);

				var cover_photo_orientation_len = $(".cover_photo_orientation").length;
			    var cover_photo_orientation = "";

			    for(var i=0; i<cover_photo_orientation_len; i++){
			        if ($(".cover_photo_orientation").eq(i).prop("checked") === true){
			            cover_photo_orientation = $(".cover_photo_orientation").eq(i).attr("data-orientation");
			        }
			    }

			    if (cover_photo_orientation !== ""){
			    	formData.append("cover_photo_orientation", cover_photo_orientation);
			    }
			    
			}else{
				formData.append("cover_photo_len", "0");
			}

			if (lessonID > 0){ // update summary
				var update_summary = $(".update_summary").val();

				if (update_summary === ""){
					$(".update_summary").css("border", "1px solid red");

					editor.notificationManager.open({
					  	text: "Please add update summary",
					  	type: 'error',
					  	timeout: 5000
					});

					return;
				}else{
					formData.append("update_summary", update_summary);
				}
			}


		    if (content !== ""){
				formData.append("lesson_content", content);
			}else{
				editor.notificationManager.open({
				  	text: "Content for " + lesson_title + " is required",
				  	type: 'error',
				  	timeout: 5000
				});
				return;
			}


			if (lessonID === 0){ // ########### INSERTING

				$(".loader_blocks").css("display", "block");

				var request = $.ajax({
		            url: base_url + "add_new_lesson",
		            type: "POST",
		            data: formData,
		            contentType: false,
		            cache: false,
		            processData: false
		        });

		        request.done(function(data){
		            console.log(data);

		            if (data.done === "TRUE"){

		            	editor.notificationManager.open({
						  	text: data.msg,
						  	type: 'info',
						  	timeout: 1000
						});

						setTimeout(function(){
			            	window.location.reload();
			            }, 2000);

						 return;
		            }else{

		            	editor.notificationManager.open({
						  	text: data.msg,
						  	type: 'error',
						  	timeout: 5000
						});

						$(".loader_blocks").css("display", "none");
		            }

		            
		        });

			}else{ // UPDATING

				$(".loader_blocks").css("display", "block");

				formData.append("lesson_id", lessonID);

				var request = $.ajax({
		            url: base_url + "update_lesson",
		            type: "POST",
		            data: formData,
		            contentType: false,
		            cache: false,
		            processData: false
		        });

		        request.done(function(data){
		            console.log(data);

		            if (data.done === "TRUE"){

		            	editor.notificationManager.open({
						  	text: data.msg,
						  	type: 'info',
						  	timeout: 1000
						});

		            }else{

		            	editor.notificationManager.open({
						  	text: data.msg,
						  	type: 'error',
						  	timeout: 5000
						});

						$(".loader_blocks").css("display", "none");
		            }

		            setTimeout(function(){
		            	window.location = base_url + "chapters_lessons";
		            }, 2000);
		        });

			}

	

        });

        editor.addButton( 'imageupload', {
            text:"",
            icon: "image",
            onclick: function(e) {
                add_img.trigger('click');
            }
        });

        editor.addButton( 'save_lesson_content', {
            text: "Save Lesson",
            icon: "",
            onclick: function(e) {
                save_lesson_content.trigger('click');
            }
        });
    },

    init_instance_callback: "get_lesson_data_to_update",
 });

function get_lesson_data_to_update(inst){

	if (lessonID > 0){

		$.post(
			base_url + "get_lesson_data_by_id",
			{
				"lesson_id" : lessonID,
				"is_actual_data" : "YES"
			},
			function(data){
				// console.log(data);

				$(".principleID").val(data[0].PrinID).change();

				setTimeout(function(){
					$(".sub_topic_ID").val(data[0].TopID).change();
				}, 500);

				setTimeout(function(){
					$(".chapter_id").val(data[0].ChapID).change();
				}, 1000);

				$(".lesson_title").val(data[0].title);

				if (data[0].isWithCoverPhoto === "1"){
					$(".cover_photo_orientation").eq(data[0].isWithCoverPhoto).prop("checked", true);
				}

				inst.setContent(data[0].content);  
			}
		);

		// inst.setContent('<strong>Some contents</strong>');  
	}
}