	<div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info btn-show-menu">
                    <i class="fas fa-align-left"></i>
                    <span>Toggle Menu</span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <!-- <li class="nav-item active">
                            <a class="nav-link" href="#">Page</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span class="fas fa-user-circle"></span>Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('admin_logout'); ?>">
                                <span class="fas fa-sign-out-alt"></span> Sign-out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    