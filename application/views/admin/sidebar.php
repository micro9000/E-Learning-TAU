		<!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5>E-Learning Admin Panel</h5>
            </div>

            <ul class="list-unstyled components">
                <p><?php 
                        echo $actualUserType." : ";
                        echo $this->session->userdata('admin_session_firstName') ." ". $this->session->userdata('admin_session_lastName') 
                    ?></p>

                <li id="admin_home_page">
                    <a href="<?php echo base_url("admin_home"); ?>">Home</a>
                </li>
                
                <?php if ($userType == "admin_faculty" || $userType == "dean_admin_faculty"): // FOR ADMIN VIEW ONLY ?>

                    <li id="principles_page">
                        <a href="<?php echo base_url("admin_agriculture_principles"); ?>">Principles</a>
                    </li>

                    <li id="principles_sub_topic_page">
                        <a href="<?php echo base_url("admin_principles_sub_topics"); ?>">Principles sub topics</a>
                    </li>

                    <!-- <li id="sub_topic_chapters_page">
                        <a href="<?php echo base_url("sub_topic_chapters"); ?>">Chapters</a>
                    </li> -->

                <?php endif; ?>

                <li id="sub_topic_chapters_page">
                    <a href="<?php echo base_url("sub_topic_chapters"); ?>">Chapters</a>
                </li>

                <!-- <li id="chapters_lessons_page">
                    <a href="<?php //echo base_url("chapters_lessons"); ?>">Lessons</a>
                </li> -->

                <li>
                    <a href="#lessonsSubmenu" id="chapters_lessons_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Lessons</a>
                    <ul class="collapse list-unstyled" id="lessonsSubmenu">
                        <li>
                            <a href="<?php echo base_url("chapters_lessons"); ?>">Search</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("add_lessons"); ?>">Add / Update</a>
                        </li>
                        <!-- <li>
                            <a href="#">My Lessons</a>
                        </li> -->
                    </ul>
                </li>

                <?php if ($userType == "admin_faculty" || $userType == "dean_admin_faculty" || $userType == "dean"): ?>
                    <li id="faculty_list_page">
                        <a href="<?php echo base_url("faculties"); ?>">Faculty</a>
                    </li>
                    <li id="students_list_page">
                        <a href="<?php echo base_url("students"); ?>">Students</a>
                    </li>
                <?php endif; ?>

                <?php if ($userType == "admin_faculty" || $userType == "dean_admin_faculty"): // FOR ADMIN VIEW ONLY ?>
                    
                    <li id="audit_trail_page">
                        <a href="<?php echo base_url("audit_trail"); ?>">Audit Trail</a>
                    </li>
                    <li id="recycle_bin_page">
                        <a href="#recycleBinSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Recycle Bin</a>
                        <ul class="collapse list-unstyled" id="recycleBinSubmenu">
                            <li>
                                <a href="<?php echo base_url("recycle_bin_principle"); ?>">Principles</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("recycle_bin_principle_sub_topic"); ?>">Sub Topics</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("recycle_bin_chapters"); ?>">Chapters</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("recycle_bin_lessons"); ?>">Lessons</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("recycle_bin_faculties"); ?>">Faculties</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url("recycle_bin_students"); ?>">Students</a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>

            <ul class="list-unstyled CTAs">
                <li>
                    <a href="http://www.tca.edu.ph/" class="download">Tarlac Agricultural University Official Website</a>
                </li>
                <!-- <li>
                    <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                </li> -->
            </ul>
        </nav>