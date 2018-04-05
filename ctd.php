<?php
//Used for loading and caching scripts and styles
require '../../../wp-load.php';
require_once plugin_dir_path(dirname(__FILE__)) . 'cusmin-themes/includes/cusmin-themes-options.php';
header("Cache-Control: max-age=2592000"); //30 days cache
header("Pragma: cache");

try {
    $script = '';
    $context = 'admin';
    //$additionalJS = '';

    $options = new CusminThemesOptions();
    $theme = $options->getActiveTheme();

    //print_r($options->getOptions());

    if (isset($_GET["ctx"])) {
        $context = $_GET["ctx"];
    }

    header('Content-type: text/css');
    if ($context == 'admin') {
        if (is_user_logged_in()) {
            $script = $theme['admin'];
            //$script = file_get_contents(plugins_url('themes/wasteland/' . 'admin.css', __FILE__));
        }
    } else if ($context == 'login') {
        $script = $theme['login'];
        //$script = file_get_contents(plugins_url('themes/wasteland/' . 'login.css', __FILE__));
    }
    echo $script;
} catch (\Exception $e) {
    echo '/*'.$e->getCode().':'.$e->getMessage().':'.$e->getFile().':'.$e->getLine().'*/';
}