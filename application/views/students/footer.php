    <div class="wrapper" style="bottom: 0; margin-bottom: 0">
        <div class="content">
            <div style="width: 100%; background-color: #53ad5a; color: #fff; padding-top: 30px; padding-bottom: 30px">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4>E-LEARNING</h4>
                            <hr>
                        </div>

                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" style="margin: auto;">
                            <a href="#"><img src="<?php echo base_url("assets/imgs/TAU.png") ?>"></a>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                            <h4>PRINCIPLES</h4>

                            <ul style="list-style-type: none; padding-left: 0;">
                                <?php 

                                    $principleLen = sizeof($agriculture_matrix);

                                    for($prinIdx=0; $prinIdx < $principleLen; $prinIdx++){
                                        echo "<li>".$agriculture_matrix[$prinIdx]['principle']."</li>";
                                    }
                                ?>
                            </ul>

                        </div>


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <hr>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div>
                                Copyright &copy 2018 ELearning. All Right Reserved. <br/>
                                <a href="http://www.tca.edu.ph/">Tarlac Agricultural University Official Website</a>
                            </div>
                        </div>

                    </div>
                </div>
                        
            </div>
        </div>
    </div>
		
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/popper.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery.mCustomScrollbar.concat.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/pagination.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url("assets/js/validations.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/sha512.min.js"); ?>"></script>
    
	<script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss').on('click', function () { // .overlay
                $('#sidebar').removeClass('active');
                // $('.overlay').removeClass('active');
            });

            $(".wrapper").on('click', function() {
                $('#sidebar').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                // $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>

	<?php if ($page_code == "login"): ?>

		<script type="text/javascript" src="<?php echo base_url("assets/js/students/login.js"); ?>"></script>

	<?php elseif($page_code == "view_lesson"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/students/view_lesson.js"); ?>"></script>

    <?php elseif($page_code == "registration" || $page_code == "registration_code"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/students/register.js"); ?>"></script>

    <?php elseif($page_code == "passwd_recovery_page" || $page_code == "pswd_recovery_code" || $page_code == "change_password"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/students/password_recovery.js"); ?>"></script>

    <?php elseif($page_code == "student_profile_panel"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/students/profile.js"); ?>"></script>

         <script type="text/javascript">
            $("#menu_profile").addClass("active");
        </script>

    <?php elseif($page_code == "chapter_take_quiz"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/students/chapter_take_quiz.js"); ?>"></script>

    <?php elseif($page_code == "home"): ?>

        <script type="text/javascript">
            $("#menu_home").addClass("active");
        </script>

    <?php elseif($page_code == "quizzes_results"): ?>

        <script type="text/javascript">
            $("#menu_quiz_results").addClass("active");
        </script>

	<?php endif; ?>


    <script type="text/javascript" src="<?php echo base_url("assets/js/students/search_lessons.js"); ?>"></script>

</body>
</html>