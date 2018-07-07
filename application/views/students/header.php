<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php echo $page_title; ?></title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/bootstrap/css/bootstrap.min.css"); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/system_design_base.css"); ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/plugins/jquery.mCustomScrollbar.min.css"); ?>">

	<script type="text/javascript" src="<?php echo base_url("assets/plugins/solid.js"); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url("assets/plugins/fontawesome.js"); ?>"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/students/tools.css"); ?>">

	<?php if ($page_code == "login"): ?>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/students/login.css"); ?>">

	<?php elseif($page_code == "home"): ?>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/main/master.css"); ?>">

	<?php endif; ?>

	
	<script type="text/javascript">
		var base_url = "<?php echo base_url(); ?>";
	</script>
</head>
<body>
