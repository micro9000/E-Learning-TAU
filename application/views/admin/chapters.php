
	<!-- <pre>
    	<?php //print_r($chapter_to_update_data); ?>
    </pre> -->
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4>Chapters</h4>
                <div class="line"></div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            	<div class="form-group">
                    <label for="select_principleID">Select Principle</label>
                    
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
                    <label for="select_sub_topic_ID">Select Sub Topic</label>
                    
                    <select class="form-control sub_topic_ID" id="select_sub_topic_ID">
					</select>
                </div>

               	<div class="form-group">
                    <label for="input_topic_chapter">New Chapter</label>

                    <?php if (isset($chapterID) && $chapterID > 0): ?>

                        <?php if (sizeof($chapter_to_update_data) > 0): ?>
                        	<input type="text" value="<?php echo $chapter_to_update_data['chapterTitle']; ?>" class="form-control topic_chapter" id="input_topic_chapter" placeholder="Chapter">
                        <?php else: ?>
                        	<input type="text" class="form-control topic_chapter" id="input_topic_chapter" placeholder="Chapter">
                         <?php endif; ?>
                            
                    <?php else: ?>
                    	<input type="text" class="form-control topic_chapter" id="input_topic_chapter" placeholder="Chapter">
                    <?php endif; ?>

                </div>
                <div class="form-group">
                	<?php if (isset($chapterID) && $chapterID > 0): ?>

                        <?php if (sizeof($chapter_to_update_data) > 0): ?>
                            <button type="submit" class="btn btn-primary btn-update-chapter" data-id='<?php echo $chapterID; ?>'>
                            	<span class="fa fa-edit"></span> Update
                            </button>
                            <button type="submit" class="btn btn-primary btn-cancel-update-chapter">
                            	<span class="fa fa-ban"></span> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary btn-cancel-update-chapter">
                                <span class="fa fa-chevron-left"></span> Back
                            </button>
                        <?php else: ?>
                            <p>Chapter does not exists</p>
                        <?php endif; ?>

                	<?php else: ?>
                    	<button type="submit" class="btn btn-primary btn-add-chapter">
                    		<span class="fa fa-plus-square"></span> Add
                    	</button>
                    <?php endif; ?>
                    <div id="topic_chapter_msg"></div>
                </div>

                
            	<div class="line"></div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-chapter" placeholder="Topic" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-chapter" type="button">
                            <span class="fa fa-search"></span>Search
                        </button>
                        <button class="btn btn-primary btn-refresh" type="button">
                            <span class="fa fa-sync-alt"></span>Refresh
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-sm table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Chapter</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Principle</th>
                            <th scope="col">User</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Date Modify</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <?php if (isset($chapterID) && $chapterID > 0): ?>
                        <?php if (sizeof($chapter_to_update_data) > 0): ?>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $chapter_to_update_data['chapterTitle']; ?></td>
                                    <td><?php echo $chapter_to_update_data['topic']; ?></td>
                                    <td><?php echo $chapter_to_update_data['principle']; ?></td>
                                    <td><?php echo $chapter_to_update_data['facultyName']; ?></td>
                                    <td><?php echo $chapter_to_update_data['dateAddedFormated']; ?></td>
                                    <td><?php echo $chapter_to_update_data['dateModifyFormated']; ?></td>
                                </tr>
                            </tbody>
                        <?php endif; ?>
                    <?php else: ?>
                        <tbody id="chapters_list_tb"></tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    
    <div class="loader_blocks"></div>
    
    <!-- Hidden by default -->
    <div id="deleteDialog" title="Delete Chapter">
        <p>Are you sure you want to delete this item?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>

    <script type="text/javascript">
    	var chapterID = <?php echo (isset($chapterID) && $chapterID > 0) ? $chapterID : 0; ?>;
    </script>