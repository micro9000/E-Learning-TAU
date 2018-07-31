		<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container">

                <button type="button" id="sidebarCollapse" class="btn btn-info btn-show-menu">
                    <i class="fas fa-align-left"></i>
                    <span>Menu</span>
                </button>

                <button class="btn btn-dark d-inline-block d-lg-none ml-auto btn-show-top-menu" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="nav navbar-nav ml-auto">
                    		
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url("home_page"); ?>"><span class="fa fa-home"></span> Home</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url("student_profile"); ?>"><span class="fa fa-user"></span> Profile</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url("student_logout"); ?>"><span class="fa fa-sign-out-alt"></span> Sign out</a>
                        </li>

                        <li class="nav-item" style="width: 300px;">
                            <form class="frm-search-lessons">
                                <div class="input-group">
                                    <input type="text" class="form-control search-article search-lessons-str" placeholder="Search">
                                    <div class="input-group-btn">
                                    <button class="btn btn-default btn-search-article btn-search-lessons" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    </div>
                                </div>
                            </form>
                                
                        </li>
                        
                    </ul>

                </div>


            </div>
        </nav>