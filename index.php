<!DOCTYPE html>
<html>
<?php
	//Stuff to configure
	$path         = "/var/www";													//Path to your www directory
	$base_url     = 'http://'.$_SERVER['SERVER_NAME'].'/'; 						//Your site URL (Normally won't need to change this)
	$exclude_list = array(".","..","index.php","functions.php","style.css");	//list of folders you would like to exclude (default assumes you just through this project into your main www folder)
	$submode      = false; 														//If you want to list folders as subdomain links eg: test.localhost instead of localhost/test
	$domain_name  = $_SERVER['SERVER_NAME'];									//name of you computer, either localhost or your hostname (Normally won't need to change this)
	$class        = "file_list"; 												//A class name you would like your list to have, normally no change needed

	$redirect     = "";	//Don't set if you use http://localhost					//Makes sure you're on the right URL for people who use vhosts and set it up for their computer name 
																				//instead of localhost but keep typing localhost into the browser (like me),
?>

<?php
	include('functions.php');
	localhost_redirect($redirect);
?>

<head>
	<title><?php echo $domain_name;?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="sidebar">
	<div class="side_title"><?php echo $domain_name;?></div>
	<div class="rule"></div>
	<div class="side_head">Applications</div>
	<div class="side_container">
		<a href="<?php echo $base_url; ?>phpmyadmin">PHPMyadmin</a>
	</div>
</div>
	<div class="content"> <?php list_sites($exclude_list,$path,$submode,$domain_name,$class); ?>
</div>
</body>
</html>