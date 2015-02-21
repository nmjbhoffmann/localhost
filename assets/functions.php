<?php
$base_url     = 'http://'.$_SERVER['SERVER_NAME'].'/';
$exclude_list = array(".","..","index.php","server_site","assets");



function list_sites($exclude_list = array(".","..","index.php"),$domain_name="",$class=""){
	$path = "/var/www";
	$dir_handle = @opendir($path) or die("Invalid Directory");

	while (false !== ($file = readdir($dir_handle))) {
	if(in_array($file, $exclude_list))
	continue;
		//Check if it is a directory
		
		//Loop through the projects to see what files they contain
		if (is_dir($path.'/'.$file)) {
			$project_path  = @opendir($path.'/'.$file);
			$project_files = array('');

			while ($pfile = readdir($project_path)) {
				array_push($project_files, $pfile);
			}
			
			closedir($project_path);
		}

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
		$file_title = str_replace("_", " ", $file);
		$file_title = ucwords(strtolower($file_title));

		echo "<li class='".$class." ".$type."'><a href='http://".$file.$domain_name."'>".$file_title."</a><small class='tags'>".$type."</small></li>";
		
	}
	closedir($dir_handle);
}

function create_site($name,$domain_name=""){
	//Get template
	$site_head   = file_get_contents('assets/snippets/site-head');
	$site_footer = file_get_contents('assets/snippets/site-footer');

	//Create content to insert into template
	$content = $site_head.'
	ServerName '.$name.'.kirastation1
	DocumentRoot /var/www/'.$name.'
	<Directory /var/www/'.$name.'/>
		Options Indexes FollowSymLinks
		AllowOverride All
		Require all granted
	</Directory>
'.$site_footer;
	//Add the location of apache's config folders
	$location = '/etc/apache2/sites-available/'.$name.'.conf';
	$site_enable = '/etc/apache2/sites-enabled/'.$name.'.conf';

	if (is_writable('/etc/apache2/sites-available/') && is_writable('/etc/apache2/sites-enabled/') && is_writable('/etc/hosts')) {

		if (file_exists($location)) {
			$status = "Created! Please run: <br/>sudo service apache2 restart";
		}else{
			//Add Site to apache
			file_put_contents($location, $content);
			//And enable it..
			symlink($location, $site_enable);
			//Add an entry into your hosts file
			$hosts  = file_get_contents('/etc/hosts');
			$hosts  = $hosts."\n127.0.0.1	".$name.".kirastation1";
			file_put_contents('/etc/hosts', $hosts);
			//Create the project folder
			mkdir("/var/www/".$name);
			//Make an index page for the hell of it
			// file_put_contents( "/var/www/".$name."/index.php","This will be the home of ".$name);
			//Done :D
			$status = "sudo service apache2 reload";
		}
	}else{
		$status = "Check Permissions";
	}
	
	echo '<small style="color:yellow;">'.$status.'</small>';
}


?>
