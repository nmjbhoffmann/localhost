<?php
$base_url     = 'https://localhost'.$_SERVER['SERVER_NAME'].'/';
$exclude_list = array(".","..","index.php","server_site","assets");



function list_sites($exclude_list = array(".","..","index.php"),$domain_name="",$class=""){
	$path = $_SERVER['DOCUMENT_ROOT'];
	$dir_handle = @opendir($path) or die("Invalid Directory");

	while (false !== ($file = readdir($dir_handle))) {
	if(in_array($file, $exclude_list))
	continue;

		//Loop through the projects to see what files they contain
		$project_path = @opendir($file);
		$project_files = array('');
		while ($pfile = readdir($project_path)) {
			array_push($project_files, $pfile);
		}
		closedir($project_path);

		//Check what type of project it is based on the files inside
		if (in_array("wp-config.php", $project_files)) {
			$type = "Wordpress";
		}
		elseif (in_array("application", $project_files)) {
			$type = "CodeIgnitor";
		}
		elseif (in_array("app", $project_files) && in_array("src", $project_files)) {
			$type = "Symfony";
		}
		else {
			$type = "Custom Project";
		}
		//Make some pretty File names
		$file       = str_replace("_", " ", $file);
		$file_title    = ucwords(strtolower($file));

		echo "<li class='".$class." ".$type."'><a href='https://".$file.$domain_name."'>".$file_title."</a><small class='tags'>".$type."</small></li>";
	}
	closedir($dir_handle);
}


?>
