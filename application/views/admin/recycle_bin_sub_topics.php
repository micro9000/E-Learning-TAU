    
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">Agriculture Principles sub topics</div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-sub-topic" placeholder="Sub topic" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-deleted-sub-topic" type="button">
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
                            <th scope="col">Topic</th>
                            <th scope="col">Principle</th>
                            <th scope="col">User</th>
                            <th scope="col">Date Added</th>
                            <th scope="col">Date Modify</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    
                    <tbody class="deleted_sub_topics"></tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Hidden by default -->
    <div id="restoreDialog" title="Restore Principle Sub topic">
        <p>Are you sure you want to restore this item?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>