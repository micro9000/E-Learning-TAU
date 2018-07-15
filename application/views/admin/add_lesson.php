	<div class="container">
        <div class="row">

        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<div class="form-group">
                    <label for="select_principleID">Select Principle <span style="color:red">*</span></label>
                    
                    <select class="form-control principleID" id="select_principleID">
					  	<option value=""></option>
					  	<?php

					  		$principlesLen = sizeof($principles);
					  		for($i=0; $i<$principlesLen; $i++){
					  			if (isset($principleID) && $principleID > 0 && $principleID == $principles[$i]['id']){
					  				echo "<option value='". $principles[$i]['id'] ."' selected>". $principles[$i]['principle'] ."</option>";
					  			}else{
					  				echo "<option value='". $principles[$i]['id'] ."'>". $principles[$i]['principle'] ."</option>";
					  			}
					  			
					  		}
					  	?>
					</select>
                </div>

                <div class="form-group">
                    <label for="select_sub_topic_ID">Select Sub Topic <span style="color:red">*</span></label>
                    
                    <select class="form-control sub_topic_ID" id="select_sub_topic_ID">
					</select>
                </div>

                <div class="form-group">
                    <label for="select_sub_topic_ID">Chapters <span style="color:red">*</span></label>
                    
                    <select class="form-control chapter_id" id="select_chapter_ID">
					</select>
                </div>

                <div class="form-group">
                    <label for="input_lesson_title">Lesson title <span style="color:red">*</span></label>

                    <input type="text" class="form-control lesson_title" id="input_lesson_title" placeholder="Title">
                </div>

                <div class="form-group">
                    <label for="exampleInputFile">Cover photo (optional)</label>
                    <input type="file" class="form-control-file lesson_cover_photo" id="exampleInputFile" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted"><!-- This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line. --></small>
                </div>

                <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-12 pt-0">Cover photo Orientation</legend>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input cover_photo_orientation" type="radio" name="gridRadios" data-orientation="L" id="gridRadios_landscape" value="Landscape" checked>
                                <label class="form-check-label" for="gridRadios_landscape">
                                    Landscape
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input cover_photo_orientation" type="radio" name="gridRadios" data-orientation="P" id="gridRadios_portrait" value="Portrait">
                                <label class="form-check-label" for="gridRadios_portrait">
                                    Portrait
                                </label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <textarea class="tinymce" id="lesson_content"></textarea>

                <!-- <img src="<?php //echo base_url("uploads/lessons/CAPARequired.PNG"); ?>"> -->
        	</div>

        </div>

    </div>