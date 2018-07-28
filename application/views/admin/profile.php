	
    <div class="container">
        <div class="row">

        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        		<h3>Profile</h3>
        		<div class="line"></div>
        	</div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_faculty_id_num">Faculty ID Number</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['facultyIDNum']; ?>" class="form-control faculty_id_num" id="input_faculty_id_num" placeholder="id number">
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_faculty_email">Email</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['email']; ?>" class="form-control faculty_email" id="input_faculty_email" placeholder="email">
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_lastname">Last Name</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['lastName']; ?>" class="form-control faculty_lastname" id="input_lastname" placeholder="lastname">
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_firstname">First Name</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['firstName']; ?>" class="form-control faculty_firstname" id="input_firstname" placeholder="firstname">
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_password">Password</label>
                            <input type="password" class="form-control faculty_password" id="input_password" placeholder="password">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_confirm_password">Confirm Password</label>
                            <input type="password" class="form-control faculty_confirm_password" id="input_confirm_password" placeholder="confirm password">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <button type="submit" class="btn btn-primary btn-update-profile-data" data-id='<?php echo $facultyID; ?>'>
                                        <span class="fa fa-edit"></span>Update
                                    </button>
                                <?php else: ?>
                                    <p>Faculty data does not exists</p>
                                <?php endif; ?>

                            <?php endif; ?>
                            <div id="faculty_data_msg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
