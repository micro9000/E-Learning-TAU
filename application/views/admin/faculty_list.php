	<div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_agriculture_principle">Faculty ID Number</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['facultyIDNum']; ?>" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="id number">
                                <?php else: ?>
                                    <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="id number">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="id number">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_agriculture_principle">Email</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['firstName']; ?>" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="email">
                                <?php else: ?>
                                    <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="email">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="email">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_agriculture_principle">Last Name</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['firstName']; ?>" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="lastname">
                                <?php else: ?>
                                    <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="lastname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="lastname">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_agriculture_principle">First Name</label>

                            <?php if (isset($facultyID) && $facultyID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <input type="text" value="<?php echo $faculty_to_update_data['firstName']; ?>" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="firstname">
                                <?php else: ?>
                                    <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="firstname">
                                <?php endif; ?>

                            <?php else: ?>
                                <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="firstname">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="input_agriculture_principle">Password</label>
                            <input type="password" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="password">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <?php if (isset($facultyID) && $principlfacultyIDeID > 0): ?>

                                <?php if (sizeof($faculty_to_update_data) > 0): ?>
                                    <button type="submit" class="btn btn-primary btn-update-principle" data-id='<?php echo $facultyID; ?>'>
                                        <span class="fa fa-edit"></span>Update
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-cancel-update-principle">
                                        <span class="fa fa-ban"></span> Cancel
                                    </button>
                                <?php else: ?>
                                    <p>Principle does not exists</p>
                                <?php endif; ?>

                            <?php else: ?>
                                <button type="submit" class="btn btn-primary btn-add-principle">
                                    <span class="fa fa-plus-square"></span> Add</button>
                            <?php endif; ?>
                            <div id="agriculture_principle_msg"></div>
                        </div>
                    </div>
                </div>

                        


                <div class="line"></div>
            </div>

        	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-principle" placeholder="Name or faculty id number" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-principle" type="button">
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
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    
                    <tbody id=""></tbody>
                </table>
            </div>
        </div>
    </div>