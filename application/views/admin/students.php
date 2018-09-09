	<?php //print_r($student_to_update_data); ?>
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4>Students</h4>
                <div class="line"></div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                <div class="form-group">
                    <label for="exampleFormControlFile1">Students Number list Mass Upload (.csv file)</label>
                    <input type="file" class="form-control-file student-numbers" id="exampleFormControlFile1">
                    <br/>
                    <button type="submit" class="btn btn-primary btn-upload-student-numbers"><span class="fa fa-upload"></span> Upload</button>

                    <button class="btn btn-primary btn-view-student-numbers" type="button" data-toggle="modal" data-target="#exampleModalCenter">
                        <span class="fa fa-eye"></span> View Student Numbers
                    </button>

                    <br/><div id="student_num_mass_upload_msg" style="font-size: 10px; width: 500px; height: auto"></div>
                </div>
                
                <div class="line"></div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_student_id_num">Student ID Number (Press enter to validate student number)</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['stdNum']; ?>" class="form-control student_id_num" id="input_student_id_num">
                                <?php else: ?>
                                    <input type="text" class="form-control student_id_num" id="input_student_id_num">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_id_num" id="input_student_id_num">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_student_email">Email</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['email']; ?>" class="form-control student_email" id="input_student_email">
                                <?php else: ?>
                                    <input type="text" class="form-control student_email" id="input_student_email">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_email" id="input_student_email">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_lastname">Last Name</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['lastName']; ?>" class="form-control student_lastname" id="input_lastname">
                                <?php else: ?>
                                    <input type="text" class="form-control student_lastname" id="input_lastname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_lastname" id="input_lastname">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_firstname">First Name</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['firstName']; ?>" class="form-control student_firstname" id="input_firstname">
                                <?php else: ?>
                                    <input type="text" class="form-control student_firstname" id="input_firstname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_firstname" id="input_firstname">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_firstname">Section</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['stdSection']; ?>" class="form-control student_section" id="input_std_section">
                                <?php else: ?>
                                    <input type="text" class="form-control student_section" id="input_std_section">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_section" id="input_std_section">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_password">Password</label>
                            <input type="password" class="form-control student_password" id="input_password">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_confirm_password">Confirm Password</label>
                            <input type="password" class="form-control student_confirm_password" id="input_confirm_password">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <button type="submit" class="btn btn-primary btn-update-student-data" data-id='<?php echo $studentID; ?>'>
                                        <span class="fa fa-edit"></span>Update
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-cancel-update-student-data">
                                        <span class="fa fa-ban"></span> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-cancel-update-student-data">
                                        <span class="fa fa-chevron-left"></span> Back
                                    </button>
                                <?php else: ?>
                                    <p>Student data does not exists</p>
                                <?php endif; ?>

                            <?php else: ?>
                                <button type="submit" class="btn btn-primary btn-add-student-data">
                                    <span class="fa fa-plus-square"></span> Add</button>
                            <?php endif; ?>
                            <div id="student_data_msg"></div>
                        </div>
                    </div>
                </div>

                <div class="line"></div>
            </div>

        	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div id="student_pagination"></div>   
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-student" placeholder="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-student" type="button">
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
                            <th scope="col">ID Number</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Section</th>
                            <th scope="col">Date Registered</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <?php if (isset($studentID) && $studentID > 0): ?>
                        <?php if (sizeof($student_to_update_data) > 0): ?>
                            
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $student_to_update_data['stdNum'] ?></td>
                                    <td><?php echo $student_to_update_data['firstName'] ." ". $student_to_update_data['lastName'] ?></td>
                                    <td><?php echo $student_to_update_data['email'] ?></td>
                                    <td><?php echo $student_to_update_data['stdSection'] ?></td>
                                    <td><?php echo $student_to_update_data['dateRegisteredFormated'] ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        <?php else: ?>
                            <tbody id="stdNum_list_tb"></tbody>
                        <?php endif; ?>
                    <?php else: ?>
                        <tbody id="stdNum_list_tb"></tbody>
                    <?php endif; ?>
                    
                </table>
            </div>

        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Student Numbers <p><span>Results: <span id="students_nums_len"></span></span></p></h5>
                <button type="button" class="close btn-close-advance-search" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container">
                    <div class="row">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control search-student-number" placeholder="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-search-student-number" type="button">
                                    <span class="fa fa-search"></span>Search
                                </button>
                            </div>
                        </div>

                        <div id="student_nums_pagination"></div>



                        <table class="table table-sm table-striped table-bordered table-hover std_nums_list_tb">
                            <thead>
                                <tr>
                                    <th class="col-sm-2">#</th>
                                    <th class="col-sm-10">Student Numbers</th>
                                </tr>
                            </thead>
                            <tbody id="student_numbers_list"></tbody>
                        </table>
                    </div>
                </div>

                        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <span class="fa fa-times"></span> Close
                </button>
            </div>
        </div>
      </div>
    </div>

    <div class="loader_blocks"></div>

    <!-- Hidden by default -->
    <div id="deleteDialog" title="Delete Student data">
        <p>Are you sure you want to delete this student data?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>

    <script type="text/javascript">
        var studentID = <?php echo (isset($studentID)) ? $studentID : 0; ?>;
    </script>

