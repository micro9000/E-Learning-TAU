	
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_faculty_id_num">Faculty ID Number</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['facultyIDNum']; ?>" class="form-control faculty_id_num" id="input_faculty_id_num" placeholder="id number">
                                <?php else: ?>
                                    <input type="text" class="form-control faculty_id_num" id="input_faculty_id_num" placeholder="id number">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control faculty_id_num" id="input_faculty_id_num" placeholder="id number">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_faculty_email">Email</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['email']; ?>" class="form-control faculty_email" id="input_faculty_email" placeholder="email">
                                <?php else: ?>
                                    <input type="text" class="form-control faculty_email" id="input_faculty_email" placeholder="email">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control faculty_email" id="input_faculty_email" placeholder="email">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_lastname">Last Name</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['firstName']; ?>" class="form-control faculty_lastname" id="input_lastname" placeholder="lastname">
                                <?php else: ?>
                                    <input type="text" class="form-control faculty_lastname" id="input_lastname" placeholder="lastname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control faculty_lastname" id="input_lastname" placeholder="lastname">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_firstname">First Name</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['firstName']; ?>" class="form-control faculty_firstname" id="input_firstname" placeholder="firstname">
                                <?php else: ?>
                                    <input type="text" class="form-control faculty_firstname" id="input_firstname" placeholder="firstname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control faculty_firstname" id="input_firstname" placeholder="firstname">
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
                                    <button type="submit" class="btn btn-primary btn-update-faculty-data" data-id='<?php echo $facultyID; ?>'>
                                        <span class="fa fa-edit"></span>Update
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-cancel-update-faculty-data">
                                        <span class="fa fa-ban"></span> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-cancel-update-faculty-data">
                                        <span class="fa fa-chevron-left"></span> Back
                                    </button>
                                <?php else: ?>
                                    <p>Faculty data does not exists</p>
                                <?php endif; ?>

                            <?php else: ?>
                                <button type="submit" class="btn btn-primary btn-add-faculty-data">
                                    <span class="fa fa-plus-square"></span> Add</button>
                            <?php endif; ?>
                            <div id="faculty_data_msg"></div>
                        </div>
                    </div>
                </div>

                        


                <div class="line"></div>
            </div>

        	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-faculty" placeholder="Name or faculty id number" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-faculty" type="button">
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
                            <th scope="col">Added by</th>
                            <th scope="col">Admin</th>
                            <th scope="col">Dean</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    <?php if (isset($facultyID) && $facultyID > 0): ?>
                        <?php if (sizeof($faculty_to_update_data) > 0): ?>
                            
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $faculty_to_update_data['facultyIDNum'] ?></td>
                                    <td><?php echo $faculty_to_update_data['firstName'] ." ". $faculty_to_update_data['lastName'] ?></td>
                                    <td><?php echo $faculty_to_update_data['email'] ?></td>
                                    <td><?php echo $faculty_to_update_data['dateRegisteredFormated'] ?></td>
                                    <td><?php echo $admin_data['firstName'] ." ". $admin_data['lastName'] ?></td>
                                    <td><input type='checkbox' class="switch-mark-as-admin" name='mark-as-admin' data-id="<?php echo $faculty_to_update_data['id'] ?>" checked></td>
                                    <td><input type='checkbox' class="switch-mark-as-dean" name='mark-as-dean' data-id="<?php echo $faculty_to_update_data['id'] ?>" checked></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        <?php else: ?>
                            <tbody id="faculty_list_tb"></tbody>
                        <?php endif; ?>
                    <?php else: ?>
                        <tbody id="faculty_list_tb"></tbody>
                    <?php endif; ?>
                    
                </table>
            </div>
        </div>
    </div>

        <!-- Hidden by default -->
    <div id="deleteDialog" title="Delete Faculty data">
        <p>Are you sure you want to delete this faculty data?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>

    <script type="text/javascript">
        var facultyID = <?php echo (isset($facultyID)) ? $facultyID : 0; ?>;
    </script>