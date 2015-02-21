<!DOCTYPE html>
<html>
<head>
	<title>Localhost</title>
	<?php include('assets/functions.php'); ?>
	<link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
<div class="sidebar">
	<div class="side_title"><?php echo $_SERVER['SERVER_NAME']?></div>
	<div class="rule"></div>
	<div class="side_head">Applications</div>
	<div class="side_container">
		<a href="<?=$base_url;?>phpmyadmin">PHPMyadmin</a>
	</div>
	<div class="side_head">Add Site</div>
	<form name="input" action="" method="post" class="side-input">
		<input type="text" name="site">
		<?php if (isset($_POST['site'])) { create_site($_POST['site'],'.'.$_SERVER['SERVER_NAME']); } ?>
	</form> 
</div>
<div class="content">
<?php list_sites($exclude_list,'.'.'kirastation1',"file_list"); ?>



</div>
</body>
</html>