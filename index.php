<!DOCTYPE html>
<html>
<?php
    //Stuff to configure
    $path            = "/var/www";                                              //Path to your www directory
    $base_url        = 'http://'.$_SERVER['SERVER_NAME'].'/';                   //Your site URL (Normally won't need to change this)
    $exclude_list    = array(".","..","index.php","functions.php","style.css"); //list of folders you would like to exclude (default assumes you just through this project into your main www folder)

    $submode         = false;                                                   //If you want to list folders as subdomain links eg: test.localhost instead of localhost/test
    $hostfile_update = 0; //0 to disable                                        //IMPORTANT - This will attempt to update your hostfile if it has permission to do so (Normally the user www-data)
                                                                                //If you want to update your hosts file on load, you need to specifiy which line number of the hosts file to update

    $domain_name     = $_SERVER['SERVER_NAME'];                                 //Name of your computer, either localhost or your hostname (Normally won't need to change this)
    $class           = "file_list";                                             //A class name you would like your list to have, normally no change needed


    //Makes sure you're on the right URL for people who use vhosts and set up for their computer name instead of localhost, but keep typing localhost into the browser (like me).
    $redirect        = "";  //Don't set if you use http://localhost

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
    <div class="side_title">My Projects</div>
    <div class="rule"></div>
    <div class="side_head">Applications</div>
    <div class="side_container">
        <a href="#">PHPMyadmin</a>
    </div>
</div>
    <div class="content"> <?php echo list_sites($exclude_list,$path,$submode,$domain_name,$class,$hostfile_update); ?>
</div>
</body>
</html>
