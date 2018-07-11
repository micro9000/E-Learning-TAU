    
    <?php //print_r($principle_to_update_data); ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="form-group">
                    <label for="input_agriculture_principle">Agriculure Principle</label>

                    <?php if (isset($principleID) && $principleID > 0): ?>

                        <?php if (sizeof($principle_to_update_data) > 0): ?>
                            <input type="text" value="<?php echo $principle_to_update_data['principle']; ?>" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="Principle">
                        <?php else: ?>
                            <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="Principle">
                        <?php endif; ?>

                    <?php else: ?>
                        <input type="text" class="form-control agriculture_principle" id="input_agriculture_principle" placeholder="Principle">
                    <?php endif; ?>

                </div>
                <div class="form-group">
                	<?php if (isset($principleID) && $principleID > 0): ?>

                        <?php if (sizeof($principle_to_update_data) > 0): ?>
                            <button type="submit" class="btn btn-primary btn-update-principle" data-id='<?php echo $principleID; ?>'>
                                <span class="fa fa-edit"></span>Update
                            </button>
                            <button type="submit" class="btn btn-primary btn-cancel-update-principle">
                                <span class="fa fa-ban"></span> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary btn-cancel-update-principle">
                                <span class="fa fa-chevron-left"></span> Back
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


            <div class="line"></div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-principle" placeholder="Principle" aria-describedby="basic-addon2">
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
                            <th scope="col">Principle</th>
                            <th scope="col">User</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Date Modify</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    
                    <?php if (isset($principleID) && $principleID > 0): ?>
                        <?php if (sizeof($principle_to_update_data) > 0): ?>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><?php echo $principle_to_update_data['principle']; ?></td>
                                    <td><?php echo $principle_to_update_data['facultyName']; ?></td>
                                    <td><?php echo $principle_to_update_data['dateAddedFormated']; ?></td>
                                    <td><?php echo $principle_to_update_data['dateModifyFormated']; ?></td>
                                </tr>
                            </tbody>
                        <?php endif; ?>
                    <?php else: ?>
                        <tbody id="principle_list_tb"></tbody>   
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Hidden by default -->
    <div id="deleteDialog" title="Delete Principle">
        <p>Are you sure you want to delete this item?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>

    <script type="text/javascript">
        var principleID = <?php echo (isset($principleID) && $principleID > 0) ? $principleID : 0 ?>;
    </script>