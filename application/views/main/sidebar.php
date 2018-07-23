			<!-- <pre>
				<?php //print_r($agriculture_matrix); ?>
			</pre> -->
			<!-- Sidebar  -->
			<nav id="sidebar">
			    <div id="dismiss">
			        <i class="fas fa-arrow-left"></i>
			    </div>

			    <div class="sidebar-header">
			        <a href="#"><img src="<?php echo base_url("assets/imgs/TAU.png") ?>"></a>
			    </div>

			    <ul class="list-unstyled components">
			        <p>E-Learning System</p>

			        <?php

			        	$principleLen = sizeof($agriculture_matrix);
			        	// PRINCIPLES
			        	for($prinIdx=0; $prinIdx < $principleLen; $prinIdx++){
			        		echo "<li>";
			        			echo "<a href='#principle_topics_". $prinIdx ."' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle'>". $agriculture_matrix[$prinIdx]['principle'] ."</a>";
			        			echo "<ul class='collapse list-unstyled' id='principle_topics_". $prinIdx ."'>";

			        				$subTopics = $agriculture_matrix[$prinIdx]['sub_topics'];
			        				$sub_topicsLen = sizeof($subTopics);

			        				// SUB TOPICS
			        				for($topicIdx=0; $topicIdx < $sub_topicsLen; $topicIdx++){
			        					echo "<li>";
			        						echo "<a href='#topic_chapter_". $prinIdx . "_" . $topicIdx ."' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle'>";
			        							echo "<span class='fa fa-angle-double-right'></span>" . $subTopics[$topicIdx]['topic'];
			        						echo "</a>";
			        						echo "<ul class='collapse list-unstyled' id='topic_chapter_". $prinIdx . "_" . $topicIdx ."'>";
												
												$chapters = $subTopics[$topicIdx]['chapters'];
												$chapterLessonsLen = sizeof($chapters);

												// CHAPTERS
												for($chapIdx=0; $chapIdx < $chapterLessonsLen; $chapIdx++){
													echo "<li>";
				        								echo "<a href='#chapter_lesson_". $prinIdx . "_" . $topicIdx ."_". $chapIdx ."' data-toggle='collapse' aria-expanded='false' class='dropdown-toggle'>";
				        									echo "<span class='fa fa-angle-double-right'></span> " . $chapters[$chapIdx]['chapter'];
				        								echo "</a>";
				        								echo "<ul class='collapse list-unstyled' id='chapter_lesson_". $prinIdx . "_" . $topicIdx ."_". $chapIdx ."'>";

					        								$lessons = $chapters[$chapIdx]['lessons'];
					        								$lessonsLen = sizeof($lessons);

					        								//LESSONS
					        								for($lesIdx=0; $lesIdx < $lessonsLen; $lesIdx++){
					        									echo "<li>";
					        										echo "<a href='". base_url('view_lesson/'.$lessons[$lesIdx]['lessonID'] ."/". $lessons[$lesIdx]['lessonSlug']) ."'><span class='fa fa-angle-right'></span> ". $lessons[$lesIdx]['lessonTitle'] ."</a>";
					        									echo "</li>";
					        								}

					        							echo "</ul>";

				        							echo "</li>";
												}			        							


			        						echo "</ul>";
			        					echo "</li>";
			        				}

			        			echo "</ul>";
			        		echo "</li>";
			        	}

			        ?>

			    </ul>

			    <ul class="list-unstyled CTAs">
			        <li>
			            <a href="http://www.tca.edu.ph/" class="download">Tarlac Agricultural University Official Website</a>
			        </li>
			       <!--  <li>
			            <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
			        </li> -->
			    </ul>


			</nav>