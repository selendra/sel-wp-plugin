<?php

/**
 * Sel_WP_Login_Admin
 */
class Sel_WP_Login_Admin
{
    /**
     * Init Admin hooks
     */
    public function __construct()
    {
        $this->plugin = Sel_WP_Login::instance();
        // Admin Setting Form
        add_action('admin_init', array($this, 'admin_init'));
        // Admin Menu
        add_action('admin_menu', array($this, 'admin_menu'));

        //Add Plugin Setting
        add_filter('plugin_action_links_' . plugin_basename($this->plugin->file . 'sel-wp-login.php'), array($this, 'admin_plugin_setting_links'));
    }
    // Initialize Setting Form
    public function admin_init()
    {
        // Add Setting Section to WP Admin 
        add_settings_section(
            'sel_wp_login_page_section',
            null,
            null,
            'sel_wp_login_page'
        );
        // Add Phone Login Field to WP Admin 
        add_settings_field(
            'sel_wp_login_phone_option',
            __('Phone Login', SEL_WP_LOGIN_KEY_NAME),
            array($this, 'sel_wp_login_phone_option'),
            'sel_wp_login_page',
            'sel_wp_login_page_section'
        );
        // Add QR Login Field to WP Admin 
        add_settings_field(
            'sel_wp_login_qr_option',
            __('QR Code Login', SEL_WP_LOGIN_KEY_NAME),
            array($this, 'sel_wp_login_qr_option'),
            'sel_wp_login_page',
            'sel_wp_login_page_section'
        );

        // Register Fields to Setting Section
        register_setting('sel_wp_login_page', 'sel_wp_login_phone_option');
        register_setting('sel_wp_login_page', 'sel_wp_login_qr_option');
    }

    // Initialize Menu in WP Admin
    public function admin_menu()
    {
        add_menu_page(
            __('Selendra WP Login', SEL_WP_LOGIN_KEY_NAME),
            __('Selendra WP Menu', SEL_WP_LOGIN_KEY_NAME),
            'manage_options',
            'sel_wp_login_page',
            array($this, 'sel_login_admin_page_content'),
            'dashicons-schedule',
            99
        );
    }
    // Load Form view
    public function sel_login_admin_page_content()
    {
        $this->plugin->load_view('admin-option-form');
    }
    // Load phone option view
    public function sel_wp_login_phone_option()
    {
        $this->plugin->load_view('admin-input-phone');
    }
    // Load qr option view
    public function sel_wp_login_qr_option()
    {
        $this->plugin->load_view('admin-input-qr');
    }

    public function admin_plugin_setting_links($links)
    {
        $url = esc_url(add_query_arg(
            'page',
            SEL_WP_LOGIN_KEY_NAME . "_page",
            get_admin_url() . 'admin.php'
        ));

        $settings_link = "<a href='$url'>" . __('Settings', SEL_WP_LOGIN_KEY_NAME) . '</a>';
        array_push(
            $links,
            $settings_link
        );
        return $links;
    }
}
