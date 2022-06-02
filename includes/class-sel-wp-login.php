<?php
if (!defined('ABSPATH')) {
    exit;
};

/**
 * Class Sel_WP_Login
 */
class Sel_WP_Login
{
    private static $_instance = null;
    public $file;

    /**
     * Init hooks
     */
    public function __construct($file = "", $version = "1.0.0")
    {
        $this->file = $file;
        // Hook Sel WP Login Admin Setting 

        load_plugin_textdomain(SEL_WP_LOGIN_KEY_NAME);

        if (is_admin()) {
            add_action('init', array($this, 'init_wp_login_admin'));
        } else {
            // Hook SEL WP Login CSS
            add_action('init', array($this, 'init_wp_login_css'));
        }
    }

    public static function instance($file = '', $version = '1.0.0')
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $version);
        }

        return self::$_instance;
    }

    // Initialize SEL WP Login CSS
    public function init_wp_login_css()
    {
        new Sel_WP_Login_CSS();
    }

    // Initialize SEL WP Login Admin Setting
    public function init_wp_login_admin()
    {
        require_once($this->file . 'includes/class-sel-wp-login-admin.php');
        new Sel_WP_Login_Admin();
    }

    /**
     * Check login by phone
     *
     * @return boolean weather login by phone is enable or not
     */
    public function is_phone_login()
    {
        return get_option('sel_wp_login_phone_option') == 1 ? true : false;
    }

    /**
     * Check login by qr
     *
     * @return boolean weather login by qr code is enable or not
     */
    public function is_qr_login()
    {
        return get_option('sel_wp_login_qr_option') == 1 ? true : false;
    }


    /**
     * Check submit form request
     *
     * @return boolean weather request is register page or not
     */
    public function is_register_page()
    {
        return isset($_GET['action']) && $_GET['action'] == 'register';
    }

    /**
     * Check submit form request
     *
     * @return boolean weather request is froget password page or not
     */
    public function is_forget_password_page()
    {
        return isset($_GET['action']) && $_GET['action'] == 'lostpassword';
    }

    /**
     * Load view from source file
     *
     * @return string content of the source file
     */
    public function load_view($name)
    {
        $file = SEL_WP_LOGIN_PLUGIN_DIR . 'includes/views/' . $name . '.php';
        if (file_exists($file)) {
            include($file);
        }
    }
}
