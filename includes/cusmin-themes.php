<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0
 * @package    CusminThemes
 * @subpackage Cusmin/includes
 * @author     Your Name <email@example.com>
 */
class CusminThemes
{

    const SLUG = 'cusmin-themes';
    const PLUGIN_NAME = 'Cusmin Themes';

    public function __construct()
    {
        $this->load_dependencies();
        $this->registerHooks();
        new CusminThemesAjax();
    }

    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'configuration.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/cusmin-themes-ajax.php';
    }

    private function registerHooks()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'onAdminInit'));
        add_action('admin_enqueue_scripts', array($this, 'registerScripts'));
        add_action('load-settings_page_cusmin-themes', array($this, 'onSettingsPage'));
        add_filter("plugin_action_links_" . self::SLUG . '/cusmin.php', array($this, 'pluginLinks'));
    }

    public function settingsPage()
    {
        ?>
        <div class="cusmin-themes-wrap">
            <h2>Cusmin Themes</h2>

            <div class="content">
                <div id="app">
                    <p>{{ message }}</p>
                    <div class="theme-browser rendered">
                        <div class="themes wp-clearfix">
                            <div class="theme" v-for="theme in themes" tabindex="0"
                                 aria-describedby="twentyfifteen-action twentyfifteen-name" data-slug="twentyfifteen">
                                <div class="theme-screenshot">
                                    <img src="http://beta.local/wp-content/themes/twentyfifteen/screenshot.png" alt="">
                                </div>
                                <span class="more-details" id="twentyfifteen-action">Theme Details</span>

                                <div class="theme-author">
                                    By Cusmin
                                </div>

                                <div class="theme-id-container">

                                    <h2 class="theme-name" id="twentyfifteen-name">{{theme.name}}</h2>


                                    <div class="theme-actions">

                                        <a class="button activate"
                                           href="http://beta.local/wp-admin/themes.php?action=activate&amp;stylesheet=twentyfifteen&amp;_wpnonce=8fdc0a3550"
                                           aria-label="Activate Twenty Fifteen">Activate</a>
                                        <a class="button button-primary load-customize hide-if-no-customize"
                                           href="http://beta.local/wp-admin/customize.php?theme=twentyfifteen&amp;return=%2Fwp-admin%2Fthemes.php">Live
                                            Preview</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function onSettingsPage()
    {

    }

    public function pluginLinks($links)
    {
        $newLinks = array(
            '<a href="options-general.php?page=' . self::SLUG . '" >' . __('Settings') . '</a>',
            '<a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=url.shortener@cusmin.com&item_name=Support+for+Cusmin+Themes+Development" >' . __('Donate') . '</a>',
            '<a target="_blank" href="https://cusmin.com/themes" >' . __('Help') . '</a>'
        );
        return array_merge($newLinks, $links);
    }

    public function onAdminInit()
    {

    }

    public function registerScripts($hook_suffix)
    {

        wp_register_script(self::SLUG, plugins_url('../js/' . self::SLUG . '.js', __FILE__), array('jquery'));
        wp_register_script(self::SLUG . '-vue', plugins_url('../js/vue.js', __FILE__), array('jquery'));
        wp_register_script(self::SLUG . '-ct', plugins_url('../js/ct.js', __FILE__), array('jquery'));
        wp_register_script(self::SLUG . '-ct-vue', plugins_url('../js/ct-vue.js', __FILE__), array('jquery'));
        wp_register_style(self::SLUG, plugins_url('../css/' . self::SLUG . '.css', __FILE__));

        if ($hook_suffix == 'settings_page_cusmin-themes') {
            wp_register_style(self::SLUG . '-settings', plugins_url('../css/' . self::SLUG . '-settings' . '.css', __FILE__));
            wp_enqueue_style(self::SLUG . '-settings');
        }


        wp_enqueue_script('jquery');
        wp_enqueue_script(self::SLUG, '', array(), false, true);
        wp_enqueue_script(self::SLUG . '-vue', '', array(), false, true);
        wp_enqueue_script(self::SLUG . '-ct', '', array(), false, true);
        wp_enqueue_script(self::SLUG . '-ct-vue', '', array(), false, true);
        wp_enqueue_style(self::SLUG);
    }


    public function admin_menu()
    {
        add_options_page(
            __(self::PLUGIN_NAME, self::SLUG),
            __(self::PLUGIN_NAME, self::SLUG),
            'manage_options',
            self::SLUG,
            array(
                $this,
                'settingsPage'
            )
        );
    }
}