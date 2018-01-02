<?php
include('functions.php');
$sites  = new Sitelister();


if (sizeof($_POST) > 0)
{
    $_POST['exclude_list'] = preg_split("/\\r\\n|\\r|\\n/", $_POST['exclude_list']);
    $_POST['pinned_sites'] = preg_split("/\\r\\n|\\r|\\n/", $_POST['pinned_sites']);
    $sites->config($_POST);
}

$config = $sites->config();

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
    <div class="content">
        <?php //var_dump($config); ?>
        <form class="" method="post">
            <table>
                <tr>
                    <td><label for="path">Domain Name</label></td>
                    <td><input type="text" name="domain_name" value="<?=$config['domain_name']?>"></td>
                </tr><tr>
                    <td><label for="path">WWW Directory</label></td>
                    <td><input type="text" name="path" value="<?=$config['path']?>"></td>
                </tr><tr>
                    <td><label for="path">Base URL</label></td>
                    <td><input type="text" name="base_url" value="<?=$config['base_url']?>"></td>
                </tr><tr>
                    <td><label for="path">Subdomain</label></td>
                    <td>
                        <select name="submode">
                            <option value="TRUE"  <?=($config['submode'] == "TRUE" ) ? 'selected="selected"':'';?>>TRUE</option>
                            <option value="FALSE" <?=($config['submode'] == "FALSE" ) ? 'selected="selected"':'';?>>FALSE</option>
                        </select>
                    </td>
                </tr><tr>
                    <td><label for="path">Display File Size</label></td>
                    <td>
                        <select name="filesize">
                            <option value="TRUE"  <?=(isset($config['filesize']) && $config['filesize'] == "TRUE" ) ? 'selected="selected"':'';?>>TRUE</option>
                            <option value="FALSE" <?=(isset($config['filesize']) && $config['filesize'] == "FALSE" ) ? 'selected="selected"':'';?>>FALSE</option>
                        </select>
                    </td>
                </tr><tr>
                    <td><label for="path">Redirect</label></td>
                    <td><input type="text" name="redirect" value="<?=$config['redirect']?>"></td>
                </tr><tr>
                    <td><label for="redirect">CSS Class</label></td>
                    <td><input type="text" name="class" value="<?=$config['class']?>"></td>
                </tr><tr>
                    <td><label for="exclude_list">File Exclude List</label></td>
                    <td><textarea name="exclude_list" cols="30" rows="10"><?=implode(PHP_EOL, $config['exclude_list'])?></textarea></td>
                </tr><tr>
                    <td><label for="sortbyframework">Sort By Framework</label></td>
                    <td>
                        <select name="sortbyframework">
                            <option value="TRUE"  <?=(isset($config['sortbyframework']) && $config['sortbyframework'] == "TRUE" ) ? 'selected="selected"':'';?>>Yes</option>
                            <option value="FALSE" <?=(isset($config['sortbyframework']) && $config['sortbyframework'] == "FALSE" ) ? 'selected="selected"':'';?>>No</option>
                        </select>
                    </td>
                </tr><tr>
                    <td><label for="pinned_sites">Pinned Sites</label></td>
                    <td><textarea name="pinned_sites" cols="30" rows="10"><?=implode(PHP_EOL, $config['pinned_sites'])?></textarea></td>
                </tr><tr>
                    <td></td>
                    <td><input type="submit" value="submit"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
