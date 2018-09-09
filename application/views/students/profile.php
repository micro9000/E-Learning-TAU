	
	<div class="wrapper">
		<div class="content">
			<div class="container">

		        <div class="row">

		            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

		            	<div class="profile-wrapper">
		            		<div class="row">
		            			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		            				<h3>Profile</h3>
									<a href="<?php echo base_url("update_student_profile") ?>" style="color: skyblue; text-decoration: underline;">Update Profile</a>
		            				<div class="line"></div>
		            			</div>
			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_student_id_num">Student ID Number</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <!-- <input type="text" value="<?php //echo $student_to_update_data['stdNum']; ?>" class="form-control student_id_num" id="input_student_id_num" placeholder="id number" disabled="disabled"> -->
			                                	<p><?php echo $student_to_update_data['stdNum']; ?></p>
											<?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_student_email">Email</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <!-- <input type="text" value="<?php //echo $student_to_update_data['email']; ?>" class="form-control student_email" id="input_student_email" placeholder="email"> -->
			                                	<p><?php echo $student_to_update_data['email']; ?></p>
											<?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_lastname">Last Name</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <!-- <input type="text" value="<?php //echo $student_to_update_data['lastName']; ?>" class="form-control student_lastname" id="input_lastname" placeholder="lastname"> -->
			                                	<p><?php echo $student_to_update_data['lastName']; ?></p>
											<?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

			                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_firstname">First Name</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <!-- <input type="text" value="<?php //echo $student_to_update_data['firstName']; ?>" class="form-control student_firstname" id="input_firstname" placeholder="firstname"> -->
			                                	<p><?php echo $student_to_update_data['firstName']; ?></p>
											<?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			                        <div class="form-group">
			                            <label for="input_firstname">Subject</label>

			                            <?php if (isset($studentID) && $studentID > 0): ?>

			                                <?php if (sizeof($student_to_update_data) > 0): ?>
			                                    <p><?php echo ($student_to_update_data['stdSubject'] != "") ? $student_to_update_data['stdSubject'] : "none"; ?></p>
											<?php endif; ?>

			                            <?php endif; ?>
			                        </div>
			                    </div>

			                </div>
		            	</div>

			                
		            </div>
		        </div>
		    </div>
		</div>
	</div>

		    


