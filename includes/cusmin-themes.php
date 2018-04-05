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

    const STATUS_NOT_INSTALLED = 1;
    const STATUS_INSTALLED = 2;
    const STATUS_ACTIVATED = 3;

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
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/cusmin-themes-options.php';
    }

    private function registerHooks()
    {
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'onAdminInit'));
        add_action('admin_enqueue_scripts', array($this, 'registerScripts'));
        add_action('admin_enqueue_scripts', array($this, 'addDynamicAdminScript'));
        add_action('login_enqueue_scripts', array($this, 'addDynamicLoginScript'));
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
                            <div class="theme" v-bind:class="{ active: theme.slug == CusminT.activeTheme }" v-for="theme in themes">
                                <div class="theme-screenshot">
                                    <img v-bind:src="theme.thumb" alt="">
                                </div>
                                <?php //<div class="update-message notice inline notice-warning notice-alt"><p>&nbsp;New version available. <button class="button-link" type="button">Update now</button></p></div> ?>
                                <?php
                                //<span class="more-details" id="twentyfifteen-action">Theme Details</span>
                                ?>
                                <div class="theme-author">
                                    By Cusmin
                                </div>
                                <div class="theme-id-container">
                                    <h2 class="theme-name">{{theme.name}}</h2>
                                    <div class="theme-actions">
                                        <a v-if="theme.slug !== CusminT.activeTheme" v-on:click="activateTheme" :data-slug="theme.slug" class="button activate" href="#">Activate</a>
                                        <a v-if="theme.slug == CusminT.activeTheme" v-on:click="deactivateTheme" :data-slug="theme.slug" class="button activate" href="#">Deactivate</a>
                                        <?php //<a v-if="theme.status == '1'" v-on:click="installTheme" :data-slug="theme.slug" class="button button-primary load-customize hide-if-no-customize" href="#">Install</a> ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            window.CusminT = {
                activeTheme: '<?php echo (new CusminThemesOptions())->getActiveThemeSlug(); ?>'
            };
        </script>
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

    public function addDynamicAdminScript(){
        $o = new CusminThemesOptions();
        wp_register_style(self::SLUG.'-ctd', plugins_url('../ctd.php?ctx=admin&ctv='.$o->getVersion(), __FILE__));
        wp_enqueue_style(self::SLUG.'-ctd');
    }

    public function addDynamicLoginScript(){
        $o = new CusminThemesOptions();
        wp_register_style(self::SLUG.'-ctd', plugins_url('../ctd.php?ctx=login&ctv='.$o->getVersion(), __FILE__));
        wp_enqueue_style(self::SLUG.'-ctd');
    }

    public function registerScripts($hook_suffix)
    {

        wp_register_script(self::SLUG, plugins_url('../js/' . self::SLUG . '.js', __FILE__), array('jquery'));
        if(CusminThemesConfiguration::DEBUG){
            wp_register_script(self::SLUG . '-vue', plugins_url('../js/vue.min.js', __FILE__), array('jquery'));
        }else{
            wp_register_script(self::SLUG . '-vue', plugins_url('../js/vue.js', __FILE__), array('jquery'));
        }

        //TODO: Move to settings page
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