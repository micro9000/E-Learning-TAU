    
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4>Audit Trail</h4>
                <div class="line"></div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="select_affectedModule">Affected Module</label>
                            
                            <select class="form-control affectedModule" id="select_affectedModule">
                                <option value=""></option>
                                <option value="PRPL">Principle</option>
                                <option value="SBTP">Sub Topic</option>
                                <option value="CHAP">Chapters</option>
                                <option value="LESS">Lessons</option>
                                <option value="FACU">Faculties</option>
                                <option value="STUD">Students</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="input_startDate">Date Range Start Date</label>
                            <input type="text" class="form-control dateRange start_date" id="input_startDate" placeholder="Start Date">
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="input_endDate">Date Range End Date</label>
                            <input type="text" class="form-control dateRange end_date" id="input_endDate" placeholder="End Date">
                        </div>
                    </div>

                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label for="btn-search-audit-trail">Search</label>
                            <button type="submit" id="btn-search-audit-trail" class="form-control btn btn-primary btn-search-audit-trail">
                                <span class="fa fa-search"></span> Search
                            </button>
                        </div>
                    </div>
                </div>
                    
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div id="audit_trail_pagination"></div>   
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <table class="table table-sm table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Action Done</th>
                            <th scope="col">Affected Module</th>
                            <th scope="col">Done by</th>
                            <th scope="col">Date Transaction</th>
                        </tr>
                    </thead>
                    
                    <tbody class="audit_trail_list">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="loader_blocks"></div>