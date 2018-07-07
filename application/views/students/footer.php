
		
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/popper.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery.mCustomScrollbar.concat.min.js"); ?>"></script>

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

	<?php elseif($page_code == ""): ?>

	<?php endif; ?>

</body>
</html>