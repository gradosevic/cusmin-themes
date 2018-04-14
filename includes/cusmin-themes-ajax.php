<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Created by PhpStorm.
 * User: goran
 * Date: 4/4/18
 * Time: 6:52 PM
 */
class CusminThemesAjax
{
    public function __construct(){
        $this->registerHooks();
    }

    /**
     *
     */
    public function themes_load(){
        $data = [
            'lemonade'=> (object)[
                'slug' => 'lemonade',
                'name' => 'Lemonade',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/lemonade/' . 'thumb.jpg', __FILE__),
                'description' => 'Make a fresh lemonade in your WordPress back-end'
            ],
            'orange-juice'=> (object)[
                'slug' => 'orange-juice',
                'name' => 'Orange Juice',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/orange-juice/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'army'=> (object)[
                'slug' => 'army',
                'name' => 'Army',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/army/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'black-shades'=> (object)[
                'slug' => 'black-shades',
                'name' => 'Black Shades',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/black-shades/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'blueberry'=> (object)[
                'slug' => 'blueberry',
                'name' => 'Blueberry',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/blueberry/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'dunes'=> (object)[
                'slug' => 'dunes',
                'name' => 'Dunes',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/dunes/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'grass'=> (object)[
                'slug' => 'grass',
                'name' => 'Grass',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/grass/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'gray'=> (object)[
                'slug' => 'gray',
                'name' => 'Gray',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/gray/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'light-blue'=> (object)[
                'slug' => 'light-blue',
                'name' => 'Light Blue',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/light-blue/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'strawberry'=> (object)[
                'slug' => 'strawberry',
                'name' => 'Strawberry',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/strawberry/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'wasteland'=> (object)[
                'slug' => 'wasteland',
                'name' => 'Wasteland',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/wasteland/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'white'=> (object)[
                'slug' => 'white',
                'name' => 'White',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/white/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
            'white-dark'=> (object)[
                'slug' => 'white-dark',
                'name' => 'White Dark',
                'status' => CusminThemes::STATUS_NOT_INSTALLED,
                'thumb' => plugins_url('../themes/white-dark/' . 'thumb.jpg', __FILE__),
                'description' => ''
            ],
        ];
        echo json_encode($data);
        die();
    }

    public function theme_install(){

        $slug = $_POST['data']['theme'];

        //TODO: Replace
        $adminCSS = file_get_contents(plugins_url('../themes/'.$slug.'/' . 'admin.min.css', __FILE__));
        $loginCSS = file_get_contents(plugins_url('../themes/'.$slug.'/' . 'login.min.css', __FILE__));
        $to = new CusminThemesOptions();
        $to->installTheme($slug, $adminCSS, $loginCSS);
        die();
    }

    public function theme_deactivate(){
        $slug = $_POST['data']['theme'];
        $to = new CusminThemesOptions();
        $to->deactivateTheme($slug);
        die();
    }

   /* public function theme_activate(){
        $slug = $_POST['theme'];
        die();
    }*/

    public function registerHooks(){
        add_action('admin_init', array($this, 'onAdminInit'));
    }

    public function onAdminInit(){
        $this->registerAjax();
    }

    public function registerAjax(){
        add_action("wp_ajax_cusmin_themes_load", array($this, "themes_load"));
        add_action("wp_ajax_nopriv_cusmin_themes_load", array($this, "themes_load"));

        add_action("wp_ajax_cusmin_themes_install", array($this, "theme_install"));
        add_action("wp_ajax_nopriv_cusmin_themes_install", array($this, "theme_install"));

        add_action("wp_ajax_cusmin_themes_activate", array($this, "theme_install"));
        add_action("wp_ajax_nopriv_cusmin_themes_activate", array($this, "theme_install"));

        add_action("wp_ajax_cusmin_themes_deactivate", array($this, "theme_deactivate"));
        add_action("wp_ajax_nopriv_cusmin_themes_deactivate", array($this, "theme_deactivate"));
    }
}