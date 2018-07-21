<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php echo $page_title; ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/bootstrap/css/bootstrap.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/bootstrap/css/bootstrap-switch.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/admin_panel.css"); ?>">
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/solid.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/fontawesome.js"); ?>"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.theme.min.css"); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.structure.min.css"); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/students/tools.css"); ?>">

	<?php if ($page_code == "login"): ?>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/students/login.css"); ?>">

	<?php elseif ($page_code == "main_panel"): ?>
		<style type="text/css">
			#admin_home_page{
				color: #fff;
				background: #0d330b;
			}
		</style>

	<?php else: ?>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/main/master.css"); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/admin/master.css"); ?>">

		<?php if ($page_code == "principle_panel"): ?>

			<style type="text/css">
				#principles_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>
		
		<?php elseif ($page_code == "principle_sub_topic_panel"): ?>

			<style type="text/css">
				#principles_sub_topic_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>

		<?php elseif ($page_code == "sub_topic_chapters_panel"): ?>
			
			<style type="text/css">
				#sub_topic_chapters_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>


		<?php elseif ($page_code == "chapters_lessons_panel"): ?>
			
			<style type="text/css">
				#chapters_lessons_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>

		<?php elseif ($page_code == "faculty_list_panel"): ?>
			
			<style type="text/css">
				#faculty_list_page, #faculty_list_page #facultiesSubmenu li{
					color: #fff;
    				background: #0d330b;
				}
			</style>

		<?php elseif ($page_code == "students_list_panel"): ?>
			
			<style type="text/css">
				#students_list_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>

		<?php elseif ($page_code == "add_lessons"): ?>
			
			<style type="text/css">
				#chapters_lessons_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>

		<?php elseif ($page_code == "audit_trail"): ?>
			
			<style type="text/css">
				#audit_trail_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>
			
		<?php elseif ($page_code == "recycle_bin_principle"): ?>
			
			<style type="text/css">
				#recycle_bin_page{
					color: #fff;
    				background: #0d330b;
				}
			</style>

		<?php endif; ?>

	
	<?php endif; ?>



	<script type="text/javascript">
		var base_url = "<?php echo base_url(); ?>";
	</script>
</head>
<body>

	<div class="wrapper" style="margin-top: 0">