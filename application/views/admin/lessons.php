	<pre>
     <?php //print_r($chapters_lessons); ?>   
    </pre>
    
	<div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-lessons" placeholder="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-lessons" type="button">
                            <span class="fa fa-search"></span> Search
                        </button>
                        <button class="btn btn-primary btn-refresh" type="button">
                            <span class="fa fa-sync-alt"></span> Refresh
                        </button>
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModalCenter">
                            <span class="fa fa-search"></span> Advance Search
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div id="lessons_pagination"></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            	<h4 id="search_length"></h4>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="line"></div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="search_lessons_results">
            </div>
        </div>
    </div>

    <!-- Advance Search modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Advance Search</h5>
                <button type="button" class="close btn-close-advance-search" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <div class="form-group">
                    <label for="select_principleID">Select Principle</label>
                    
                    <select class="form-control principleID" id="select_principleID">
                        <option value=""></option>
                        <?php
                            $principlesLen = sizeof($principles);
                            for($i=0; $i<$principlesLen; $i++){
                                echo "<option value='". $principles[$i]['id'] ."'>". $principles[$i]['principle'] ."</option>";
                            }
                        ?>
                    </select>

                    <div class="form-group">
                        <label for="select_sub_topic_ID">Select Sub Topic</label>
                        
                        <select class="form-control sub_topic_ID" id="select_sub_topic_ID">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="select_sub_topic_ID">Chapters</label>
                        
                        <select class="form-control chapter_id" id="select_chapter_ID">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input_lesson_title">Lesson title</label>

                        <input type="text" class="form-control lesson_title" id="input_lesson_title" placeholder="Title">
                    </div>

                    <div class="form-group">
                        <label for="input_faculty_id_number">Faculty ID Number</label>

                        <input type="text" class="form-control faculty_id_number" id="input_faculty_id_number" placeholder="ID Number">
                    </div>

                    <div class="form-group">
                        <label for="input_lesson_title">Date Added (optional)</label>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="text" class="form-control advance_search_date_range" id="addedStartDate" placeholder="mm/dd/yyyy">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <input type="text" class="form-control advance_search_date_range" id="addedEndDate" placeholder="mm/dd/yyyy">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="fa fa-times"></span> Close
                </button>
                <button type="button" class="btn btn-primary btn-advance-search-lesson">
                    <span class="fa fa-search"></span> Search
                </button>
            </div>
        </div>
      </div>
    </div>


    <!-- Update Summary modal -->
    <div class="modal fade" id="update_summary_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Summary</h5>
                <button type="button" class="close btn-close-advance-search" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>
                <h3>HI</h3>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="fa fa-times"></span> Close
                </button>
            </div>
        </div>
      </div>
    </div>

        <!-- Hidden by default -->
    <div id="deleteDialog" title="Delete Student data">
        <p>Are you sure you want to delete this lesson ?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>

    <script type="text/javascript">
        var userType = "<?php echo $userType; ?>";
    </script>