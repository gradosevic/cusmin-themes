<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class CusminThemesOptions
{
    private static $options;

    const SLUG = 'cusmin-themes';

    public function __construct()
    {
        $this->loadOptions();
    }

    private function loadOptions()
    {
        if (self::$options) {
            return self::$options;
        }
        self::$options = get_option(self::SLUG);
        return self::$options;
    }

    public function getOptions()
    {
        if (self::$options) {
            return self::$options;
        }
        return [
            'themes' => [],
            'active-theme' => '',
            'version' => $this->randomNumber()
        ];
    }

    public function getActiveThemeSlug(){
        $o = $this->getOptions();
        return $o['active-theme'];
    }

    private function randomNumber(){
        return rand(10000, 99999);
    }

    public function saveOptions(){
        update_option(self::SLUG, self::$options);
    }

    public function installTheme($slug, $adminCSS = '', $loginCSS = ''){

        $o = $this->getOptions();

        $o['themes'][$slug] = [
            'admin' => $adminCSS,
            'login' => $loginCSS
        ];
        $o['active-theme'] = $slug;
        $o['version'] = $this->randomNumber();
        self::$options = $o;
        self::saveOptions();
    }

    public function deactivateTheme($slug){
        $o = $this->getOptions();
        $o['active-theme'] = '';
        $o['version'] = $this->randomNumber();
        self::$options = $o;
        self::saveOptions();
    }

    public function activateTheme($slug){
        $o = $this->getOptions();
        $o['active-theme'] = $slug;
        $o['version'] = $this->randomNumber();
        self::$options = $o;
        self::saveOptions();
    }

    public function getVersion(){
        $o = $this->getOptions();
        return !empty($o['version'])?$o['version']:'';
    }

    public function getActiveTheme(){
        $o = $this->getOptions();
        $at = !empty($o['active-theme'])?$o['active-theme']:'';

        return [
            'active-theme' => $at,
            'admin' => !empty($o['themes'][$at]['admin'])?$o['themes'][$at]['admin']:'',
            'login' => !empty($o['themes'][$at]['login'])?$o['themes'][$at]['login']:'',
        ];
    }

    public function getThemes()
    {
        return !empty($this->options['themes']) ? $this->options['themes'] : '';
    }
}