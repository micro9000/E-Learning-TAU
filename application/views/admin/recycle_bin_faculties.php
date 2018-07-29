    
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><strong>Recycle bin: Faculties</strong></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="input-group mb-3">
                    <input type="text" class="form-control search-faculties" placeholder="Faculties" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-search-deleted-faculties" type="button">
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
                    
                    <tbody class="deleted_faculties"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="loader_blocks"></div>
    
    <!-- Hidden by default -->
    <div id="restoreDialog" title="Restore Faculty">
        <p>Are you sure you want to restore this item?</p>
    </div>

    <!-- Hidden by default -->
    <div id="actionMsgDialog" title="Message">
        <p class="actionMsg"></p>
    </div>