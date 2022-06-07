<?php

/**
 * Class Sel_WP_Login_CSS
 */
class Sel_WP_Login_CSS
{
    /**
     * Init hooks
     */
    public function __construct()
    {
        $this->plugin = Sel_WP_Login::instance();
        $this->_file = $this->plugin->file;

        if ($this->plugin->is_register_page() || $this->plugin->is_forget_password_page()) {
            add_action('login_head', array($this, 'load_default_jquery'));
            $this->is_qr_login = false;
        } else {
            $this->is_qr_login = $this->plugin->is_qr_login();
        }
        $this->is_phone_login = $this->plugin->is_phone_login();

        // Load TailWindCSS
        add_action('login_head', array($this, 'load_tailwind'), 1);
        // Login CSS
        add_action('login_head', array($this, 'generate_css'), 15);
        // Navbar
        add_action('login_head', array($this, 'add_nav_bar'), 16);
        // Notice
        add_action('login_head', array($this, 'add_notice'), 17);
        // Phone Or QR Form
        add_action('login_header', array($this, 'add_custom_div'));
        // Close Phoen or QR Form
        add_action('login_footer', array($this, 'close_custom_div'));
        // JS function for login by email or phone
        add_action('login_enqueue_scripts', array($this, 'add_tab_click_event'), 99);
        // JS function for dark mode
        add_action('login_enqueue_scripts', array($this, 'init_dark_mode'), 99);
        //JS function for language switcher
        add_action('login_enqueue_scripts', array($this, 'init_main_js'), 99);

        // Check if Login by Phone enable 
        // Load IntlTelInput Library
        if ($this->is_phone_login) {
            add_action('login_enqueue_scripts', array($this, 'init_intl'), 99);
        }
    }
    //Load TailWindCss CDn
    public function load_tailwind()
    {
        wp_enqueue_style('tailwind', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/css/tailwind.css');
    }
    // Load Default Jquery if neccessary 
    function load_default_jquery()
    {
        wp_enqueue_script('jquery');
    }
    //Add Custom Class to Login page body 
    public function add_custom_class($classes)
    {
        $classes[] = "dark";
        return $classes;
    }

    // Generate Login Page CSS
    public function generate_css()
    {
        $custom_css = array(
            '.login h1 a' => array(
                "display" => "none"
            ),
            '.login form' => array(
                "border" => "none",
                "margin" => "unset",
                "padding" => "unset",
                "box-shadow" => "unset",
            ),
            '.login' => array(
                "background" => "white",
            ),
            '#login' => array(
                "width" => "auto",
                "padding" => "unset",
                "margin-top" => "1rem",
            ),
            '.login .button.wp-hide-pw:focus' => array(
                'box-shadow' => 'none',
                'border' => 'none',
            ),
            'body.login div#login form#loginform p label, body.login div#login form#loginform p.forgetmenot' => array(
                "float" => "unset",
            ),
            'body.login div#login p#nav' => array(
                'visibility' => 'collapse',
                'display' => 'flex',
                'flex-direction' => 'column-reverse',
                'padding' => '0px',
            ),
            'body.login div#login p#nav a' => array(
                'visibility' => 'visible',
            ),
            '.login .button.wp-hide-pw .dashicons' => array(
                'top' => '16px',
                'color' => 'black',
            ),
            '.login #backtoblog' => array(
                'padding' => 'unset',
                'color' => 'black',
            ),
        );

        // If QR is enable genrate CSS
        if ($this->is_qr_login) {
            $custom_css['.qr-login'] = array(
                "display" => "flex",
                "flex-direction" => "column",
                "align-items" => "center",
                'width' => '35%',
                'margin-top' => '32px',
                'margin-left' => '64px',
            );

            $custom_css['.qr-login figure'] = array(
                'padding' => '16px 8px 16px 8px',
            );
            $custom_css['.qr-login p'] = array(
                'text-align' => 'center',
                'padding' => '0px 8px 0px 8px',
            );
            $custom_css['.qr-login a'] = array(
                'text-decoration' => 'none',
                'padding' => '0px 2px 0px 2px',
            );
            $custom_css['.qr-title'] = array(
                'font-size' => '12pt',
                'font-weight' => "bold",
                'margin-bottom' => '16px',
            );
        }
        // If Phone is enable genrate CSS
        if ($this->is_phone_login) {

            $custom_css['#phone-login-nav'] = array(
                'display' => 'inline-flex',
                'flex-direction' => 'column',
                'margin' => '16px 0 0',
            );
            $custom_css['#phone-login-nav a'] = array(
                'text-decoration' => 'none',
                'font-size' => "0.875rem",
                'line-height' => "1.25rem",
            );
            $custom_css["#mybacktoblog"] = array(
                'margin-top' => '4px',
            );

            $custom_css['.dropdown-content']  = array(
                'display' => 'none',
                'position' => 'absolute',
                'background-color' => '#f1f1f1',
                'min-width' => '160px',
                'max-width' => '300px',
                'overflow-y' => 'scroll',
                'box-shadow' => '0px 8px 16px 0px rgba(0, 0, 0, 0.2)',
                'z-index' => '1',
                'height' => '50vh',
                'scrollbar-width' => 'none',
                '-ms-overflow-style' => 'none',
            );
            $custom_css['.dropdown-content a ']  = array(
                'color' => 'black',
                'padding' => '12px 16px',
                'text-decoration' => 'none',
                'display' => 'flex',
                'align-items' => 'center',
            );
            $custom_css['.dropdown a:hover']  = array(
                'background-color' => '#ddd',
            );

            $custom_css['.show']  = array(
                'display' => 'block',
            );

            $custom_css['.dropdown-content::-webkit-scrollbar']  = array(
                'display' => 'none',
            );
        }
        $css = $this->css_array_to_css($custom_css);
        echo '<style>' . $css . '</style>';
    }
    // Convert Array to CSS String
    public function css_array_to_css($custom_css)
    {
        $css = '';

        foreach ($custom_css as $key => $value) {
            if (is_array($value)) {
                $css .= "$key {";
                $css .=  $this->css_array_to_css(
                    $value
                );
                $css .=  "}";
            } else {
                $css .= "$key: $value;";
            }
        }

        return $css;
    }

    // Load Notice View
    public function add_notice()
    {
        $this->plugin->load_view('notice');
    }

    public function add_custom_div()
    {
        $form_class = 'w-5/6 md:w-3/6 lg:w-2/6';
        $login_class = 'w-full';
        if ($this->is_qr_login) {
            $login_class = 'basis-3/5';
            $form_class = 'w-3/4 md:w-3/5 lg:w-1/2';
        }
        echo '<div class="flex flex-col lg:flex-row ' . $form_class . ' mt-24 m-auto email-login">
            <div class="' . $login_class . ' custom-title">
            <div class="text-xl font-medium dark:text-white">' . __('Selendra Account Login', 'sel-wp-login') . '</div>';

        // Load Phone Tab View if login by phone enabled
        if ($this->is_phone_login) {
            $this->plugin->load_view('phone-tab-header');
            echo "<div id='tab-contents'>";
        }
    }
    public function close_custom_div()
    {
        // Load Phone form if login by phone enabled
        if ($this->is_phone_login) {
            $this->plugin->load_view('phone-login');
            echo "</div>";
        }
        echo '</div>';
        // Load QR form if login by qr enabled
        if ($this->is_qr_login) {
            $this->plugin->load_view('qr-login');
        }
        echo '</div></div>';
    }
    // Load Navbar view
    public function add_nav_bar()
    {
        $this->plugin->load_view('navbar');
    }

    // Load Tab view script
    public function add_tab_click_event()
    {
        wp_enqueue_script('tab-controller', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/js/tabController.js', array('jquery'), null, true);
    }

    // Initialize intlTelInput JS & CSS
    public function init_intl()
    {
        wp_enqueue_script('intlTelInput', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/js/intlTelInput.js', array('jquery'), null, true);
        wp_enqueue_script('intlTelInput', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/js/utils.js', array('jquery'), null, true);
        wp_enqueue_script('initCountryCode', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/js/initCountryCode.js', array('jquery'), null, true);
        wp_enqueue_style('intlTelInputStyle', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/css/intlTelInput.css',);
    }
    //Initialize DarkMode Toggle
    public function init_dark_mode()
    {
        wp_enqueue_script('initDarkMode', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/js/initDarkMode.js', array('jquery'), null, true);
    }

    //Initialize Main JS for Language Switcher
    public function init_main_js()
    {
        wp_enqueue_script('main', SEL_WP_LOGIN_PLUGIN_PATH . 'assets/js/main.js', array('jquery'), null, true);
    }
}
