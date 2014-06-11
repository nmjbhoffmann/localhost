<!DOCTYPE html>
<html>
<head>
	<title>Localhost</title>
	<?php include('assets/functions.php'); ?>
	<link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
<div class="sidebar">
	<div class="side_title">TEST</div>
	<div class="rule"></div>
	<div class="side_head">Applications</div>
	<div class="side_container">
		<a href="<?=$base_url;?>phpmyadmin">PHPMyadmin</a>
	</div>
</div>
<div class="content">
<?php list_sites($exclude_list,'.'.$_SERVER['SERVER_NAME'],"file_list"); ?>



</div>
</body>
</html>