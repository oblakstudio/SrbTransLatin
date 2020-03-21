<?php

namespace SGI\STL\Admin\Settings;

use const SGI\STL\DOMAIN;

use function SGI\STL\Core\Utils\is_wpml_active;

trait Menu
{

    public function section_menu()
    {
        add_settings_section(
            'stl_settings_menu',
            __('Menu Settings', DOMAIN),
            [&$this, 'callback_section_menu'],
            'stl_settings'
        );
    }

    public function callback_section_menu()
    {

        printf(
            '<p>%s</p>',
            __('Menu settings control extending and tweaking the script selector in theme menus', DOMAIN)
        );

        add_settings_field(
            'stl_menu_enable',
            __('Extend Nav Menu', DOMAIN),
            [&$this, 'callback_option_extend'],
            'stl_settings',
            'stl_settings_menu',
            $this->opts['menu']['extend']
        );

        add_settings_field(
            'stl_menu_selector',
            __('Nav Menu to extend', DOMAIN),
            [&$this, 'callback_option_selector'],
            'stl_settings',
            'stl_settings_menu',
            $this->opts['menu']['selector']
        );

        add_settings_field(
            'stl_menu_type',
            __('Selector type', DOMAIN),
            [&$this, 'callback_option_type'],
            'stl_settings',
            'stl_settings_menu',
            $this->opts['menu']['type']
        );

        add_settings_field(
            'stl_menu_label',
            __('Menu Label', DOMAIN),
            [&$this, 'callback_option_label'],
            'stl_settings',
            'stl_settings_menu',
            $this->opts['menu']['label']
        );

    }

    public function callback_option_extend($extend)
    {

        $enable_extend = is_wpml_active();

        self::checkbox(
            $extend,
            'sgi/stl/opt[menu][extend]',
            !$enable_extend,
            __('Extend menu with script selector', DOMAIN),
            __('Enables adding script selector to nav menus', DOMAIN)
        );

    }

    public function callback_option_selector($menu)
    {

        $options = get_registered_nav_menus();

        Generator::select(
            $options,
            $menu,
            'sgi/stl/opt[menu][selector]',
            true,
            '',
            __('Menu to extend with script selector', DOMAIN),
            ''
        );

    }

    public function callback_option_type($type)
    {

        $options = [
            'dropdown' => __('Dropdown', DOMAIN),
            'inline'   => __('Inline', DOMAIN)
        ];

        Generator::select(
            $options,
            $type,
            'sgi/stl/opt[menu][type]',
            true,
            '',
            __('Menu to extend with script selector', DOMAIN),
            ''
        );

    }

    public function callback_option_label($label)
    {

        Generator::input(
            $label,
            'sgi/stl/opt[menu][label]',
            true,
            '',
            __('Label used for the menu dropdown', DOMAIN)
        );

    }


}