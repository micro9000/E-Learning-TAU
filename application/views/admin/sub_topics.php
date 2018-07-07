
<!--     <pre>
    	<?php print_r($topic_to_update_data); ?>
    </pre> -->
    <div class="container">
        <div class="row">
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
                    <label for="input_principle_sub_topic">Principle Sub Topic</label>

                    <?php if (isset($topicID) && $topicID > 0): ?>

                        <?php if (sizeof($topic_to_update_data) > 0): ?>
                        	<input type="text" value="<?php echo $topic_to_update_data['topic']; ?>" class="form-control principle_sub_topic" id="input_principle_sub_topic" placeholder="Sub topic">
                        <?php else: ?>
                        	<input type="text" class="form-control principle_sub_topic" id="input_principle_sub_topic" placeholder="Sub topic">
                         <?php endif; ?>
                            
                    <?php else: ?>
                    	<input type="text" class="form-control principle_sub_topic" id="input_principle_sub_topic" placeholder="Sub topic">
                    <?php endif; ?>

                    
                </div>
                <div class="form-group">
                	<?php if (isset($topicID) && $topicID > 0): ?>

                        <?php if (sizeof($topic_to_update_data) > 0): ?>
                            <button type="submit" class="btn btn-primary btn-update-sub-topic" data-id='<?php echo $topicID; ?>'>Update</button>
                            <button type="submit" class="btn btn-primary btn-cancel-update-sub-topic">Cancel</button>
                        <?php else: ?>
                            <p>Sub topic does not exists</p>
                        <?php endif; ?>

                	<?php else: ?>
                    	<button type="submit" class="btn btn-primary btn-add-sub-topic">Add</button>
                    <?php endif; ?>
                    <div id="principle_sub_topic_msg"></div>
                </div>

                
            <div class="line"></div>
            </div>


            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-sm table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Principle</th>
                            <th scope="col">User</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Date Modify</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <?php if (isset($topicID) && $topicID > 0): ?>
                        <?php if (sizeof($topic_to_update_data) > 0): ?>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $topic_to_update_data['topic']; ?></td>
                                    <td><?php echo $topic_to_update_data['principle']; ?></td>
                                    <td><?php echo $topic_to_update_data['facultyName']; ?></td>
                                    <td><?php echo $topic_to_update_data['dateAdded']; ?></td>
                                    <td><?php echo $topic_to_update_data['dateModify']; ?></td>
                                </tr>
                            </tbody>
                        <?php endif; ?>
                    <?php else: ?>
                        <tbody id="sub_topics_list_tb"></tbody>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Hidden by default -->
    <div id="deleteDialog" title="Delete Principle">
        <p>Are you sure you want to delete this item?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>

    <script type="text/javascript">
    	var topicID = <?php echo (isset($topicID) && $topicID > 0) ? $topicID : 0; ?>;
    </script>