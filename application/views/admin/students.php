	<?php //print_r($student_to_update_data); ?>
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_student_id_num">Student ID Number (Press enter to validate student number))</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['stdNum']; ?>" class="form-control student_id_num" id="input_student_id_num" placeholder="id number">
                                <?php else: ?>
                                    <input type="text" class="form-control student_id_num" id="input_student_id_num" placeholder="id number">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_id_num" id="input_student_id_num" placeholder="id number">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_student_email">Email</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['email']; ?>" class="form-control student_email" id="input_student_email" placeholder="email">
                                <?php else: ?>
                                    <input type="text" class="form-control student_email" id="input_student_email" placeholder="email">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_email" id="input_student_email" placeholder="email">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_lastname">Last Name</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['lastName']; ?>" class="form-control student_lastname" id="input_lastname" placeholder="lastname">
                                <?php else: ?>
                                    <input type="text" class="form-control student_lastname" id="input_lastname" placeholder="lastname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_lastname" id="input_lastname" placeholder="lastname">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_firstname">First Name</label>

                            <?php if (isset($studentID) && $studentID > 0): ?>

                                <?php if (sizeof($student_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $student_to_update_data['firstName']; ?>" class="form-control student_firstname" id="input_firstname" placeholder="firstname">
                                <?php else: ?>
                                    <input type="text" class="form-control student_firstname" id="input_firstname" placeholder="firstname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control student_firstname" id="input_firstname" placeholder="firstname">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_password">Password</label>
                            <input type="password" class="form-control student_password" id="input_password" placeholder="password">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_confirm_password">Confirm Password</label>
                            <input type="password" class="form-control student_confirm_password" id="input_confirm_password" placeholder="confirm password">
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

