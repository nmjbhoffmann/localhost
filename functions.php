<?php
function localhost_redirect($url){
    if (($_SERVER['SERVER_NAME'] == 'localhost') && $url !="")
    {
        header('Location: '.$url);
    }
}

function get_folder_size($path){
    $path = "'".$path."'";
    $io   = popen ( '/usr/bin/du -h -s '.$path, 'r' );
    $size = fgets ( $io, 4096);
    $size = substr ( $size, 0, strpos ( $size, "\t" ) );
    pclose ( $io );
    return $size;
}

function list_sites($exclude_list = array(".",".."),$path,$submode = false,$domain_name="",$class=""){
    $dir_handle = @opendir($path) or die("Invalid Directory");

    while (false !== ($folder = readdir($dir_handle))) {
    if(in_array($folder, $exclude_list))
    continue;

        //Loop through the projects to see what files they contain
        if (is_dir($path.'/'.$folder)) { // Check if it is a folder, since it's pointless having a subdomain point to a file

            $project_path  = @opendir($path.'/'.$folder);
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
            elseif (in_array("backend", $project_files) && in_array("console", $project_files)) {
                $type = "Yii";
            }
            else {
                $type = "Custom Project";
            }


            //Get Folder Size
            $size = get_folder_size($path."/".$folder."/");
            //Make some pretty File names
            $file_title = str_replace("_", " ", $folder);
            $file_title = ucwords(strtolower($file_title));
            if ($submode == true) {
                echo "<li class='".$class." ".$type."'><a href='https://".$folder.".".$domain_name."'>".$file_title."</a><small class='tags ".$type."'>".$type." <div class='tag-size'>= ".$size."</div></small></li>";
            }
            else{
                echo "<li class='".$class." ".$type."'><a href='https://".$domain_name."/".$folder."'>".$file_title."</a><small class='tags ".$type."'>".$type." <div class='tag-size'>= ".$size."</div></small></li>";
            }
        }
    }
    closedir($dir_handle);
}

function config($data = FALSE)
{
    # Read the current data file
    $current_data = unserialize(file_get_contents("data"));

    # If no data needs to be saved, just return what's there in array format
    if ($data)
    {
        $data_file = fopen("data", "w") or die("Unable to open data file!");
        foreach ($data as $key => $value) {
            $current_data[$key] = $value;
        }
        fwrite($data_file, serialize($current_data));
    }

    return $current_data;
}


?>
