<!DOCTYPE html>
<html>
<?php

?>

<?php
    include('functions.php');
    $config = config();
    if (!isset($config['domain_name'])) { $config['domain_name']   = 'Kira Home'; }
    if (!isset($config['path'])) { $config['path']                 = '/home/snickers/public_html'; }
    if (!isset($config['base_url'])) { $config['base_url']         = 'https://localhost.alpha.kira/'; }
    if (!isset($config['submode'])) { $config['submode']           = 'TRUE'; }
    if (!isset($config['redirect'])) { $config['redirect']         = 'https://localhost.alpha.kira/'; }
    if (!isset($config['exclude_list'])) { $config['exclude_list'] = [ ".","..","index.php","functions.php","style.css" ]; }
?>

<head>
    <title><?=$config['domain_name'];?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="sidebar">
    <div class="side_title"><?=$config['domain_name'];?></div>
    <div class="rule"></div>
    <div class="side_head">Localscript</div>
    <div class="side_container">
        <a href="<?=$config['base_url']?>">Site List</a>
    </div>
    <div class="side_container">
        <a href="<?=$config['base_url']?>config.php">Configuration</a>
    </div>
    <div class="side_head">Applications</div>
    <div class="side_container">
        <a href="https://phpmyadmin.alpha.kira">PHPMyadmin</a>
    </div>

</div>
    <div class="content"> <?=list_sites($config['exclude_list'],$config['path'],TRUE,$config['domain_name'],'file_list'); ?>
</div>
</body>
</html>
