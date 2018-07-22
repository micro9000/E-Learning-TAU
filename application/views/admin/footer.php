    
		
		</div> <!-- content class div - see content_start_div.php -->
	</div> <!-- wrapper -->

    <script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/popper.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap-switch.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/plugins/pagination.min.js"); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url("assets/plugins/tinymce/tinymce.min.js"); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url("assets/js/validations.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/sha512.min.js"); ?>"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

        // $(".advance_search_date_range").datepicker();
    </script>

    <?php if ($page_code == "login"): ?>

		<script type="text/javascript" src="<?php echo base_url("assets/js/admin/login.js"); ?>"></script>

	<?php elseif($page_code == "principle_panel"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/principle.js"); ?>"></script>

    <?php elseif($page_code == "principle_sub_topic_panel"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/sub_topics.js"); ?>"></script>

    <?php elseif($page_code == "sub_topic_chapters_panel"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/chapters.js"); ?>"></script>

    <?php elseif($page_code == "chapters_lessons_panel"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/lessons.js"); ?>"></script>
    
    <?php elseif($page_code == "faculty_list_panel"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/faculty.js"); ?>"></script>
    
    <?php elseif($page_code == "students_list_panel"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/students.js"); ?>"></script>
    
    <?php elseif($page_code == "add_lessons"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/add_lessons.js"); ?>"></script>
    
    <?php elseif($page_code == "audit_trail"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/audit_trail.js"); ?>"></script>

    <?php elseif($page_code == "recycle_bin_principle"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/recycle_bin_principle.js"); ?>"></script>

    <?php elseif($page_code == "recycle_bin_sub_topics"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/recycle_bin_sub_topics.js"); ?>"></script>

    <?php elseif($page_code == "recycle_bin_chapters"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/recycle_bin_chapters.js"); ?>"></script>

    <?php elseif($page_code == "recycle_bin_faculties"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/recycle_bin_faculties.js"); ?>"></script>

    <?php elseif($page_code == "recycle_bin_students"): ?>

        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/recycle_bin_students.js"); ?>"></script>

	<?php endif; ?>

    <?php if ($page_code !== "login"): ?>
        <script type="text/javascript" src="<?php echo base_url("assets/js/admin/control_btns.js"); ?>"></script>
    <?php endif; ?>

</body>
</html>