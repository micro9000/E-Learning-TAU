
		
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/popper.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery.mCustomScrollbar.concat.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/pagination.min.js"); ?>"></script>

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
    
	<?php endif; ?>

    <script type="text/javascript" src="<?php echo base_url("assets/js/students/search_lessons.js"); ?>"></script>

</body>
</html>