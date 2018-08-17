    <div class="wrapper">
        <div class="content">
            <div class="container">
            	<?php if ($lesson_data == null || sizeof($lesson_data) == 0): ?>
            		<?php show_404(); ?>
            	<?php else: ?>
	                <div class="row">
	                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
	                    	<!-- <pre>
								<?php //print_r($quizzes); ?>
							</pre> -->
	                       	
	                       	<div class="lesson-details-wrapper">

	                       		<div class="date"><?php echo $lesson_data[0]['dateAddedFormated']; ?></div>
	                       		<div class="category"><?php echo $lesson_data[0]['principle'] ." / ". $lesson_data[0]['topic']; ?></div>

	                       		<div class="title"><?php echo $lesson_data[0]['title'] ?></div>

	                       		<div class="posted_by"><?php echo $lesson_data[0]['AddedByUser'] ." / ". $lesson_data[0]['chapterTitle']; ?></div>

	                       		<div class="btns-quizzes">
	                       			<?php
	                       				$quizzesLen = sizeof($quizzes);

	                       				if ($quizzesLen > 0){
	                       					for($i=0; $i<$quizzesLen; $i++){
	                       						echo "<a href='". base_url("chapter_take_quiz/".$quizzes[$i]['id']."/".$quizzes[$i]['quizTitleSlug']) ."' class='btn'>". $quizzes[$i]['quizTitle'] ."</a>";
	                       					}
	                       				}
	                       			?>
	                       		</div>
	                       		<hr class="style2"></hr>

	                       		<div class="contents">
	                       			<?php echo $lesson_data[0]['content'] ?>
	                       		</div>

	                       		<br/>
	                       		<hr class="style2"></hr>
	                       		<br/>

	                       		<div class="comments">

									<div class="comments_list"></div>
									
									<div class="card comments_wrapper">
									  	<div class="card-header">
									  		Share your comments
									  	</div>
									  	<textarea class="card-body form-control lesson_comments" id="exampleTextarea" rows="3"></textarea>

									  	<div class="card-footer">
									  		<button class="btn btn-primary btn-add-comment" data-lesson-id='<?php echo $lesson_data[0]['id'] ?>'><span class="fa fa-comment-alt"></span> Share</button>
									  		<span id="share_comment_msg"></span>
									  	</div>
									</div>

	                       		</div>
	                       	</div>
	                    </div>

	                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
	                       	<div class="content-panel" style="margin-bottom: 0;">
	                       		<div class="chapter_lessons">
	                       			<div class="chapters_title">
		                       			<?php echo $lesson_data[0]['chapterTitle']; ?>
		                       		</div>

		                       		<div class="chapter_lesson_list">
		                       			<ul>
		                       				<?php
		                       					if ($chapter_lessons != null){
		                       						$lesson_len = sizeof($chapter_lessons);

		                       						for($i=0; $i<$lesson_len; $i++){

		                       							if ($lesson_data[0]['id'] == $chapter_lessons[$i]['id']){
		                       								echo "<li style='font-size: 14px;'><span class='fa fa-angle-double-right' style='color: green'></span> ". $chapter_lessons[$i]['title'] ."<br/>
		                       								<a href='". base_url("view_lesson/".$chapter_lessons[$i]['id']."/".$chapter_lessons[$i]['slug']) ."' class='link-read-more'>Read more</a></li>";
		                       							}else{
		                       								echo "<li>". $chapter_lessons[$i]['title'] ."<br/>
		                       								<a href='". base_url("view_lesson/".$chapter_lessons[$i]['id']."/".$chapter_lessons[$i]['slug']) ."' class='link-read-more'>Read more</a></li>";
		                       							}

		                       							
		                       						}
		                       					}
		                       				?>
		                       			</ul>
		                       		</div>
	                       		</div>
	                       		
	                       	</div>
	                    </div>

	                </div>

	            <?php endif; ?>

            </div>

        </div>
    </div>

    <script type="text/javascript">
    	var lessonID = <?php echo $lesson_data[0]['id']; ?>;
    	var stdNum = <?php echo $this->session->userdata('std_session_stdNum'); ?>;
    </script>