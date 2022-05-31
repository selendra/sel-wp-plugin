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

        // Check if Login by Phone enable 
        // Load IntlTelInput Library
        if ($this->is_phone_login) {
            add_action('login_enqueue_scripts', array($this, 'init_intl'), 99);
        }
    }
    // Load Default Jquery if neccessary 
    function load_default_jquery()
    {
        wp_enqueue_script('jquery');
    }

    // Generate Login Page CSS
    public function generate_css()
    {
        $custom_css = array(
            'html' => array(
                'overflow-y' => 'scroll',
                'scrollbar-width' => 'none',
                '-ms-overflow-style' => 'none',
            ),
            'body::-webkit-scrollbar' => array(
                'display' => 'none'
            ),
            'a:focus' => array(
                'box-shadow' => 'none'
            ),
            '.login h1 a' => array(
                "display" => "none"
            ),
            '.login form' => array(
                "border" => "none"
            ),
            '.login' => array(
                "background" => "none"
            ),
            '#login' => array(
                "width" => "auto",
                "padding" => "0px"
            ),
            '.spacer' => array(
                "margin" => "0px 16px 0px 16px"
            ),
            '.container' => array(
                "justify-content" => "center",
                "margin" => "auto"
            ),
            '@media only screen and (max-width: 600px)' => array(
                '.custom-width' => array(
                    "width" => '80%',
                ),
                '.row' => array(
                    "display" => "block !important",
                ),
                '.qr-login' =>  array(
                    'width' => '100% !important',
                    'margin-left' => '0px !important',
                )
            ),
            '@media only screen and (min-width: 600px)' => array(
                '.custom-width' => array(
                    "width" => '75%',
                ),
            ),
            '@media only screen and (min-width: 768px)' => array(
                '.custom-width' => array(
                    "width" => '70%',
                ),
            ),
            '@media only screen and (min-width: 992px)' => array(
                '.custom-width' => array(
                    'width' => $this->is_qr_login ? "65%" : "45%"
                ),
            ),
            '@media only screen and (min-width: 1200px)' => array(
                '.custom-width' => array(
                    'width' => $this->is_qr_login ? "50%" : "40%"
                ),
            ),
            'nav' => array(
                'display' => 'flex',
                'justify-content' => 'space-between',
                'margin' => '8px 0px 8px 0px !important',
            ),
            'nav #logo' => array(
                "margin-left" => "25%",
            ),
            'nav #darkmode' => array(
                "margin-right" => "25%",
            ),
            '.col' => array("flex" => "1 0 0%"),
            '#loginform,#registerform,#lostpasswordform' => array(
                "padding" => "2px",
                'box-shadow' => 'none',
            ),
            '.custom-title' => array(
                'font-size' => '1rem',
                'font-weight' => '500',
                'line-height' => '1.2'
            ),
            'body.login div#login p#backtoblog,body.login div.phone-login p#backtoblog' => array(
                "padding" => "unset"
            ),
            'body.login div#login form#loginform input#user_login, body.login div#login form#loginform input#user_pass,body.login div#login form#registerform input#user_login, body.login div#login form#registerform input#user_email,body.login div#login form#lostpasswordform input#user_login,body.login div.phone-login form#loginform input#user_phone,body.login div.phone-login form#loginform input#user_pass' => array(
                'font-size' => '1rem',
                'font-weight' => '400',
                'line-height' => '1.5',
                'background' => 'rgba(108,117,125,0.1)',
                'border' => 'none',
                'appearance' => 'none',
                'padding' => '8px',
                'border-radius' => '8px',
                'transition' => 'border-color .15s ease-in-out,box-shadow .15s ease-in-out'
            ),
            '.login .button.wp-hide-pw:focus' => array(
                'box-shadow' => 'none',
                'border' => 'none',
            ),
            'body.login div#login form#loginform p label, body.login div#login form#loginform p.forgetmenot' => array(
                'margin-bottom' => '0.5em'
            ),

            'body.login div#login form#loginform p.submit input#wp-submit,body.login div#login form#registerform p.submit input#wp-submit,body.login div#login form#lostpasswordform p.submit input#wp-submit,body.login div.phone-login form#loginform p.submit input#wp-submit' => array(
                'width' => '100%',
                'font-size' => '1rem',
                'font-weight' => '400',
                'line-height' => '1.5',
                'background-color' => '#01A9F9',
                'color' => 'white',
                'padding' => '8px',
                'border-radius' => '8px',
                'border' => 'none',
                'cursor' => 'pointer'
            ),
            '.img-flip' => array(
                'transform' => 'rotateY(180deg)',
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
            '.row' => array(
                "display" => "flex",
                'flex-wrap' => "wrap"
            ),
            '.notice' => array(
                "background-color" => "rgba(1, 169, 249, 0.1)",
                "font-size" => "small",
                "padding" => "8px",
                'display' =>
                'flex', "justify-content" => "center",
                "margin-bottom" => "100px",
            ),
            '.notice a' => array(
                'text-decoration' => 'none',
                'padding' => '0px 2px 0px 2px',
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
            $custom_css['.phone-login']  = array(
                'display' => 'none',
            );
            $custom_css['.tab']  = array(
                'margin' => '32px 0px 16px 0px',
            );
            $custom_css['.button-type']  = array(
                'font-size' => '16px',
                'font-weight' => '400',
                'line-height' => '1.5',
                'margin-right' => "16px",
                'background' => 'none',
                'padding' => '4px 16px 4px 16px',
                'border-radius' => '8px',
                'border' => 'none',
                'cursor' => 'pointer'
            );
            $custom_css['.button-type.active']  = array(
                'background' => 'rgba(108,117,125,0.25)',
            );
            $custom_css['#phone-login-nav'] = array(
                'display' => 'inline-flex',
                'flex-direction' => 'column',
                'margin-top' => '16px',
                'line-height' => '1.5',
            );
            $custom_css['#phone-login-nav a'] = array(
                'text-decoration' => 'none',
                'color' => 'black',
                'margin-top' => '8px',
                'margin-bottom' => '8px',
            );

            $custom_css['.dropbtn'] = array(
                'font-size' => '1rem',
                'font-weight' => '400',
                'line-height' => '1.5',
                'background' => 'rgba(108, 117, 125, 0.1)',
                'border' => 'none',
                'appearance' => 'none',
                'padding' => '8px',
                'border-radius' => '8px',
                'cursor' => 'pointer',
                'display' => 'inline-flex',
                'align-items' => 'center',
                'width' => '100%',
            );

            $custom_css['.dropbtn>*,.dropdown-content a>*']  = array(
                'margin-right' => '8px',
            );

            $custom_css['.dropdown']  = array(
                'position' => 'relative',
                'display' => 'inline-block',
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
            $custom_css['.prefix-phone']  = array(
                'width' => '30%',
            );
            $custom_css['.phone-number']  = array(
                'width' => '60%',
            );
            $custom_css[' @media only screen and (max-width: 600px)']  = array(
                '.dropbtn' => array(
                    'margin-bottom' => '8px',
                    'width' => '-webkit-fill-available',
                ),
                '.prefix-phone,.dropdown-content,.phone-number' => array(
                    'width' => 'auto',
                ),
            );
            $custom_css['.dropdown-content::-webkit-scrollbar']  = array(
                'display' => 'none',
            );
        }

        $css = $this->css_array_to_css($custom_css);
        echo '<style type="text/css" id="wp-login-css">' . $css . '</style>';
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
        echo '<div class="container custom-width">
            <div class="row">
            <div class="col email-login">
            <div class="custom-title">
            <h3>Selendra Account Login</h3>';

        // Load Phone Tab View if login by phone enabled
        if ($this->is_phone_login) {
            $this->plugin->load_view('phone-tab-header');
        }
        echo '</div>';
    }
    public function close_custom_div()
    {
        // Load Phone form if login by phone enabled
        if ($this->is_phone_login) {
            $this->plugin->load_view('phone-login');
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
}
