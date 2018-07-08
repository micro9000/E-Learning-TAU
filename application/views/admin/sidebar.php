		<!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5>E-Learning Admin Panel</h5>
            </div>

            <ul class="list-unstyled components">
                <p>Admin: <?php echo $this->session->userdata('admin_session_firstName') ." ". $this->session->userdata('admin_session_lastName') ?></p>
                
                <li id="principles_page">
                    <a href="<?php echo base_url("admin_agriculture_principles"); ?>">Principles</a>
                </li>

                <li id="principles_sub_topic_page">
                    <a href="<?php echo base_url("admin_principles_sub_topics"); ?>">Principles sub topics</a>
                </li>

                <li id="sub_topic_chapters_page">
                    <a href="<?php echo base_url("sub_topic_chapters"); ?>">Chapters</a>
                </li>

                <li id="chapters_lessons_page">
                    <a href="<?php echo base_url("chapters_lessons"); ?>">Lessons</a>
                </li>

                <li id="faculty_list_page">
                    <a href="#facultiesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle faculty_list_page">Faculties</a>
                    <ul class="collapse list-unstyled" id="facultiesSubmenu">
                        <li>
                            <a href="<?php echo base_url("faculties"); ?>">List</a>
                        </li>
                        <li>
                            <a href="#">Add / Update</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#studentsSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Students</a>
                    <ul class="collapse list-unstyled" id="studentsSubmenu">
                        <li>
                            <a href="#">List</a>
                        </li>
                        <li>
                            <a href="#">Add / Update</a>
                        </li>
                        <li>
                            <a href="#">Student numbers</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Admins</a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li>
                            <a href="#">List</a>
                        </li>
                        <li>
                            <a href="#">Add / Update</a>
                        </li>
                    </ul>
                </li>
                
                <!-- <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pages</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Portfolio</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li> -->
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