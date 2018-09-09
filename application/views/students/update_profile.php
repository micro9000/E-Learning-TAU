	<div class="wrapper">
		<div class="content">
			<div class="container">

		        <div class="row">

		            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		            	<div class="profile-wrapper">
		            		<div class="row">
		            			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		            				<h3>Update Profile</h3>
		            				<div class="line"></div>
		            			</div>
			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_student_id_num">Student ID Number (Press enter to validate student number))</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <input type="text" value="<?php echo $student_to_update_data['stdNum']; ?>" class="form-control student_id_num" id="input_student_id_num" placeholder="id number" disabled="disabled">
			                                <?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_student_email">Email</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <input type="text" value="<?php echo $student_to_update_data['email']; ?>" class="form-control student_email" id="input_student_email" placeholder="email">
			                                <?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_lastname">Last Name</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <input type="text" value="<?php echo $student_to_update_data['lastName']; ?>" class="form-control student_lastname" id="input_lastname" placeholder="lastname">
			                                <?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_firstname">First Name</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <input type="text" value="<?php echo $student_to_update_data['firstName']; ?>" class="form-control student_firstname" id="input_firstname" placeholder="firstname">
			                                <?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_confirm_password">Subject</label>
			                            <input type="text" class="form-control student_subject" value="<?php echo $student_to_update_data['stdSubject']; ?>" id="input_std_subject">
			                        </div>
			                    </div>

								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
                                                
									            <a href="<?php echo base_url("student_profile") ?>" class="btn btn-primary">
                                                    <span class="fa fa-ban"></span> Cancel
                                                </a>
			                                <?php else: ?>
			                                    <p>Student data does not exists</p>
			                                <?php endif; ?>
			                            <?php endif; ?>
			                            <div id="student_data_msg"></div>
			                        </div>
			                    </div>
			                </div>
		            	</div>

			                
		            </div>
		        </div>
		    </div>
		</div>
	</div>

		    


