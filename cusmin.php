<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * @wordpress-plugin
 * Plugin Name:       Cusmin Themes
 * Plugin URI:        https://cusmin.com/themes
 * Description:       Cusmin Themes for your admin panel and login page
 * Version:           1.0
 * Author:            Cusmin
 * Author URI:        https://cusmin.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cusmin-themes
 * Domain Path:       /languages
 */
require_once plugin_dir_path( __FILE__ ) . 'configuration.php';

require plugin_dir_path( __FILE__ ) . 'includes/cusmin-themes.php';

$plugin = new CusminThemes();