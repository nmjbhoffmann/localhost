<?php
function localhost_redirect($url){
    if (($_SERVER['SERVER_NAME'] == 'localhost') && $url !="")
    {
        header('Location: '.$url);
    }
}

/**
 * Sitelister
 *
 * This is a self contained class designed to do site listing with default or saved
 * parameters.
 */
class Sitelister
{
    public $defaults;
    public $config;

    public function __construct()
    {
        # Setup Defaults
        $this->defaults['domain_name']     = 'localhost';
        $this->defaults['path']            = '/var/www/';
        $this->defaults['base_url']        = 'http://localhost';
        $this->defaults['submode']         = "FALSE";
        $this->defaults['class']           = 'file_list';
        $this->defaults['exclude_list']    = ['.','..','functions.php', 'data', 'style.css', 'README.md', 'config.php'];
        $this->defaults['datapath']        = 'data';
        $this->defaults['pinned_sites']    = [];
        $this->defaults['sortbyframework'] = "TRUE";

        $this->config = $this->config();
    }

    public function config($data = FALSE)
    {
        # Read the current data file
        $current_data = unserialize(file_get_contents($this->defaults['datapath']));

        # If no data needs to be saved, just return what's there in array format
        if ($data)
        {
            $data_file = fopen($this->defaults['datapath'], "w") or die("Unable to open data file!");
            foreach ($data as $key => $value)
            {
                $current_data[$key] = $value;
            }
            fwrite($data_file, serialize($current_data));
            return TRUE;
        }

        # Add all default values if they don't exist in the config
        foreach ($this->defaults as $key => $value)
        {
            if (!isset($current_data[$key]))
            {
                $current_data[$key] = $value;
            }

        }

        return $current_data;
    }

    public function pin_site($project_name)
    {
        $pinned_sites = $this->config()['pinned_sites'];

        if (($key = array_search($project_name, $pinned_sites)) !== false) {
            unset($pinned_sites[$key]);
        }
        else
        {
            array_push($pinned_sites, $project_name);
        }
        $pinned_sites = array_values($pinned_sites);

        $this->config(['pinned_sites' => $pinned_sites]);

    }

    public function get_folder_size($path)
    {
        $path = "'".$path."'";

        # Not sure if this works since I don't use Windows, but worth added a check anyway
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
        {
            $obj = new COM ( 'scripting.filesystemobject' );
            $ref = $obj->getfolder ( $path );
            $obj = null;
            return 'Directory: ' . $path . ' => Size: ' . $ref->size;
        }

        $io   = popen ( '/usr/bin/du -h -s '.$path, 'r' );
        $size = fgets ( $io, 4096);
        $size = substr ( $size, 0, strpos ( $size, "\t" ) );
        pclose ( $io );
        return $size;

    }

    public function detect_framework($project)
    {

        $dir_handle = @opendir($this->config['path']."/".$project) or die("Invalid Framework Directory");
        $files      = [];
        $i = 0;
        while ( false !== ($folder = readdir($dir_handle)) )
        {
            $files[$i] = $folder;
            $i++;
        } # End While
        closedir($dir_handle);

        if (in_array("wp-config.php", $files))
        {
            return "Wordpress";
        }
        if (in_array("application", $files))
        {
            return "CodeIgnitor";
        }
        if (in_array("app", $files) && in_array("src", $files))
        {
            return "Symfony";
        }
        if (in_array("backend", $files) && in_array("console", $files))
        {
            return "Yii";
        }
        return 'Custom Project';
    }

    public function list_sites()
    {
        $projects        = [];
        $used_frameworks = [];

        # Create an array of folders in the project folder
        $dir_handle = @opendir($this->config['path']) or die("Invalid www Directory");

        while ( false !== ($folder = readdir($dir_handle)) )
        {
            # Only continue if the folder isn't excluded
            if(in_array($folder, $this->config['exclude_list']))
            continue;

            if(in_array($folder, $this->config['pinned_sites']))
            continue;

            $projects[$folder] = $this->detect_framework($folder);

            # Create a list of frameworks for use later
            if (!in_array($projects[$folder], $used_frameworks))
            {
                array_push($used_frameworks, $projects[$folder]);
            }

        } # End While
        closedir($dir_handle);

        $grouped_projects = [];

        if ($this->config['sortbyframework'] == "TRUE")
        {
            foreach ($used_frameworks as $framework)
            {
                $grouped_projects[$framework] = [];
                $i = 0;
                foreach ($projects as $project => $project_framework)
                {
                    if ($project_framework == $framework)
                    {
                        array_push($grouped_projects[$framework], $project);
                    }
                    $i++;
                }
                # Sort each porject in the framework groups by name
                asort($grouped_projects[$framework]);
            }
        }
        # Sort the main frameworks by name
        arsort($grouped_projects);

        $grouped_projects; # Contains Framework grouped projects
        $projects;         # Contains all projects

        foreach ($grouped_projects as $framework => $projects)
        {
            foreach ($projects as $project)
            {
                # Get Folder Size if we set it in config
                $size = "";
                if ($this->config()['filesize'] == "TRUE")
                {
                    $size = "<div class='tag-size'> &nbsp= ".$this->get_folder_size($this->config['path']."/".$project."/")."</div>";
                }
                # Make some pretty File names
                $file_title = str_replace("_", " ", $project);
                $file_title = ucwords(strtolower($file_title));
                if ($this->config['submode'] == true)
                {
                    echo "<li class='".$this->config['class']." ".$framework."'><a href='https://".$project.".".$this->config['domain_name']."'>".$file_title."</a><small class='tags ".$framework."'>".$framework.$size."</small></li>";
                }
                else
                {
                    echo "<li class='".$this->config['class']." ".$framework."'><a href='https://".$this->config['domain_name']."/".$project."'>".$file_title."</a><small class='tags ".$framework."'>".$framework." <div class='tag-size'>= ".$size."</div></small></li>";
                }
            }
            echo "<br/><br/>";
        }

    }

    public function list_pinned_sites()
    {
        echo "<h4>Pinned Sites</h4>";
        $projects = $this->config()['pinned_sites'];

        foreach ($projects as $project)
        {
            $framework = $this->detect_framework($project);
            # Get Folder Size if we set it in config
            $size = "";
            if ($this->config()['filesize'] == "TRUE")
            {
                $size = "<div class='tag-size'> &nbsp= ".$this->get_folder_size($this->config['path']."/".$project."/")."</div>";
            }
            # Make some pretty File names
            $file_title = str_replace("_", " ", $project);
            $file_title = ucwords(strtolower($file_title));
            if ($this->config['submode'] == true)
            {
                echo "<li class='".$this->config['class']." ".$framework."'><a href='https://".$project.".".$this->config['domain_name']."'>".$file_title."</a><small class='tags ".$framework."'>".$framework.$size."</small></li>";
            }
            else
            {
                echo "<li class='".$this->config['class']." ".$framework."'><a href='https://".$this->config['domain_name']."/".$project."'>".$file_title."</a><small class='tags ".$framework."'>".$framework." <div class='tag-size'>= ".$size."</div></small></li>";
            }
        }
        echo "<br/><br/>";
    }
}

?>
