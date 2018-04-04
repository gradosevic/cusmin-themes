<?php

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
            'theme1'=> (object)[
                'slug' => 'theme-1',
                'name' => 'Theme 1',
                'featured-image' => 'image1.png',
                'description' => 'Best to start'
            ],
            'theme2'=> (object)[
                'slug' => 'theme-2',
                'name' => 'Theme 2',
                'featured-image' => 'image2.png',
                'description' => 'Best to start again'
            ]
        ];
        echo json_encode($data);
        die();
    }

    public function theme_install(){
        $slug = $_POST['slug'];
        die();
    }




    public function registerHooks(){
        add_action('admin_init', array($this, 'onAdminInit'));
    }

    public function onAdminInit(){
        $this->registerAjax();
    }

    public function registerAjax(){
        add_action("wp_ajax_cusmin_themes_load", array($this, "themes_load"));
        add_action("wp_ajax_nopriv_cusmin_themes_load", array($this, "themes_load"));
    }
}