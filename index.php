<!DOCTYPE html>
<html>
<?php
    include('functions.php');
    $sites  = new Sitelister();
    $config = $sites->config();
    if (isset($_POST['pinsite']))
    {
        $sites->pin_site($_POST['pinsite']);
    }

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
    <div class="content"> <?=$sites->list_pinned_sites(); ?> <br/><?=$sites->list_sites(); ?>
</div>
</body>
</html>
