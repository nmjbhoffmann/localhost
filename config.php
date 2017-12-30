<?php
include('functions.php');


if (sizeof($_POST) > 0)
{
    $_POST['exclude_list'] = preg_split("/\\r\\n|\\r|\\n/", $_POST['exclude_list']);
    config($_POST);
}



$config = config();
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
        <form class="" method="post">
            <table>
                <tr>
                    <td><label for="path">Domain Name</label></td>
                    <td><input type="text" name="domain_name" value="<?=$config['domain_name']?>"></td>
                </tr>
                <tr>
                    <td><label for="path">WWW Directory</label></td>
                    <td><input type="text" name="path" value="<?=$config['path']?>"></td>
                </tr>
                <tr>
                    <td><label for="path">Base URL</label></td>
                    <td><input type="text" name="base_url" value="<?=$config['base_url']?>"></td>
                </tr>
                <tr>
                    <td><label for="path">Subdomain</label></td>
                    <td>
                        <select name="submode">
                            <option value="TRUE"  <?=($config['submode'] == TRUE ) ? 'selected="selected"':'';?>>TRUE</option>
                            <option value="FALSE" <?=($config['submode'] == FALSE ) ? 'selected="selected"':'';?>>FALSE</option>
                        </select>
                    </td>
                </tr><tr>
                    <td><label for="path">Redirect</label></td>
                    <td><input type="text" name="redirect" value="<?=$config['redirect']?>"></td>
                </tr><tr>
                    <td><label for="path">File Exclude List</label></td>
                    <td><textarea name="exclude_list" cols="30" rows="10"><?=implode(PHP_EOL, $config['exclude_list'])?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="submit"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
