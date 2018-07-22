    
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">Lessons</div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-lessons" placeholder="Lessons" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-deleted-lessons" type="button">
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
                            <th scope="col">Title</th>
                            <th scope="col">Chapter</th>
                            <th scope="col">Topic</th>
                            <th scope="col">Principle</th>
                            <th scope="col">User</th>
                            <th scope="col">Control</th>
                        </tr>
                    </thead>
                    
                    <tbody class="deleted_principles"></tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Hidden by default -->
    <div id="restoreDialog" title="Restore Lesson">
        <p>Are you sure you want to restore this item?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>