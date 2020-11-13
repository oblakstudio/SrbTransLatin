<?php

namespace SGI\STL\Core;

use SGI\STL\{
    Update    as Update,
    Admin     as Admin,
    Ajax      as Ajax,
    Frontend  as Frontend,
    Shortcode as Shortcode,
};

use const SGI\STL\{
    FILE,
    PATH,
    DOMAIN
};

/**
 * Main plugin class which loads all needed frontend and backend functionalities
 */
class Bootstrap
{

    /**
     * @var Bootstrap Class instance
     */
    private static $instance = null;

    private function __construct()
    {
        
        if (is_admin()) :
            add_action('init', [&$this, 'loadAdmin']);
        endif;

        if (wp_doing_ajax()) :
            add_action('init', [&$this, 'loadAjax']);
        endif;

        add_action('init', [&$this, 'loadFrontend']);
        add_action('widgets_init', [&$this, 'loadWidgets']);

    }

    public static function getInstance()
    {

        if (self::$instance == null) :
            self::$instance = new self;
        endif;

        return self::$instance;

    }

    public function loadAdmin()
    {

        new Update\Handler();

        new Admin\Core();
        new Admin\TinyMCE();
        new Admin\SettingsPage();

    }

    public function loadAjax()
    {

        new Ajax\Engine();

    }

    public function loadFrontend()
    {

        new Frontend\Core();
        new Frontend\Fixes();

        new Shortcode\Info();
        new Shortcode\Cyrilizer();
        new Shortcode\Translator();
        new Shortcode\SelectiveOutput();
        new Shortcode\LegacyShortcodes();

    }

    public function loadWidgets()
    {

        register_widget('SGI\STL\Widget\Selector');

    }

}